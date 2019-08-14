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
class Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Edit_Tab_Form
     * @author NetGo
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('netgopricereminder_');
        $form->setFieldNameSuffix('netgopricereminder');
        $this->setForm($form);
        $fieldset = $form->addFieldset('netgopricereminder_form', array('legend'=>Mage::helper('netgo_pricereminder')->__('Netgopricereminder')));

        $fieldset->addField('emailid', 'text', array(
            'label' => Mage::helper('netgo_pricereminder')->__('Email Id'),
            'name'  => 'emailid',
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('productid', 'text', array(
            'label' => Mage::helper('netgo_pricereminder')->__('Product Id'),
            'name'  => 'productid',

        ));

        $fieldset->addField('rprice', 'text', array(
            'label' => Mage::helper('netgo_pricereminder')->__('Reminder Price'),
            'name'  => 'rprice',

        ));

        $fieldset->addField('isfixed', 'select', array(
            'label' => Mage::helper('netgo_pricereminder')->__('Is Fixed'),
            'name'  => 'isfixed',
            'note'	=> $this->__('If selected on fixed, then mail will be send only when price gets lower than the specified price'),

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('netgo_pricereminder')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('netgo_pricereminder')->__('No'),
                ),
            ),
        ));

        $fieldset->addField('isvariable', 'select', array(
            'label' => Mage::helper('netgo_pricereminder')->__('Is Variable'),
            'name'  => 'isvariable',
            'note'	=> $this->__("If it's yes, then mail will be send if the product price gets decreased."),

            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('netgo_pricereminder')->__('Yes'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('netgo_pricereminder')->__('No'),
                ),
            ),
        ));
        $fieldset->addField('url_key', 'text', array(
            'label' => Mage::helper('netgo_pricereminder')->__('Url key'),
            'name'  => 'url_key',
            'note'    => Mage::helper('netgo_pricereminder')->__('Relative to Website Base URL')
        ));
        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('netgo_pricereminder')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('netgo_pricereminder')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('netgo_pricereminder')->__('Disabled'),
                ),
            ),
        ));
        if (Mage::app()->isSingleStoreMode()){
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_netgopricereminder')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_netgopricereminder')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getNetgopricereminderData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getNetgopricereminderData());
            Mage::getSingleton('adminhtml/session')->setNetgopricereminderData(null);
        }
        elseif (Mage::registry('current_netgopricereminder')){
            $formValues = array_merge($formValues, Mage::registry('current_netgopricereminder')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
