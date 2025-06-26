<?php
/**
 * Smartworking Grid AddRow Controller
 *
 * @category    Smartworking
 * @package     Smartworking_CustomOrderProcessing
 * @author      Smartworking Software Private Limited
 *
 */
namespace Smartworking\CustomOrderProcessing\Controller\Adminhtml\Grid;

use Magento\Framework\Controller\ResultFactory;

class AddRow extends \Magento\Backend\App\Action
{
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry    $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) 
    {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
    }
    /**
     * Add New Row Form page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $rowId = (int) $this->getRequest()->getParam('id');
        $rowData = $this->_objectManager->create('Smartworking\CustomOrderProcessing\Model\Grid');
        if ($rowId) {
            $rowData = $rowData->load($rowId);
            $rowTitle = $rowData->getStatusCode();
            if (!$rowData->getStatusId()) {
                $this->messageManager->addError(__('row data no longer exist.'));
                $this->_redirect('grid/grid/rowdata');
                return;
            }
        }

        $this->_coreRegistry->register('row_data', $rowData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $rowId ? __('Edit Row Data ').$rowTitle : __('Add Row Data');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Smartworking_CustomOrderProcessing::add_row');
    }
}