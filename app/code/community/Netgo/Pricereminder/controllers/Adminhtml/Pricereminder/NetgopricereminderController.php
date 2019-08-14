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
class Netgo_Pricereminder_Adminhtml_Pricereminder_NetgopricereminderController
    extends Netgo_Pricereminder_Controller_Adminhtml_Pricereminder {
    /**
     * init the netgopricereminder
     * @access protected
     * @return Netgo_Pricereminder_Model_Netgopricereminder
     */
    protected function _initNetgopricereminder(){
        $netgopricereminderId  = (int) $this->getRequest()->getParam('id');
        $netgopricereminder    = Mage::getModel('netgo_pricereminder/netgopricereminder');
        if ($netgopricereminderId) {
            $netgopricereminder->load($netgopricereminderId);
        }
        Mage::register('current_netgopricereminder', $netgopricereminder);
        return $netgopricereminder;
    }
     /**
     * default action
     * @access public
     * @return void
     * @author NetGo
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('netgo_pricereminder')->__('Price Reminder'))
             ->_title(Mage::helper('netgo_pricereminder')->__('Netgopricereminder'));
        $this->renderLayout();
    }
    /**
     * grid action
     * @access public
     * @return void
     * @author NetGo
     */
    public function gridAction() {
        $this->loadLayout()->renderLayout();
    }
    /**
     * edit netgopricereminder - action
     * @access public
     * @return void
     * @author NetGo
     */
    public function editAction() {
        $netgopricereminderId    = $this->getRequest()->getParam('id');
        $netgopricereminder      = $this->_initNetgopricereminder();
        if ($netgopricereminderId && !$netgopricereminder->getId()) {
            $this->_getSession()->addError(Mage::helper('netgo_pricereminder')->__('This netgopricereminder no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getNetgopricereminderData(true);
        if (!empty($data)) {
            $netgopricereminder->setData($data);
        }
        Mage::register('netgopricereminder_data', $netgopricereminder);
        $this->loadLayout();
        $this->_title(Mage::helper('netgo_pricereminder')->__('Price Reminder'))
             ->_title(Mage::helper('netgo_pricereminder')->__('Netgopricereminder'));
        if ($netgopricereminder->getId()){
            $this->_title($netgopricereminder->getEmailid());
        }
        else{
            $this->_title(Mage::helper('netgo_pricereminder')->__('Add netgopricereminder'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new netgopricereminder action
     * @access public
     * @return void
     * @author NetGo
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save netgopricereminder - action
     * @access public
     * @return void
     * @author NetGo
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('netgopricereminder')) {
		 //echo '<pre>';print_r($data);die;
            try {
                $netgopricereminder = $this->_initNetgopricereminder();
                $netgopricereminder->addData($data);
                $netgopricereminder->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('netgo_pricereminder')->__('Netgopricereminder was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $netgopricereminder->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setNetgopricereminderData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('There was a problem saving the netgopricereminder.'));
                Mage::getSingleton('adminhtml/session')->setNetgopricereminderData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('Unable to find netgopricereminder to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete netgopricereminder - action
     * @access public
     * @return void
     * @author NetGo
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $netgopricereminder = Mage::getModel('netgo_pricereminder/netgopricereminder');
                $netgopricereminder->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('netgo_pricereminder')->__('Netgopricereminder was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('There was an error deleting netgopricereminder.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('Could not find netgopricereminder to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete netgopricereminder - action
     * @access public
     * @return void
     * @author NetGo
     */
    public function massDeleteAction() {
        $netgopricereminderIds = $this->getRequest()->getParam('netgopricereminder');
        if(!is_array($netgopricereminderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('Please select netgopricereminder to delete.'));
        }
        else {
            try {
                foreach ($netgopricereminderIds as $netgopricereminderId) {
                    $netgopricereminder = Mage::getModel('netgo_pricereminder/netgopricereminder');
                    $netgopricereminder->setId($netgopricereminderId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('netgo_pricereminder')->__('Total of %d netgopricereminder were successfully deleted.', count($netgopricereminderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('There was an error deleting netgopricereminder.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass status change - action
     * @access public
     * @return void
     * @author NetGo
     */
    public function massStatusAction(){
        $netgopricereminderIds = $this->getRequest()->getParam('netgopricereminder');
        if(!is_array($netgopricereminderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('Please select netgopricereminder.'));
        }
        else {
            try {
                foreach ($netgopricereminderIds as $netgopricereminderId) {
                $netgopricereminder = Mage::getSingleton('netgo_pricereminder/netgopricereminder')->load($netgopricereminderId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d netgopricereminder were successfully updated.', count($netgopricereminderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('There was an error updating netgopricereminder.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Is Fixed change - action
     * @access public
     * @return void
     * @author NetGo
     */
    public function massIsfixedAction(){
        $netgopricereminderIds = $this->getRequest()->getParam('netgopricereminder');
        if(!is_array($netgopricereminderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('Please select netgopricereminder.'));
        }
        else {
            try {
                foreach ($netgopricereminderIds as $netgopricereminderId) {
                $netgopricereminder = Mage::getSingleton('netgo_pricereminder/netgopricereminder')->load($netgopricereminderId)
                            ->setIsfixed($this->getRequest()->getParam('flag_isfixed'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d netgopricereminder were successfully updated.', count($netgopricereminderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('There was an error updating netgopricereminder.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass Is Variable change - action
     * @access public
     * @return void
     * @author NetGo
     */
    public function massIsvariableAction(){
        $netgopricereminderIds = $this->getRequest()->getParam('netgopricereminder');
        if(!is_array($netgopricereminderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('Please select netgopricereminder.'));
        }
        else {
            try {
                foreach ($netgopricereminderIds as $netgopricereminderId) {
                $netgopricereminder = Mage::getSingleton('netgo_pricereminder/netgopricereminder')->load($netgopricereminderId)
                            ->setIsvariable($this->getRequest()->getParam('flag_isvariable'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d netgopricereminder were successfully updated.', count($netgopricereminderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('netgo_pricereminder')->__('There was an error updating netgopricereminder.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * export as csv - action
     * @access public
     * @return void
     * @author NetGo
     */
    public function exportCsvAction(){
        $fileName   = 'netgopricereminder.csv';
        $content    = $this->getLayout()->createBlock('netgo_pricereminder/adminhtml_netgopricereminder_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     * @author NetGo
     */
    public function exportExcelAction(){
        $fileName   = 'netgopricereminder.xls';
        $content    = $this->getLayout()->createBlock('netgo_pricereminder/adminhtml_netgopricereminder_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     * @author NetGo
     */
    public function exportXmlAction(){
        $fileName   = 'netgopricereminder.xml';
        $content    = $this->getLayout()->createBlock('netgo_pricereminder/adminhtml_netgopricereminder_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     * @author NetGo
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('netgo_pricereminder/netgopricereminder');
    }
}
