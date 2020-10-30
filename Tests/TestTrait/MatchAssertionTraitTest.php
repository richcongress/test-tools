<?php declare(strict_types=1);

namespace RichCongress\TestTools\Tests\TestTrait;

use RichCongress\TestTools\Accessor\ForcePropertyAccessor;
use RichCongress\TestTools\TestCase\TestCase;
use RichCongress\TestTools\Tests\Resources\Entity\DummyEntity;
use RichCongress\TestTools\TestTrait\Assertion\Parameter;

/**
 * Class MatchAssertionTraitTest
 *
 * @package   RichCongress\TestTools\Tests\TestTrait
 * @author    Nicolas Guilloux <nguilloux@richcongress.com>
 * @copyright 2014 - 2020 RichCongress (https://www.richcongress.com)
 *
 * @covers \RichCongress\TestTools\TestTrait\MatchAssertionTrait
 * @covers \RichCongress\TestTools\TestTrait\Assertion\Parameter
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

    public function testForObject(): void
    {
        $accessor = new ForcePropertyAccessor();
        $object = new DummyEntity();
        $accessor->setValue($object, 'id', 1);
        $accessor->setValue($object, 'name', 'Name');
        $accessor->setValue($object, 'keyname', 'keyname');
        $accessor->setValue($object, 'privateVariable', ['test']);

        self::assertMatch(
            [
                'id' => 1,
                'name' => 'Name',
                'keyname' => Parameter::string(),
                'privateVariable' => [
                    Parameter::string(),
                ],
            ],
            $object
        );
    }
}
