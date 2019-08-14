<?php
/**
 * @category   SellerActive
 * @package    SellerActive
 * @version    1.0.0
 * @copyright  Copyright 2013 SellerActive (http://www.selleractove.com/)
 */
class SellerActive_SellerActive_Adminhtml_SettingsController extends Mage_Adminhtml_Controller_Action
{
    private function _initSettingData()
    {
        $config = Mage::getSingleton('selleractive/config');

        $webApiKey = $config->getSavedWebApiKey();
        $model = Mage::getModel('selleractive/setting');
        if ($webApiKey) {
            try {
                $model->load($webApiKey)
                    ->setWebapikey($webApiKey);
            } catch (Exception $e) {

            }
        }

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('setting_data', $model);

        return $model;
    }

    public function indexAction()
    {
        $this->_initSettingData();

        $this->loadLayout();
        $this->_setActiveMenu('system');
        $this->_addBreadcrumb(Mage::helper('selleractive')->__('Seller Active Magento Settings'), Mage::helper('selleractive')->__('SellerActive Magento Settings'));
        $this->_addContent($this->getLayout()->createBlock('selleractive/adminhtml_settings'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        $config = Mage::getSingleton('selleractive/config');
        $data = $this->getRequest()->getPost();
        if (isset($data[$config->getField('webapikey', 'api_key')])) {
            if (!isset($data[$config->getField('is_active', 'api_key')])) {
                $data[$config->getField('is_active', 'api_key')] = 'false';
            }
			if (!isset($data[$config->getField('magento_import_hidden_inventory', 'api_key')])) {
                $data[$config->getField('magento_import_hidden_inventory', 'api_key')] = 'false';
            }if (!isset($data[$config->getField('magento_send_email_when_shipped', 'api_key')])) {
                $data[$config->getField('magento_send_email_when_shipped', 'api_key')] = 'false';
            }
			if (!isset($data[$config->getField('magento_include_comment_in_email', 'api_key')])) {
                $data[$config->getField('magento_include_comment_in_email', 'api_key')] = 'false';
            }

            $model = Mage::getModel('selleractive/setting');
            $model->setData($data);

            try {
                $model->save();
                $config->saveWebApiKey($data[$config->getField('webapikey', 'api_key')]);

                $this->_getSession()->addSuccess(Mage::helper('selleractive')->__('SellerActive Settings was successfully saved'));
                $this->_getSession()->setFormData(false);

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_getSession()->setFormData($data);
                $this->_redirect('*/*/');
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('selleractive')->__('Unable to save SellerActive Settings'));
        $this->_redirect('*/*/');
    }

    public function validateAction()
    {
        try {
            $siteSetting = Mage::getModel('selleractive/setting')->load($this->getRequest()->getParam('webapikey'));
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($siteSetting->getData()));
        }catch (Exception $e) {
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('error'=>true)));
        }

    }
}