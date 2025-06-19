<?php
namespace Smartworking\CustomOrderProcessing\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;

class OrderStatus implements \Smartworking\CustomOrderProcessing\Api\OrderStatusInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var Order
     */
    protected $order;

    /**
     * OrderStatus constructor.
     *
     * @param OrderRepositoryInterface $orderRepository
     * @param Order $order
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        Order $order
    ) {
        $this->orderRepository = $orderRepository;
        $this->order = $order;
    }

    /**
     * @inheritDoc
     */
    public function updateStatus($orderId, $status, $comment = null)
    {
        try {
            $order = $this->orderRepository->get($orderId);
            
            if (!$order->getEntityId()) {
                throw new LocalizedException(__('Order not found'));
            }

            // Validate status
            if (!$this->order->getConfig()->getStateStatuses($order->getState())) {
                throw new LocalizedException(__('Invalid status provided'));
            }

            $order->setStatus($status)
                  ->setState($this->getStateForStatus($status));

            if ($comment) {
                $order->addStatusHistoryComment($comment, $status);
            }

            $this->orderRepository->save($order);
            return true;
        } catch (\Exception $e) {
            throw new LocalizedException(__($e->getMessage()));
        }
    }

    /**
     * Get state for status
     *
     * @param string $status
     * @return string
     */
    private function getStateForStatus($status)
    {
        $states = $this->order->getConfig()->getStates();

        foreach ($states as $state => $stateStatuses) {
            // Ensure $stateStatuses is an array
            if (!is_array($stateStatuses)) {
                $stateStatuses = (array)$stateStatuses;
            }
            if (in_array($status, $stateStatuses)) {
                return $state;
            }
        }
        return $this->order->getState();
    }
}