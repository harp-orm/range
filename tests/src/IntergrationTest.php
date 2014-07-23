<?php

namespace Harp\Range\Test;

use Harp\Range\Test\Model\TestModel;
use Harp\Range\Range;

/**
 * @coversNothing
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class IntegrationTest extends AbstractTestCase
{
    public function testRange()
    {
        $model = TestModel::find(1);

        $this->assertEquals(new Range(10, 32), $model->getDays());

        $model->setDays(new Range(4, 12));

        TestModel::save($model);

        $this->assertQueries([
            'SELECT `TestModel`.* FROM `TestModel` WHERE (`id` = 1) LIMIT 1',
            'UPDATE `TestModel` SET `days` = "4|12" WHERE (`id` = 1)',
        ]);
    }
}
