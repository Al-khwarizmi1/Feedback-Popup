<?php
/**
 * Adminhtml Feedbackpopup grid block
 *
 * @category   Apptha
 * @package    Apptha_Feedbackpopup
 * @author     Apptha Team <support@apptha.com>
 * @copyright  Copyright (c) 2012 (www.apptha.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version    0.1.0
 * 
 */
class Apptha_Feedbackpopup_Block_Adminhtml_Feedbackpopup_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    /**
     * Display the product in the descending manner in the grid
     */
    public function __construct() {
        parent::__construct();
        $this->setId('feedbackpopupGrid');
        $this->setDefaultSort('feedbackpopup_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Collection of all the product details
     * 
     * @return array $this 
     */
    protected function _prepareCollection() {
        $collection = Mage::getModel('feedbackpopup/feedbackpopup')->getCollection();
        /* @var $collection Mage_Feedbackpopup_Model_Mysql4_Feedbackpopup_Collection */
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Show all the details in the table formate
     * 
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns() {
        $this->addColumn('feedbackpopup_id', array(
            'header' => Mage::helper('feedbackpopup')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'feedbackpopup_id',
        )); //Row id
        $this->addColumn('title', array(
            'header' => Mage::helper('feedbackpopup')->__('Form Title'),
            'align' => 'left',
            'index' => 'title',
        )); //Form title

        $this->addColumn('options_type', array(
            'header' => Mage::helper('feedbackpopup')->__('Type'),
            'align' => 'left',
            'index' => 'options_type',
            'type' => 'options',
            'options' => array(
                2 => 'Notifiaction',
                1 => 'Form',
                0 => 'Static',
            ),
        )); //Type of the form selected 
        $this->addColumn('status', array(
            'header' => Mage::helper('feedbackpopup')->__('Status'),
            'align' => 'left',
            'width' => '80px',
            'index' => 'status',
            'type' => 'options',
            'options' => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        )); //status of the form
        
        /**
         * Check is single store mode
         */
//        if (!Mage::app()->isSingleStoreMode()) {
//            $this->addColumn('store_id', array(
//                'header'        => Mage::helper('feedbackpopup')->__('Store View'),
//                'index'         => 'store_id',
//                'type'          => 'store',
//                'store_all'     => true,
//                'store_view'    => true,
//                'sortable'      => false,
//                'filter_condition_callback'
//                                => array($this, '_filterStoreCondition'),
//            ));
//        }

        $this->addColumn('action', array(
            'header' => Mage::helper('feedbackpopup')->__('Action'),
            'width' => '100',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('feedbackpopup')->__('Edit'),
                    'url' => array('base' => '*/*/edit'),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
            'is_system' => true,
        )); // edit action

        /* To export the Grid data in XML / CSV file */
        $this->addExportType('*/*/exportCsv', Mage::helper('feedbackpopup')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('feedbackpopup')->__('XML'));

        return parent::_prepareColumns();
    }

    /**
     * Enable / Disable request option to specified form to display in the frontend
     * 
     * @return  Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction() {
        //feedbackpopup_id is unique identifier
        $this->setMassactionIdField('feedbackpopup_id');
        //Form field name
        $this->getMassactionBlock()->setFormFieldName('feedbackpopup');
        //Delete the selected rows from the grid
        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('feedbackpopup')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('feedbackpopup')->__('Are you sure?')
        ));
        //status enable/disable
        $statuses = Mage::getSingleton('feedbackpopup/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('feedbackpopup')->__('Change status'),
            'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('feedbackpopup')->__('Status'),
                    'values' => $statuses
                )
            )
        ));
        return $this;
    }
    
     protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
    protected function _filterStoreCondition($collection, $column)
    {
        
        if (!$value = $column->getFilter()->getValue()) {
            
            return;
        }
        $this->getCollection()->addStoreFilter($value);
        
    }
    

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row) {
        return $this->getUrl('*/*/edit', array('id' => $row->getFeedbackpopupId()));
    }

}