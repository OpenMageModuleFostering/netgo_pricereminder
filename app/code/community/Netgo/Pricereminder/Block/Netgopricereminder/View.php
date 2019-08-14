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
class Netgo_Pricereminder_Block_Netgopricereminder_View
    extends Mage_Core_Block_Template {
    /**
     * get the current netgopricereminder
     * @access public
     * @return mixed (Netgo_Pricereminder_Model_Netgopricereminder|null)
     * @author NetGo
     */
    public function getCurrentNetgopricereminder(){
        return Mage::registry('current_netgopricereminder');
    }
}
