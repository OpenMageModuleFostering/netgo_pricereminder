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
class Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder
    extends Mage_Adminhtml_Block_Widget_Grid_Container {
    /**
     * constructor
     * @access public
     * @return void
     * @author NetGo
     */
    public function __construct(){
        $this->_controller         = 'adminhtml_netgopricereminder';
        $this->_blockGroup         = 'netgo_pricereminder';
        parent::__construct();
        $this->_headerText         = Mage::helper('netgo_pricereminder')->__('Netgopricereminder');
        $this->_updateButton('add', 'label', Mage::helper('netgo_pricereminder')->__('Add Netgopricereminder'));

    }
}
