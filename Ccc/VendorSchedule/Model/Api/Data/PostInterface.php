<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ccc\VendorSchedule\Model\Api\Data;

interface PostInterface{
    
    public function getId();
    public function setId();
    
    public function getVendorId();
    public function setVendorId();
    
    public function getCustomerId();
    public function setCustomerId();
    
    public function getTime();
    public function setTime();
    
    public function getDate();
    public function setDate();
    
    public function getContent();
    public function setContent();
    
    public function getStatus();
    public function setStatus();
}