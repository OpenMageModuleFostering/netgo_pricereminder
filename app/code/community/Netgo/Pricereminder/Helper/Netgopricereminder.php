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
class Netgo_Pricereminder_Helper_Netgopricereminder
    extends Mage_Core_Helper_Abstract {
		
		protected $jsdir = 'netgo/pricereminder/';
    /**
     * get the url to the netgopricereminder list page
     * @access public
     * @return string
     * @author NetGo
     */
    public function getNetgopriceremindersUrl(){
        if ($listKey = Mage::getStoreConfig('netgo_pricereminder/netgopricereminder/url_rewrite_list')) {
            return Mage::getUrl('', array('_direct'=>$listKey));
        }
        return Mage::getUrl('netgo_pricereminder/netgopricereminder/index');
    }
    /**
     * check if breadcrumbs can be used
     * @access public
     * @return bool
     * @author NetGo
     */
    public function getUseBreadcrumbs(){
        return Mage::getStoreConfigFlag('netgo_pricereminder/netgopricereminder/breadcrumbs');
    }
	
	 protected $_files = array(
       'jquery-1.10.2.min.js',
       'noconflict.js',
   );
 
   
   public function getFiles(){ 
	   return  $this->_files;
   } 
 
   
   
      public function getJQueryPath($filename){ 
	    return $this->jsdir.$filename; 
   }
   
     public function isEnableExtension(){ 
	   $enableext = Mage::getStoreConfig('netgo_pricereminder/netgopricereminder/enablenotifier');
	   if($enableext==1){
		   return true;
	   }else{ 
		   return false;
	   }
   }
   
   public function isEnableJQuery(){ 
	   $enablejQuery = Mage::getStoreConfig('netgo_pricereminder/netgopricereminder/enablejquery');
	   if($enablejQuery==1){
		   return true;
	   }else{ 
		   return false;
	   }
   }
}
