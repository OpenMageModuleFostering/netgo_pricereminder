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
class Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Grid
    extends Mage_Adminhtml_Block_Widget_Grid {
    /**
     * constructor
     * @access public
     * @author NetGo
     */
    public function __construct(){
        parent::__construct();
        $this->setId('netgopricereminderGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    /**
     * prepare collection
     * @access protected
     * @return Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Grid
     * @author NetGo
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('netgo_pricereminder/netgopricereminder')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Grid
     * @author NetGo
     */
    protected function _prepareColumns(){
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('netgo_pricereminder')->__('Id'),
            'index'        => 'entity_id',
            'type'        => 'number'
        ));
        $this->addColumn('emailid', array(
            'header'    => Mage::helper('netgo_pricereminder')->__('Email Id'),
            'align'     => 'left',
            'index'     => 'emailid',
        ));
        $this->addColumn('status', array(
            'header'    => Mage::helper('netgo_pricereminder')->__('Status'),
            'index'        => 'status',
            'type'        => 'options',
            'options'    => array(
                '1' => Mage::helper('netgo_pricereminder')->__('Enabled'),
                '0' => Mage::helper('netgo_pricereminder')->__('Disabled'),
            )
        ));
        $this->addColumn('productid', array(
            'header'=> Mage::helper('netgo_pricereminder')->__('Product Id'),
            'index' => 'productid',
            'type'=> 'number',

        ));
        $this->addColumn('rprice', array(
            'header'=> Mage::helper('netgo_pricereminder')->__('Reminder Price'),
            'index' => 'rprice',
            'type'=> 'number',

        ));
        $this->addColumn('isfixed', array(
            'header'=> Mage::helper('netgo_pricereminder')->__('Is Fixed'),
            'index' => 'isfixed',
            'type'    => 'options',
            'options'    => array(
                '1' => Mage::helper('netgo_pricereminder')->__('Yes'),
                '0' => Mage::helper('netgo_pricereminder')->__('No'),
            )

        ));
        $this->addColumn('isvariable', array(
            'header'=> Mage::helper('netgo_pricereminder')->__('Is Variable'),
            'index' => 'isvariable',
            'type'    => 'options',
            'options'    => array(
                '1' => Mage::helper('netgo_pricereminder')->__('Yes'),
                '0' => Mage::helper('netgo_pricereminder')->__('No'),
            )

        ));
        $this->addColumn('url_key', array(
            'header' => Mage::helper('netgo_pricereminder')->__('URL key'),
            'index'  => 'url_key',
        ));
        if (!Mage::app()->isSingleStoreMode() && !$this->_isExport) {
            $this->addColumn('store_id', array(
                'header'=> Mage::helper('netgo_pricereminder')->__('Store Views'),
                'index' => 'store_id',
                'type'  => 'store',
                'store_all' => true,
                'store_view'=> true,
                'sortable'  => false,
                'filter_condition_callback'=> array($this, '_filterStoreCondition'),
            ));
        }
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('netgo_pricereminder')->__('Created at'),
            'index'     => 'created_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('netgo_pricereminder')->__('Updated at'),
            'index'     => 'updated_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('action',
            array(
                'header'=>  Mage::helper('netgo_pricereminder')->__('Action'),
                'width' => '100',
                'type'  => 'action',
                'getter'=> 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('netgo_pricereminder')->__('Edit'),
                        'url'   => array('base'=> '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter'=> false,
                'is_system'    => true,
                'sortable'  => false,
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('netgo_pricereminder')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('netgo_pricereminder')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('netgo_pricereminder')->__('XML'));
        return parent::_prepareColumns();
    }
    /**
     * prepare mass action
     * @access protected
     * @return Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Grid
     * @author NetGo
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('netgopricereminder');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('netgo_pricereminder')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('netgo_pricereminder')->__('Are you sure?')
        ));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('netgo_pricereminder')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'status' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('netgo_pricereminder')->__('Status'),
                        'values' => array(
                                '1' => Mage::helper('netgo_pricereminder')->__('Enabled'),
                                '0' => Mage::helper('netgo_pricereminder')->__('Disabled'),
                        )
                )
            )
        ));
        $this->getMassactionBlock()->addItem('isfixed', array(
            'label'=> Mage::helper('netgo_pricereminder')->__('Change Is Fixed'),
            'url'  => $this->getUrl('*/*/massIsfixed', array('_current'=>true)),
            'additional' => array(
                'flag_isfixed' => array(
                        'name' => 'flag_isfixed',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('netgo_pricereminder')->__('Is Fixed'),
                        'values' => array(
                                '1' => Mage::helper('netgo_pricereminder')->__('Yes'),
                                '0' => Mage::helper('netgo_pricereminder')->__('No'),
                            )

                )
            )
        ));
        $this->getMassactionBlock()->addItem('isvariable', array(
            'label'=> Mage::helper('netgo_pricereminder')->__('Change Is Variable'),
            'url'  => $this->getUrl('*/*/massIsvariable', array('_current'=>true)),
            'additional' => array(
                'flag_isvariable' => array(
                        'name' => 'flag_isvariable',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('netgo_pricereminder')->__('Is Variable'),
                        'values' => array(
                                '1' => Mage::helper('netgo_pricereminder')->__('Yes'),
                                '0' => Mage::helper('netgo_pricereminder')->__('No'),
                            )

                )
            )
        ));
        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param Netgo_Pricereminder_Model_Netgopricereminder
     * @return string
     * @author NetGo
     */
    public function getRowUrl($row){
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    /**
     * get the grid url
     * @access public
     * @return string
     * @author NetGo
     */
    public function getGridUrl(){
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
    /**
     * after collection load
     * @access protected
     * @return Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Grid
     * @author NetGo
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    /**
     * filter store column
     * @access protected
     * @param Netgo_Pricereminder_Model_Resource_Netgopricereminder_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     * @return Netgo_Pricereminder_Block_Adminhtml_Netgopricereminder_Grid
     * @author NetGo
     */
    protected function _filterStoreCondition($collection, $column){
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $collection->addStoreFilter($value);
        return $this;
    }
}
