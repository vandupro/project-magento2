<?php

namespace Cowell\ProductShippingMethod\Plugin;

use Magento\Quote\Api\Data\TotalsItemInterface;
use Magento\Quote\Model\Cart\Totals\ItemConverter;
class QuoteItemExtensionAttribute
{
    /**
     * @param ItemConverter $subject
     * @param TotalsItemInterface $result
     * @param Item $item
     * @return TotalsItemInterface
     */
    public function afterModelToDataObject(ItemConverter $subject, TotalsItemInterface $result, $item): TotalsItemInterface
    {
        if(!$item['payment_fee']){
            $item['payment_fee'] = 0;
        }
        $result->getExtensionAttributes()->setPaymentFee($item['payment_fee']);
        return $result;
    }
}
