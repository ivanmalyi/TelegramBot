<?php

declare(strict_types=1);

namespace System\Component\CreateCheque;


use System\Entity\Component\Billing\LocalizationData;
use System\Entity\Component\Billing\Response\ChequePrint;
use System\Entity\Component\ChequeComponent;
use System\Entity\InternalProtocol\Currency;
use System\Entity\InternalProtocol\Stage;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Payment;
use System\Exception\EmptyFetchResultException;
use Symfony\Component\Yaml\Yaml;
use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class CreateChequeComponent
 * @package System\Component\GenerateCheque
 */
class CreateChequeComponent implements CreateChequeComponentInterface
{
    use CreateChequeComponentDependenciesTrait;
    use LoggerReferenceTrait;

    /**
     * @param Payment $payment
     * @return ChequeComponent
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    public function generateCheque(Payment $payment): ChequeComponent
    {
        $chat = $this->getChatsRepository()->findByChequeId($payment->getChequeId());
        $chequeText = $this->generateChequeText($payment, $chat);
        $chequeName = $this->createCheque($chequeText, $payment);
        $chequeUrl = $this->createChequeUrl($chequeName);

        return new ChequeComponent($chequeText, $chequeName, $chequeUrl);
    }

    /**
     * @param Payment $payment
     * @param Chat $chat
     *
     * @return string
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateChequeText(Payment $payment, Chat $chat): string
    {
        $localization = $chat->getCurrentLocalization() === LocalizationData::EN ? LocalizationData::RU: $chat->getCurrentLocalization();
        $stageMessage = $this->getStagesMessagesRepository()->findMessage(Stage::CHEQUE,0, $chat->getCurrentLocalization());
        $recipientForCheque = $this->getRecipientsTemplateRepository()
            ->findByItemId($payment->getItemId(), $chat->getCurrentLocalization());
        $pointInfo = $this->getPointsInfoRepository()->findPointInfo();

        $itemLocalization = $this->getItemsLocalizationRepository()
            ->findItemByIdAndLocale($payment->getItemId(), $localization);
        $cheque = $this->getChequesRepository()->findById($payment->getChequeId());
        $paymentSystemHeaderLocalization = $this->getPaymentSystemsHeadersLocalizationRepository()
            ->findPaymentSystemById($cheque->getPaymentSystemId(), $localization);
        $chequesPrint = $this->getChequePrintRepository()->findChequesPrintByChequeId($payment->getChequeId());

        try {
            $paymentPurpose = $this->getPaymentsPurposeRepository()
                ->findPaymentPurpose($payment->getItemId(), $localization);
        } catch (EmptyFetchResultException $e) {
            $paymentPurpose = $this->getPaymentsPurposeRepository()->findPaymentPurpose(0, $localization);
        }

        $chequeText = str_replace('{RecipientTemplate}', $recipientForCheque->getName(), $stageMessage->getMessage());
        $chequeText = str_replace('{CompanyName}', $recipientForCheque->getCompanyName(), $chequeText);
        $chequeText = str_replace('{RecipientCode}', $recipientForCheque->getRecipientCode(), $chequeText);
        $chequeText = str_replace('{PaymentSystem}', $paymentSystemHeaderLocalization->getText(), $chequeText);
        $chequeText = str_replace('{BankName}', $recipientForCheque->getBankName(), $chequeText);
        $chequeText = str_replace('{Mfo}', $recipientForCheque->getBankCode(), $chequeText);
        $chequeText = str_replace('{CheckingAccount}', $recipientForCheque->getCheckingAccount(), $chequeText);

        $chequeText = str_replace('{PointId}', $pointInfo->getPointId(), $chequeText);
        $chequeText = str_replace('{BillingChequeId}', $payment->getBillingChequeId(), $chequeText);
        $chequeText = str_replace('{CratedAt}', $payment->getCreatedAt(), $chequeText);
        $chequeText = str_replace('{PsId}', $payment->getPsId(), $chequeText);
        $chequeText = str_replace('{Account}', implode(';', $payment->getAccount()), $chequeText);
        $chequeText = str_replace('{ChequePrint}', $this->generateChequePrintText($chequesPrint), $chequeText);
        $chequeText = str_replace('{PaymentPurpose}', $paymentPurpose->getPurpose(), $chequeText);
        $chequeText = str_replace('{ItemName}', $itemLocalization->getName(), $chequeText);
        $chequeText = str_replace('{PayAmount}', Currency::kopeckToUah($payment->getAmount()), $chequeText);
        $chequeText = str_replace('{Commission}', Currency::kopeckToUah($payment->getCommission()), $chequeText);
        $chequeText = str_replace('{Amount}', Currency::kopeckToUah($payment->getCommission()+$payment->getAmount()), $chequeText);

        return $chequeText;
    }

    /**
     * @param string $chequeText
     * @param Payment $payment
     * @return string
     */
    private function createCheque(string $chequeText, Payment $payment): string
    {
        $strings = explode("\n", $chequeText);
        $countRows = count($strings);

        $imgName = $payment->getId() . '.png';
        $image = imagecreatetruecolor(500, 21 * $countRows);
        $black = imagecolorallocate($image, 255, 255, 255);
        $white = imagecolorallocate($image, 0, 0, 0);
        imagefilledrectangle($image, 0, 0, 1000, 600, $black);

        $y = 16;

        $dataForHash = $payment->getAccount();
        $dataForHash[] = $payment->getBillingChequeId();
        $dataForHash[] = $payment->getCreatedAt();
        $dataForHash[] = $payment->getId();

        $hash = hash("sha224", implode(';', $dataForHash));
        $strings[] = $hash;
        $this->getLogger()->debug('Cheque text '.implode("\n", $strings));

        foreach ($strings as $string) {
            imagettftext($image, 11, 0, 5, $y, $white, __DIR__.'/16764.otf', $string);
            $y += 20;
        }

        imagepng($image, __DIR__.'/../../../../public/' . $imgName);

        return $imgName;
    }

    /**
     * @param string $chequeName
     * @return string
     */
    private function createChequeUrl(string $chequeName): string
    {
        $env = $GLOBALS['argv'][1];
        $configFile = "options.{$env}.yml";
        $parameter = Yaml::parse(file_get_contents(__DIR__.'/../../../../config/' . $configFile));
        $chequeUrl = $parameter['parameters']['chatbot.hostname'] . '/' . $chequeName;

        return $chequeUrl;
    }

    /**
     * @param ChequePrint[] $chequesPrint
     * @return string
     */
    private function generateChequePrintText(array $chequesPrint): string
    {
        $chequePrintText = '';
        foreach ($chequesPrint as $chequePrint) {
            $chequePrintText .= $chequePrint->getText() . ": " . $chequePrint->getValue() . "\n";
        }

        return $chequePrintText;
    }
}