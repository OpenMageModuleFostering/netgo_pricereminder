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
class Netgo_Pricereminder_Helper_Data
    extends Mage_Core_Helper_Abstract {
    /**
     * convert array to options
     * @access public
     * @param $options
     * @return array
     * @author NetGo
     */
    public function convertOptions($options){
        $converted = array();
        foreach ($options as $option){
            if (isset($option['value']) && !is_array($option['value']) && isset($option['label']) && !is_array($option['label'])){
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }
}
