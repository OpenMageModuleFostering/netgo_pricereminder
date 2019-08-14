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
class Netgo_Pricereminder_Model_Adminhtml_Search_Netgopricereminder
    extends Varien_Object {
    /**
     * Load search results
     * @access public
     * @return Netgo_Pricereminder_Model_Adminhtml_Search_Netgopricereminder
     * @author NetGo
     */
    public function load(){
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('netgo_pricereminder/netgopricereminder_collection')
            ->addFieldToFilter('emailid', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $netgopricereminder) {
            $arr[] = array(
                'id'=> 'netgopricereminder/1/'.$netgopricereminder->getId(),
                'type'  => Mage::helper('netgo_pricereminder')->__('Netgopricereminder'),
                'name'  => $netgopricereminder->getEmailid(),
                'description'   => $netgopricereminder->getEmailid(),
                'url' => Mage::helper('adminhtml')->getUrl('*/pricereminder_netgopricereminder/edit', array('id'=>$netgopricereminder->getId())),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
