<?php

class Apptha_Feedbackpopup_Model_Showat 
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray() {

        return array(
            array('value' => 'home', 'label' => Mage::helper('adminhtml')->__('Home Page')),
            array('value' => 'product', 'label' => Mage::helper('adminhtml')->__('Product View page')),
            array('value' => 'category', 'label' => Mage::helper('adminhtml')->__('Category View page')),
            array('value' => 'cms', 'label' => Mage::helper('adminhtml')->__('Cms page')),
            array('value' => 'account', 'label' => Mage::helper('adminhtml')->__('Customer page')),
            array('value' => 'onepage', 'label' => Mage::helper('adminhtml')->__('Check Out page')),
            array('value' => 'cart', 'label' => Mage::helper('adminhtml')->__('Shopping Cart page')),
        );
    }

}

?>
