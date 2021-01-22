<?php declare(strict_types=1);

namespace RichCongress\TestTools\Tests\Resources;

use PHPUnit\Framework\TestCase;
use RichCongress\TestTools\TestTrait\BeforeAndAfterTestTrait;

/**
 * Class DummyTestTrait
 *
 * @package    RichCongress\TestTools\Tests\Resources
 * @author     Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright  2014 - 2021 RichCongress (https://www.richcongress.com)
 */
class DummyTestTrait extends TestCase
{
    use BeforeAndAfterTestTrait;

    public $beforeTestExecuted = false;
    public $afterTestExecuted = false;

    protected function beforeTest(): void
    {
        $this->beforeTestExecuted = true;
    }

    protected function afterTest(): void
    {
        $this->afterTestExecuted = true;
    }
}
