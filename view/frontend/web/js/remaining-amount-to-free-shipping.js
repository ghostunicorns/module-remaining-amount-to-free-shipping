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
                this.cart = customerData.get('cart');

                this._super();
            },
        });
    }
);
