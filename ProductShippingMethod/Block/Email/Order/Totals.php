<?php

namespace Cowell\ProductShippingMethod\Block\Email\Order;

class Totals extends \Magento\Framework\View\Element\AbstractBlock
{
    public function initTotals()
    {
        $orderTotalsBlock = $this->getParentBlock();
        $order = $orderTotalsBlock->getOrder();
        if ($order->getPaymentFee() > 0) {
            $orderTotalsBlock->addTotal(new \Magento\Framework\DataObject([
                'code'       => 'payment_fee',
                'label'      => __('Payment Fee'),
                'value'      => $order->getPaymentFee(),
                'base_value' => $order->getPaymentFee(),
            ]), 'subtotal');
        }
    }
}
