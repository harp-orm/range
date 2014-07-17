<?php

namespace Harp\Range\Test\Model;

use Harp\Harp\AbstractModel;
use Harp\Range\Range;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class TestModel extends AbstractModel
{
    public static function initialize($config)
    {
        $config;
    }

    public $id;
    public $range;

    public function getRange()
    {
        return Range::fromString($this->range);
    }

    public function setRange(Range $range)
    {
        $this->range = $range->__toString();
    }
}
