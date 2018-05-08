<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ccc\VendorSchedule\Controller\Index;

use Magento\Framework\App\Action\Context;
use Ccc\VendorSchedule\Model\PostFactory;

class Index extends \Magento\Framework\App\Action\Action{
    protected $postFactory;
    protected $_pageFactory;
    protected $resultJsonFactory;
    protected $customerSession;


    public function __construct(Context $context,
            \Magento\Framework\View\Result\PageFactory $pageFactory,
            \Magento\Customer\Model\Session $customerSession,
            PostFactory $postFactory) {
        $this->_pageFactory = $pageFactory;
        $this->postFactory = $postFactory;
        $this->customerSession = $customerSession;
        return parent::__construct($context);
    }
    
    public function execute() {
        
        //$this->_eventManager->dispatch('check_login');
        
        if($this->getRequest()->getParams() != NULL){
            if(!$this->customerSession->isLoggedIn()){
                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $urlInterface = $objectManager->get('\Magento\Framework\UrlInterface');
                $this->customerSession->setAfterAuthUrl($urlInterface->getCurrentUrl());
                $this->customerSession->authenticate();
            }else{
                $data = $this->postFactory->create();
                $data->setData('vendor_id',(int)$this->getRequest()->getParam('appointment_vendor'))
                        ->setData('customer_id',(int)$this->getRequest()->getParam('appointment_customer'))
                        ->setData('time',$this->getRequest()->getParam('appointment_time'))
                        ->setData('date',$this->getRequest()->getParam('appointment_date') )
                        ->setData('address',$this->getRequest()->getParam('appointment_address'))
                        ->setData('content',$this->getRequest()->getParam('appointment_content'))
                        ->setData('status',"vendor unread")
                ->save();
            }
        }
        return $this->_pageFactory->create();
        
    }

}