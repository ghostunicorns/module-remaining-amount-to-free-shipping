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
use Magento\SalesRule\Model\RuleRepository;

class GetRemainingAmountToFreeShipping
{
    /**
     * @var RuleRepository
     */
    private $ruleRepository;

    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param Session $checkoutSession
     * @param RuleRepository $ruleRepository
     * @param Config $config
     */
    public function __construct(
        Session $checkoutSession,
        RuleRepository $ruleRepository,
        Config $config
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->ruleRepository = $ruleRepository;
        $this->config = $config;
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
            $ruleId = $this->config->getRuleId();
            if (!$ruleId) {
                return '';
            }
            $cartRule = $this->ruleRepository->getById($ruleId);
        } catch (Exception $e) {
            return '';
        }

        if (!$cartRule->getIsActive()) {
            return '';
        }

        $freeShippingThreshold = (float)$cartRule->getCondition()->getConditions()[0]->getValue();
        if (!$freeShippingThreshold) {
            return '';
        }
        $itemTotal = $this->checkoutSession->getQuote()->getGrandTotal();
        $remainingAmountToFreeShipping = $freeShippingThreshold - $itemTotal;

        if ($remainingAmountToFreeShipping < 0) {
            return '';
        }

        return number_format($remainingAmountToFreeShipping, 2, '.', '');
    }
}
