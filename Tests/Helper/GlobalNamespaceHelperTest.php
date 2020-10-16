<?php declare(strict_types=1);

namespace RichCongress\TestTools\Tests\Helper;

use RichCongress\TestTools\TestCase\TestCase;
use RichCongress\TestTools\Tests\Resources\Entity\DummyEntity;

/**
 * Class GlobalNamespaceHelperTest
 *
 * @package   RichCongress\TestTools\Tests\Helper
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \debug
 * @covers \trace
 */
class GlobalNamespaceHelperTest extends TestCase
{
    public function testDebugWithSimpleValue(): void
    {
        $this->expectOutputString('string(4) "test"');

        \debug('test');
    }

    public function testDebugWithObjectValueWithoutVerbose(): void
    {
        $this->expectOutputString('Object of class RichCongress\TestTools\Tests\Resources\Entity\DummyEntity');

        \debug(new DummyEntity());
    }

    public function testDebugWithObjectValueWithVerbose(): void
    {
        $this->expectOutputRegex('/protected/');

        \debug(new DummyEntity(), true);
    }

    public function testTrace(): void
    {
        $this->expectOutputRegex('/^#0 (.*)GlobalNamespaceHelperTest\.php\((\d*)\): trace\(\)/');

        \trace();
    }
}
