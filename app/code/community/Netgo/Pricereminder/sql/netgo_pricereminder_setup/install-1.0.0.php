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
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('netgo_pricereminder/netgopricereminder'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Netgopricereminder ID')
    ->addColumn('emailid', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Email Id')

    ->addColumn('productid', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Product Id')

    ->addColumn('rprice', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        ), 'Reminder Price')

    ->addColumn('isfixed', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        ), 'Is Fixed')

    ->addColumn('isvariable', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        ), 'Is Variable')

    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        ), 'Enabled')

    ->addColumn('url_key', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'URL key')

     ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        ), 'Netgopricereminder Status')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            ), 'Netgopricereminder Modification Time')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Netgopricereminder Creation Time') 
    ->setComment('Netgopricereminder Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
    ->newTable($this->getTable('netgo_pricereminder/netgopricereminder_store'))
    ->addColumn('netgopricereminder_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'primary'   => true,
        ), 'Netgopricereminder ID')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Store ID')
    ->addIndex($this->getIdxName('netgo_pricereminder/netgopricereminder_store', array('store_id')), array('store_id'))
    ->addForeignKey($this->getFkName('netgo_pricereminder/netgopricereminder_store', 'netgopricereminder_id', 'netgo_pricereminder/netgopricereminder', 'entity_id'), 'netgopricereminder_id', $this->getTable('netgo_pricereminder/netgopricereminder'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('netgo_pricereminder/netgopricereminder_store', 'store_id', 'core/store', 'store_id'), 'store_id', $this->getTable('core/store'), 'store_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Netgopricereminder To Store Linkage Table');
$this->getConnection()->createTable($table);
$this->endSetup();
