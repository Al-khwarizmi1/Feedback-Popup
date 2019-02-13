<?php

class Apptha_Feedbackpopup_Model_Fielddisplay extends Varien_Object
{


    public function getOptionArray()
    {
       
        return array(
            array('value' => 0, 'label' => Mage::helper('adminhtml')->__('Hide')),
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Show')),
        );
    }
}