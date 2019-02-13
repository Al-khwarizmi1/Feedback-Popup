<?php
/**
 * Feedbackpopup block edit form container
 *
 * @category   Apptha
 * @package    Apptha_Feedbackpopup
 * @author     Apptha Team <support@apptha.com>
 * @copyright  Copyright (c) 2012 (www.apptha.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version    0.1.0
 * 
 */
class Apptha_Feedbackpopup_Block_Adminhtml_Feedbackpopup_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';// variable is used in the form URL’s.
        $this->_blockGroup = 'feedbackpopup';
        $this->_controller = 'adminhtml_feedbackpopup';

        $this->_updateButton('save', 'label', Mage::helper('feedbackpopup')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('feedbackpopup')->__('Delete Item'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
                ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('feedbackpopup_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'feedbackpopup_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'feedbackpopup_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
          
    }
    public function getHeaderText() {
        if (Mage::registry('feedbackpopup_data') && Mage::registry('feedbackpopup_data')->getId()) {
            return Mage::helper('feedbackpopup')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('feedbackpopup_data')->getTitle()));
        } else {
            return Mage::helper('feedbackpopup')->__('Add Pop-up');
        }
    }

}