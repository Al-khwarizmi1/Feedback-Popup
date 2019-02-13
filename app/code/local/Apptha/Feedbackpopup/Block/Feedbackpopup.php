<?php

/**
 * Feedbackpopup frontend block
 *
 * @category   Apptha
 * @package    Apptha_Feedbackpopup
 * @author     Apptha Team <support@apptha.com>
 * @copyright  Copyright (c) 2012 (www.apptha.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Apptha_Feedbackpopup_Block_Feedbackpopup extends Mage_Core_Block_Template {

    /**
     * Preparing global layout
     * 
     * @return Mage_Core_Block_Template
     */
    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    /**
     * Retrieve feedbackpopup model object
     *
     * @return Apptha_Feedbackpopup_Model_Feedbackpopup
     */
    public function getFeedbackpopup() {
        if (!$this->hasData('feedbackpopup')) {
            $this->setData('feedbackpopup', Mage::registry('feedbackpopup'));
        }
        return $this->getData('feedbackpopup');
    }

    /**
     * Add CSS and  JS file to FOOTER 
     * @param string $type
     * @param string $path
     * @return Mage_Page_Block_Html_Head
     */
    public function addItem($type, $path) {

        /**
         * Verify moduel was enabled/disabled
         * to add the css and js files
         */
        $config = Mage::getStoreConfig('feedbackpopup/feedbackpopup/active');
        if ($config == "1") {
            $head = $this->getLayout()->getBlock('head');
            return $head->addItem($type, $path);
        }
    }

}