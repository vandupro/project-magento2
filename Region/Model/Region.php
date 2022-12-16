<?php

namespace Cowell\Region\Model;

class Region extends \Magento\Framework\Model\AbstractExtensibleModel
{
    protected function _construct()
    {
        $this->_init('Cowell\Region\Model\ResourceModel\Region');
    }
}
