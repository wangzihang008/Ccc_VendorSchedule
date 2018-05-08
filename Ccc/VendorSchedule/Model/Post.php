<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ccc\VendorSchedule\Model;

class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
// \Ccc\VendorSchedule\Model\Api\Data\PostInterface
{
    const CACHE_TAG = 'ccc_vendorschedule_appointment';
    protected $_cacheTag = 'ccc_vendorschedule_appointment';
    protected $_eventPrefix = 'ccc_vendorschedule_appointment';
    
    
    protected function _construct()
    {
        $this->_init('Ccc\VendorSchedule\Model\ResourceModel\Post');
    }
    
    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    
    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
    
    public function getId() {
        return $this->getData('id');
    }

    public function getContent() {
        return $this->getData('content');
    }

    public function getCustomerId($customerId) {
        return $this->setData('customer_id',$customerId);
    }

    public function getDate() {
        return $this->getData('date');
    }

    public function getStatus() {
        return $this->getData('status');
    }

    public function getTime() {
        return $this->getData('time');
    }

    public function getVendorId() {
        return $this->getData('vendor_id');
    }

    public function setContent($content) {
        return $this->setData('content',$content);
    }

    public function setCustomerId($customerId) {
        return $this->setData('customer_id',$customerId);
    }

    public function setDate($date) {
        return $this->setData('date',$date);
    }

    public function setStatus($status) {
        return $this->setData('status',$status);
    }

    public function setTime($time) {
        return $this->setData('time',$time);
    }

    public function setVendorId($vendorId) {
        return $this->setData('vendor_id',$vendorId);
    }
    
    public function getAddress(){
        return $this->getData('address');
    }
    
    public function setAddress($address){
        return $this->setData('address', $address);
    }
    
    public function getVendorName(){
        return $this->getData('vendor_name');
    }
    
    public function setVendorName($vendorName){
        return $this->setData('vendor_name', $vendorName);
    }
    
    public function getCustomerName(){
        return $this->getData('customer_name');
    }
    
    public function setCustomerName($customerName){
        return $this->setData('customer_name', $customer_name);
    }

}