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
class Netgo_Pricereminder_Block_Netgopricereminder_List
    extends Mage_Core_Block_Template {
    /**
     * initialize
     * @access public
     * @author NetGo
     */
     public function __construct(){
        parent::__construct();
         $netgopricereminders = Mage::getResourceModel('netgo_pricereminder/netgopricereminder_collection')
                         ->addStoreFilter(Mage::app()->getStore())
                         ->addFieldToFilter('status', 1);
        $netgopricereminders->setOrder('emailid', 'asc');
        $this->setNetgopricereminders($netgopricereminders);
    }
    /**
     * prepare the layout
     * @access protected
     * @return Netgo_Pricereminder_Block_Netgopricereminder_List
     * @author NetGo
     */
    protected function _prepareLayout(){
        parent::_prepareLayout();
        $pager = $this->getLayout()->createBlock('page/html_pager', 'netgo_pricereminder.netgopricereminder.html.pager')
            ->setCollection($this->getNetgopricereminders());
        $this->setChild('pager', $pager);
        $this->getNetgopricereminders()->load();
        return $this;
    }
    /**
     * get the pager html
     * @access public
     * @return string
     * @author NetGo
     */
    public function getPagerHtml(){
        return $this->getChildHtml('pager');
    }
}
