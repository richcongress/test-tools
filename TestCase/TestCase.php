<?php declare(strict_types=1);

namespace RichCongress\UnitTestBundle\TestCase;

use RichCongress\UnitTestBundle\TestTrait\MatchAssertionTrait;
use RichCongress\UnitTestBundle\TestTrait\SubSetAssertionTrait;

/**
 * Class TestCase
 *
 * @package   RichCongress\UnitTestBundle\TestCase
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    use MatchAssertionTrait;
    use SubSetAssertionTrait;
}
