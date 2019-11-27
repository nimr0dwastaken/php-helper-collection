/**
 * Pre-formatted print_r for any data type
 * @param any $input
 */
function PRINTR($input) {
    print "<pre>\n";
    print_r($input);
    print "</pre>\n";
}

/**
 * Pre-formatted var_dump for any data type
 * @param any $input
 */
function VD($input) {
    print "<pre>\n";
    var_dump($input);
    print "</pre>\n";
}

/**
 * Return query param array
 * @param string $url
 */
function urlParams($url) {
    if (!$querySet = (isset(parse_url($url)['query']) ? parse_url($url)['query'] : false)) {
        return $querySet;
    }
    $queries = explode('&', $querySet);
    foreach ($queries as $query) {
        $params[] = explode('=', $query);
    }
    foreach ($params as $param) {
        if (!isset($param[1]) || $param[1] == "") {
            continue;
        }
        $ret[$param[0]] = $param[1];
    }
    return !isset($ret) ? false : $ret;
}

/**
 * Returns current datetime
 * @param string $format default 'Y-m-d H:i:s'
 * @return string
 */
function now($format = 'Y-m-d H:i:s') {
    return (new \DateTime('now'))->format($format);
}


/**
 * Returns TRUE for any date string in $format else FALSE
 * 
 * @param string $date date in $format
 * @param string $format default 'd-m-Y'
 * @return bool
 */
function validDate($date, $format = 'd-m-Y') {
    $d = DateTime::createFromFormat($format, $date);

    return $d && $d->format($format) === $date;
}

/**
 * Generate an array of string dates between 2 dates
 *
 * @param string $start Start date
 * @param string $end End date
 * @param string $format Output format (Default: Y-m-d)
 *
 * @return array
 */
function getDatesFromRange($start, $end, $format = 'Y-m-d', $skipWeekends = true) {
    $array    = array();
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach ($period as $date) {
        if ($skipWeekends === true && in_array($date->format('D'), ['Sat', 'Sun'])) {
            continue;
        }
        $array[$date->format($format)] = NULL;
    }

    return $array;
}

/**
 * Rounds number to nearest divisor
 * @param int $num
 * @param int $divisor
 * @return int
 */
function nearest($num, $divisor) {
    $diff = $num % $divisor;
    if ($diff == 0) {
        return $num;
    } elseif ($diff >= ceil($divisor / 2)) {
        return $num - $diff + $divisor;
    } else {
        return $num - $diff;
    }
}

/**
 * Merges two multidimensional arrays disregarding keys with non-array values
 * @param array $array1
 * @param array $array2
 * @param bool  $unique - only return unique values per array / sub-array
 * @return array
 */
function recursiveMerge(array &$array1, array &$array2, $unique = false) {
    $merged = $array1;

    foreach ($array2 as $key => &$value) {
        if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
            $merged[$key] = recursiveMerge($merged[$key], $value, $unique);
        } else {
            if (!isset($merged[$key])) {
                $merged[$key] = $value;
            } else {
                if ($unique == true) {
                    if (!in_array($value, $merged)) {
                        $merged[] = $value;
                    }
                } else {
                    $merged[] = $value;
                }
            }
        }
    }
    return $merged;
}

/**
 * Danish time format
 * @param date $date
 * @param bool $includeTime | Include timestamp
 * @return string - Date format for front end
 */
function myTime($date, $includeTime = false, $includeDate = true) {
    if (!$includeTime) {
        return (new \DateTime($date))->format('d-m-Y');
    } elseif ($includeDate === true && $includeTime === true) {
        return (new \DateTime($date))->format('d-m-Y H:i');
    } elseif ($includeTime === true && !$includeDate) {
        return (new \DateTime($date))->format('H:i');
    }
}

/**
 * Returns array of months by format
 * @param $format Default 'm-Y'
 * @return array Months
 */
function getMonths($format = 'm-Y') {
    return array_reduce(range(1, 12), function($rslt, $m) {
        $rslt[$m] = date($format, mktime(0, 0, 0, $m, 10));
        return $rslt;
    });
}

/**
 * Returns time since / till certain datetime
 * Modify to fit your given locale
 * @param string $timestamp
 * @return string
 */
function timeSince($timestamp, $addDaysToMonths = false) {
    if (is_null($timestamp)) {
        return false;
    }
    $date     = (new \DateTime($timestamp));
    $interval = $date->diff(new \DateTime('now'));
    $since    = [
        'years'   => $interval->format('%y'),
        'months'  => $interval->format('%m'),
        'days'    => $interval->format('%d'),
        'hours'   => $interval->format('%h'),
        'minutes' => $interval->format('%i'),
        'seconds' => $interval->format('%s'),
        'now'     => $interval->format('%r')
    ];

// Years
    if ($since['years'] > 0) {
        $years = $since['years'] . ' år';
    } else {
        $years = "";
    }
// Months
    if ($since['months'] > 1) {
        $months = $since['months'] . ' måneder';
    } elseif ($since['months'] <= 1) {
        $months = $since['months'] . ' måned';
    }
// Days
    if ($since['days'] > 1) {
        $days = $since['days'] . ' dage';
    } elseif ($since['days'] <= 1) {
        $days = $since['days'] . ' dag';
    }
// Hours
    if ($since['hours'] > 1) {
        $hours = $since['hours'] . ' timer';
    } elseif ($since['hours'] <= 1) {
        $hours = $since['hours'] . ' time';
    }
// Minutes
    if ($since['minutes'] > 1) {
        $minutes = $since['minutes'] . ' minutter';
    } elseif ($since['minutes'] <= 1) {
        $minutes = $since['minutes'] . ' minut';
    }
// Seconds
    if ($since['seconds'] > 1) {
        $seconds = $since['seconds'] . ' sekunder';
    } elseif ($since['seconds'] <= 1) {
        $seconds = $since['seconds'] . ' sekund';
    }

    if ($since['years'] != 0) {
        // More than a year
        $ret = $years . ($months != 0 ? '&nbsp;' . $months : '');
    } elseif ($since['months'] > 0 && $since['years'] == 0) {
        // More than a month, less than a year
        if ($addDaysToMonths === false) {
            $ret = $months;
        } else {
            $ret = $months . ' ' . $days;
        }
    } elseif ($since['days'] > 0 && $since['months'] == 0 && $since['years'] == 0) {
        // More than a day, less than a month
        $ret = $days;
    } elseif ($since['hours'] > 0 && $since['days'] == 0 && $since['months'] == 0 && $since['years'] == 0) {
        // More than an hour, less than a day
        $ret = $hours /* . ' ' . ($minutes != 0 ? $minutes : $seconds) */;
    } elseif ($since['minutes'] > 0 && $since['hours'] == 0 && $since['days'] == 0 && $since['months'] == 0 && $since['years'] == 0) {
        // More than a minute, less than an hour
        $ret = $minutes;
    } elseif ($since['seconds'] && $since['minutes'] == 0 && $since['hours'] == 0 && $since['days'] == 0 && $since['months'] == 0 && $since['years'] == 0) {
        // More than a second, less than a minute
        $ret = $seconds;
    }


    if ($since['now'] == "-") {
        $ret = 'Om ' . @$ret;
    } else {
        $ret = $ret . ' siden';
    }

    return $ret;
}

/**
 * Generate an array of string dates between 2 dates
 *
 * @param string $start Start date
 * @param string $end End date
 * @param string $format Output format (Default: Y-m-d)
 *
 * @return array
 */
function getDatesFromRange($start, $end, $format = 'Y-m-d', $skipWeekends = true) {
    $ret      = [];
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach ($period as $date) {
        if ($skipWeekends === true && in_array($date->format('D'), ['Sat', 'Sun'])) {
            continue;
        }
        $ret[$date->format($format)] = NULL;
    }

    return $ret;
}

/*
 * Adds values of 2 array per key. Fill missing indexes with value from one array
 * Eg. 
 * $arr1[0] + $arr2[0] = $returnArr[0]
 * $arr1[1] + $arr2[1] = $returnArr[1]
 * 
 * @param array $arr1
 * @param array $arr2
 * @return array
 * @throws \exception 
 */

function array_add_values($arr1, $arr2, $subtract = false) {
    if (!is_array($arr1)) {
        throw new \exception('$arr1 is not of type: array');
    }
    if (!is_array($arr2)) {
        throw new \exception('$arr2 is not of type: array');
    }
    $retArr = [];
    if (count($arr2) > count($arr1)) {
        $tempArr1 = $arr2;
        $tempArr2 = $arr1;
    } else {
        $tempArr1 = $arr1;
        $tempArr2 = $arr2;
    }

    foreach ($tempArr1 as $key => $value) {
        if (!$subtract) {
            $retArr[$key] = $value + (isset($tempArr2[$key]) ? $tempArr2[$key] : 0);
        } elseif ($subtract === true) {
            $retArr[$key] = $value - (isset($tempArr2[$key]) ? $tempArr2[$key] : 0);
        }
    }

    return $retArr;
}
