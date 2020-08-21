<?php declare(strict_types=1);

namespace RichCongress\UnitTestBundle\Tests\TestTrait;

use RichCongress\UnitTestBundle\TestCase\TestCase;
use RichCongress\UnitTestBundle\Tests\Resources\Entity\DummyEntity;
use RichCongress\UnitTestBundle\TestTrait\Assertion\Parameter;

/**
 * Class MatchAssertionTraitTest
 *
 * @package   RichCongress\UnitTestBundle\Tests\TestTrait
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\UnitTestBundle\TestTrait\MatchAssertionTrait
 * @covers \RichCongress\UnitTestBundle\TestTrait\Assertion\Parameter
 */
class MatchAssertionTraitTest extends TestCase
{
    public function testAssertMatch(): void
    {
        $tested = [
            'id'          => 3,
            'name'        => 'Any Name',
            'size'        => 1,
            'floatValue'  => 3.1,
            'arrayValue'  => ['yes'],
            'isBoolean'   => true,
            'siret'       => '012345678910',
            'choiceValue' => 'Certain Type',
            'subArray'    => [
                'instanceOf'  => new DummyEntity(),
            ]
        ];

        $expected = [
            'id'          => 3,
            'name'        => Parameter::string(),
            'size'        => Parameter::integer(),
            'floatValue'  => Parameter::float(),
            'arrayValue'  => Parameter::array(),
            'isBoolean'   => Parameter::boolean(),
            'siret'       => Parameter::regex('/\d{12}/'),
            'choiceValue' => Parameter::choice(['Certain Type', 'Other Type']),
            'subArray'    => [
                'instanceOf'  => Parameter::instanceOf(DummyEntity::class),
            ],
        ];

        self::assertMatch($expected, $tested);
    }
}
