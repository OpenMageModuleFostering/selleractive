<?php
/**
 * @category   SellerActive
 * @package    SellerActive
 * @version    1.0.0
 * @copyright  Copyright 2013 SellerActive (http://www.selleractove.com/)
 */
class SellerActive_SellerActive_Block_Adminhtml_Settings extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'selleractive';
        $this->_controller = 'adminhtml';
        $this->_mode = 'settings';

        $this->_removeButton('reset');
        $this->_removeButton('back');
        $this->_updateButton('save', 'label', Mage::helper('selleractive')->__('Save Settings'));

        $validateUrl = Mage::helper('adminhtml')->getUrl('selleractive/adminhtml_settings/validate');
        $config = Mage::getSingleton('selleractive/config');
        $apiKeyFieldName = $config->getField('webapikey', 'api_key');
        $isActiveFieldName = $config->getField('is_active', 'api_key');
		$hiddenInventoryFieldName = $config->getField('magento_import_hidden_inventory', 'api_key');
		$sendEmailWhenShippedFieldName = $config->getField('magento_send_email_when_shipped', 'api_key');
		$includeCommentInEmailFieldName = $config->getField('magento_include_comment_in_email', 'api_key');
        $domainFieldName = $config->getField('magento_to_domain', 'api_key');
        $loginFieldName = $config->getField('magento_to_login', 'api_key');
        $passwordFieldName = $config->getField('magento_password', 'api_key');
		$versionFieldName = $config->getField('magento_version', 'api_key');
        $orderStartFieldName = $config->getField('magento_order_start', 'api_key');
        $storeViewFieldName = $config->getField('magento_store_view', 'api_key');
		$shippingCommentFieldName = $config->getField('magento_shipping_comment', 'api_key');

        $this->_formScripts[] = "
            function _qresetForm(){
                $$('#edit_form input').each(function(e){
                   if (e.id != '{$apiKeyFieldName}') {e.disabled=true;}
                });
                alert('API Key Invalid!');

            }
            function validateApiKey(){
                new Ajax.Request('{$validateUrl}', {
                  method:'post',
                  parameters: {webapikey: $('{$apiKeyFieldName}').value},
                  onSuccess: function(transport){
                     var json = transport.responseText.evalJSON();
                     if ('{$isActiveFieldName}' in json) {
                        if (json['{$isActiveFieldName}']== 'False' || json['{$isActiveFieldName}'] == 'false') {
                            $('{$isActiveFieldName}').checked = false;
                            $('{$isActiveFieldName}').disabled = false;
                        }else if (json['{$isActiveFieldName}']== 'True' || json['{$isActiveFieldName}'] == 'true'){
                            $('{$isActiveFieldName}').checked = true;
                            $('{$isActiveFieldName}').disabled = false;
                        }else{
                            _qresetForm();
                        }
                     }
					 if ('{$hiddenInventoryFieldName}' in json) {
                        if (json['{$hiddenInventoryFieldName}']== 'False' || json['{$hiddenInventoryFieldName}'] == 'false') {
                            $('{$hiddenInventoryFieldName}').checked = false;
                            $('{$hiddenInventoryFieldName}').disabled = false;
                        }else if (json['{$hiddenInventoryFieldName}']== 'True' || json['{$hiddenInventoryFieldName}'] == 'true'){
                            $('{$hiddenInventoryFieldName}').checked = true;
                            $('{$hiddenInventoryFieldName}').disabled = false;
                        }else{
                            _qresetForm();
                        }
                     }
					 if ('{$sendEmailWhenShippedFieldName}' in json) {
                        if (json['{$sendEmailWhenShippedFieldName}']== 'False' || json['{$sendEmailWhenShippedFieldName}'] == 'false') {
                            $('{$sendEmailWhenShippedFieldName}').checked = false;
                            $('{$sendEmailWhenShippedFieldName}').disabled = false;
                        }else if (json['{$sendEmailWhenShippedFieldName}']== 'True' || json['{$sendEmailWhenShippedFieldName}'] == 'true'){
                            $('{$sendEmailWhenShippedFieldName}').checked = true;
                            $('{$sendEmailWhenShippedFieldName}').disabled = false;
                        }else{
                            _qresetForm();
                        }
                     }
					 if ('{$includeCommentInEmailFieldName}' in json) {
                        if (json['{$includeCommentInEmailFieldName}']== 'False' || json['{$includeCommentInEmailFieldName}'] == 'false') {
                            $('{$includeCommentInEmailFieldName}').checked = false;
                            $('{$includeCommentInEmailFieldName}').disabled = false;
                        }else if (json['{$includeCommentInEmailFieldName}']== 'True' || json['{$includeCommentInEmailFieldName}'] == 'true'){
                            $('{$includeCommentInEmailFieldName}').checked = true;
                            $('{$includeCommentInEmailFieldName}').disabled = false;
                        }else{
                            _qresetForm();
                        }
                     }
					 
					 $('{$domainFieldName}').value = '';
					 $('{$loginFieldName}').value = '';
					 $('{$passwordFieldName}').value = '';
					 $('{$versionFieldName}').value = '';
					 $('{$orderStartFieldName}').value = '';
					 $('{$storeViewFieldName}').value = '';
					 $('{$shippingCommentFieldName}').value = '';
                     for(var i in json){
                        if (i != '{$isActiveFieldName}' && i != '{$hiddenInventoryFieldName}' && i != '{$sendEmailWhenShippedFieldName}' && i != '{$includeCommentInEmailFieldName}') {
                            $(i).value = json[i];
                            $(i).disabled = false;
                        }
						if (i == '{$versionFieldName}') {
							$(i).disabled = true;
							$(i).style.backgroundColor = 'lightgray';
						}
                     }
                  },
                   onFailure: function() { alert('".Mage::helper('selleractive')->__('Something went wrong...')."'); }
                });


            }

        ";
    }

    public function getHeaderText()
    {
        return Mage::helper('selleractive')->__('SellerActive Magento Settings');
    }
}