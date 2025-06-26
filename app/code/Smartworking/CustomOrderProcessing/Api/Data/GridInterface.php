<?php
/**
 * Smartworking Software.
 *
 * @category   Smartworking
 * @package    Smartworking_CustomOrderProcessing
 * @author     Smartworking Software Private Limited
 * @copyright  Smartworking Software Private Limited (https://Smartworking.com)
 * @license    https://store.Smartworking.com/license.html
 */
namespace Smartworking\CustomOrderProcessing\Api\Data;

/**
 * Grid Interface
 * @api
 */
interface GridInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    public const STATUS_ID          = 'status_id';
    public const STATUS_CODE        = 'status_code';
    public const LABEL              = 'label';
    public const IS_ACTIVE          = 'is_active';



    /**
     * Get Status Id
     *
     * @return integer|null
     */
    public function getStatusId();

    /**
     * Set Status Id
     *
     * @param integer $statusId
     * @return \Smartworking\CustomOrderProcessing\Api\Data\GridInterface
     */
    public function setStatusId($statusId);

    /**
     * Get Status Code
     * @return \Smartworking\CustomOrderProcessing\Api\Data\GridInterface
     */
    public function getStatusCode();

    /**
     * Set Status Code
     *
     * @param string $statusCode
     * @return \Smartworking\CustomOrderProcessing\Api\Data\GridInterface
     */
    public function setStatusCode($statusCode);

    /**
     * Get Label
     *
     * @return string|null
     */
    public function getLabel();

    /**
     * Set Label
     *
     * @param string $label
     * @return \Smartworking\CustomOrderProcessing\Api\Data\GridInterface
     */
    public function setLabel($label);

    /**
     * Get Is Active
     *
     * @return int|null
     */
    public function getIsActive();

    /**
     * Set Is Active
     *
     * @param int $isActive
     * @return \Smartworking\CustomOrderProcessing\Api\Data\GridInterface
     */
    public function setIsActive($isActive);

}