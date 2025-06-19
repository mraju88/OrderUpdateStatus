Smartworking_CustomOrderProcessing Module

This Magento 2 module provides functionality to update order statuses via a REST API, log status changes, and send email notifications when orders are marked as shipped.
Module Overview

    Module Name: Smartworking_CustomOrderProcessing
    Version: 1.1.0
    Compatibility: Magento 2.4.x
    Dependencies: Magento_Sales, Magento_Email

Features
1. Order Status Update API

A REST API endpoint to programmatically update order statuses.

    Endpoint: PUT /rest/V1/orders/:orderId/status
    Request Payload:
    json

    {
        "status": "processing",
        "comment": "Status updated via API"
    }
    Response:
        Success: true
        Error: Exception message with HTTP error code
    Authentication: Requires admin or customer token with Magento_Sales::sales permission.

2. Order Status Change Logging

An event observer listens for sales_order_save_after to log status changes.

    Database Table: smartworking_order_status_change_log
        Columns: log_id, order_id, old_status, new_status, created_at
        Foreign key to sales_order.entity_id
    Functionality: Logs order ID, old status, new status, and timestamp whenever an order's status changes.

3. Shipment Email Notification

Sends an email to the customer when an order is marked as shipped.

    Trigger: Order status changes to complete or shipped.
    Email Template: order_shipped.html
        Configured via etc/email_templates.xml
        Customizable in Admin under Marketing > Email Templates.
    Content: Includes order number, customer name, and store information.

Installation

    Place the module files in app/code/Smartworking/CustomOrderProcessing/
    Run the following commands:
    bash

    php bin/magento setup:upgrade
    php bin/magento setup:di:compile
    php bin/magento cache:clean
    Configure the email template:
        Go to Marketing > Email Templates in the Admin panel.
        Add a new template based on Order Shipped Notification.

Usage
API Usage

Update an order status using the REST API:
curl --location --request PUT 'http://local.magento.com/rest/V1/orders/000000011/status' \
--header 'Content-Type: application/json' \
--header 'Authorization: ••••••' \
--header 'Cookie: PHPSESSID=b1rmtk5fngugkriroom6d72s69; mage-messages=%5B%7B%22type%22%3A%22error%22%2C%22text%22%3A%22Invalid%20Form%20Key.%20Please%20refresh%20the%20page.%22%7D%5D; private_content_version=e3607706fb9bc4b60cfdfb235d4908f9' \
--data '{
    "status": "processing",
    "comment": "Order status updated via API"
}'

    Generate Token: Use /rest/V1/integration/admin/token for admin authentication.
    Permissions: Ensure the API user has Magento_Sales::sales resource access.

Verify Status Change Logs

Check logged status changes in the database:
sql
SELECT * FROM smartworking_order_status_change_log;
Configure Shipment Email

Ensure email settings are configured in Stores > Configuration > Sales > Sales Emails to enable shipment notifications.
File Structure

    etc/module.xml: Module definition and dependencies.
    etc/webapi.xml: API endpoint configuration.
    etc/events.xml: Event observer configuration.
    etc/email_templates.xml: Email template configuration.
    Api/OrderStatusInterface.php: API interface.
    Model/OrderStatus.php: API implementation.
    Model/StatusChangeLog.php: Status change log model.
    Model/ResourceModel/StatusChangeLog.php: Resource model for log table.
    Observer/LogOrderStatusChange.php: Observer for status changes and email triggers.
    Setup/UpgradeSchema.php: Database schema for log table.
    view/frontend/email/order_shipped.html: Email template for shipment notification.

