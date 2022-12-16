<?php

namespace Cowell\ProductShippingMethod\Plugin;

use Magento\Quote\Model\Quote\Item\ToOrderItem;
use Magento\Quote\Model\Quote\Item\AbstractItem;
class CopyPaymentFeeToOrderItem
{
    public function aroundConvert(
        ToOrderItem $subject,
        \Closure $proceed,
        AbstractItem $item,
        $additional = []
    ) {
        /** @var $orderItem \Magento\Sales\Model\Order\Item */
        $orderItem = $proceed($item, $additional);
        $orderItem->setPaymentFee($item->getPaymentFee());
        return $orderItem;
    }
}
