<?php
/**
 * @category   SellerActive
 * @package    SellerActive
 * @version    1.0.0
 * @copyright  Copyright 2013 SellerActive (http://www.selleractove.com/)
 */
class SellerActive_SellerActive_Model_Resource_Setting extends Varien_Object
{
    protected $serviceUrl = 'https://api.selleractive.com/API/SiteSettings/4';
    protected $params = array();

    public function _construct()
    {
		// sellerID not needed anymore
        //$this->params['sellerid'] = 706;
    }

    public function setWebApiKey($webApiKey)
    {
        $config = Mage::getSingleton('selleractive/config');
        $this->params[$config->getField('webapikey', 'api_key')] = $webApiKey;
    }

    public function load(SellerActive_SellerActive_Model_Setting $object, $webApiKey = null, $field = 'webapikey')
    {
        if (!is_null($webApiKey)) {
            $this->params[$field] = $webApiKey;
        }

        $this->_submitData($object);

        return $this;
    }

    public function setRemoteData($key, $value)
    {
        $this->params['settingkey'] = $key;
        $this->params['settingvalue'] = $value;

        return $this;
    }

    public function save(SellerActive_SellerActive_Model_Setting $object)
    {
        $config = Mage::getSingleton('selleractive/config');
        $data = $object->getData();
        $this->setWebApiKey($data[$config->getField('webapikey', 'api_key')]);
        //check webapikey
        try {
            $this->_submitData($object);
        }catch (Exception $e){
            throw new Exception('API Key Invalid!');
        }

        $toSave = array();
        $filters = array(
            $config->getField('is_active', 'api_key'),
            $config->getField('magento_to_domain', 'api_key'),
            $config->getField('magento_to_login', 'api_key'),
            $config->getField('magento_password', 'api_key'),
            $config->getField('magento_order_start', 'api_key'),
            $config->getField('magento_store_view', 'api_key'),
			$config->getField('magento_import_hidden_inventory', 'api_key'),
			$config->getField('magento_send_email_when_shipped', 'api_key'),
			$config->getField('magento_include_comment_in_email', 'api_key'),
			$config->getField('magento_shipping_comment', 'api_key')
        );

        foreach ($filters as $field) {
            if (isset($data[$field])) {
                $toSave[$field] = $data[$field];
            }
        }

        foreach ($toSave as $k => $v) {
            $this->setRemoteData($k, $v);
            $this->_submitData($object, 'put', false);
        }

        return $this;
    }

    protected function _submitData($object, $method='get', $parseResponse = true)
    {
        $url = $this->serviceUrl . '?format=json&' . http_build_query($this->params);
        //$this->debug_to_console($url);$this->debug_to_console($method);$this->debug_to_console(var_export($object, true));exit;
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, 0);
        if ($method == 'put') {
            curl_setopt($curlSession, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curlSession, CURLOPT_PUT, 1);
            curl_setopt($curlSession, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PUT'));
        }

        $response = curl_exec($curlSession);

        if ($parseResponse) {
            if ($response) {
                $results = Mage::helper('core')->jsonDecode($response);
                foreach ($results as $result) {
                    $object->setData($result['SettingKey'], $result['SettingValue']);
                }
            }else {
                throw new Exception('Curl error: ' . curl_error($curlSession) . ' (' . curl_errno($curlSession) . ')');
            }
        }

        curl_close($curlSession);

        return $object;
    }

}