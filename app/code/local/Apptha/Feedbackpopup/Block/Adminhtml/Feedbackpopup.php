<?php
/**
 * Adminhtml manage feedbackpopup grid block
 *
 * @category   Apptha
 * @package    Apptha_Feedbackpopup
 * @author     Apptha Team <support@apptha.com>
 * @copyright  Copyright (c) 2012 (www.apptha.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version    0.1.0
 */
class Apptha_Feedbackpopup_Block_Adminhtml_Feedbackpopup extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_feedbackpopup';
    $this->_blockGroup = 'feedbackpopup';
    $this->_headerText = Mage::helper('feedbackpopup')->__('Manage Pop-Up');
    $this->_addButtonLabel = Mage::helper('feedbackpopup')->__('Add Pop-Up');
    parent::__construct();
  }
}