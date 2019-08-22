<?php

declare(strict_types=1);

namespace System\Component\Billing;

use System\Entity\Component\Billing\Display;
use System\Entity\Component\Billing\Response\AcquiringCommission;
use System\Entity\Component\Billing\Response\CheckResponse;
use System\Entity\Component\Billing\Response\ChequePrint;
use System\Entity\Component\Billing\Response\DownloadKeysResponse;
use System\Entity\Component\Billing\Response\GetClientCardsResponse;
use System\Entity\Component\Billing\Response\GetPaymentPageResponse;
use System\Entity\Component\Billing\Response\LoadCommissionResponse;
use System\Entity\Component\Billing\Response\LoadInformationResponse;
use System\Entity\Component\Billing\Response\LoadItemsTagsResponse;
use System\Entity\Component\Billing\Response\LoadOperatorsResponse;
use System\Entity\Component\Billing\BillingResponseCode;
use System\Entity\Component\Billing\Response\LoadPaymentSystemsResponse;
use System\Entity\Component\Billing\Response\LoadRecipientResponse;
use System\Entity\Component\Billing\Response\PaymentPurposeResponse;
use System\Entity\Component\Billing\Response\PayResponse;
use System\Entity\Component\Billing\Response\Response;
use System\Entity\Component\Billing\Response\VerifyResponse;
use System\Entity\InternalProtocol\Currency;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\Repository\CallbackUrl;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Cheque;
use System\Entity\Repository\ChequeCallbackUrl;
use System\Entity\Repository\Payment;

/**
 * Class BillingComponent
 * @package System\Component\Billing
 */
class BillingComponentTest implements BillingComponentInterface
{
    use BillingComponentDependenciesTrait;

    /**
     * @param Cheque $cheque
     * @return VerifyResponse
     */
    public function verify(Cheque $cheque): VerifyResponse
    {
        $char = (int)substr(implode(';', $cheque->getAccount()), -1);
        switch ($char) {
            case 1:
                $response = TestBillingResponse::KYIVSTAR_SUCCESS_RESPONSE;
                break;
            default:
                $response = TestBillingResponse::KYIVSTAR_SUCCESS_RESPONSE;
        }
        $parsedResponse = json_decode($response, true);

        $verifyResponse = $this->generateVerifyResponse($parsedResponse);
        return $verifyResponse;
    }


    /**
     * @param array $response
     * @return VerifyResponse
     */
    private function generateVerifyResponse(array $response): VerifyResponse
    {
        $result = $response['Result'];
        if ($result == BillingResponseCode::SUCCESS_ACTION) {
            $verifyResult = new VerifyResponse(
                $result,
                $response['Time'],
                $response['ChequeId'],
                $response['PsId'],
                $response['Status'],
                $response['PaymentSystemId']
            );

            if (isset($response['Display'])) {
                $display = $response['Display'];

                $verifyResult->setDisplay(
                    new Display(
                        $display['text'] ?? '',
                        isset($display['pay_amount']) ? Currency::uahToKopeck((float)$display['pay_amount']): 0,
                        isset($display['MaxPayAmount']) ? Currency::uahToKopeck((float)$display['MaxPayAmount']): 0,
                        isset($display['MinPayAmount']) ? Currency::uahToKopeck((float)$display['MinPayAmount']): 0,
                        $display['IsModifyPayAmount'] ?? true,
                        $display['recipient'] ?? '',
                        $display['RecipientCode'] ?? '',
                        $display['BankName'] ?? '',
                        $display['BankCode'] ?? '',
                        $display['CheckingAccount'] ?? ''
                    )
                );
            }

            if (isset($response['Print'])) {
                $chequesPrint = [];
                foreach ($response['Print'] as $print) {
                    $chequesPrint[] = new ChequePrint(
                        $print['Text'] ?? '',
                        $print['Value'] ?? '',
                        $print['Target'] ?? ''
                    );
                }

                $verifyResult->setChequesPrint($chequesPrint);
            }

            if (isset($response['AcquiringCommissions'])) {
                $acquiringCommissions = [];
                foreach ($response['AcquiringCommissions'] as $acquiringCommission) {

                    $acquiringCommissions[] = new AcquiringCommission(
                        isset($acquiringCommission['Amount']) ? Currency::uahToKopeck((float)$acquiringCommission['Amount']): 0,
                        $acquiringCommission['Algorithm'] ?? 0,
                        isset($acquiringCommission['FromAmount']) ? Currency::uahToKopeck((float)$acquiringCommission['FromAmount']): 0,
                        isset($acquiringCommission['ToAmount']) ? Currency::uahToKopeck((float)$acquiringCommission['ToAmount']): 0,
                        isset($acquiringCommission['MinAmount']) ? Currency::uahToKopeck((float)$acquiringCommission['MinAmount']): 0,
                        isset($acquiringCommission['MaxAmount']) ? Currency::uahToKopeck((float)$acquiringCommission['MaxAmount']): 0
                    );
                }
                $verifyResult->setAcquiringCommissions($acquiringCommissions);
            }

        } else {
            $verifyResult = VerifyResponse::buildWhenError($result);
        }

        return $verifyResult;
    }

    /**
     * @return DownloadKeysResponse
     */
    public function downloadKeys(): DownloadKeysResponse{}

    /**
     * @return LoadOperatorsResponse
     */
    public function loadOperators(): LoadOperatorsResponse{}

    /**
     * @return LoadCommissionResponse
     */
    public function loadCommission(): LoadCommissionResponse{}

    /**
     * @return LoadRecipientResponse
     */
    public function loadRecipient(): LoadRecipientResponse{}

    /**
     * @return LoadPaymentSystemsResponse
     */
    public function loadPaymentSystems(): LoadPaymentSystemsResponse{}

    /**
     * @param Cheque $cheque
     * @param CallbackUrl $callbackUrl
     * @param ChequeCallbackUrl $chequeCallbackUrl
     * @param Chat $chat
     * @return GetPaymentPageResponse
     */
    public function getPaymentPage(
        Cheque $cheque,
        CallbackUrl $callbackUrl,
        ChequeCallbackUrl $chequeCallbackUrl,
        Chat $chat
    ): GetPaymentPageResponse{}

    /**
     * @param Payment $payment
     * @return PayResponse
     */
    public function payByAcquiringOrder(Payment $payment): PayResponse{}

    /**
     * @return LoadItemsTagsResponse
     */
    public function loadItemsTags(): LoadItemsTagsResponse{}

    /**
     * @param Payment $payment
     * @return CheckResponse
     */
    public function check(Payment $payment): CheckResponse{}

    /**
     * @return LoadInformationResponse
     */
    public function loadInformation(): LoadInformationResponse{}

    /**
     * @return PaymentPurposeResponse
     */
    public function paymentPurpose(): PaymentPurposeResponse{}

    /**
     * @param Chat $chat
     * @return GetClientCardsResponse
     */
    public function getClientCards(Chat $chat): GetClientCardsResponse{}

    /**
     * @param Cheque $cheque
     * @return VerifyResponse
     */
    public function verifyPackage(Cheque $cheque): VerifyResponse{}

    /**
     * @param TelegramRequest $telegramRequest
     * @param Chat $chat
     * @return Response
     */
    public function unbindCardFromClient(TelegramRequest $telegramRequest, Chat $chat): Response{}
}