<?php

namespace Harp\Range\Test;

use Harp\Range\AssertRange;

/**
 * @coversDefaultClass Harp\Range\AssertRange
 */
class AssertRangeTest extends AbstractTestCase
{
    public function dataIsValidRange()
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
     * @dataProvider dataIsValidRange
     * @covers ::isValidRange
     */
    public function testIsValidRange($rangeString, $expected)
    {
        $this->assertSame($expected, AssertRange::isValidRange($rangeString));
    }

    public function dataIsValid()
    {
        return [
            ['1|2', AssertRange::RANDOM, true],
            ['2|1', AssertRange::RANDOM, true],
            ['|', AssertRange::RANDOM, true],
            ['n34', AssertRange::RANDOM, false],
            ['1|2', AssertRange::CONSECUTIVE, true],
            ['ds|2', AssertRange::CONSECUTIVE, false],
            ['4|2', AssertRange::CONSECUTIVE, false],
        ];
    }

    /**
     * @dataProvider dataIsValid
     * @covers ::isValid
     */
    public function testIsValid($value, $type, $expected)
    {
        $assertion = new AssertRange('test', $type);

        $this->assertEquals($expected, $assertion->isvalid($value));
    }

    /**
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
