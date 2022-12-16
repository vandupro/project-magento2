define(
    [
        'Cowell_ProductShippingMethod/js/view/checkout/summary/payment-fee'
    ],
    function (Component) {
        'use strict';
        return Component.extend({
            /**
             * @override
             */
            isDisplayed: function () {
                return true;
            }
        });
    }
);
