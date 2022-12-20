<?php

namespace Cowell\ProductShippingMethod\Plugin;

use Magento\Quote\Model\Quote;
use Magento\Quote\Model\ShippingMethodManagement;
use Magento\Quote\Api\CartRepositoryInterface;
class RestrictShippingMethodsByProduct
{

    /**
     * Quote repository model
     *
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    public function __construct(
        CartRepositoryInterface $quoteRepository
    ) {
        $this->quoteRepository = $quoteRepository;
    }


    /**
     * @param ShippingMethodManagement $subject
     * @return array;
     */
    public function afterEstimateByAddressId(ShippingMethodManagement $subject, $result, int $cartId, int $addressId) {

        /** @var Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);

        $data = [];
        foreach ($quote->getItems() as $item) {
            if ($item->getData('shipping_methods')) {
                $data[] = explode(",",$item->getData('shipping_methods'));
            }
        }
        if (empty($data)) {
            return [];
        }
        $intersect = call_user_func_array('array_intersect',$data);
        foreach ($result as $key => $value) {
            if (!in_array($value->getMethodCode(), $intersect)) {
                unset($result[$key]);
            }
        }
        return $result;

    }
}
