<?php

namespace Harp\Range\Test;

use Harp\Range\Range;

/**
 * @coversDefaultClass Harp\Range\Range
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class RangeTest extends AbstractTestCase
{
    /**
     * @covers ::sum
     */
    public function testSum()
    {
        $range = Range::sum(
            [
                new Range(3, 5),
                new Range(2, 9),
                new Range(12, 20),
            ],
            '%s - %s'
        );
        $this->assertEquals(new Range(17, 34, '%s - %s'), $range);
    }

    /**
     * @covers ::merge
     */
    public function testMerge()
    {
        $range = Range::merge(
            [
                new Range(3, 5),
                new Range(12, 9),
                new Range(2, 20),
            ],
            '%s - %s'
        );
        $this->assertEquals(new Range(12, 20, '%s - %s'), $range);
    }

    /**
     * @covers ::fromString
     */
    public function testFromString()
    {
        $range = Range::fromString('10|32');
        $this->assertEquals(new Range(10, 32), $range);
    }

    /**
     * @covers ::__construct
     * @covers ::getMin
     * @covers ::setMin
     * @covers ::getMax
     * @covers ::setMax
     * @covers ::getFormat
     * @covers ::setFormat
     */
    public function testConstruct()
    {
        $range = new Range(10, 32, '%s / %s');

        $this->assertSame(10, $range->getMin());
        $range->setMin(4);
        $this->assertSame(4, $range->getMin());

        $this->assertSame(32, $range->getMax());
        $range->setMax(43);
        $this->assertSame(43, $range->getMax());

        $this->assertSame('%s / %s', $range->getFormat());
        $range->setFormat('%s \ %s');
        $this->assertSame('%s \ %s', $range->getFormat());

        $range = new Range();
        $this->assertSame(0, $range->getMin());
        $this->assertSame(0, $range->getMax());
        $this->assertSame('%d - %d', $range->getFormat());
    }

    /**
     * @covers ::add
     */
    public function testAdd()
    {
        $range = new Range(10, 32, '%s - %s');

        $result = $range->add(new Range(2, 3));

        $this->assertEquals(new Range(12, 35, '%s - %s'), $result);
        $this->assertNotSame($range, $result);
    }

    /**
     * @covers ::offsetGet
     * @covers ::assertValidOffset
     */
    public function testOffsetGet()
    {
        $range = new Range(10, 32);
        $this->assertSame(10, $range[0]);
        $this->assertSame(32, $range[1]);

        $this->setExpectedException('InvalidArgumentException', 'Offset must be 0 (for min) or 1 (for max) but was 3');

        $range[3];
    }

    /**
     * @covers ::offsetSet
     * @covers ::assertValidOffset
     */
    public function testOffsetSet()
    {
        $range = new Range(10, 32);

        $range[0] = 8;
        $this->assertSame(8, $range->getMin());

        $range[1] = 18;
        $this->assertSame(18, $range->getMax());

        $this->setExpectedException('InvalidArgumentException', 'Offset must be 0 (for min) or 1 (for max) but was 3');

        $range[3] = 9;
    }

    /**
     * @covers ::offsetExists
     */
    public function testOffsetExists()
    {
        $range = new Range(10, 32);

        $this->assertTrue(isset($range[0]));
        $this->assertTrue(isset($range[1]));
        $this->assertFalse(isset($range[2]));
        $this->assertFalse(isset($range[3]));
    }

    /**
     * @covers ::offsetUnset
     */
    public function testOffsetUnset()
    {
        $range = new Range(10, 32);

        $this->setExpectedException('InvalidArgumentException', 'Cannot unset range object');

        unset($range[0]);
    }

    /**
     * @covers ::__toString
     */
    public function testToString()
    {
        $range = new Range(10, 32);

        $this->assertSame('10|32', (string) $range);
    }

    /**
     * @covers ::humanize
     */
    public function testHumanize()
    {
        $range = new Range(10, 32);

        $this->assertSame('10 - 32', $range->humanize());

        $range = new Range(10, 32, function ($min, $max) {
            return $min.'..'.$max;
        });

        $this->assertSame('10..32', $range->humanize());
    }

    /**
     * @covers ::toArray
     */
    public function testToArray()
    {
        $range = new Range(10, 32);

        $this->assertSame([10, 32], $range->toArray());
    }

    /**
     * @covers ::serialize
     * @covers ::unserialize
     */
    public function testSerializable()
    {
        $range = new Range(10, 32);

        $this->assertSame('10|32', $range->serialize());

        $range->unserialize('2|3');

        $this->assertEquals(new Range(2, 3), $range);
    }

}
