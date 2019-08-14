<?php
/**
 * @category   SellerActive
 * @package    SellerActive
 * @version    1.0.0
 * @copyright  Copyright 2013 SellerActive (http://www.selleractove.com/)
 */
class SellerActive_SellerActive_Block_Adminhtml_Settings_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $model = Mage::registry('setting_data');
        $config = Mage::getSingleton('selleractive/config');
        $apiKeyFieldName = $config->getField('webapikey', 'api_key');
        $isActiveFieldName = $config->getField('is_active', 'api_key');

        $form = new Varien_Data_Form(array(
                'id'      => 'edit_form',
                'action'  => $this->getUrl('*/*/save'),
                'method'  => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        $fieldset = $form->addFieldset('credential_settings', array('legend' => Mage::helper('selleractive')->__('Credential Settings')));

        $fieldset->addField($config->getField('webapikey', 'api_key'), 'text', array(
            'label'    => $config->getField('webapikey', 'label'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => $config->getField('webapikey', 'api_key'),
            'note'     => '<a onclick="validateApiKey()" href="#webapikey">' . Mage::helper('selleractive')->__('validate api key') . '</a>',
            'after_element_html' => $config->getField('webapikey', 'document_link/link_to')
                ? '<a href="'.$config->getField('webapikey', 'document_link/link_to')
                    .'" style="margin-left:15px" target="_blank">'
                    .$config->getField('webapikey', 'document_link/label').'</a>'
                : ''
        ));

        $checked = 1;
        if(strtolower($model->getData($config->getField('is_active', 'api_key'))) == 'false')
        {
            $checked = 0;
        }
        $model->setData($config->getField('is_active', 'api_key'), 'true');
        $fieldset->addField($config->getField('is_active', 'api_key'), 'checkbox', array(
            'label'     => $config->getField('is_active', 'label'),
            'name'      => $config->getField('is_active', 'api_key'),
            'value'		=>	'true',
            'checked'	=>	$checked,
            'disabled'  => !$model->getWebapikey() ? true : false,
        ));

        $fieldset->addField($config->getField('magento_to_domain', 'api_key'), 'text', array(
            'label'    => $config->getField('magento_to_domain', 'label'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => $config->getField('magento_to_domain', 'api_key'),
            'disabled'  => !$model->getWebapikey() ? true : false,
            'after_element_html' => $config->getField('magento_to_domain', 'document_link/link_to')
                ? '<a href="'.$config->getField('magento_to_domain', 'document_link/link_to')
                    .'" style="margin-left:15px" target="_blank">'
                    .$config->getField('magento_to_domain', 'document_link/label').'</a>'
                : ''
        ));

        $fieldset->addField($config->getField('magento_to_login', 'api_key'), 'text', array(
            'label'    => $config->getField('magento_to_login', 'label'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => $config->getField('magento_to_login', 'api_key'),
            'disabled'  => !$model->getWebapikey() ? true : false,
            'after_element_html' => $config->getField('magento_to_login', 'document_link/link_to')
                ? '<a href="'.$config->getField('magento_to_login', 'document_link/link_to')
                    .'" style="margin-left:15px" target="_blank">'
                    .$config->getField('magento_to_login', 'document_link/label').'</a>'
                : ''

        ));

        $fieldset->addField($config->getField('magento_password', 'api_key'), 'text', array(
            'label'    => $config->getField('magento_password', 'label'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => $config->getField('magento_password', 'api_key'),
            'disabled'  => !$model->getWebapikey() ? true : false
        ));
		
		$fieldset->addField($config->getField('magento_version', 'api_key'), 'text', array(
            'label'    => $config->getField('magento_version', 'label'),
            'class'    => 'required-entry',
            'required' => false,
            'name'     => $config->getField('magento_version', 'api_key'),
            'disabled'  => true
        ));

        $fieldset = $form->addFieldset('order_management_settings', array('legend' => Mage::helper('selleractive')->__('Order Management Settings')));
        $fieldset->addField($config->getField('magento_order_start', 'api_key'), 'text', array(
            'label'    => $config->getField('magento_order_start', 'label'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => $config->getField('magento_order_start', 'api_key'),
            'disabled'  => !$model->getWebapikey() ? true : false,
            'after_element_html' => $config->getField('magento_order_start', 'document_link/link_to')
                ? '<a href="'.$config->getField('magento_order_start', 'document_link/link_to')
                    .'" style="margin-left:15px" target="_blank">'
                    .$config->getField('magento_order_start', 'document_link/label').'</a>'
                : ''
        ));

        $fieldset = $form->addFieldset('inventory_management_settings', array('legend' => Mage::helper('selleractive')->__('Inventory Management Settings')));
        $fieldset->addField($config->getField('magento_store_view', 'api_key'), 'text', array(
            'label'    => $config->getField('magento_store_view', 'label'),
            'class'    => 'required-entry',
            'required' => true,
            'name'     => $config->getField('magento_store_view', 'api_key'),
            'disabled'  => !$model->getWebapikey() ? true : false,
            'after_element_html' => $config->getField('magento_store_view', 'document_link/link_to')
                ? '<a href="'.$config->getField('magento_store_view', 'document_link/link_to')
                    .'" style="margin-left:15px" target="_blank">'
                    .$config->getField('magento_store_view', 'document_link/label').'</a>'
                : ''
        ));
		
		$fieldset = $form->addFieldset('optional_settings', array('legend' => Mage::helper('selleractive')->__('Optional Settings')));
        $checked = 1;
        if(strtolower($model->getData($config->getField('magento_import_hidden_inventory', 'api_key'))) == 'false')
        {
            $checked = 0;
        }
        $model->setData($config->getField('magento_import_hidden_inventory', 'api_key'), 'true');
        $fieldset->addField($config->getField('magento_import_hidden_inventory', 'api_key'), 'checkbox', array(
            'label'     => $config->getField('magento_import_hidden_inventory', 'label'),
            'name'      => $config->getField('magento_import_hidden_inventory', 'api_key'),
            'value'		=>	'true',
            'checked'	=>	$checked,
            'disabled'  => !$model->getWebapikey() ? true : false,
        ));
		
		$checked = 1;
        if(strtolower($model->getData($config->getField('magento_send_email_when_shipped', 'api_key'))) == 'false')
        {
            $checked = 0;
        }
        $model->setData($config->getField('magento_send_email_when_shipped', 'api_key'), 'true');
        $fieldset->addField($config->getField('magento_send_email_when_shipped', 'api_key'), 'checkbox', array(
            'label'     => $config->getField('magento_send_email_when_shipped', 'label'),
            'name'      => $config->getField('magento_send_email_when_shipped', 'api_key'),
            'value'		=>	'true',
            'checked'	=>	$checked,
            'disabled'  => !$model->getWebapikey() ? true : false,
        ));
		
		$checked = 1;
        if(strtolower($model->getData($config->getField('magento_include_comment_in_email', 'api_key'))) == 'false')
        {
            $checked = 0;
        }
        $model->setData($config->getField('magento_include_comment_in_email', 'api_key'), 'true');
        $fieldset->addField($config->getField('magento_include_comment_in_email', 'api_key'), 'checkbox', array(
            'label'     => $config->getField('magento_include_comment_in_email', 'label'),
            'name'      => $config->getField('magento_include_comment_in_email', 'api_key'),
            'value'		=>	'true',
            'checked'	=>	$checked,
            'disabled'  => !$model->getWebapikey() ? true : false,
        ));
		
		$fieldset->addField($config->getField('magento_shipping_comment', 'api_key'), 'textarea', array(
            'label'    => $config->getField('magento_shipping_comment', 'label'),
            'class'    => 'required-entry',
            'required' => false,
            'name'     => $config->getField('magento_shipping_comment', 'api_key'),
            'disabled'  => !$model->getWebapikey() ? true : false
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}