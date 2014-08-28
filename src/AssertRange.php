<?php

namespace Harp\Range;

use Harp\Validate\Error;
use Harp\Validate\Assert\AbstractValueAssertion;

/**
 * Assert that the value is a valid iso currency code
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class AssertRange extends AbstractValueAssertion
{
    const RANDOM = 1;
    const CONSECUTIVE = 2;

    /**
     * @param  string  $rangeString
     * @return boolean
     */
    public static function isValidRange($rangeString)
    {
        return (bool) preg_match('/^\d*\|\d*$/', $rangeString);
    }

    /**
     * @var mixed
     */
    protected $type;

    /**
     * @param string  $name
     * @param integer $type    AssertRange::CONSECUTIVE or AssertRange::RANDOM
     * @param string  $message
     */
    public function __construct($name, $type = AssertRange::CONSECUTIVE, $message = ':name is invalid')
    {
        $this->type = $type;

        parent::__construct($name, $message);
    }

    public function isConsecutive()
    {
        return $this->type === AssertRange::CONSECUTIVE;
    }

    /**
     * @param  mixed   $value
     * @return boolean
     */
    public function isValid($value)
    {
        if ( ! self::isValidRange($value)) {
            return false;
        }

        if ($this->isConsecutive()) {
            $range = (new Range())->unserialize($value);
            if ($range->getMin() > $range->getMax()) {
                return false;
            }
        }

        return true;
    }
}
