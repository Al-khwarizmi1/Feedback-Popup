<?php

class Apptha_Feedbackpopup_Model_Effects 
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() {

        return array(
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Slide')),
            array('value' => 0, 'label' => Mage::helper('adminhtml')->__('Pop up')),
        );
    }

}

?>
