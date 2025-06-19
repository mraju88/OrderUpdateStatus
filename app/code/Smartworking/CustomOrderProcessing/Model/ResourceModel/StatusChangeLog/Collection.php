<?php
namespace Smartworking\CustomOrderProcessing\Model\ResourceModel\StatusChangeLog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'log_id';

    protected function _construct()
    {
        $this->_init(
            \Smartworking\CustomOrderProcessing\Model\StatusChangeLog::class,
            \Smartworking\CustomOrderProcessing\Model\ResourceModel\StatusChangeLog::class
        );
    }
}