<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\RemainingAmountToFreeShipping\ViewModel;

use GhostUnicorns\RemainingAmountToFreeShipping\Model\GetRemainingAmountToFreeShipping;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class RemainingAmountToFreeShipping implements ArgumentInterface
{
    /**
     * @var GetRemainingAmountToFreeShipping
     */
    private $getRemainingAmountToFreeShipping;

    /**
     * @param GetRemainingAmountToFreeShipping $getRemainingAmountToFreeShipping
     */
    public function __construct(
        GetRemainingAmountToFreeShipping $getRemainingAmountToFreeShipping
    ) {
        $this->getRemainingAmountToFreeShipping = $getRemainingAmountToFreeShipping;
    }

    /**
     * Return the cash amount needed to reach the free shipping threshold
     *
     * @return string
     * @throws LocalizedException
     */
    public function getRemainingAmountToFreeShipping(): string
    {
        return $this->getRemainingAmountToFreeShipping->execute();
    }
}
