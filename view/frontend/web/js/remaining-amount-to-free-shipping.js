/*
 * Copyright © Ghost Unicorns snc. All rights reserved.
 * See LICENSE for license details.
 */

define([
        'uiComponent',
        'Magento_Customer/js/customer-data'
    ], function (Component, customerData) {
        'use strict';
        return Component.extend({
            initialize: function () {
                this.remainingAmountToFreeShipping = customerData.get('remainingAmountToFreeShipping');
                this.hasRemainingAmountToFreeShipping = this.remainingAmountToFreeShipping().hasOwnProperty('amount') &&
                    this.remainingAmountToFreeShipping().amount !== '';
                console.log(this.remainingAmountToFreeShipping());
                console.log(this.remainingAmountToFreeShipping().amount);

                this._super();
            },
        });
    }
);
