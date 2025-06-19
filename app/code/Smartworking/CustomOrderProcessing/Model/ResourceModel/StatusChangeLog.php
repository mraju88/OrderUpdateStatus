<?php
namespace Smartworking\CustomOrderProcessing\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class StatusChangeLog extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('smartworking_order_status_change_log', 'log_id');
    }
}