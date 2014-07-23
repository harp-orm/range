<?php

namespace Harp\Range\Test;

use Harp\Range\Test\Model\TestModel;
use Harp\Range\Range;

/**
 * @coversDefaultClass Harp\Range\DaysRangeTrait
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class DaysRangeTraitTest extends AbstractTestCase
{
    /**
     * @covers ::initialize
     * @covers ::getDays
     * @covers ::setDays
     */
    public function testRange()
    {
        $model = new TestModel();
        $this->assertEquals(new Range(0, 0), $model->getDays());

        $model->setDays(new Range(10, 21));

        $this->assertEquals('10|21', $model->days);
    }
}
