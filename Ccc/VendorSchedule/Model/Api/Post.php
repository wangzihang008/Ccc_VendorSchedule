<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ccc\VendorSchedule\Model\Api;

class Post extends \Magento\Framework\Model\AbstractModel{
    const CACHE_TAG = 'ccc_vendorschedule_appointment';
    protected $_cacheTag = 'ccc_vendorschedule_appointment';
    protected $_eventPrefix = 'ccc_vendorschedule_appointment';
    
    protected function _construct()
    {
        $this->_init('Ccc\VendorSchedule\Model\ResourceModel\Post');
    }
    
    public function getCollection() {
        $collection = $this->getResourceCollection();
        $result = [];
        foreach($collection as $item){
            $re = [
                'id' => $item->getData('id'),
                'vendor_id' => $item->getData('vendor_id'),
                'vendor_name' => $item->getData('vendor_name'),
                'customer_id' => $item->getData('customer_id'),
                'customer_name' => $item->getData('customer_name'),
                'time' => $item->getData('time'),
                'date' => $item->getData('date'),
                'address' => $item->getData('address'),
                'content' => $item->getData('content'),
                'status' => $item->getData('status')
                    ];
            array_push($result, $re);
        }
        return $result;
    }
    
    public function getVendorCollection($vendorId){
        $collection = $this->getResourceCollection();
        $result = [];
        foreach($collection as $item){
            if($item->getData('vendor_id') === $vendorId){
                $re = [
                    'id' => $item->getData('id'),
                    'vendor_id' => $item->getData('vendor_id'),
                    'vendor_name' => $item->getData('vendor_name'),
                    'customer_id' => $item->getData('customer_id'),
                    'customer_name' => $item->getData('customer_name'),
                    'time' => $item->getData('time'),
                    'date' => $item->getData('date'),
                    'address' => $item->getData('address'),
                    'content' => $item->getData('content'),
                    'status' => $item->getData('status')
                        ];
                array_push($result, $re);
            }
        }
        return $result;
    }
} 