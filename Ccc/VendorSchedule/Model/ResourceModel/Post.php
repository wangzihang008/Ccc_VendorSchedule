<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ccc\VendorSchedule\Model\ResourceModel;

class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb{
    
    protected $_date;
    
    public function __construct(\Magento\Framework\Stdlib\DateTime\DateTime $date,
            \Magento\Framework\Model\ResourceModel\Db\Context $context) {
        $this->_date = $date;
        parent::__construct($context);
    }

    protected function _construct() {
        $this->_init('ccc_vendorschedule_appointment', 'id');
    }
    
    public function getVendorIdById($id)
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()
            ->from($this->getMainTable(), 'vendor_id')
            ->where('id = :id');
        $binds = ['id' => (int)$id];
        return $adapter->fetchOne($select, $binds);
    }
    
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $object->setUpdatedAt($this->_date->date());
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->_date->date());
        }
        return parent::_beforeSave($object);
    }

}