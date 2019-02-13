<?php

class Apptha_Feedbackpopup_Model_Formtype 
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() {

        return array(
            array('value' => 2, 'label' => Mage::helper('adminhtml')->__('Notification')),
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Form')),
            array('value' => 0, 'label' => Mage::helper('adminhtml')->__('Static')),
        );
    }

}
?>
