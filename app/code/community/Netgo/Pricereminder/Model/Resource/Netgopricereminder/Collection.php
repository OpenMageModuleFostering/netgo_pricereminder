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
class Netgo_Pricereminder_Model_Resource_Netgopricereminder_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    protected $_joinedFields = array();
    /**
     * constructor
     * @access public
     * @return void
     * @author NetGo
     */
    protected function _construct(){
        parent::_construct();
        $this->_init('netgo_pricereminder/netgopricereminder');
        $this->_map['fields']['store'] = 'store_table.store_id';
    }
    /**
     * Add filter by store
     * @access public
     * @param int|Mage_Core_Model_Store $store
     * @param bool $withAdmin
     * @return Netgo_Pricereminder_Model_Resource_Netgopricereminder_Collection
     * @author NetGo
     */
    public function addStoreFilter($store, $withAdmin = true){
        if (!isset($this->_joinedFields['store'])){
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }
            if (!is_array($store)) {
                $store = array($store);
            }
            if ($withAdmin) {
                $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
            }
            $this->addFilter('store', array('in' => $store), 'public');
            $this->_joinedFields['store'] = true;
        }
        return $this;
    }
    /**
     * Join store relation table if there is store filter
     * @access protected
     * @return Netgo_Pricereminder_Model_Resource_Netgopricereminder_Collection
     * @author NetGo
     */
    protected function _renderFiltersBefore(){
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('store_table' => $this->getTable('netgo_pricereminder/netgopricereminder_store')),
                'main_table.entity_id = store_table.netgopricereminder_id',
                array()
            )->group('main_table.entity_id');
            /*
             * Allow analytic functions usage because of one field grouping
             */
            $this->_useAnalyticFunction = true;
        }
        return parent::_renderFiltersBefore();
    }
    /**
     * get netgopricereminders as array
     * @access protected
     * @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     * @author NetGo
     */
    protected function _toOptionArray($valueField='entity_id', $labelField='emailid', $additional=array()){
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
    /**
     * get options hash
     * @access protected
     * @param string $valueField
     * @param string $labelField
     * @return array
     * @author NetGo
     */
    protected function _toOptionHash($valueField='entity_id', $labelField='emailid'){
        return parent::_toOptionHash($valueField, $labelField);
    }
    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     * @access public
     * @return Varien_Db_Select
     * @author NetGo
     */
    public function getSelectCountSql(){
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(Zend_Db_Select::GROUP);
        return $countSelect;
    }
}
