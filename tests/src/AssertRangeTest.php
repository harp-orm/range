<?php

namespace Harp\Range\Test;

use Harp\Range\AssertRange;
use Harp\Validate\Test\AbstractTestCase;

/**
 * @coversDefaultClass Harp\Range\AssertRange
 */
class AssertRangeTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return [
            ['|', true],
            ['1|', true],
            ['1|2', true],
            ['|2', true],
            ['s', false],
            ['s|3', false],
            ['n34', false],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($rangeString, $expected)
    {
        $this->assertSame($expected, AssertRange::isValid($rangeString));
    }

    public function dataExecute()
    {
        return [
            ['1|2', AssertRange::RANDOM, true],
            ['2|1', AssertRange::RANDOM, true],
            ['|', AssertRange::RANDOM, true],
            ['n34', AssertRange::RANDOM, 'test is invalid'],
            ['1|2', AssertRange::CONSECUTIVE, true],
            ['ds|2', AssertRange::CONSECUTIVE, 'test is invalid'],
            ['4|2', AssertRange::CONSECUTIVE, 'test is invalid'],
        ];
    }

    /**
     * @dataProvider dataExecute
     * @covers ::execute
     */
    public function testExecute($value, $type, $expected)
    {
        $assertion = new AssertRange('test', $type);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @dataProvider dataExecute
     * @covers ::__construct
     * @covers ::isConsecutive
     */
    public function testConstruct()
    {
        $assertion = new AssertRange('test', AssertRange::CONSECUTIVE, 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertTrue($assertion->isConsecutive());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
