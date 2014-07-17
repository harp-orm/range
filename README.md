Range
=====

[![Build Status](https://travis-ci.org/harp-orm/range.png?branch=master)](https://travis-ci.org/harp-orm/range)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/harp-orm/range/badges/quality-score.png)](https://scrutinizer-ci.com/g/harp-orm/range/)
[![Code Coverage](https://scrutinizer-ci.com/g/harp-orm/range/badges/coverage.png)](https://scrutinizer-ci.com/g/harp-orm/range/)
[![Latest Stable Version](https://poser.pugx.org/harp-orm/range/v/stable.png)](https://packagist.org/packages/harp-orm/range)

An object representing 2 integer values

Usage
-----

This is a object representing two values - min and max, that can be stored string (as "first\_value|second\_value"). You can set / retrieve it as string or as an array like this:

```php
$range = new Range(5, 10);

// Will return 5
echo $range->getMin();

// Will return 10
echo $range->getMax();

// It also implements ArrayAccess
echo $range[0]; // 5
echo $range[1]; // 10

$range[0] = 2;
$range[1] = 9;

// And you can convert it to a short string representation
// For example for storing in the DB
echo (string) $range; // 2|9
$newRange = Range::fromString('2|9');

// You can "add" ranges together
// This will add the min and the max values
$range = new Range(5, 10);
$range->add(new Range(3, 20));
echo $range; // 8|30

// You can get a human readable version with humanize method
$range = new Range(5, 10);
echo $range->humanize(); // 5 - 10

// This is also custumizable
$range = new Range(5, 10, '%s - / - %s');
echo $range->humanize(); // 5 - / - 10

// You can add a closure to further custumize this
$range = new Range(5, 10, function ($min, $max) {
    return $min.'..'.$max;
});
echo $range->humanize(); // 5..10
```

Aggregate Methods
-----------------

There are several methods for working with multiple ranges:

```php
$range1 = new Range(5, 10);
$range2 = new Range(2, 8);
$range3 = new Range(9, 8);

// Sum adds all of the ranges together
$range = Range::sum([$range1, $range2, $range3], '%s - %s');
echo $range; // 16|26

// Get the maximum values for the first and second value
$range = Range::merge([$range1, $range2, $range3], '%s - %s');
echo $range; // 9|10
```

License
-------

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.
