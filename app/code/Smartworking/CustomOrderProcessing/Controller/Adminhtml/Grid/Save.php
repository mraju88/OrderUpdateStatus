<?php
/**
 * Smartworking Grid Row Save Controller
 *
 * @category    Smartworking
 * @package     Smartworking_CustomOrderProcessing
 * @author      Smartworking Software Private Limited
 *
 */
namespace Smartworking\CustomOrderProcessing\Controller\Adminhtml\Grid;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            $this->_redirect('grid/grid/addrow');
            return;
        }
        try {
            $rowData = $this->_objectManager->create('Smartworking\CustomOrderProcessing\Model\Grid');
            $rowData->setData($data);
            if (isset($data['status_id'])) {
                $rowData->setStatusId($data['status_id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('grid/grid/index');
    }

    /**
     * Check Category Map permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Smartworking_Auction::add_auction');
    }
}