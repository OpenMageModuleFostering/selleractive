<?php
/**
 * @category   SellerActive
 * @package    SellerActive
 * @version    1.0.0
 * @copyright  Copyright 2013 SellerActive (http://www.selleractove.com/)
 */
class SellerActive_SellerActive_Model_Setting extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('selleractive/setting');
    }

    public function load($webApiKey, $field = null)
    {
        $config = Mage::getSingleton('selleractive/config');
        $field = $field ? $field : $config->getField('webapikey', 'api_key');

        return parent::load($webApiKey, $field);
    }

    public function save()
    {
        $this->_getResource()->save($this);
    }
}