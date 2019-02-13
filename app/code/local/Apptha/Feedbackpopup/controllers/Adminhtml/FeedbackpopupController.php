<?php

class Apptha_Feedbackpopup_Adminhtml_FeedbackpopupController extends Mage_Adminhtml_Controller_action {

    protected function _initAction() {

        $this->loadLayout()
                ->_setActiveMenu('feedbackpopup/items')
                ->_addBreadcrumb(Mage::helper('adminhtml')->__('feedbackpopup'), Mage::helper('adminhtml')->__('feedbackpopup'));
        
        return $this;
    }

    public function indexAction() {
        $this->_initAction()
                ->renderLayout();
        
    }

    public function editAction() {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('feedbackpopup/feedbackpopup')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('feedbackpopup_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('feedbackpopup/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('feedbackpopup'), Mage::helper('adminhtml')->__('feedbackpopup'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            
            //wysiwyg code start 
            
            if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
                $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
            }
            //wysiwyg code ends
            
            $this->_addContent($this->getLayout()->createBlock('feedbackpopup/adminhtml_feedbackpopup_edit'))
                    ->_addLeft($this->getLayout()->createBlock('feedbackpopup/adminhtml_feedbackpopup_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('feedbackpopup')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
           
             if ($data['fromdate'] == NULL || $data['todate'] == NULL) {
                 $data['fromdate'] =   now();
                 $data['todate']     = now();
                } 
            if($data['show_at'] != ''){
              
            $data['show_at'] = implode(",",array_filter($data['show_at']));
                
            }
           
            $model = Mage::getModel('feedbackpopup/feedbackpopup');
           
            $model->setData($data)
                   ->setId($this->getRequest()->getParam('id'));
            Mage::dispatchEvent('feedbackpopup_prepare_save', array('feedbackpopup' => $model, 'request' => $this->getRequest()));
          
               
            try {
               
                
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('feedbackpopup')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('feedbackpopup')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('feedbackpopup/feedbackpopup');

                $model->setId($this->getRequest()->getParam('id'))
                        ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() {
        $feedbackpopupIds = $this->getRequest()->getParam('feedbackpopup');
        if (!is_array($feedbackpopupIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($feedbackpopupIds as $feedbackpopupId) {
                    $feedbackpopup = Mage::getModel('feedbackpopup/feedbackpopup')->load($feedbackpopupId);
                    $feedbackpopup->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                        Mage::helper('adminhtml')->__(
                                'Total of %d record(s) were successfully deleted', count($feedbackpopupIds)
                        )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction() {
        $feedbackpopupIds = $this->getRequest()->getParam('feedbackpopup');
        if (!is_array($feedbackpopupIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($feedbackpopupIds as $feedbackpopupId) {
                    $feedbackpopup = Mage::getSingleton('feedbackpopup/feedbackpopup')
                            ->load($feedbackpopupId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) were successfully updated', count($feedbackpopupIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction() {
        $fileName = 'feedbackpopup.csv';
        $content = $this->getLayout()->createBlock('feedbackpopup/adminhtml_feedbackpopup_grid')
                ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction() {
        $fileName = 'feedbackpopup.xml';
        $content = $this->getLayout()->createBlock('feedbackpopup/adminhtml_feedbackpopup_grid')
                ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream') {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

}