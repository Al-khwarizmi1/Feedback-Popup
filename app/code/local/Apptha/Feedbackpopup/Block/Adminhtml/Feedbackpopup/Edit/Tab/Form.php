<?php

class Apptha_Feedbackpopup_Block_Adminhtml_Feedbackpopup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $model = Mage::registry('feedbackpopup_data');
        $this->setForm($form);
        $fieldset = $form->addFieldset('feedbackpopup_form', array('legend' => Mage::helper('feedbackpopup')->__('Popup Information')));
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('add_variables' => false, 'add_widgets' =>
                    false, 'files_browser_window_url' => $this->getBaseUrl() . 'admin/cms_wysiwyg_images/index/'));
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('feedbackpopup')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
            'note' => Mage::helper('feedbackpopup')->__('Enter the pop-up title'),
            'tabindex' => 1
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('feedbackpopup')->__('Status'),
            'name' => 'status',
            'values' => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('feedbackpopup')->__('Enabled'),
                ),
                array(
                    'value' => 2,
                    'label' => Mage::helper('feedbackpopup')->__('Disabled'),
                ),
            ),
            'note' => Mage::helper('feedbackpopup')->__('To enable/ disable this Content'),
            'tabindex' => 2
        ));
       
        $fieldset->addField('options_type', 'select', array(
            'label' => Mage::helper('feedbackpopup')->__('Option'),
            'name' => 'options_type',
            'required' => true,
            'values' => Mage::getModel('feedbackpopup/formtype')->toOptionArray(),
            'note' => Mage::helper('feedbackpopup')->__('Select Content Type'),
            'tabindex' => 4
        ));
        
        $fieldset->addField('displayeffect', 'select', array(
            'label' => Mage::helper('feedbackpopup')->__('Display Effect'),
            'name' => 'displayeffect',
            'required' => true,
            'values' => Mage::getModel('feedbackpopup/effects')->toOptionArray(),
            'note' => Mage::helper('feedbackpopup')->__('Slide effect is not applicable for notification type'),
            'tabindex' => 5
        ));
        
        $fieldset->addField('show_at', 'multiselect', array(
            'label' => Mage::helper('feedbackpopup')->__('Visible At'),
            'name' => 'show_at[]',
            'required' => false,
            'values' => Mage::getModel('feedbackpopup/showat')->toOptionArray(),
            'note' => Mage::helper('feedbackpopup')->__('Select the page type'),
            'tabindex' => 6
        ));
//        $fieldset->addField('displayposition', 'select', array(
//            'label' => Mage::helper('feedbackpopup')->__('Position'),
//            'name' => 'displayposition',
//            'required' => true,
//            'values' => Mage::getModel('feedbackpopup/position')->toOptionArray(),
//        )); 
        $fieldset->addField('receiveremail', 'text', array(
            'label' => Mage::helper('feedbackpopup')->__('Receiver Email'),
            'class' => 'validate-email',
            'required' => false,
            'name' => 'receiveremail',
            'note' => Mage::helper('feedbackpopup')->__('Please enter an email id to get the feed back'),
            'tabindex' => 7
        ));
        //enable the form fields start
        $fieldset->addField('enablephonefield', 'select', array(
            'label' => Mage::helper('feedbackpopup')->__('Enable Phone Field'),
            'name' => 'enablephonefield',
            'required' => false,
            'values' => Mage::getModel('feedbackpopup/fielddisplay')->getOptionArray(),
            'note' => Mage::helper('feedbackpopup')->__('Enable the phone field in form'),
            'tabindex' => 8
        ));

        $fieldset->addField('enableaddressfield', 'select', array(
            'label' => Mage::helper('feedbackpopup')->__('Enable Address Field'),
            'name' => 'enableaddressfield',
            'required' => false,
            'values' => Mage::getModel('feedbackpopup/fielddisplay')->getOptionArray(),
            'note' => Mage::helper('feedbackpopup')->__('Enable the address field in form'),
            'tabindex' => 9
        ));

        $fieldset->addField('enablecomment', 'select', array(
            'label' => Mage::helper('feedbackpopup')->__('Enable Details Field'),
            'name' => 'enablecomment',
            'required' => false,
            'values' => Mage::getModel('feedbackpopup/fielddisplay')->getOptionArray(),
            'note' => Mage::helper('feedbackpopup')->__('Enable the details field in form'),
            'tabindex' => 10
        ));
        $fieldset->addField('hear_about', 'select', array(
            'label' => Mage::helper('feedbackpopup')->__('Enable Hear About Field in form'),
            'name' => 'hear_about',
            'required' => false,
            'values' => Mage::getModel('feedbackpopup/fielddisplay')->getOptionArray(),
            'note' => Mage::helper('feedbackpopup')->__('Enable Hear About Field in form'),
            'tabindex' => 11
        ));
        //enable the form fields end
        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
        $fieldset->addField('fromdate', 'date', array(
            'name' => 'fromdate',
            'label' => Mage::helper('feedbackpopup')->__('From Date'),
            'title' => Mage::helper('feedbackpopup')->__('From Date'),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'required' => false,
            'format' => $dateFormatIso,
            'note' => Mage::helper('feedbackpopup')->__('Select start date for notification'),
            'tabindex' => 12
        ));
        $fieldset->addField('todate', 'date', array(
            'name' => 'todate',
            'label' => Mage::helper('feedbackpopup')->__('To Date'),
            'title' => Mage::helper('feedbackpopup')->__('To Date'),
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'required' => false,
            'format' => $dateFormatIso,
            'note' => Mage::helper('feedbackpopup')->__('Select end date for notification'),
            'tabindex' => 13
        ));
        $fieldset->addField('starttime', 'text', array(
            'label' => Mage::helper('feedbackpopup')->__('Start Time'),
            
            'style' => "width:50px",
            'required' => false,
            'name' => 'starttime',
            'note' => Mage::helper('feedbackpopup')->__('Starting time interval (in seconds)'),
            'tabindex' => 14
        ));
        $fieldset->addField('closetime', 'text', array(
            'label' => Mage::helper('feedbackpopup')->__('Close Time'),
           
            'style' => "width:50px",
            'required' => false,
            'name' => 'closetime',
            'note' => Mage::helper('feedbackpopup')->__('Ending time interval (in seconds)'),
            'tabindex' => 15
        ));
        //wysiwyg code start 
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $wysiwygConfig->addData(array(
            'plugins' => array(),
            'widget_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/widget/index'),
            'directives_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive'),
            'directives_url_quoted' => preg_quote(Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive')),
            'files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'),
        ));
        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField('store_id', 'multiselect', array(
                        'name' => 'stores[]',
                        'label' => Mage::helper('feedbackpopup')->__('Store View'),
                        'title' => Mage::helper('feedbackpopup')->__('Store View'),
                        'required' => false,
                        'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
                        'tabindex' => 16
                    ));
            $renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
            $field->setRenderer($renderer);
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name' => 'stores[]',
                'tabindex' => 16,
                'value' => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }


        //wysiwyg code end
        $fieldset->addField('content_type', 'editor', array(
            'name' => 'content_type',
            'label' => Mage::helper('feedbackpopup')->__('Content'),
            'title' => Mage::helper('feedbackpopup')->__('Content'),
            'required' => false,
            'style' => 'width:700px; height:500px;',
            'config' => $wysiwygConfig,
            'tabindex' => 11
        ));

        if (Mage::getSingleton('adminhtml/session')->getFeedbackpopupData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getFeedbackpopupData());
            Mage::getSingleton('adminhtml/session')->setFeedbackpopupData(null);
        } elseif (Mage::registry('feedbackpopup_data')) {
            $form->setValues(Mage::registry('feedbackpopup_data')->getData());
        }

        return parent::_prepareForm();
    }

    
}