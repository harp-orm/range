<?php

namespace Harp\Range;

use Harp\Harp\AbstractModel;
use InvalidArgumentException;
use Closure;
use ArrayAccess;
use Serializable;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Range implements ArrayAccess, Serializable {

    /**
     * @param  Range[] $ranges
     * @param  string  $format
     * @return Range
     */
    public static function sum(array $ranges, $format = null)
    {
        $sum = new Range(0, 0, $format);

        foreach ($ranges as $range) {
            $sum->setMin($sum->getMin() + $range->getMin());
            $sum->setMax($sum->getMax() + $range->getMax());
        }

        return $sum;
    }

    /**
     * @param  Range[] $ranges
     * @param  string  $format
     * @return Range
     */
    public static function merge(array $ranges, $format = null)
    {
        $sum = new Range(0, 0, $format);

        foreach ($ranges as $range) {
            $sum->setMin(max($sum->getMin(), $range->getMin()));
            $sum->setMax(max($sum->getMax(), $range->getMax()));
        }

        return $sum;
    }

    /**
     * @param  string $range
     * @return Range
     */
    public static function fromString($range)
    {
        list($min, $max) = $range ? explode('|', $range) : [0, 0];

        return new Range($min, $max);
    }

    /**
     * @param integer        $min
     * @param integer        $max
     * @param string|Closure $format
     */
    public function __construct($min = 0, $max = 0, $format = "%d - %d")
    {
        $this->setMin($min);
        $this->setMax($max);
        $this->setFormat($format);
    }

    /**
     * @var integer
     */
    private $min;

    /**
     * @var integer
     */
    private $max;

    /**
     * @var string|Closure
     */
    private $format;

    /**
     * @return string|Closure
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string|Closure $format
     * @return Range
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return integer
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @param integer $min
     * @return Range
     */
    public function setMin($min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * @return integer
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param integer $min
     * @return Range
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Return a new Range object with added min and max values
     *
     * @param Range $range
     */
    public function add(Range $range)
    {
        return new Range(
            $this->getMin() + $range->getMin(),
            $this->getMax() + $range->getMax(),
            $this->getFormat()
        );
    }

    /**
     * @param  integer $offset
     */
    public function assertValidOffset($offset)
    {
        if ( ! $this->offsetExists($offset)) {
            throw new InvalidArgumentException(
                sprintf('Offset must be 0 (for min) or 1 (for max) but was %s', $offset)
            );
        }
    }

    /**
     * Implements ArrayAccess
     *
     * @param  integer $offset
     * @param  integer $value
     */
    public function offsetSet($offset, $value)
    {
        $this->assertValidOffset($offset);

        if ($offset == 0) {
            $this->setMin($value);
        } elseif ($offset == 1) {
            $this->setMax($value);
        }
    }

    /**
     * Implements ArrayAccess
     *
     * @param  integer $offset
     */
    public function offsetExists($offset)
    {
        return ($offset !== null and ($offset == 0 or $offset == 1));
    }

    /**
     * Implements ArrayAccess
     *
     * @param  integer $offset
     */
    public function offsetUnset($offset)
    {
        throw new InvalidArgumentException('Cannot unset range object');
    }

    /**
     * Implements ArrayAccess
     *
     * @param  integer $offset
     * @return integer
     */
    public function offsetGet($offset)
    {
        $this->assertValidOffset($offset);

        return $offset ? $this->max : $this->min;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->min.'|'.$this->max;
    }

    /**
     * @return string
     */
    public function humanize()
    {
        if ($this->format instanceof Closure) {
            $closure = $this->format;
            return $closure($this->min, $this->max);
        } else {
            return sprintf($this->format, $this->min, $this->max);
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [$this->min, $this->max];
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return $this->__toString();
    }

    /**
     * @param  string $data
     */
    public function unserialize($data)
    {
        list($min, $max) = explode('|', $data);

        $this->setMin($min);
        $this->setMax($max);
    }
}
