<?php
/**
 * Smartworking Grid Row MassDelete Controller
 *
 * @category    Smartworking
 * @package     Smartworking_CustomOrderProcessing
 * @author      Smartworking Software Private Limited
 *
 */
namespace Smartworking\CustomOrderProcessing\Controller\Adminhtml\Grid;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Smartworking\CustomOrderProcessing\Model\ResourceModel\Grid\CollectionFactory;
use Smartworking\CustomOrderProcessing\Model\Grid;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Massactions filter.
     *
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        Grid $grid = null
    ) 
    {
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->grid = $grid ?: \Magento\Framework\App\ObjectManager::getInstance()->get(Grid::class);
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        $recordDeleted = 0;
        foreach ($collection->getItems() as $auctionProduct) {
            $deleteItem = $this->grid->load($auctionProduct->getStatusId());
            $deleteItem->delete();
            $recordDeleted++;
        }
 
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been deleted.', $recordDeleted)
        );
 
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }

    /**
     * Check delete Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Smartworking_CustomOrderProcessing::row_data_delete');
    }
}