<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Ccc\VendorSchedule\Controller\Ticket;

use Magento\Framework\App\Action\Context;
use Ccc\VendorSchedule\Model\PostFactory;

class Index extends \Magento\Framework\App\Action\Action{
    protected $postFactory;
    protected $_pageFactory;
    protected $resultJsonFactory;
    protected $customerSession;


    public function __construct(Context $context,
            \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
            \Magento\Framework\View\Result\PageFactory $pageFactory,
            \Magento\Customer\Model\Session $customerSession,
            PostFactory $postFactory
            ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_pageFactory = $pageFactory;
        $this->postFactory = $postFactory;
        $this->customerSession = $customerSession;
        return parent::__construct($context);
    }
    
    public function execute() {
        $message = "";
        //$this->_eventManager->dispatch('check_login');
        if(!$this->customerSession->isLoggedIn()){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $urlInterface = $objectManager->get('\Magento\Framework\UrlInterface');
            $this->customerSession->setAfterAuthUrl($urlInterface->getCurrentUrl());
            $this->customerSession->authenticate();
        }else if($this->getRequest()->getParams() != NULL){
            
            if($this->getRequest()->getParam('unread_edit')){
                $data = $this->postFactory->create()->getCollection();
                foreach($data as $item){
                    if($item->getId() == $this->getRequest()->getParam('unread_appointment_id')){
                        $item ->setDate($this->getRequest()->getParam('unread_date'))
                                ->setTime($this->getRequest()->getParam('unread_time'))
                                ->setAddress($this->getRequest()->getParam('unread_address'))
                                ->setStatus("vendor unread")
                        ->save();
                        $vendor_name = $item->getVendorName();
                        //$this->messageManager->addSuccess("The appointment has been modified and sent to " . $vendor_name);
                        $message = "The appointment has been modified and sent to " . $vendor_name;
                    }
                }
            }else if($this->getRequest()->getParam('unread_add')){
                if($this->getRequest()->getParam('unread_new_message') == ""){
                    $this->messageManager->addErrorMessage("The content of message of appointment cannot be empty!");
                    return;
                }
                $this->customerSession = $this->_objectManager->create('Magento\Customer\Model\Session');
                $datetime = $this->_objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime')->gmtDate();
                $data = $this->postFactory->create()->getCollection();
                foreach($data as $item){
                    if($item->getId() == $this->getRequest()->getParam('unread_appointment_id')){
                        $old_content = $item->getContent();
                        $item->setContent($old_content . $item->getCustomerName() . " " . $datetime . "<br />" .  str_replace(array("\r\n", "\r", "\n"), "<br />",$this->getRequest()->getParam('unread_new_message')) . "<br />")
                                ->setStatus("vendor unread")
                        ->save();
                        $vendor_name = $item->getVendorName();
                        //$this->messageManager->addSuccess("The new message of appointment has been sent to " . $vendor_name);
                        $message = "The new message of appointment has been sent to " . $vendor_name;
                    }
                }
            }else if($this->getRequest()->getParam('unread_cancel')){
                $data = $this->postFactory->create()->getCollection();
                foreach($data as $item){
                    if($item->getId() == $this->getRequest()->getParam('unread_appointment_id')){
                        $item->setStatus("cancelled")
                        ->save();
                        //$this->messageManager->addSuccess("The appointment has been cancelled ");
                        $message = "The appointment has been cancelled ";
                    }
                }
            }else if($this->getRequest()->getParam('booked_finish')){
                $data = $this->postFactory->create()->getCollection();
                foreach($data as $item){
                    if($item->getId() == $this->getRequest()->getParam('unread_appointment_id')){
                        $item->setStatus("finished")
                        ->save();
                        //$this->messageManager->addSuccess("The appointment has been finished ");
                        $message = "The appointment has been finished";
                    }
                }
            }else if($this->getRequest()->getParam('appointment_edit')){
                $data = $this->postFactory->create()->getCollection();
                foreach($data as $item){
                    if($item->getId() == $this->getRequest()->getParam('appointment_id')){
                        $item->setDate($this->getRequest()->getParam('appointment_date'))
                                ->setTime($this->getRequest()->getParam('appointment_time'))
                                ->setAddress($this->getRequest()->getParam('appointment_address'))
                        ->save();
                        //$this->messageManager->addSuccess("The appointment has been finished ");
                        $message = "The appointment has been changed";
                    }
                }
            }else if($this->getRequest()->getParam('appointment_cancel')){
                $data = $this->postFactory->create()->getCollection();
                foreach($data as $item){
                    if($item->getId() == $this->getRequest()->getParam('appointment_id')){
                        $item->setStatus("cancelld")
                        ->save();
                        //$this->messageManager->addSuccess("The appointment has been cancelled ");
                        $message = "The appointment has been cancelled";
                    }
                }
            }else if($this->getRequest()->getParam('appointment_send')){
                if($this->getRequest()->getParam('unread_new_message') == ""){
                    $this->messageManager->addErrorMessage("The content of message of appointment cannot be empty!");
                    return;
                }
                $data = $this->postFactory->create()->getCollection();
                foreach($data as $item){
                    if($item->getId() == $this->getRequest()->getParam('appointment_id')){
                        $old_content = $item->getContent();
                        $item->setContent($old_content . $item->getVendorName() . " " . $datetime . "<br />" .  str_replace(array("\r\n", "\r", "\n"), "<br />",$this->getRequest()->getParam('unread_new_message')) . "<br />")
                                ->setStatus("customer unread")
                        ->save();
                        //$this->messageManager->addSuccess("The new message has been sent to " . $this->getRequest()->getParam('appointment_vendor') );
                        $message = "The new message has been sent to " . $this->getRequest()->getParam('appointment_vendor');
                    }
                }
            }else if($this->getRequest()->getParam('appointment_finish')){
                $data = $this->postFactory->create()->getCollection();
                foreach($data as $item){
                    if($item->getId() == $this->getRequest()->getParam('appointment_id')){
                        $item->setStatus("finished")
                        ->save();
                        //$this->messageManager->addSuccess("The appointment has been finished ");
                        $message = "The appointment has been finished";
                    }
                }
            }
            $request = $this->getRequest();
            $request->setParam('schedule-message', $message);
        }
        return $this->_pageFactory->create();
        
    }

}