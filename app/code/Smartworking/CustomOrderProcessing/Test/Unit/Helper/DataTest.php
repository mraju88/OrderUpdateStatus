<?php
namespace Smartworking\CustomOrderProcessing\Test\Unit\Helper;

use Smartworking\CustomOrderProcessing\Helper\Data;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class DataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\App\Helper\Context
     */
    protected $context;

    protected $expectedMessage;

    /**
     * Set up
     *
     * @return void
     */
    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);

        $this->context = $this->createMock(
            \Magento\Framework\App\Helper\Context::class
        );

        $this->storeManager = $this->getMockForAbstractClass(
            StoreManagerInterface::class
        );

        /* Mock Class Object With Constructor Args*/
        $this->helper = $objectManager->getObject(
            Data::class,
            [
               "context" => $this->context,
               "storeManager" => $this->storeManager
            ]
        );
    }

    /**
     * Test unitTest function
     */
    public function testUnitTest()
    {
        $this->expectedMessage = __("This is Unit Test");
        $this->assertEquals($this->expectedMessage, $this->helper->unitTest());
        // Optionally
        $this->assertTrue(true);
    }
}