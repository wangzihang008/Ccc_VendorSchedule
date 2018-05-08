<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ccc\VendorSchedule\Observer;
 
use Magento\Framework\Event\ObserverInterface;
use Ccc\VendorSchedule\Model\PostFactory;
 
class CheckLoginPersistentObserver implements ObserverInterface{
    
    protected $redirect;

    /**
     * Customer session
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Response\RedirectInterface $redirect

    ) {

        $this->customerSession = $customerSession;
        $this->redirect = $redirect;

    }

    public function execute(\Magento\Framework\Event\Observer $observer) {
        $controller = $observer->getControllerAction();
        //var_dump($controller);
        if($controller == 'index' && !$this->customerSession->isLoggedIn()) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $urlInterface = $objectManager->get('\Magento\Framework\UrlInterface');
            $this->customerSession->setAfterAuthUrl($urlInterface->getCurrentUrl());
            $this->customerSession->authenticate(Mage::getUrl('customer/account'));
            //Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account'));
        }
    }

}