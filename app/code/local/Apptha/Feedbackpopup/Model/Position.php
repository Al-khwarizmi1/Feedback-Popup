<?php

class Apptha_Feedbackpopup_Model_Position 
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() {

        return array(
            array('value' => 2, 'label' => Mage::helper('adminhtml')->__('Bottom')),
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Right')),
            array('value' => 0, 'label' => Mage::helper('adminhtml')->__('Left')),
        );
    }

}

?>
