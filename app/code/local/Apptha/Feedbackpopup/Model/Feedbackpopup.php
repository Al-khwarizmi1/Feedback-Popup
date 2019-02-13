<?php

class Apptha_Feedbackpopup_Model_Feedbackpopup extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('feedbackpopup/feedbackpopup');
    }
    
}