<?php
/**
 * @category   SellerActive
 * @package    SellerActive
 * @version    1.0.0
 * @copyright  Copyright 2013 SellerActive (http://www.selleractove.com/)
 */
class SellerActive_SellerActive_Model_Config extends Varien_Object
{
    protected $_webServiceConfig;

    protected function _construct()
    {
        parent::_construct();
        $this->_loadConfig();
    }

    protected function _loadConfig()
    {
        $filePath = Mage::getModuleDir('etc', 'SellerActive_SellerActive') . DS . 'webservice.xml';
        $this->_webServiceConfig = new Varien_Simplexml_Config($filePath);
    }

    public function getFieldConfig($field)
    {
        if (is_null($this->_webServiceConfig)) {
            $this->_loadConfig();
        }

        if (is_object($this->_webServiceConfig)) {
            return $this->_webServiceConfig->getNode('setting_fields/' . $field);
        } else {
            throw new Exception('Unable to load web service config file.');
        }
    }

    public function getField($field, $path)
    {
        try {
            $fieldConfig = $this->getFieldConfig($field);
            if ($r = $fieldConfig->xpath($path)){
                return $r[0]->asArray();
            }
            return null;
        }catch (Exception $e) {
            return null;
        }
    }

    const PATH_SAVE_SELLER_ACTIVE_WEB_API_KEY = 'selleractive/general/webApiKey';
    public function getSavedWebApiKey()
    {
        return Mage::getStoreConfig(self::PATH_SAVE_SELLER_ACTIVE_WEB_API_KEY, 0);
    }

    public function saveWebApiKey($value)
    {
        Mage::getConfig()->saveConfig(self::PATH_SAVE_SELLER_ACTIVE_WEB_API_KEY, $value)
            ->reinit();
        Mage::app()->reinitStores();
    }
}