<?php

namespace Harp\Range;

use Harp\Harp\Config;

/**
 * Adds value property
 * Adds present and number asserts on value property
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
trait DaysRangeTrait
{
    public static function initialize(Config $config)
    {
        $config
            ->addAsserts([
                new AssertRange('value'),
            ]);
    }

    public $days;

    /**
     * @return Money
     */
    public function getDays()
    {
        return (new Range())->unserialize($this->days);
    }

    /**
     * @return static
     */
    public function setDays(Range $range)
    {
        return $this->days = $range->serialize();
    }
}
