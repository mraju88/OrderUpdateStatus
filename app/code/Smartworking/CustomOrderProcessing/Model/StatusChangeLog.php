<?php
namespace Smartworking\CustomOrderProcessing\Model;

use Magento\Framework\Model\AbstractModel;

class StatusChangeLog extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Smartworking\CustomOrderProcessing\Model\ResourceModel\StatusChangeLog::class);
    }
}