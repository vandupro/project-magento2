define(
    [
        'jquery',
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals',
        'Magento_Catalog/js/price-utils'
    ],
    function ($,Component,quote,totals,priceUtils) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Cowell_ProductShippingMethod/checkout/summary/payment-fee'
            },
            totals: quote.getTotals(),
            isDisplayedPaymentFee : function () {
                return true;
            },
            getPaymentTotal : function () {
                var price = totals.getSegment('payment_fee').value;
                return this.getFormattedPrice(price);
            }
        });
    }
);
