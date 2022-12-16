<?php

namespace Cowell\ProductShippingMethod\Plugin;

use Magento\Quote\Model\Quote\Item;
use Magento\Framework\Pricing\Helper\Data;
class AddPaymentFeeToCustomData
{
    /** @var Data $priceHelper */
    protected $priceHelper;
    public function __construct(Data $priceHelper,) {
        $this->priceHelper = $priceHelper;
    }
    public function aroundGetItemData($subject, \Closure $proceed, Item $item)
    {
        $data = $proceed($item);
        $product = $item->getData();

        $atts = [
            "payment_fee" => $this->priceHelper->currency($product['payment_fee'], true, false)
        ];
        return array_merge($data, $atts);
    }
}
