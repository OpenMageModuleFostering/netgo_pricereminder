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
class Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * constructor
     * @access public
     * @return void
     * @author NetGo
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'netgo_pricereminder';
        $this->_controller = 'adminhtml_netgopricereminder';
        $this->_updateButton('save', 'label', Mage::helper('netgo_pricereminder')->__('Save Netgopricereminder'));
        $this->_updateButton('delete', 'label', Mage::helper('netgo_pricereminder')->__('Delete Netgopricereminder'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('netgo_pricereminder')->__('Save And Continue Edit'),
            'onclick'    => 'saveAndContinueEdit()',
            'class'        => 'save',
        ), -100);
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    /**
     * get the edit form header
     * @access public
     * @return string
     * @author NetGo
     */
    public function getHeaderText(){
        if( Mage::registry('current_netgopricereminder') && Mage::registry('current_netgopricereminder')->getId() ) {
            return Mage::helper('netgo_pricereminder')->__("Edit Netgopricereminder '%s'", $this->escapeHtml(Mage::registry('current_netgopricereminder')->getEmailid()));
        }
        else {
            return Mage::helper('netgo_pricereminder')->__('Add Netgopricereminder');
        }
    }
}
