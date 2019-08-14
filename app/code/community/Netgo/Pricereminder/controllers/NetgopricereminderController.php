<?php
/***************************************
 *** Price Drop Notifier ***
 ***************************************
 *
 * @copyright   Copyright (c) 2015
 * @company     NetAttingo Technologies
 * @package     Netgo_Pricereminder
 * @author 		NetGo
 * @dev			netattingomails@gmail.com
 *
 */
class Netgo_Pricereminder_NetgopricereminderController
    extends Mage_Core_Controller_Front_Action {
    /**
      * default action
      * @access public
      * @return void
      * @author NetGo
      */
    public function indexAction(){
         $this->loadLayout();
         $this->_initLayoutMessages('catalog/session');
         $this->_initLayoutMessages('customer/session');
         $this->_initLayoutMessages('checkout/session');
         if (Mage::helper('netgo_pricereminder/netgopricereminder')->getUseBreadcrumbs()){
             if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
                 $breadcrumbBlock->addCrumb('home', array(
                            'label'    => Mage::helper('netgo_pricereminder')->__('Home'),
                            'link'     => Mage::getUrl(),
                        )
                 );
                 $breadcrumbBlock->addCrumb('netgopricereminders', array(
                            'label'    => Mage::helper('netgo_pricereminder')->__('Netgopricereminder'),
                            'link'    => '',
                    )
                 );
             }
         }
        $this->renderLayout();
    }
    /**
     * init Netgopricereminder
     * @access protected
     * @return Netgo_Pricereminder_Model_Entity
     * @author NetGo
     */
    protected function _initNetgopricereminder(){
        $netgopricereminderId   = $this->getRequest()->getParam('id', 0);
        $netgopricereminder     = Mage::getModel('netgo_pricereminder/netgopricereminder')
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->load($netgopricereminderId);
        if (!$netgopricereminder->getId()){
            return false;
        }
        elseif (!$netgopricereminder->getStatus()){
            return false;
        }
        return $netgopricereminder;
    }
    /**
      * view netgopricereminder action
      * @access public
      * @return void
      * @author NetGo
      */
    public function viewAction(){
        $netgopricereminder = $this->_initNetgopricereminder();
        if (!$netgopricereminder) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_netgopricereminder', $netgopricereminder);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('pricereminder-netgopricereminder pricereminder-netgopricereminder' . $netgopricereminder->getId());
        }
        if (Mage::helper('netgo_pricereminder/netgopricereminder')->getUseBreadcrumbs()){
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')){
                $breadcrumbBlock->addCrumb('home', array(
                            'label'    => Mage::helper('netgo_pricereminder')->__('Home'),
                            'link'     => Mage::getUrl(),
                        )
                );
                $breadcrumbBlock->addCrumb('netgopricereminders', array(
                            'label'    => Mage::helper('netgo_pricereminder')->__('Netgopricereminder'),
                            'link'    => Mage::helper('netgo_pricereminder/netgopricereminder')->getNetgopriceremindersUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb('netgopricereminder', array(
                            'label'    => $netgopricereminder->getEmailid(),
                            'link'    => '',
                    )
                );
            }
        }
        $this->renderLayout();
    }
	
	
	public function saveNotificationAction(){
	 
	 $rmodel = Mage::getModel('netgo_pricereminder/netgopricereminder');
	 $storemodel = Mage::getModel('netgo_pricereminder/netgopricereminder_store');
	 $storeId = Mage::app()->getStore()->getId();
	 $storearr= array($storeId); 
		$data = $this->getRequest()->getParams();
		
		
		$savedata['emailid']=$data['emailid'];
		$savedata['productid']=$data['productid'];
		$savedata['rprice']=$data['rprice']; 
		$savedata['status']=1; 
		$savedata['stores']= $storearr;
		
		switch($data['notifyoption']){
			case 'fixed':
			$savedata['isfixed']=1;
			$savedata['isvariable']=0;
			break;
			case 'variable':
			$savedata['isvariable']=1;
			$savedata['isfixed']=0;
			break;
		}
	    //find record by email and product id
		$collection = $rmodel->getCollection()->addFieldToFilter('emailid',$savedata['emailid'])
																->addFieldToFilter('status',1) 
																->addFieldToFilter('productid',$savedata['productid'])->load();
		$recData = $collection->getData(); 									
		if(count($recData)>0){
			$savedata['entity_id']=$recData[0]['entity_id'];
		}									
		 
	    $rmodel->setData($savedata);
		$rmodel->save();
		$msg='success';
		echo $msg;die;//ajax hit response , do not remove
	}
	
	
		/**
	* Unsubscribe one notification
	* params emailid , productid
	*
	**/
	public function unsubscribeOneAction(){
		$emailid =$this->getRequest()->getParam('emailid');
		$productid = $this->getRequest()->getParam('productid');
		$rmodel = Mage::getModel('netgo_pricereminder/netgopricereminder');
        $collection = $rmodel->getCollection()->addFieldToFilter('emailid',$emailid)
																  ->addFieldToFilter('status',1) 
																   ->addFieldToSelect('entity_id') 
																  ->addFieldToFilter('productid',$productid)->load();
		$recData = $collection->getData(); 
        if(count($recData)>0){
			 foreach($recData as $key=>$value){
				 $this->deleteRecordById($value['entity_id']);
			 }
		}
		 $this->loadLayout();		
         $this->renderLayout();		
	}
	
	
	/**
	* Unsubscribe all notifications
	* params emailid , productid
	*
	**/
	public function unsubscribeAllAction(){
		
		$emailid =$this->getRequest()->getParam('emailid'); 
		$rmodel = Mage::getModel('netgo_pricereminder/netgopricereminder');
        $collection = $rmodel->getCollection()->addFieldToFilter('emailid',$emailid)
																  ->addFieldToFilter('status',1) 
																  ->addFieldToSelect('entity_id') 
																  ->load();
		$recData = $collection->getData(); 
        if(count($recData)>0){
			 foreach($recData as $key=>$value){
				 $this->deleteRecordById($value['entity_id']);
			 }
		}	
	 
		 $this->loadLayout();		
       $this->renderLayout();		
	}
	
	public function deleteRecordById($entity_id){
	   	Mage::getModel('netgo_pricereminder/netgopricereminder')->setEntityId($entity_id)->delete(); 
	}
	
	
}
