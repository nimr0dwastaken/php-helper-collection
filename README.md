# php-helper-collection
Small repo of PHP helper functions
See helpers.php


```
/**
 * Pre-formatted print_r for any data type
 * @param any $input
 */
function PRINTR($input) {}
```

```
/**
 * Pre-formatted var_dump for any data type
 * @param any $input
 */
function VD($input) {}
```

```
/**
 * Return query param array
 * @param string $url
 */
function urlParams($url) {}
```

```
/**
 * Returns current datetime
 * @param string $format default 'Y-m-d H:i:s'
 * @return string
 */
function now($format = 'Y-m-d H:i:s') {}
```

```
/**
 * Returns TRUE for any date string in $format else FALSE
 * 
 * @param string $date date in $format
 * @param string $format default 'd-m-Y'
 * @return bool
 */
function validDate($date, $format = 'd-m-Y') {}
```

```
/**
 * Generate an array of string dates between 2 dates
 *
 * @param string $start Start date
 * @param string $end End date
 * @param string $format Output format (Default: Y-m-d)
 *
 * @return array
 */
function getDatesFromRange($start, $end, $format = 'Y-m-d', $skipWeekends = true) {}
```

```
/**
 * Rounds number to nearest divisor
 * @param int $num
 * @param int $divisor
 * @return int
 */
function nearest($num, $divisor) {}
```

```
/**
 * Merges two multidimensional arrays disregarding keys with non-array values
 * @param array $array1
 * @param array $array2
 * @param bool  $unique - only return unique values per array / sub-array
 * @return array
 */
function recursiveMerge(array &$array1, array &$array2, $unique = false) {}
```

```
/**
 * Danish time format
 * @param date $date
 * @param bool $includeTime | Include timestamp
 * @return string - Date format for front end
 */
function myTime($date, $includeTime = false, $includeDate = true) {}
```

```
/**
 * Returns array of months by format
 * @param $format Default 'm-Y'
 * @return array Months
 */
function getMonths($format = 'm-Y') {}
```

```
/**
 * Returns time since / till certain datetime
 * Modify to fit your given locale
 * @param string $timestamp
 * @return string
 */
function timeSince($timestamp, $addDaysToMonths = false) {}
```

```
/**
 * Generate an array of string dates between 2 dates
 *
 * @param string $start Start date
 * @param string $end End date
 * @param string $format Output format (Default: Y-m-d)
 *
 * @return array
 */
function getDatesFromRange($start, $end, $format = 'Y-m-d', $skipWeekends = true) {}
```

```
/*
 * Adds values of 2 array per key. Fill missing indexes with value from one array.
 * Can also be set to subtract values of $arr2 from $arr1
 * Eg. 
 * $arr1[0] + $arr2[0] = $returnArr[0]
 * $arr1[1] + $arr2[1] = $returnArr[1]
 * 
 * @param array $arr1
 * @param array $arr2
 * @return array
 * @throws \exception 
 */
function array_add_values($arr1, $arr2, $subtract = false) {}
```
