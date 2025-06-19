<?php
namespace Smartworking\CustomOrderProcessing\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            $table = $setup->getConnection()
                ->newTable($setup->getTable('smartworking_order_status_change_log'))
                ->addColumn(
                    'log_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'nullable' => false, 'primary' => true],
                    'Log ID'
                )
                ->addColumn(
                    'order_id',
                    Table::TYPE_INTEGER,
                    null,
                    ['nullable' => false],
                    'Order ID'
                )
                ->addColumn(
                    'old_status',
                    Table::TYPE_TEXT,
                    32,
                    ['nullable' => false],
                    'Old Status'
                )
                ->addColumn(
                    'new_status',
                    Table::TYPE_TEXT,
                    32,
                    ['nullable' => false],
                    'New Status'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                    'Created At'
                )
                ->setComment('Order Status Change Log');

            $setup->getConnection()->createTable($table);
        }

        $setup->endSetup();
    }
}