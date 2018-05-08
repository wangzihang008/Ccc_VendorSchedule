<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ccc\VendorSchedule\Block;
class Post extends \Magento\Framework\View\Element\Template
{
    protected $postFactory;
    protected $request;


    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
     \Ccc\VendorSchedule\Model\PostFactory $postFactory,
            \Magento\Framework\App\Request\Http $request)
    {
        $this->request = $request;
        $this->postFactory = $postFactory;
        parent::__construct($context);
    }

    public function sayHello()
    {
        return __('Hello World');
    }
    
    /*function _prepareLayout()
    {
        $todo = $this->postFactory->create();
        $collection = $todo->getCollection();

        foreach($collection as $item)
        {
            var_dump('Item ID: ' . $item->getId());
            var_dump($item->getData());
        }
        exit;
    }*/
    
    public function getCollection(){
        return $this->postFactory->create()->getCollection();
    }
    
    public function getVendorId(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        return $customerSession->getCustomer()->getId();
    }
    
    public function getContent($id){
        $todo = $this->postFactory->create();
        $collection = $todo->getCollection();
        foreach($collection as $item)
        {
            if($item->getId() == $id){
                return $item->getData('content');
            }
        }
    }
    
    public function getId($time, $date, $vendor_id){
        $todo = $this->postFactory->create();
        $collection = $todo->getCollection();
        foreach($collection as $item)
        {
            if($item->getId() == $vendor_id && $item->getDate() == $date && $this->getTime() == $time){
                return $item->getData('id');
            }
        }
    }
    
    public function getRequiredCollection($status, $id){
        $todo = $this->postFactory->create();
        $collection = $todo->getCollection();
        $result = array();
        foreach($collection as $item)
        {
            if($item->getVendorId() == $id && $item->getStatus() == $status){
                array_push($result, $item);
            }
        }
        return $result;
    }
    
    
    /*public function execute(){
        $data = $this->postFactory->create();
        /*$todo->setData('vendor_id',$data["vendor_id"])
                ->setData('customer_id',$data["customer_id"])
                ->setData('time',$data["time"])
                ->setData('date',$data["date"])
                ->setData('address',$data["address"])
                ->setData('content',$data["content"])
                ->setData('status',$data["status"])
        ->save();
        //if ($this->getRequest()->getPostValue()  != null) {
            $post = $this->getRequest()->getPostValue();
            /*$VENDOR_ID = $this->getRequest()->getPost('VENDOR_ID'); 
            $CUSTOMER_ID = $this->getRequest()->getPost('CUSTOMER_ID');
            $TIME = $this->getRequest()->getPost('TIME');
            $DATE = $this->getRequest()->getPost('DATE');
            $ADDRESS = $this->getRequest()->getPost('ADDRESS');
            $CONTENT = $this->getRequest()->getPost('CONTENT');
            $STATUS = $this->getRequest()->getPost('STATUS');
            
            $VENDOR_ID = $post('VENDOR_ID'); 
            $CUSTOMER_ID = $post('CUSTOMER_ID');
            $TIME = $post('TIME');
            $DATE = $post('DATE');
            $ADDRESS = $post('ADDRESS');
            $CONTENT = $post('CONTENT');
            $STATUS = $post('STATUS');
            
            $data->setData('vendor_id',$VENDOR_ID)
                    ->setData('customer_id',$CUSTOMER_ID)
                    ->setData('time',$TIME)
                    ->setData('date',$DATE )
                    ->setData('address',$ADDRESS)
                    ->setData('content',$CONTENT)
                    ->setData('status',$STATUS)
            ->save();
        }
    }*/
    
    function insertData(){
        $data = $this->postFactory->create();
        $VENDOR_ID = $this->getRequest()->getPost('VENDOR_ID'); 
        $CUSTOMER_ID = $this->getRequest()->getPost('CUSTOMER_ID');
        $TIME = $this->getRequest()->getPost('TIME');
        $DATE = $this->getRequest()->getPost('DATE');
        $ADDRESS = $this->getRequest()->getPost('ADDRESS');
        $CONTENT = $this->getRequest()->getPost('CONTENT');
        $STATUS = $this->getRequest()->getPost('STATUS');
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