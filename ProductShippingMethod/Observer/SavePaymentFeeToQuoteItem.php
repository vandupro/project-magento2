<?php

namespace Cowell\ProductShippingMethod\Observer;

use Magento\Framework\Event\ObserverInterface;
class SavePaymentFeeToQuoteItem implements ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quoteItem = $observer->getQuoteItem();
        $product = $observer->getProduct();
        $quoteItem->setPaymentFee($product->getData('payment_fee'));
    }
}
