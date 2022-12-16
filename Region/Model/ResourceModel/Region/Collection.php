<?php
namespace Cowell\Region\Model\ResourceModel\Region;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'region_id';
    protected function _construct()
    {
        $this->_init(\Cowell\Region\Model\Region::class, \Cowell\Region\Model\ResourceModel\Region::class);
    }
}
