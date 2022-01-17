<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\RemainingAmountToFreeShipping\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    /** @var string */
    const XML_PATH_GENERAL_ENABLED = 'ghostunicorns_remainingamounttofreeshipping/general/enabled';

    /** @var string */
    const XML_PATH_GENERAL_SHOW_IN_CART = 'ghostunicorns_remainingamounttofreeshipping/general/show_in_cart';

    /** @var string */
    const XML_PATH_GENERAL_SHOW_IN_MINICART = 'ghostunicorns_remainingamounttofreeshipping/general/show_in_minicart';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfigInterface
     */
    public function __construct(
        ScopeConfigInterface $scopeConfigInterface
    )
    {
        $this->scopeConfig = $scopeConfigInterface;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_GENERAL_ENABLED);
    }

    /**
     * @return bool
     */
    public function getShowInCart(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_GENERAL_SHOW_IN_CART);
    }

    /**
     * @return bool
     */
    public function getShowInMinicart(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_GENERAL_SHOW_IN_MINICART);
    }

    /**
     * @return float
     */
    public function getFreeShippingSubtotal(): float
    {
        $shippingSubtotal = $this->scopeConfig->getValue(
            'carriers/freeshipping/free_shipping_subtotal',
            ScopeInterface::SCOPE_STORE
        );

        return !$shippingSubtotal ? 0.0 : (float)$shippingSubtotal;
    }
}
