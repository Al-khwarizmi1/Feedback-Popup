<?php

class Apptha_Feedbackpopup_Model_Mysql4_Feedbackpopup_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    
    
    /**
     * Load data for preview flag
     *
     * @var bool
     */
    protected $_previewFlag;

    
    public function _construct()
    {
        //parent::_construct();
        $this->_init('feedbackpopup/feedbackpopup');
        $this->_map['fields']['feedbackpopup_id'] = 'main_table.feedbackpopup_id';
        $this->_map['fields']['store']   = 'store_table.store_id';
        
    }
    /**
     * Set first store flag
     *
     * @param bool $flag
     * @return Apptha_Feedbackpopup_Model_Mysql4_Feedbackpopup_Collection
     */
    public function setFirstStoreFlag($flag = false)
    {
        $this->_previewFlag = $flag;
        return $this;
    }
     protected function _afterLoad()
    {
        if ($this->_previewFlag) {
            $items = $this->getColumnValues('feedbackpopup_id');
            $connection = $this->getConnection();
            if (count($items)) {
                $select = $connection->select()
                        ->from(array('cps'=>$this->getTable('feedbackpopup_store')))
                        ->where('cps.feedbackpopup_id IN (?)', $items);

                if ($result = $connection->fetchPairs($select)) {
                    foreach ($this as $item) {
                        if (!isset($result[$item->getData('feedbackpopup_id')])) {
                            continue;
                        }
                        if ($result[$item->getData('feedbackpopup_id')] == 0) {
                            $stores = Mage::app()->getStores(false, true);
                            $storeId = current($stores)->getId();
                            $storeCode = key($stores);
                        } else {
                            $storeId = $result[$item->getData('feedbackpopup_id')];
                            $storeCode = Mage::app()->getStore($storeId)->getCode();
                        }
                        $item->setData('_first_store_id', $storeId);
                        $item->setData('store_code', $storeCode);
                    }
                }
            }
        }

        return parent::_afterLoad();
    }

    /**
     * Add filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @param bool $withAdmin
     * @return Apptha_Feedbackpopup_Model_Mysql4_Feedbackpopup_Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {  
        if (!$this->getFlag('store_filter_added')) {
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }

            if (!is_array($store)) {
                $store = array($store);
            }

            if ($withAdmin) {
                $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
            }
           
            $this->addFilter('store', array('in' => $store), 'public');
        }
        return $this;
    }

    /**
     * Join store relation table if there is store filter
     */
    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('store_table' => $this->getTable('feedbackpopup_store')),
                'main_table.feedbackpopup_id = store_table.feedbackpopup_id',
                array()
            )->group('main_table.feedbackpopup_id');

            /*
             * Allow analytic functions usage because of one field grouping
             */
            $this->_useAnalyticFunction = true;
        }
        return parent::_renderFiltersBefore();
    }
    
}