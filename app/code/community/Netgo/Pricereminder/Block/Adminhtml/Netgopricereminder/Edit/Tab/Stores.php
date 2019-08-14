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
class Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Edit_Tab_Stores
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Edit_Tab_Stores
     * @author NetGo
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setFieldNameSuffix('netgopricereminder');
        $this->setForm($form);
        $fieldset = $form->addFieldset('netgopricereminder_stores_form', array('legend'=>Mage::helper('netgo_pricereminder')->__('Store views')));
        $field = $fieldset->addField('store_id', 'multiselect', array(
            'name'  => 'stores[]',
            'label' => Mage::helper('netgo_pricereminder')->__('Store Views'),
            'title' => Mage::helper('netgo_pricereminder')->__('Store Views'),
            'required'  => true,
            'values'=> Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
        ));
        $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
        $field->setRenderer($renderer);
          $form->addValues(Mage::registry('current_netgopricereminder')->getData());
        return parent::_prepareForm();
    }
}
