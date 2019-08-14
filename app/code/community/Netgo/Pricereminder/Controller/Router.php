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
class Netgo_Pricereminder_Controller_Router
    extends Mage_Core_Controller_Varien_Router_Abstract {
    /**
     * init routes
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Netgo_Pricereminder_Controller_Router
     * @author NetGo
     */
    public function initControllerRouters($observer){
        $front = $observer->getEvent()->getFront();
        $front->addRouter('netgo_pricereminder', $this);
        return $this;
    }
    /**
     * Validate and match entities and modify request
     * @access public
     * @param Zend_Controller_Request_Http $request
     * @return bool
     * @author NetGo
     */
    public function match(Zend_Controller_Request_Http $request){
        if (!Mage::isInstalled()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();
            exit;
        }
        $urlKey = trim($request->getPathInfo(), '/');
        $check = array();
        $check['netgopricereminder'] = new Varien_Object(array(
            'prefix'        => Mage::getStoreConfig('netgo_pricereminder/netgopricereminder/url_prefix'),
            'suffix'        => Mage::getStoreConfig('netgo_pricereminder/netgopricereminder/url_suffix'),
            'list_key'       => Mage::getStoreConfig('netgo_pricereminder/netgopricereminder/url_rewrite_list'),
            'list_action'   => 'index',
            'model'         =>'netgo_pricereminder/netgopricereminder',
            'controller'    => 'netgopricereminder',
            'action'        => 'view',
            'param'         => 'id',
            'check_path'    => 0
        ));
        foreach ($check as $key=>$settings) {
            if ($settings->getListKey()) {
                if ($urlKey == $settings->getListKey()) {
                    $request->setModuleName('netgo_pricereminder')
                        ->setControllerName($settings->getController())
                        ->setActionName($settings->getListAction());
                    $request->setAlias(
                        Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                        $urlKey
                    );
                    return true;
                }
            }
            if ($settings['prefix']){
                $parts = explode('/', $urlKey);
                if ($parts[0] != $settings['prefix'] || count($parts) != 2){
                    continue;
                }
                $urlKey = $parts[1];
            }
            if ($settings['suffix']){
                $urlKey = substr($urlKey, 0 , -strlen($settings['suffix']) - 1);
            }
            $model = Mage::getModel($settings->getModel());
            $id = $model->checkUrlKey($urlKey, Mage::app()->getStore()->getId());
            if ($id){
                if ($settings->getCheckPath() && !$model->load($id)->getStatusPath()) {
                    continue;
                }
                $request->setModuleName('netgo_pricereminder')
                    ->setControllerName($settings->getController())
                    ->setActionName($settings->getAction())
                    ->setParam($settings->getParam(), $id);
                $request->setAlias(
                    Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                    $urlKey
                );
                return true;
            }
        }
        return false;
    }
}
