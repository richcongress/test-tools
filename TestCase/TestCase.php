<?php declare(strict_types=1);

namespace RichCongress\TestTools\TestCase;

use RichCongress\TestTools\TestTrait\MatchAssertionTrait;
use RichCongress\TestTools\TestTrait\SubSetAssertionTrait;

/**
 * Class TestCase
 *
 * @package   RichCongress\TestTools\TestCase
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    use MatchAssertionTrait;
    use SubSetAssertionTrait;
}
