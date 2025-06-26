<?php

/**
 * Grid Grid Collection.
 * @category    Smartworking
 * @author      Smartworking Software Private Limited
 */
namespace Smartworking\CustomOrderProcessing\Model\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'status_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Smartworking\CustomOrderProcessing\Model\Grid', 'Smartworking\CustomOrderProcessing\Model\ResourceModel\Grid');
    }
}