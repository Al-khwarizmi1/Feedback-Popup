<?php

class Apptha_Feedbackpopup_Model_Mysql4_Feedbackpopup extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the feedbackpopup_id refers to the key field in your database table.
        $this->_init('feedbackpopup/feedbackpopup','feedbackpopup_id');
       
    }
    public function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $condition = array(
            'feedbackpopup_id = ?'     => (int) $object->getId(),
        );

        $this->_getWriteAdapter()->delete($this->getTable('feedbackpopup_store'), $condition);

        return parent::_beforeDelete($object);
    }

    /**
     *
     * @param Mage_Core_Model_Abstract $object
     */
     protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        $condition = $this->_getWriteAdapter()->quoteInto('feedbackpopup_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('feedbackpopup/feedbackpopup_store'), $condition);

        foreach ((array)$object->getData('stores') as $store) {
            $storeArray = array();
            $storeArray['feedbackpopup_id'] = $object->getId();
            $storeArray['store_id'] = $store;
            $this->_getWriteAdapter()->insert($this->getTable('feedbackpopup/feedbackpopup_store'), $storeArray);
        }

        return parent::_afterSave($object);
    }
    
    
    public function load(Mage_Core_Model_Abstract $object, $value, $field = null)
    {
   
        return parent::load($object, $value, $field);
    }

    /**
     * Perform operations after object load
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Apptha_Feedbackpopup_Model_Mysql4_Feedbackpopup
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());

            $object->setData('store_id', $stores);

        }

        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Apptha_Feedbackpopup_Model_Feedbackpopup $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('feedbackpopup_store' => $this->getTable('feedbackpopup_store')),
                $this->getMainTable() . '.feedbackpopup_id = feedbackpopup_store.feedbackpopup_id',
                array())
                ->where('status = ?', 1)
                ->where('feedbackpopup_store.store_id IN (?)', $storeIds)
                ->order('feedbackpopup_store.store_id DESC')
                ->limit(1);
        }
  
        return $select;
    }
  
    
    public function lookupStoreIds($pageId)
    {
      
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('feedbackpopup_store'), 'store_id')
            ->where('feedbackpopup_id = ?',(int)$pageId);
        return $adapter->fetchCol($select);
    }
    
    /**
     * Set store model
     *
     * @param Mage_Core_Model_Store $store
     * @return Apptha_Feedbackpopup_Model_Feedbackpopup
     */
    public function setStore($store)
    {
        $this->_store = $store;
        return $this;
    }

    /**
     * Retrieve store model
     *
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        return Mage::app()->getStore($this->_store);
    }
}