<?php

namespace Cowell\Region\Model\ResourceModel;

class Region extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('directory_country_region', 'region_id');
    }

    public function saveRegionName($data, $id){
        $this->getConnection()->beginTransaction();
        try {
            if ($id) {
                $this->deleteById($id);
            }
            $this->getConnection()->insertMultiple('directory_country_region_name', $data);
            $this->getConnection()->commit();
        } catch (\Exception $e) {
            $this->getConnection()->rollBack();
            throw $e;
        }

    }

    public function deleteById($id){
        $whereConditions = [
            $this->getConnection()->quoteInto('region_id = ?', $id),
        ];
        $this->getConnection()->delete('directory_country_region_name',$whereConditions);
    }
    public function getRegionName($regionId){
        $select = $this->getConnection()->select()->from(
            ['directory_country_region_name']
        )->where('region_id = ' . $regionId);
        $regionName = $this->getConnection()->fetchAll($select);
        return $regionName;
    }
}
