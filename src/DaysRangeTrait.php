<?php

namespace Harp\Range;

use Harp\Harp\Config;

/**
 * Adds days property
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
                new AssertRange('days'),
            ]);
    }

    /**
     * @var string
     */
    public $days;

    /**
     * @return Range
     */
    public function getDays()
    {
        return (new Range())->unserialize($this->days);
    }

    /**
     * @param Range $range
     */
    public function setDays(Range $range)
    {
        $this->days = $range->serialize();

        return $this;
    }
}
