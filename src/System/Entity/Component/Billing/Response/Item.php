<?php

declare(strict_types=1);

namespace System\Entity\Component\Billing\Response;

use System\Entity\Component\Billing\Display;

/**
 * Class Item
 * @package System\Entity\Component\Billing\Response
 */
class Item
{
    /**
     * @var int
     */
    private $itemId;

    /**
     * @var int
     */
    private $chequeId;

    /**
     * @var int
     */
    private $paymentSystemId;

    /**
     * @var Display
     */
    private $display;

    /**
     * @var ChequePrint[]
     */
    private $print;

    /**
     * @var AdditionalAccount[]
     */
    private $additionalAccounts;

    /**
     * @var Commission[]
     */
    private $commissions;

    /**
     * @var null|Discount
     */
    private $discount;

    /**
     * Item constructor.
     * @param int $itemId
     * @param int $chequeId
     * @param int $paymentSystemId
     * @param Display $display
     * @param ChequePrint[] $print
     * @param AdditionalAccount[] $additionalAccounts
     * @param Commission[] $commissions
     * @param null|Discount $discount
     */
    public function __construct(
        int $itemId,
        int $chequeId,
        int $paymentSystemId,
        Display $display,
        array $print,
        array $additionalAccounts,
        array $commissions,
        ?Discount $discount
    )
    {
        $this->itemId = $itemId;
        $this->chequeId = $chequeId;
        $this->paymentSystemId = $paymentSystemId;
        $this->display = $display;
        $this->print = $print;
        $this->additionalAccounts = $additionalAccounts;
        $this->commissions = $commissions;
        $this->discount = $discount;
    }

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @return int
     */
    public function getChequeId(): int
    {
        return $this->chequeId;
    }

    /**
     * @return int
     */
    public function getPaymentSystemId(): int
    {
        return $this->paymentSystemId;
    }

    /**
     * @return Display
     */
    public function getDisplay(): Display
    {
        return $this->display;
    }

    /**
     * @return ChequePrint[]
     */
    public function getPrint(): array
    {
        return $this->print;
    }

    /**
     * @return AdditionalAccount[]
     */
    public function getAdditionalAccounts(): array
    {
        return $this->additionalAccounts;
    }

    /**
     * @return Commission[]
     */
    public function getCommissions(): array
    {
        return $this->commissions;
    }

    /**
     * @return null|Discount
     */
    public function getDiscount(): ?Discount
    {
        return $this->discount;
    }
}
