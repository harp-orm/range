<?php

namespace Harp\Range;

use Harp\Validate\Error;
use Harp\Validate\Assert\AbstractAssertion;

/**
 * Assert that the value is a valid iso currency code
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class AssertRange extends AbstractAssertion
{
    const RANDOM = 1;
    const CONSECUTIVE = 2;

    /**
     * @param  string  $rangeString
     * @return boolean
     */
    public static function isValid($rangeString)
    {
        return (bool) preg_match('/^\d*\|\d*$/', $rangeString);
    }

    /**
     * @var mixed
     */
    protected $type;

    /**
     * @param string  $name
     * @param integer $type
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
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($subject)
    {
        if ($this->issetProperty($subject, $this->getName())) {
            $value = $this->getProperty($subject, $this->getName());

            if (! self::isValid($value)) {
                return new Error($this->getMessage(), $this->getName());
            }

            if ($this->isConsecutive()) {
                $range = Range::fromString($value);
                if ($range->getMin() > $range->getMax()) {
                    return new Error($this->getMessage(), $this->getName());
                }
            }
        }
    }
}
