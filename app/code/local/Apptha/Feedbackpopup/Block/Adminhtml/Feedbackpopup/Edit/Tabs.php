<?php

class Apptha_Feedbackpopup_Block_Adminhtml_Feedbackpopup_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('feedbackpopup_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('feedbackpopup')->__('Pop-up Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('feedbackpopup')->__('Pop-up Settings'),
          'title'     => Mage::helper('feedbackpopup')->__('Pop-up Settings'),
          'content'   => $this->getLayout()->createBlock('feedbackpopup/adminhtml_feedbackpopup_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}