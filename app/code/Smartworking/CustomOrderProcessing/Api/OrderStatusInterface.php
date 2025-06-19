<?php
namespace Smartworking\CustomOrderProcessing\Api;

interface OrderStatusInterface
{
    /**
     * Update order status
     *
     * @param int $orderId
     * @param string $status
     * @param string|null $comment
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function updateStatus($orderId, $status, $comment = null);
}