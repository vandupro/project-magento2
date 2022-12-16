<?php

namespace Cowell\ProductShippingMethod\Model\Total\Quote;

use Magento\Framework\Pricing\PriceCurrencyInterface;

class Custom extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{

    protected $_priceCurrency;

    /**
     * Custom constructor.
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    )
    {
        $this->_priceCurrency = $priceCurrency;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this|bool
     */
    public function collect(
        \Magento\Quote\Model\Quote                          $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total            $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);
        $quoteItems = $quote->getAllItems();
        $paymentFees = 0;
        foreach ($quoteItems as $quoteItem) {
            $paymentFees += $quoteItem['payment_fee'];
        }
        $paymentFees = $this->_priceCurrency->convert($paymentFees);
        $total->addTotalAmount($this->getCode(), +$paymentFees);
        $total->addBaseTotalAmount($this->getCode(), +$paymentFees);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() + $paymentFees);
        $quote->setPaymentFee($paymentFees);
        return $this;
    }

    public function fetch(
        \Magento\Quote\Model\Quote               $quote,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        $quoteItems = $quote->getAllItems();
        $paymentFees = 0;
        foreach ($quoteItems as $quoteItem) {
            $paymentFees += $quoteItem['payment_fee'];
        }
        $paymentFees = $this->_priceCurrency->convert($paymentFees);
        return [
            'code' => $this->getCode(),
            'title' => $this->getLabel(),
            'value' => $paymentFees  //You can change the reduced amount, or replace it with your own variable
        ];
    }
}
