<?php
namespace Smartworking\CustomOrderProcessing\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Smartworking\CustomOrderProcessing\Model\StatusChangeLogFactory;
use Smartworking\CustomOrderProcessing\Model\ResourceModel\StatusChangeLog;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class LogOrderStatusChange implements ObserverInterface
{
    protected $statusChangeLogFactory;
    protected $statusChangeLogResource;
    protected $transportBuilder;
    protected $inlineTranslation;
    protected $storeManager;
    protected $logger;

    public function __construct(
        StatusChangeLogFactory $statusChangeLogFactory,
        StatusChangeLog $statusChangeLogResource,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger
    ) {
        $this->statusChangeLogFactory = $statusChangeLogFactory;
        $this->statusChangeLogResource = $statusChangeLogResource;
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        /** @var Order $order */
        $order = $observer->getEvent()->getOrder();
        if (!$order || !$order->getId()) {
            return;
        }

        // Get original data to compare status
        $originalStatus = $order->getOrigData('status');
        $newStatus = $order->getStatus();

        if ($originalStatus !== $newStatus && $originalStatus !== null) {
            try {
                // Log status change
                $this->logStatusChange($order->getId(), $originalStatus, $newStatus);

                // Send email if order is marked as shipped
                if ($newStatus === Order::STATE_COMPLETE || $newStatus === 'shipped') {
                    $this->sendShipmentNotification($order);
                }
            } catch (\Exception $e) {
                $this->logger->error('Error in order status change observer: ' . $e->getMessage());
            }
        }
    }

    protected function logStatusChange($orderId, $oldStatus, $newStatus)
    {
        $log = $this->statusChangeLogFactory->create();
        $log->setData([
            'order_id' => $orderId,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $this->statusChangeLogResource->save($log);
    }

    protected function sendShipmentNotification(Order $order)
    {
        try {
            $this->inlineTranslation->suspend();
            
            $storeId = $order->getStoreId();
            $recipientEmail = $order->getCustomerEmail();
            $recipientName = $order->getCustomerName();

            $transport = $this->transportBuilder
                ->setTemplateIdentifier('order_shipped_template')
                ->setTemplateOptions([
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $storeId
                ])
                ->setTemplateVars([
                    'order' => $order,
                    'store' => $this->storeManager->getStore($storeId),
                    'customer_name' => $recipientName
                ])
                ->setFrom([
                    'name' => $this->storeManager->getStore($storeId)->getName(),
                    'email' => $this->storeManager->getStore($storeId)->getConfig('trans_email/ident_general/email')
                ])
                ->addTo($recipientEmail, $recipientName)
                ->getTransport();

            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->inlineTranslation->resume();
            $this->logger->error('Error sending shipment email: ' . $e->getMessage());
        }
    }
}