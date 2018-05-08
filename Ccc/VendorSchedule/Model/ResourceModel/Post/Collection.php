<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ccc\VendorSchedule\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'ccc_vendorschedule_appointment_collection';
    protected $_eventObject = 'post_collection';
    
    protected function _construct()
    {
        $this->_init('Ccc\VendorSchedule\Model\Post', 'Ccc\VendorSchedule\Model\ResourceModel\Post');
    }
    
    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(\Zend_Db_Select::GROUP);
        return $countSelect;
    }
    
    protected function _toOptionArray($valueField = 'id', $labelField = 'vendor_id', $additional = [])
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
}