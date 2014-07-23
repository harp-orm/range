<?php

namespace Harp\Range\Test\Model;

use Harp\Harp\AbstractModel;
use Harp\Range\DaysRangeTrait;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class TestModel extends AbstractModel
{
    use DaysRangeTrait;

    public static function initialize($config)
    {
        DaysRangeTrait::initialize($config);
    }

    public $id;
}
