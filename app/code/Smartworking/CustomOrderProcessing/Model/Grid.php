<?php

/**
 * Auction Grid Model.
 *
 * @category    Smartworking
 *
 * @author      Smartworking Software Private Limited
 */
namespace Smartworking\CustomOrderProcessing\Model;

use Smartworking\CustomOrderProcessing\Api\Data\GridInterface;

class Grid extends \Magento\Framework\Model\AbstractModel implements GridInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'wk_smartworking_order_status';

    /**
     * @var string
     */
    protected $_cacheTag = 'wk_smartworking_order_status';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'wk_smartworking_order_status';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Smartworking\CustomOrderProcessing\Model\ResourceModel\Grid');
    }
    /**
     * Get status_id.
     *
     * @return int
     */
    public function getStatusId()
    {
        return $this->getData(self::STATUS_ID);
    }

    /**
     * Set statusId.
     */
    public function setStatusId($statusId)
    {
        return $this->setData(self::STATUS_ID, $statusId);
    }

    /**
     * Get Status code.
     *
     * @return varchar
     */
    public function getStatusCode()
    {
        return $this->getData(self::STATUS_CODE);
    }

    /**
     * Set Status code.
     */
    public function setStatusCode($statuscode)
    {
        return $this->setData(self::STATUS_CODE, $statuscode);
    }

    /**
     * Get getLabel.
     *
     * @return varchar
     */
    public function getLabel()
    {
        return $this->getData(self::LABEL);
    }

    /**
     * Set label.
     */
    public function setLabel($label)
    {
        return $this->setData(self::LABEL, $label);
    }

    /**
     * Get IsActive.
     *
     * @return varchar
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set IsActive.
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getStatusId()];
    }    
}