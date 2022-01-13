<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\RemainingAmountToFreeShipping\CustomerData;

use GhostUnicorns\RemainingAmountToFreeShipping\Model\Config;
use GhostUnicorns\RemainingAmountToFreeShipping\Model\GetRemainingAmountToFreeShipping;
use Magento\Customer\CustomerData\SectionSourceInterface;

class RemainingAmountToFreeShipping implements SectionSourceInterface
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
    public function __construct(
        GetRemainingAmountToFreeShipping $getRemainingAmountToFreeShipping,
        Config $config
    ) {
        $this->getRemainingAmountToFreeShipping = $getRemainingAmountToFreeShipping;
        $this->config = $config;
    }

    /**
     * @inheritdoc
     */
    public function getSectionData()
    {
        if (!$this->config->isEnabled()) {
            return [];
        }

        if (!$this->config->getShowInMinicart()) {
            return [];
        }

        $remainingAmountToFreeShipping = $this->getRemainingAmountToFreeShipping->execute();
        return [
            'amount' => $remainingAmountToFreeShipping
        ];
    }
}
