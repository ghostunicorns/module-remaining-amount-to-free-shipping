<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\RemainingAmountToFreeShipping\Model;

use Exception;
use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Shipping\Model\CarrierFactory;

class GetRemainingAmountToFreeShipping
{
    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var CarrierFactory
     */
    private $carrierFactory;

    /**
     * @param Session $checkoutSession
     * @param CarrierFactory $carrierFactory
     * @param Config $config
     */
    public function __construct(
        Session        $checkoutSession,
        CarrierFactory $carrierFactory,
        Config         $config
    )
    {
        $this->checkoutSession = $checkoutSession;
        $this->config = $config;
        $this->carrierFactory = $carrierFactory;
    }

    /**
     * Return the cash amount needed to reach the free shipping threshold
     *
     * @return string
     * @throws LocalizedException
     */
    public function execute(): string
    {
        if (!$this->config->isEnabled()) {
            return '';
        }
        try {
            $freeShippingSubtotal = $this->config->getFreeShippingSubtotal();
            if ($freeShippingSubtotal <= 0) {
                return '';
            }
        } catch (Exception $e) {
            return '';
        }

        $itemTotal = $this->checkoutSession->getQuote()->getTotals();

        if (!array_key_exists('shipping', $itemTotal) || !array_key_exists('grand_total', $itemTotal)) {
            return '';
        }

        $shippingFee = $itemTotal['shipping'];
        $grandTotal = $itemTotal['grand_total'];
        $quoteTotalWithShipping = (float)$grandTotal->getData('value');

        if ($shippingFee->getData('value') !== null) {
            $shippingAmount = (float)$shippingFee->getData('value');
            $remainingAmountToFreeShipping = $quoteTotalWithShipping - $shippingAmount;
        }else {
            $remainingAmountToFreeShipping = $quoteTotalWithShipping;
        }

        $remainingAmountToFreeShipping = $freeShippingSubtotal - $remainingAmountToFreeShipping;

        if ($remainingAmountToFreeShipping < 0) {
            return '';
        }

        return number_format($remainingAmountToFreeShipping, 2, '.', '');
    }
}
