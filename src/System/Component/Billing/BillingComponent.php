<?php

declare(strict_types=1);

namespace System\Component\Billing;

use System\Entity\Component\Billing\Display;
use System\Entity\Component\Billing\LocalizationData;
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
use System\Entity\Component\Billing\Response\UserCard;
use System\Entity\Component\Billing\Response\VerifyResponse;
use System\Entity\InternalProtocol\Currency;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\Provider\FieldName;
use System\Entity\Provider\HttpsRequest;
use System\Entity\Provider\HttpsResponse;
use System\Entity\Provider\InputField;
use System\Entity\Repository\BillingSettings;
use System\Entity\Repository\CallbackUrl;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Cheque;
use System\Entity\Repository\ChequeCallbackUrl;
use System\Entity\Repository\Commission;
use System\Entity\Repository\Item;
use System\Entity\Repository\ItemLocalization;
use System\Entity\Repository\ItemTag;
use System\Entity\Repository\ItemType;
use System\Entity\Repository\Operator;
use System\Entity\Repository\OperatorLocalization;
use System\Entity\Repository\Payment;
use System\Entity\Repository\PaymentPurpose;
use System\Entity\Repository\PaymentSystem;
use System\Entity\Repository\PaymentSystemHeaderLocalization;
use System\Entity\Repository\Recipient;
use System\Entity\Repository\Section;
use System\Entity\Repository\Service;
use System\Entity\Repository\ServiceLocalization;
use System\Exception\Provider\CurlException;

/**
 * Class BillingComponent
 * @package System\Component\Billing
 */
class BillingComponent implements BillingComponentInterface
{
    use BillingComponentDependenciesTrait;

    /**
     * @return DownloadKeysResponse
     */
    public function downloadKeys(): DownloadKeysResponse
    {
        $session = $this->createSessionGuid();
        try {
            $httpsRequest = $this->generateDownloadKeysHttpRequest();
            $this->log(
                'download_keys',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'download_keys',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = $this->getBodyFromResponse($response);
            return $this->generateDownloadKeysResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('download_keys', 'response', get_class($e).': '.$e->getMessage(), $session);
            return DownloadKeysResponse::buildWhenError(BillingResponseCode::CURL_ERROR);
        } catch (\Throwable $t) {
            $this->log('download_keys', 'response', get_class($t).': '.$t->getMessage(), $session);
            return DownloadKeysResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }
    }

    /**
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateDownloadKeysHttpRequest(): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'DownloadKeys',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'ClientKey' => $billingSettings->getClientKey()
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $response
     * @return DownloadKeysResponse
     */
    private function generateDownloadKeysResponse(array $response): DownloadKeysResponse
    {
        $result = (int) $response['Result'];
        if ($result === BillingResponseCode::SUCCESS_ACTION) {
            return new DownloadKeysResponse(
                $result,
                $response['PrivateKey'],
                $response['PublicKey'],
                $response['Time']
            );
        }

        return DownloadKeysResponse::buildWhenError($result);
    }

    /**
     * @return LoadOperatorsResponse
     */
    public function loadOperators(): LoadOperatorsResponse
    {
        $session = $this->createSessionGuid();
        try {
            $httpsRequest = $this->generateLoadOperatorsHttpRequest();
            $this->log(
                'loadOperators',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'loadOperators',
                'response',
                $response->getBody(),
                $session
            );

            $parsedJson = $this->getBodyFromResponse($response);
            return $this->generateLoadOperatorsResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('loadOperators', 'response', get_class($e).': '.$e->getMessage(), $session);
            return new LoadOperatorsResponse(
                BillingResponseCode::UNKNOWN_ERROR,
                (new \DateTime())->format('Y-m-d H:i:s')
                );
        } catch (\Throwable $t) {
            $this->log('loadOperators', 'response', get_class($t).': '.$t->getMessage(), $session);
            return new LoadOperatorsResponse(
                BillingResponseCode::UNKNOWN_ERROR,
                (new \DateTime())->format('Y-m-d H:i:s')
            );
        }
    }

    /**
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateLoadOperatorsHttpRequest(): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command'=>'LoadOperators',
            'Login'=>$billingSettings->getLogin(),
            'Password'=>$billingSettings->getPassword(),
            'ClientKey'=>$billingSettings->getClientKey(),
            'Time'=>(new \DateTime())->format('Y-m-d H:i:s')
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $response
     * @return LoadOperatorsResponse
     */
    private function generateLoadOperatorsResponse(array $response): LoadOperatorsResponse
    {
        $result = $response['Result'];
        $loadOperatorsResponse = new LoadOperatorsResponse($result, $response['Time']);

        if ($result == BillingResponseCode::SUCCESS_ACTION) {
            $sections = [];
            foreach ($response['Sections'] as $section) {
                $sectionId = $section['Id'];

                foreach ($section['Names'] as $localization) {
                    if ($localization['Language'] == 'UA') {
                        $nameUa = $localization['Text'];
                    } elseif ($localization['Language'] == 'RU') {
                        $nameRu = $localization['Text'];
                    } elseif ($localization['Language'] == 'EN') {
                        $nameEn = $localization['Text'];
                    }
                }
                $sections[] = new Section($nameUa ?? '', $nameRu ?? '', $nameEn ?? '', $sectionId);

            }
            $loadOperatorsResponse->setSections($sections);

            $operators = [];
            $operatorsLocalization = [];
            foreach ($response['Operators'] as $operator) {
                $operators[] = new Operator(
                    $operator['SectionId'],
                    $operator['Image'],
                    $operator['Status'],
                    $operator['Id']
                );

                foreach ($operator['Names'] as $key=>$name) {
                    $operatorsLocalization[] = new OperatorLocalization(
                        $operator['Id'],
                        $name['Language'],
                        $name['Text'],
                        $operator['Descriptions'][$key]['Text'] ?? ''
                    );
                }
            }
            $loadOperatorsResponse->setOperators($operators);
            $loadOperatorsResponse->setOperatorsLocalization($operatorsLocalization);

            $services = [];
            $servicesLocalization = [];
            foreach ($response['Services'] as $service) {
                $services[] = new Service(
                    $service['OperatorId'],
                    $service['ServiceTypeId'],
                    $service['Image'],
                    $service['Status'],
                    $service['Id']
                );
                foreach ($service['Names'] as $name) {
                    $servicesLocalization[] = new ServiceLocalization(
                        $service['Id'],
                        $name['Language'],
                        $name['Text']
                    );
                }

            }
            $loadOperatorsResponse->setServices($services);
            $loadOperatorsResponse->setServicesLocalization($servicesLocalization);

            $items = [];
            $inputFields = [];
            $itemsLocalization = [];
            $itemTypes = [];
            foreach ($response['Items'] as $item) {
                $items[] = new Item(
                    $item['ServiceId'],
                    $item['Image'],
                    Currency::uahToKopeck($item['MinAmount']),
                    Currency::uahToKopeck($item['MaxAmount']),
                    $item['Status'],
                    $item['Mcc'],
                    $item['Id']
                );

                foreach ($item['Names'] as $key=>$name) {
                    $itemsLocalization[] = new ItemLocalization(
                        $item['Id'],
                        $name['Language'],
                        $name['Text'],
                        $item['Descriptions'][$key]['Text']
                    );
                }

                foreach ($item['InputFields'] as $inputFieldRow) {
                    $inputField = new InputField(
                        $item['Id'],
                        $inputFieldRow['Order'],
                        $inputFieldRow['MinLength'] ?? 0,
                        $inputFieldRow['MaxLength'] ?? 0,
                        $inputFieldRow['Pattern'],
                        $inputFieldRow['IsMobile'] == true ? 1: 0,
                        $inputFieldRow['TypingStyle'],
                        implode(';', $inputFieldRow['Prefixes'])
                    );

                    $fieldNames = [];
                    foreach ($inputFieldRow['FieldNames'] as $key=>$fieldName) {
                        $fieldNames[] = new FieldName(
                            $fieldName['Language'],
                            $fieldName['Text'],
                            $inputFieldRow['Instructions'][$key]['Text']
                        );
                    }

                    $inputField->setFieldNames($fieldNames);
                    $inputFields[] = $inputField;
                }

                foreach ($item['Types'] as $type) {
                    $itemTypes[] = new ItemType( $item['Id'], $type);
                }

            }
            $loadOperatorsResponse->setItems($items);
            $loadOperatorsResponse->setInputFields($inputFields);
            $loadOperatorsResponse->setItemLocalization($itemsLocalization);
            $loadOperatorsResponse->setItemTypes($itemTypes);
        }

        return $loadOperatorsResponse;
    }

    /**
     * @return LoadCommissionResponse
     */
    public function loadCommission(): LoadCommissionResponse
    {
        $session = $this->createSessionGuid();

        try {
            $httpsRequest = $this->generateLoadCommissionHttpRequest();
            $this->log(
                'load_commission',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'load_commission',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = $this->getBodyFromResponse($response);
            return $this->generateLoadCommissionResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('load_commission', 'response', get_class($e).': '.$e->getMessage(), $session);
            return new LoadCommissionResponse(
                BillingResponseCode::UNKNOWN_ERROR,
                (new \DateTime())->format('Y-m-d H:i:s')
            );
        } catch (\Throwable $t) {
            $this->log('load_commission', 'response', get_class($t).': '.$t->getMessage(), $session);
            return new LoadCommissionResponse(
                BillingResponseCode::UNKNOWN_ERROR,
                (new \DateTime())->format('Y-m-d H:i:s')
            );
        }
    }

    /**
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateLoadCommissionHttpRequest(): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command'=>'LoadCommission',
            'Login'=>$billingSettings->getLogin(),
            'Password'=>$billingSettings->getPassword(),
            'ClientKey'=>$billingSettings->getClientKey(),
            'Time'=>(new \DateTime())->format('Y-m-d H:i:s'),
            'CommissionType' => 3,
            'Version' => 6
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $response
     * @return LoadCommissionResponse
     */
    private function generateLoadCommissionResponse(array $response): LoadCommissionResponse
    {
        $result = $response['Result'];
        $loadCommissionResponse = new LoadCommissionResponse($result, $response['Time']);

        if ($result == BillingResponseCode::SUCCESS_ACTION) {
            $commissions = [];
            foreach ($response['Commissions']as $commission) {
                $commissions[] = new Commission(
                    $commission['ItemId'],
                    $commission['CommissionType'],
                    Currency::uahToKopeck($commission['Amount']),
                    $commission['Algorithm'],
                    Currency::uahToKopeck($commission['FromAmount']),
                    Currency::uahToKopeck($commission['ToAmount']),
                    Currency::uahToKopeck($commission['MinAmount']),
                    Currency::uahToKopeck($commission['MaxAmount']),
                    $commission['FromTime'],
                    $commission['ToTime'],
                    Currency::uahToKopeck($commission['Round']),
                    $commission['Id']
                );
            }

            $loadCommissionResponse->setCommissions($commissions);
        }

        return $loadCommissionResponse;
    }


    /**
     * @param array $body
     * @param BillingSettings $billingSettings
     * @return HttpsRequest
     * @throws \System\Exception\DiException
     */
    private function generateHttpsRequest(array $body, BillingSettings $billingSettings): HttpsRequest
    {
        $body = json_encode($body);
        $httpsRequest = new HttpsRequest(
            $billingSettings->getUrl(),
            [
                'Content-Type: application/json',
                'Signature: '.$this->getOpenSslSecurityComponent()->sign($body, $billingSettings->getPrivateKey())
            ],
            $body
        );
        $httpsRequest->setTimeout(20);

        return $httpsRequest;
    }

    /**
     * @param HttpsResponse $response
     * @return array
     */
    private function getBodyFromResponse(HttpsResponse $response): array
    {
        foreach ($response->getHeaders() as $key => $value) {
            if (strtolower($key) === 'content-type' and $value === 'zip') {
                return json_decode(gzuncompress(base64_decode($response->getBody())), true);
            }
        }
        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $method
     * @param string $query
     * @param string $data
     * @param string $session
     */
    private function log(string $method, string $query, string $data, string $session = '')
    {
        try {
            $this->getLogger()->info($data, [
                'tag' => [$method, $query],
                'component' => strtolower((new \ReflectionClass($this))->getShortName()),
                'session' => $session
            ]);
        } catch (\ReflectionException $e) {
        }
    }

    /**
     * @return string
     */
    private function createSessionGuid() : string
    {
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535),
            mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /**
     * @return LoadRecipientResponse
     */
    public function loadRecipient(): LoadRecipientResponse
    {
        $session = $this->createSessionGuid();
        try {
            $httpsRequest = $this->generateLoadRecipientHttpRequest();
            $this->log(
                'load_recipient',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'load_recipient',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = $this->getBodyFromResponse($response);
            return $this->generateLoadRecipientResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('load_recipient', 'response', get_class($e).': '.$e->getMessage(), $session);
            return LoadRecipientResponse::buildWhenError(BillingResponseCode::CURL_ERROR);
        } catch (\Throwable $t) {
            $this->log('load_recipient', 'response', get_class($t).': '.$t->getMessage(), $session);
            return LoadRecipientResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }
    }

    /**
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateLoadRecipientHttpRequest(): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'LoadRecipient',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'ClientKey' => $billingSettings->getClientKey(),
            'Time' => date('Y-m-d H:i:s'),
            'Version' => 6
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $parsedJson
     * @return LoadRecipientResponse
     */
    private function generateLoadRecipientResponse(array $parsedJson): LoadRecipientResponse
    {
        $result = $parsedJson['Result'];

        if ($result !== BillingResponseCode::SUCCESS_ACTION) {
            return LoadRecipientResponse::buildWhenError($result);
        } elseif (!isset($parsedJson['Template']) or !isset($parsedJson['Recipients'])) {
            return LoadRecipientResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }

        $templates = [];
        foreach ($parsedJson['Template'] as $template) {
            $templates[] = new LocalizationData($template['Language'], $template['Text']);
        }

        $recipients = [];
        foreach ($parsedJson['Recipients'] as $recipient) {
            $recipients[] = new Recipient(
                (int) $recipient['ItemId'],
                Recipient::TEMPLATE_ID,
                $recipient['CompanyName'],
                $recipient['RecipientCode'],
                $recipient['BankName'],
                $recipient['BankCode'],
                $recipient['CheckingAccount']
            );
        }

        return new LoadRecipientResponse($result, $templates, $recipients, $parsedJson['Time']);
    }

    /**
     * @return LoadPaymentSystemsResponse
     */
    public function loadPaymentSystems(): LoadPaymentSystemsResponse
    {
        $session = $this->createSessionGuid();
        try {
            $httpsRequest = $this->generateLoadPaymentSystemsHttpRequest();
            $this->log(
                'load_payment_systems',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'load_payment_systems',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = $this->getBodyFromResponse($response);
            return $this->generateLoadPaymentSystemsResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('load_payment_systems', 'response', get_class($e).': '.$e->getMessage(), $session);
            return LoadPaymentSystemsResponse::buildWhenError(BillingResponseCode::CURL_ERROR);
        } catch (\Throwable $t) {
            $this->log('load_payment_systems', 'response', get_class($t).': '.$t->getMessage(), $session);
            return LoadPaymentSystemsResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }
    }

    /**
     * @return HttpsRequest
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateLoadPaymentSystemsHttpRequest(): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'LoadPaymentSystems',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'ClientKey' => $billingSettings->getClientKey(),
            'Time' => date('Y-m-d H:i:s')
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $parsedJson
     * @return LoadPaymentSystemsResponse
     */
    private function generateLoadPaymentSystemsResponse(array $parsedJson): LoadPaymentSystemsResponse
    {
        $result = $parsedJson['Result'];

        if ($result !== BillingResponseCode::SUCCESS_ACTION) {
            return LoadPaymentSystemsResponse::buildWhenError($result);
        } elseif (!isset($parsedJson['PaymentSystems'])) {
            return LoadPaymentSystemsResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }

        $paymentSystems = [];
        $paymentSystemsHeadersLocalization = [];
        foreach ($parsedJson['PaymentSystems'] as $paymentSystemArray) {
            $paymentSystem = new PaymentSystem(
                $paymentSystemArray['Name'],
                (int) $paymentSystemArray['Id']
            );

            foreach ($paymentSystemArray['Headers'] as $header) {
                $paymentSystemsHeadersLocalization[] = new PaymentSystemHeaderLocalization(
                    $paymentSystem->getId(),
                    $header['Language'],
                    $header['Text']
                );
            }

            $paymentSystems[] = $paymentSystem;
        }

        return new LoadPaymentSystemsResponse(
            $result,
            $paymentSystems,
            $paymentSystemsHeadersLocalization,
            $parsedJson['Time']
        );
    }

    /**
     * @param Cheque $cheque
     * @return VerifyResponse
     */
    public function verify(Cheque $cheque): VerifyResponse
    {
        $session = $this->createSessionGuid();

        try {
            $httpsRequest = $this->generateVerifyHttpRequest($cheque);
            $this->log(
                'verify',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'verify',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = json_decode($response->getBody(), true);
            $verifyResponse = $this->generateVerifyResponse($parsedJson);

        } catch (CurlException $e) {
            $this->log('verify', 'response', get_class($e).': '.$e->getMessage(), $session);
            $verifyResponse =  VerifyResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        } catch (\Throwable $t) {
            $this->log('verify', 'response', get_class($t).': '.$t->getMessage(), $session);
            $verifyResponse =  VerifyResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }

        return $verifyResponse;
    }

    /**
     * @param Cheque $cheque
     * @return HttpsRequest
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateVerifyHttpRequest(Cheque $cheque): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command'=>'Verify',
            'Login'=>$billingSettings->getLogin(),
            'Password'=>$billingSettings->getPassword(),
            'ClientKey'=>$billingSettings->getClientKey(),
            "EncashmentGuid"=>0,
            "ItemId"=>$cheque->getItemId(),
            "Accounts"=>$cheque->getAccount(),
            "Locale"=>"ru",
            'Type' => 0,
            'Time'=>(new \DateTime())->format('Y-m-d H:i:s')
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
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
                $response['PaymentSystemId'] ?? 1
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
     * @param Cheque $cheque
     * @param CallbackUrl $callbackUrl
     * @param ChequeCallbackUrl $chequeCallbackUrl
     * @param Chat $chat
     *
     * @return GetPaymentPageResponse
     */
    public function getPaymentPage(
        Cheque $cheque,
        CallbackUrl $callbackUrl,
        ChequeCallbackUrl $chequeCallbackUrl,
        Chat $chat
    ): GetPaymentPageResponse
    {
        $session = $this->createSessionGuid();

        try {
            $httpsRequest = $this->generateGetPaymentPageHttpRequest($cheque, $callbackUrl, $chequeCallbackUrl, $chat);
            $this->log(
                'get_payment_page',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'get_payment_page',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = json_decode($response->getBody(), true);
            return $this->generateGetPaymentPageResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('get_payment_page', 'response', get_class($e).': '.$e->getMessage(), $session);
            return  GetPaymentPageResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        } catch (\Throwable $t) {
            $this->log('get_payment_page', 'response', get_class($t).': '.$t->getMessage(), $session);
            return  GetPaymentPageResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }
    }


    /**
     * @param Cheque $cheque
     * @param CallbackUrl $callbackUrl
     * @param ChequeCallbackUrl $chequeCallbackUrl
     * @param Chat $chat
     *
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateGetPaymentPageHttpRequest(
        Cheque $cheque,
        CallbackUrl $callbackUrl,
        ChequeCallbackUrl $chequeCallbackUrl,
        Chat $chat
    ): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'LoadPaymentPage',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'ClientKey' => $billingSettings->getClientKey(),
            'Time' => (new \DateTime())->format('Y-m-d H:i:s'),
            'ChequeId' => $cheque->getBillingChequeId(),
            'Amount' => Currency::kopeckToUah($cheque->getAmount()+$cheque->getCommission()),
            'OkCallbackUrl' => $callbackUrl->getCallbackUrlOk().'?guid='.$chequeCallbackUrl->getGuid(),
            'ErrorCallbackUrl' => $callbackUrl->getCallbackUrlError().'?guid='.$chequeCallbackUrl->getGuid(),
            'CallBack3dsUrl' => $callbackUrl->getCallbackUrl3ds().'?guid='.$chequeCallbackUrl->getGuid(),
            'UserPhoneNumber' => $chat->getPhone()
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $response
     * @return GetPaymentPageResponse
     */
    private function generateGetPaymentPageResponse(array $response): GetPaymentPageResponse
    {
        $usersCards = [];
        if (isset($response['UserCards'])) {
            foreach ($response['UserCards'] as $card) {
                $usersCards[] = new UserCard(
                    $card['Card'],
                    $card['Url']
                );
            }
        }

        return new GetPaymentPageResponse($response['Result'], $response['Time'], $response['Url'], $usersCards);
    }

    /**
     * @param Payment $payment
     * @return PayResponse
     */
    public function payByAcquiringOrder(Payment $payment): PayResponse
    {
        $session = $this->createSessionGuid();

        try {
            $httpsRequest = $this->generatePayByAcquiringOrderHttpRequest($payment);
            $this->log(
                'pay_by_acquiring_order',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'pay_by_acquiring_order',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = json_decode($response->getBody(), true);
            return $this->generatePayByAcquiringOrderResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('pay_by_acquiring_order', 'response', get_class($e).': '.$e->getMessage(), $session);
            return  PayResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        } catch (\Throwable $t) {
            $this->log('pay_by_acquiring_order', 'response', get_class($t).': '.$t->getMessage(), $session);
            return  PayResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }
    }

    /**
     * @param Payment $payment
     *
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generatePayByAcquiringOrderHttpRequest(Payment $payment): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'Pay',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'ClientKey' => $billingSettings->getClientKey(),
            'Time' => (new \DateTime())->format('Y-m-d H:i:s'),
            'ChequeId' => $payment->getBillingChequeId(),
            'PayAmount' => Currency::kopeckToUah($payment->getAmount()),
            'CommissionAmount' => Currency::kopeckToUah($payment->getCommission()),
            'EncashmentGuid' => 0,
            'AcquiringOrder' => [
                'MerchantOrderId' => $payment->getBillingChequeId(),
                'Amount' => $payment->getAmount()+$payment->getCommission()
            ]
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param $parsedJson
     * @return PayResponse
     */
    private function generatePayByAcquiringOrderResponse($parsedJson): PayResponse
    {
        $payResponse = new PayResponse(
            (int) $parsedJson['Result'],
            $parsedJson['Time'],
            (int)( $parsedJson['Status'] ?? 0),
            (int) ($parsedJson['ChequeId'] ?? 0),
            (int) ($parsedJson['PaymentId'] ?? 0),
            (int) ($parsedJson['AcquiringStatus'] ?? 0),
            (int) ($parsedJson['AcquiringTransactionId'] ?? 0),
            $parsedJson['AcquiringMerchantId'] ?? '',
            $parsedJson['AcquiringConfirmUrl'] ?? '',
            (int) ($parsedJson['PsId'] ?? 0),
            $parsedJson['OperatorPayId'] ?? 0,
            $parsedJson['OperatorChequeId'] ?? 0
        );
        if (isset($parsedJson['Print'])) {
            $chequePrint = [];
            foreach ($parsedJson['Print'] as $print) {
                $chequePrint[] = new ChequePrint(
                    $print['Text'],
                    $print['Value'],
                    $print['Target'] ?? ''
                );
            }
            $payResponse->setPrint($chequePrint);
        }
        if (isset($parsedJson['Display']['text'])) {
            $payResponse->setDisplay(new Display($parsedJson['Display']['text']));
        }

        return $payResponse;
    }

    /**
     * @return LoadItemsTagsResponse
     */
    public function loadItemsTags(): LoadItemsTagsResponse
    {
        $session = $this->createSessionGuid();

        try {
            $httpsRequest = $this->generateLoadItemsTagsHttpRequest();
            $this->log(
                ' loadItemsTags',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                ' loadItemsTags',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = $this->getBodyFromResponse($response);
            return $this->generateLoadItemsTagsResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('loadItemsTags', 'response', get_class($e).': '.$e->getMessage(), $session);
            return  LoadItemsTagsResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        } catch (\Throwable $t) {
            $this->log('loadItemsTags', 'response', get_class($t).': '.$t->getMessage(), $session);
            return  LoadItemsTagsResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }
    }

    /**
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateLoadItemsTagsHttpRequest(): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'LoadItemsTags',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'ClientKey' => $billingSettings->getClientKey(),
            'Time' => (new \DateTime())->format('Y-m-d H:i:s')
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $response
     *
     * @return LoadItemsTagsResponse
     */
    private function generateLoadItemsTagsResponse(array $response): LoadItemsTagsResponse
    {
        $result = $response['Result'];
        if ($result == BillingResponseCode::SUCCESS_ACTION) {
            $itemsTags = [];
            foreach ($response['ItemsTags'] as $itemTags) {
                $itemsTags[] = new ItemTag($itemTags['ItemId'], implode(';', $itemTags['Tags']));
            }
            $loadItemsTagsResponse = new LoadItemsTagsResponse($result, $response['Time'], $itemsTags);
        }else {
            $loadItemsTagsResponse = LoadItemsTagsResponse::buildWhenError($result);
        }

        return $loadItemsTagsResponse;
    }

    /**
     * @param Payment $payment
     * @return CheckResponse
     */
    public function check(Payment $payment): CheckResponse
    {
        $session = $this->createSessionGuid();

        try {
            $httpsRequest = $this->generateCheckHttpRequest($payment);
            $this->log(
                'check',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'check',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = json_decode($response->getBody(), true);
            return $this->generateCheckResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('check', 'response', get_class($e).': '.$e->getMessage(), $session);
            return  CheckResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        } catch (\Throwable $t) {
            $this->log('check', 'response', get_class($t).': '.$t->getMessage(), $session);
            return  CheckResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }
    }

    /**
     * @param Payment $payment
     *
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateCheckHttpRequest(Payment $payment): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'Check',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'ClientKey' => $billingSettings->getClientKey(),
            'Time' => (new \DateTime())->format('Y-m-d H:i:s'),
            'ChequeId' => $payment->getBillingChequeId()
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $parsedJson
     *
     * @return CheckResponse
     */
    private function generateCheckResponse(array $parsedJson): CheckResponse
    {
        $checkResponse = new CheckResponse(
            (int) $parsedJson['Result'],
            $parsedJson['Time'],
            (int)( $parsedJson['Status'] ?? 0),
            (int) ($parsedJson['ChequeId'] ?? 0),
            (int) ($parsedJson['PaymentId'] ?? 0),
            (int) ($parsedJson['AcquiringStatus'] ?? 0),
            (int) ($parsedJson['AcquiringTransactionId'] ?? 0),
            $parsedJson['AcquiringMerchantId'] ?? '',
            $parsedJson['AcquiringConfirmUrl'] ?? '',
            (int) ($parsedJson['PsId'] ?? 0),
            $parsedJson['OperatorPayId'] ?? 0,
            $parsedJson['OperatorChequeId'] ?? 0
        );

        return $checkResponse;
    }

    /**
     * @return LoadInformationResponse
     */
    public function loadInformation(): LoadInformationResponse
    {
        $session = $this->createSessionGuid();
        try {
            $httpsRequest = $this->generateLoadInformationHttpRequest();
            $this->log(
                'load_information',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'load_information',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = json_decode($response->getBody(), true);
            return $this->generateLoadInformationResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('load_information', 'response', get_class($e).': '.$e->getMessage(), $session);
            return LoadInformationResponse::buildWhenError(BillingResponseCode::CURL_ERROR);
        } catch (\Throwable $t) {
            $this->log('load_information', 'response', get_class($t).': '.$t->getMessage(), $session);
            return LoadInformationResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }
    }

    /**
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateLoadInformationHttpRequest(): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'LoadInformation',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'ClientKey' => $billingSettings->getClientKey(),
            'Time' => (new \DateTime())->format('Y-m-d H:i:s')
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $response
     *
     * @return LoadInformationResponse
     */
    private function generateLoadInformationResponse(array $response): LoadInformationResponse
    {
        $result = $response['Result'];
        if ($result == BillingResponseCode::SUCCESS_ACTION) {
            $loadInformationResponse = new LoadInformationResponse(
                $result,
                $response['Time'],
                $response['MemberId'],
                $response['Id'],
                $response['Address'],
                $response['Place'],
                $response['AddInfo'] ?? ''
            );
        }else {
            $loadInformationResponse = LoadInformationResponse::buildWhenError($result);
        }

        return $loadInformationResponse;
    }

    /**
     * @return PaymentPurposeResponse
     */
    public function paymentPurpose(): PaymentPurposeResponse
    {
        $session = $this->createSessionGuid();
        try {
            $httpsRequest = $this->generatePaymentPurposeHttpRequest();
            $this->log(
                'payment_purpose',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'payment_purpose',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = $this->getBodyFromResponse($response);
            return $this->generatePaymentPurposeResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('payment_purpose', 'response', get_class($e).': '.$e->getMessage(), $session);
            return PaymentPurposeResponse::buildWhenError(BillingResponseCode::CURL_ERROR);
        } catch (\Throwable $t) {
            $this->log('payment_purpose', 'response', get_class($t).': '.$t->getMessage(), $session);
            return PaymentPurposeResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }
    }

    /**
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generatePaymentPurposeHttpRequest(): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'PaymentPurpose',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'ClientKey' => $billingSettings->getClientKey(),
            'Time' => (new \DateTime())->format('Y-m-d H:i:s')
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $response
     * @return PaymentPurposeResponse
     */
    private function generatePaymentPurposeResponse(array $response): PaymentPurposeResponse
    {
        $result = $response['Result'];
        if ($result == BillingResponseCode::SUCCESS_ACTION) {

            $paymentsPurpose = [];
            foreach ($response['PaymentPurpose'] as $paymentPurpose) {
                foreach ($paymentPurpose as $key=>$purpose) {
                    $localization = strtoupper($key);
                    switch ($localization) {
                        case 'RU':
                            $paymentsPurpose[] = new PaymentPurpose(
                                $paymentPurpose['ItemId'],
                                $localization,
                                $purpose
                            );
                            break;
                        case 'UA':
                            $paymentsPurpose[] = new PaymentPurpose(
                                $paymentPurpose['ItemId'],
                                $localization,
                                $purpose
                            );
                            break;
                        case 'EN':
                            $paymentsPurpose[] = new PaymentPurpose(
                                $paymentPurpose['ItemId'],
                                $localization,
                                $purpose
                            );
                            break;
                    }
                }
            }
            $paymentPurposeResponse = new PaymentPurposeResponse($result, $response['Time'], $paymentsPurpose);
        }else {
            $paymentPurposeResponse = LoadInformationResponse::buildWhenError($result);
        }

        return $paymentPurposeResponse;
    }

    /**
     * @param Chat $chat
     * @return GetClientCardsResponse
     */
    public function getClientCards(Chat $chat): GetClientCardsResponse
    {
        $session = $this->createSessionGuid();

        try {
            $httpsRequest = $this->generateGetClientCardsHttpRequest($chat);
            $this->log(
                ' getClientCards',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                ' getClientCards',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = $this->getBodyFromResponse($response);
            return $this->generateGetClientCardsResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('getClientCards', 'response', get_class($e).': '.$e->getMessage(), $session);
            return  GetClientCardsResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        } catch (\Throwable $t) {
            $this->log('getClientCards', 'response', get_class($t).': '.$t->getMessage(), $session);
            return  GetClientCardsResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }
    }

    /**
     * @param Chat $chat
     *
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateGetClientCardsHttpRequest(Chat $chat): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'LoadClientCards',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'Time' => (new \DateTime())->format('Y-m-d H:i:s'),
            'UserPhoneNumber' => $chat->getPhone()
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $response
     *
     * @return GetClientCardsResponse
     */
    private function generateGetClientCardsResponse(array $response): GetClientCardsResponse
    {
        $usersCards = [];
        if (isset($response['Cards'])) {
            foreach ($response['Cards'] as $card) {
                $usersCards[] = new UserCard(
                    $card['Card'],
                    '',
                    $card['DeleteToken']
                );
            }
        }

        return new GetClientCardsResponse($response['Result'], $response['Time'], $usersCards);
    }

    /**
     * @param TelegramRequest $telegramRequest
     * @param Chat $chat
     *
     * @return mixed|Response
     */
    public function unbindCardFromClient(TelegramRequest $telegramRequest, Chat $chat): Response
    {
        $session = $this->createSessionGuid();

        try {
            $httpsRequest = $this->generateUnbindCardFromClientHttpRequest($telegramRequest, $chat);
            $this->log(
                'unbindCardFromClient',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $response = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'unbindCardFromClient',
                'response',
                $response->getBody(),
                $session
            );
            $parsedJson = $this->getBodyFromResponse($response);
            return $this->generateUnbindCardFromClientResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('unbindCardFromClient', 'response', get_class($e).': '.$e->getMessage(), $session);
            return new Response (BillingResponseCode::UNKNOWN_ERROR, date('Y-m-d H:i:s'));
        } catch (\Throwable $t) {
            $this->log('unbindCardFromClient', 'response', get_class($t).': '.$t->getMessage(), $session);
            return new Response (BillingResponseCode::UNKNOWN_ERROR, date('Y-m-d H:i:s'));
        }
    }

    /**
     * @param TelegramRequest $telegramRequest
     * @param Chat $chat
     *
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateUnbindCardFromClientHttpRequest(TelegramRequest $telegramRequest, Chat $chat): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'UnbindCardFromClient',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'Time' => (new \DateTime())->format('Y-m-d H:i:s'),
            'UserPhoneNumber' => $chat->getPhone(),
            'DeleteToken' => $telegramRequest->getCallbackData()->getToken()
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $parsedJson
     *
     * @return Response
     */
    private function generateUnbindCardFromClientResponse(array $parsedJson): Response
    {
        if (!isset($parsedJson['Result'])) {
            return new Response(BillingResponseCode::UNKNOWN_ERROR, date('Y-m-d H:i:s'));
        }

        return new Response((int) $parsedJson['Result'],  $parsedJson['Time']);
    }

    /**
     * @param Cheque $cheque
     * @return VerifyResponse
     */
    public function verifyPackage(Cheque $cheque): VerifyResponse
    {
        $session = $this->createSessionGuid();

        try {
            $httpsRequest = $this->generateVerifyPackageHttpRequest($cheque);
            $this->log(
                'verify_package',
                'request',
                $httpsRequest->getUrl().' - '.$httpsRequest->getBody(),
                $session
            );
            $httpResponse = $this->getHttpClient()->sendRequest($httpsRequest);
            $this->log(
                'verify_package',
                'response',
                $httpResponse->getBody(),
                $session
            );
            $parsedJson = json_decode($httpResponse->getBody(), true);
            $response = $this->generateVerifyPackageResponse($parsedJson);
        } catch (CurlException $e) {
            $this->log('verify_package', 'response', get_class($e).': '.$e->getMessage(), $session);
            $response =  VerifyResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        } catch (\Throwable $t) {
            $this->log('verify_package', 'response', get_class($t).': '.$t->getMessage(), $session);
            $response =  VerifyResponse::buildWhenError(BillingResponseCode::UNKNOWN_ERROR);
        }

        return $response;
    }

    /**
     * @param Cheque $cheque
     *
     * @return HttpsRequest
     *
     * @throws \System\Exception\DiException
     * @throws \System\Exception\EmptyFetchResultException
     */
    private function generateVerifyPackageHttpRequest(Cheque $cheque): HttpsRequest
    {
        $billingSettings = $this->getBillingSettingsRepository()->findParams();
        $body = [
            'Command' => 'VerifyPackage',
            'Login' => $billingSettings->getLogin(),
            'Password' => $billingSettings->getPassword(),
            'ClientKey' => $billingSettings->getClientKey(),
            "EncashmentGuid" => 0,
            "ItemId" => $cheque->getItemId(),
            "Accounts" => $cheque->getAccount(),
            "Locale" => "ru",
            'Type' => 0,
            'Time' => (new \DateTime())->format('Y-m-d H:i:s')
        ];

        return $this->generateHttpsRequest($body, $billingSettings);
    }

    /**
     * @param array $parsedJson
     * @return VerifyResponse
     */
    private function generateVerifyPackageResponse(array $parsedJson): VerifyResponse
    {
        $result = $parsedJson['Result'];
        if ($result == BillingResponseCode::SUCCESS_ACTION and isset($parsedJson['Status'])) {
            $status = (int) $parsedJson['Status'];

            if (Cheque::OK === $status) {
                $verifyResult = new VerifyResponse(
                    $result,
                    $parsedJson['Time'],
                    $parsedJson['Items'][0]['ChequeId'],
                    isset($parsedJson['Items'][0]['PsId']) ? $parsedJson['Items'][0]['PsId'] : 0,
                    $parsedJson['Status'],
                    $parsedJson['Items'][0]['PaymentSystemId'],
                    (int)$parsedJson['Items'][0]['ItemId']
                );

                if (isset($parsedJson['Items'][0]['Display'])) {
                    $display = $parsedJson['Items'][0]['Display'];

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

                if (isset($parsedJson['Items'][0]['Print'])) {
                    $chequesPrint = [];
                    foreach ($parsedJson['Items'][0]['Print'] as $print) {
                        $chequesPrint[] = new ChequePrint(
                            $print['Text'] ?? '',
                            $print['Value'] ?? '',
                            $print['Target'] ?? ''
                        );
                    }

                    $verifyResult->setChequesPrint($chequesPrint);
                }

                if (isset($parsedJson['Items'][0]['AcquiringCommissions'])) {
                    $acquiringCommissions = [];
                    foreach ($parsedJson['Items'][0]['AcquiringCommissions'] as $acquiringCommission) {

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
                return new VerifyResponse($result, '', 0, 0, $status, 0);
            }
        } else {
            $verifyResult = VerifyResponse::buildWhenError($result);
        }

        return $verifyResult;
    }
}