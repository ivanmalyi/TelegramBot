<?php

declare(strict_types=1);

namespace System\Component\Billing;

use System\Entity\Component\Billing\Response\CheckResponse;
use System\Entity\Component\Billing\Response\DownloadKeysResponse;
use System\Entity\Component\Billing\Response\GetClientCardsResponse;
use System\Entity\Component\Billing\Response\GetPaymentPageResponse;
use System\Entity\Component\Billing\Response\LoadCommissionResponse;
use System\Entity\Component\Billing\Response\LoadInformationResponse;
use System\Entity\Component\Billing\Response\LoadItemsTagsResponse;
use System\Entity\Component\Billing\Response\LoadOperatorsResponse;
use System\Entity\Component\Billing\Response\LoadPaymentSystemsResponse;
use System\Entity\Component\Billing\Response\LoadRecipientResponse;
use System\Entity\Component\Billing\Response\PaymentPurposeResponse;
use System\Entity\Component\Billing\Response\PayResponse;
use System\Entity\Component\Billing\Response\Response;
use System\Entity\Component\Billing\Response\VerifyResponse;
use System\Entity\InternalProtocol\Request\Telegram\TelegramRequest;
use System\Entity\Repository\CallbackUrl;
use System\Entity\Repository\Chat;
use System\Entity\Repository\Cheque;
use System\Entity\Repository\ChequeCallbackUrl;
use System\Entity\Repository\Payment;

/**
 * Interface BillingComponentInterface
 * @package System\Component\Billing
 */
interface BillingComponentInterface
{
    /**
     * @return DownloadKeysResponse
     */
    public function downloadKeys(): DownloadKeysResponse;

    /**
     * @return LoadOperatorsResponse
     */
    public function loadOperators(): LoadOperatorsResponse;

    /**
     * @return LoadCommissionResponse
     */
    public function loadCommission(): LoadCommissionResponse;

    /**
     * @return LoadRecipientResponse
     */
    public function loadRecipient(): LoadRecipientResponse;

    /**
     * @param Cheque $cheque
     * @return VerifyResponse
     */
    public function verify(Cheque $cheque): VerifyResponse;

    /**
     * @return LoadPaymentSystemsResponse
     */
    public function loadPaymentSystems(): LoadPaymentSystemsResponse;

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
    ): GetPaymentPageResponse;

    /**
     * @param Payment $payment
     * @return PayResponse
     */
    public function payByAcquiringOrder(Payment $payment): PayResponse;

    /**
     * @return LoadItemsTagsResponse
     */
    public function loadItemsTags(): LoadItemsTagsResponse;

    /**
     * @param Payment $payment
     * @return CheckResponse
     */
    public function check(Payment $payment): CheckResponse;

    /**
     * @return LoadInformationResponse
     */
    public function loadInformation(): LoadInformationResponse;

    /**
     * @return PaymentPurposeResponse
     */
    public function paymentPurpose(): PaymentPurposeResponse;

    /**
     * @param Chat $chat
     * @return GetClientCardsResponse
     */
    public function getClientCards(Chat $chat): GetClientCardsResponse;


    /**
     * @param TelegramRequest $telegramRequest
     * @param Chat $chat
     *
     * @return Response
     */
    public function unbindCardFromClient(TelegramRequest $telegramRequest, Chat $chat): Response;

    /**
     * @param Cheque $cheque
     * @return VerifyResponse
     */
    public function verifyPackage(Cheque $cheque): VerifyResponse;
}