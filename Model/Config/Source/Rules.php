<?php
/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

declare(strict_types=1);

namespace GhostUnicorns\RemainingAmountToFreeShipping\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory;
use Magento\SalesRule\Model\Rule;

class Rules implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $rules = [
            [
                'value' => 0,
                'label' => __('--- Select a Sales Rule ---')
            ]
        ];

        $collection = $this->collectionFactory->create();
        $collection->addIsActiveFilter();

        foreach ($collection as $rule) {
            /** @var $rule Rule */
            $rules[] =
                [
                    'value' => $rule->getRuleId(),
                    'label' => $rule->getName()
                ];
        }

        return $rules;
    }
}
