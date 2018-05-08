<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ccc\VendorSchedule\Observer;
 
use Magento\Framework\Event\ObserverInterface;
use Ccc\VendorSchedule\Model\PostFactory;
 
class insertData implements ObserverInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;
    protected $_request;
    protected $_postFactory;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
            \Magento\Framework\App\Request\Http $request,
            PostFactory $postFactory
    ) {
        $this->_objectManager = $objectManager;
        $this->_request = $request;
        $this->_postFactory = $postFactory;
    }
 
    /**
     * customer register event handler
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        //Do your stuff here!
        //die('Observer Is called!');
        //$observer->getDataByKey($key);
        $data = $this->_postFactory->create();
        $this->eventManager->dispatch('insert_data');
        
        if($observer->hasData()){
            $VENDOR_ID = $observer->getData('vendor_id'); 
            $CUSTOMER_ID = $observer->getData('CUSTOMER_ID');
            $TIME = $observer->getData('TIME');
            $DATE = $observer->getData('DATE');
            $ADDRESS = $observer->getData('ADDRESS');
            $CONTENT = $observer->getData('CONTENT');
            $STATUS = $observer->getData('STATUS');
            
            $data->setData('vendor_id',$VENDOR_ID)
                    ->setData('customer_id',$CUSTOMER_ID)
                    ->setData('time',$TIME)
                    ->setData('date',$DATE )
                    ->setData('address',$ADDRESS)
                    ->setData('content',$CONTENT)
                    ->setData('status',$STATUS)
            ->save();
            
        }
    }
}