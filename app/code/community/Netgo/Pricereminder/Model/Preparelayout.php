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
class Netgo_Pricereminder_Model_Preparelayout
    extends Mage_Core_Model_Abstract {
		
    public function prepareLayoutBefore(Varien_Event_Observer $observer)
   {
	  
	     if (Mage::helper('netgo_pricereminder/netgopricereminder')->isEnableExtension()) 
		 {  
				$block = $observer->getEvent()->getBlock(); 
				 
				if (Mage::helper('netgo_pricereminder/netgopricereminder')->isEnableJQuery()) 
				{  
					/* @var $block Mage_Page_Block_Html_Head */ 
					if ("head" == $block->getNameInLayout()) {  
				 
					foreach (Mage::helper('netgo_pricereminder/netgopricereminder')->getFiles() as   $file) {
						$block->addJs(Mage::helper('netgo_pricereminder/netgopricereminder')->getJQueryPath($file)); 
						} 
					}
				} 
			 
	}
       return $this;
   }
	
 
}
