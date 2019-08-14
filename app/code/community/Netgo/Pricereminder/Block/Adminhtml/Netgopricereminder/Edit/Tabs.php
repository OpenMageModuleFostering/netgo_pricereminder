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
class Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs {
    /**
     * Initialize Tabs
     * @access public
     * @author NetGo
     */
    public function __construct() {
        parent::__construct();
        $this->setId('netgopricereminder_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('netgo_pricereminder')->__('Netgopricereminder'));
    }
    /**
     * before render html
     * @access protected
     * @return Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Edit_Tabs
     * @author NetGo
     */
    protected function _beforeToHtml(){
        $this->addTab('form_netgopricereminder', array(
            'label'        => Mage::helper('netgo_pricereminder')->__('Netgopricereminder'),
            'title'        => Mage::helper('netgo_pricereminder')->__('Netgopricereminder'),
            'content'     => $this->getLayout()->createBlock('netgo_pricereminder/adminhtml_netgopricereminder_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_netgopricereminder', array(
                'label'        => Mage::helper('netgo_pricereminder')->__('Store views'),
                'title'        => Mage::helper('netgo_pricereminder')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('netgo_pricereminder/adminhtml_netgopricereminder_edit_tab_stores')->toHtml(),
            ));
        }
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve netgopricereminder entity
     * @access public
     * @return Netgo_Pricereminder_Model_Netgopricereminder
     * @author NetGo
     */
    public function getNetgopricereminder(){
        return Mage::registry('current_netgopricereminder');
    }
}
