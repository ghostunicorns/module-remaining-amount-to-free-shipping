<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GhostUnicorns\RemainingAmountToFreeShipping\Plugin\CustomerData;

use GhostUnicorns\RemainingAmountToFreeShipping\Model\Config;
use GhostUnicorns\RemainingAmountToFreeShipping\Model\GetRemainingAmountToFreeShipping;
use Magento\Checkout\CustomerData\Cart;
use Magento\Framework\Exception\LocalizedException;

class CartPlugin
{
    /**
     * @var GetRemainingAmountToFreeShipping
     */
    private $getRemainingAmountToFreeShipping;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param GetRemainingAmountToFreeShipping $getRemainingAmountToFreeShipping
     * @param Config $config
     */
    public function __construct(GetRemainingAmountToFreeShipping $getRemainingAmountToFreeShipping, Config $config)
    {
        $this->getRemainingAmountToFreeShipping = $getRemainingAmountToFreeShipping;
        $this->config = $config;
    }

    /**
     * @param Cart $subject
     * @param $result
     * @return array
     * @throws LocalizedException
     */
    public function afterGetSectionData(Cart $subject, $result)
    {
        if (!$this->config->isEnabled()) {
            return $result;
        }

        if (!$this->config->getShowInMinicart()) {
            return $result;
        }

        $remainingAmountToFreeShipping = $this->getRemainingAmountToFreeShipping->execute();

        $result['remainingAmountToFreeShipping'] = $remainingAmountToFreeShipping;
        return $result;
    }
}
