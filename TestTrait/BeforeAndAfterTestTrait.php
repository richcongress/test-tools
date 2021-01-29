<?php declare(strict_types=1);

namespace RichCongress\TestTools\TestTrait;

/**
 * Class BeforeAndAfterTestTrait
 *
 * @package    RichCongress\TestTools\TestTrait
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2021 RichCongress (https://www.richcongress.com)
 */
trait BeforeAndAfterTestTrait
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTestCase();
        $this->beforeTest();
    }

    protected function setUpTestCase(): void
    {
        // Override this to execute code before each test (reserved to TestCase)
    }

    protected function beforeTest(): void
    {
        // Override this to execute code before each test
    }

    public function tearDown(): void
    {
        $this->afterTest();
        $this->tearDownTestCase();

        parent::tearDown();
    }

    protected function tearDownTestCase(): void
    {
        // Override this to execute code after each test (reserved to TestCase)
    }

    protected function afterTest(): void
    {
        // Override this to execute code after each test
    }
}
