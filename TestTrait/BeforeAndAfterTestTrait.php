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
    /** @var bool */
    protected static $holdBeforeTest = false;

    /** @var bool */
    protected static $holdAfterTest = false;

    public function setUp(): void
    {
        parent::setUp();

        if (!static::$holdBeforeTest) {
            $this->beforeTest();
        }
    }

    protected function beforeTest(): void
    {
        // Override this to execute code before each test
    }

    public function tearDown(): void
    {
        if (!static::$holdAfterTest) {
            $this->afterTest();
        }

        parent::tearDown();
    }

    protected function afterTest(): void
    {
        // Override this to execute code after each test
    }
}
