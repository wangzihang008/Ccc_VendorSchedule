<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Ccc\VendorSchedule\Api;

interface PostInterface{
    
    /**
    @api
    @return String
    */
    //public function getId();
    /**
    @api
    @Param String
    @return
    */
    //public function setId($id);
    
    /*public function getVendorId();
    public function setVendorId($vendorId);
    
    public function getCustomerId();
    public function setCustomerId($customerId);
    
    public function getTime();
    public function setTime($time);
    
    public function getDate();
    public function setDate($date);
    
    public function getContent();
    public function setContent($content);
    
    public function getStatus();
    public function setStatus($status);*/
    
    /**
     * @api
     * @return
    */
    public function getCollection();
    
    /**
     * @api 
     * @param string $vendorId
     * @return array
    */
    public function getVendorCollection($vendorId);
}