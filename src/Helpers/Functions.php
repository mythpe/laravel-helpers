<?php
/**
 * Copyright MyTh
 * Website: www.4MyTh.com
 * Email: mythpe@gmail.com
 * Copyright © 2006-2020 MyTh All rights reserved.
 */

use Symfony\Component\VarDumper\VarDumper;

if (!function_exists('to_number_format')) {
    /**
     * @param string|int|float $number
     * @param int $decimals
     * @param string $currency
     *
     * @return string
     */
    function to_number_format($number = '', $decimals = 0, $currency = null)
    {
        $dec_point = '.';
        $thousands_sep = ',';
        $v = number_format((float) $number, (int) $decimals, $dec_point, $thousands_sep);
        $temp = explode('.', $v);
        $temp[0] = isset($temp[0]) ? $temp[0] : 0;
        $temp[1] = isset($temp[1]) ? $temp[1] : 0;
        $args[0] = $temp[0];
        $res = "{$temp[0]}" . (intval($temp[1]) > 0 ? ".{$temp[1]}" : '');

        return $res . ($currency ? " {$currency}" : '');
    }
}

if (!function_exists('ends_with')) {
    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string $haystack
     * @param string|array $needles
     *
     * @return bool
     */
    function ends_with($haystack, $needles)
    {
        return \Illuminate\Support\Str::endsWith($haystack, $needles);
    }
}

if (!function_exists('starts_with')) {
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string $haystack
     * @param string|array $needles
     *
     * @return bool
     */
    function starts_with($haystack, $needles)
    {
        return \Illuminate\Support\Str::startsWith($haystack, $needles);
    }
}

if (!function_exists('d')) {
    /**
     * @param mixed ...$vars
     */
    function d(...$vars)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Headers: *');
        http_response_code(500);

        $debug = @debug_backtrace();
        $call = current($debug);
        $line = (isset($call['line']) ? $call['line'] : __LINE__);
        $file = (isset($call['file']) ? $call['file'] : __FILE__);

        echo("[{$file}] Line ({$line}): <br>");
        foreach ($vars as $v) {
            VarDumper::dump($v);
        }

        die(1);
    }
}

if (!function_exists('locale_attribute')) {
    /**
     * get attribute by locale
     *
     * @param string $attribute
     *
     * @uses app()->getLocale()
     * @return string
     */
    function locale_attribute($attribute = "name")
    {
        return (string) rtrim($attribute, '_') . "_" . app()->getLocale();
    }
}

if (!function_exists('str_replace_en_ar')) {
    /**
     * Replace string for AR & EN
     *
     * @param string $string
     *
     * @return string
     */
    function str_replace_en_ar($string = '')
    {
        return str_replace_name_ar(str_replace_name_en($string));
    }
}

if (!function_exists('str_replace_name_ar')) {
    /**
     * Replace string for AR Name
     *
     * @param string $string
     *
     * @return string
     */
    function str_replace_name_ar($string = '')
    {
        $string = str_ireplace(['إ', 'أ'], 'ا', $string);
        $string = str_ireplace("عبدال", 'عبد ال', $string);
        $string = trim($string);

        return "" . $string;
    }
}

if (!function_exists('str_replace_name_en')) {
    /**
     * Replace string for EN Name
     *
     * @param string $string
     *
     * @return string
     */
    function str_replace_name_en($string = '')
    {
        $string = trim($string);
        $string = ucwords($string);

        return "" . $string;
    }
}

if (!function_exists('date_by_locale')) {
    /**
     * Convert date By locale
     *
     * @param $date
     * @param null $toLocale
     *
     * @return mixed|string
     */
    function date_by_locale($date, $toLocale = null)
    {
        if (is_null($toLocale)) $toLocale = app()->getLocale();

        $ar = [
            "الأحد",
            "أح",
            "الإثنين",
            "إث",
            "الثلاثاء",
            "ث",
            "الأربعاء",
            "أر",
            "الخميس",
            "خ",
            "الجمعة",
            "ج",
            "السبت",
            "س",
            "ص",
            "ص",
            "م",
            "م",
            "يناير",
            "يناير",
            "فبراير",
            "فبراير",
            "مارس",
            "مارس",
            "أبريل",
            "أبريل",
            "مايو",
            "مايو",
            "يونيو",
            "يونيو",
            "يوليو",
            "يوليو",
            "أغسطس",
            "أغسطس",
            "سبتمبر",
            "سبتمبر",
            "اكتوبر",
            "اكتوبر",
            "نوفمبر",
            "نوفمبر",
            "ديسمبر",
            "ديسمبر",
        ];
        $notAr = [
            "Sunday",
            "Sun",
            "Monday",
            "Mon",
            "Tuesday",
            "Tue",
            "Wednesday",
            "Wed",
            "Thursday",
            "Thu",
            "Friday",
            "Fri",
            "Saturday",
            "Sat",
            "am",
            "AM",
            "pm",
            "PM",
            "January",
            "Jan",
            "February",
            "Feb",
            "March",
            "Mar",
            "April",
            "Apr",
            "May",
            "May",
            "June",
            "Jun",
            "July",
            "Jul",
            "August",
            "Aug",
            "September",
            "Sep",
            "October",
            "Oct",
            "November",
            "Nov",
            "December",
            "Dec",
        ];

        try {
            if (!$date) return $date;
            $date = str_ireplace($toLocale === 'ar' ? $notAr : $ar, $toLocale === 'ar' ? $ar : $notAr, $date);

            return $date;
        }
        catch (Exception $exception) {
            if (config('app.debug')) {
                d($exception);
            }
        }

        return $date ? $date : "";
    }
}

if (!function_exists('manifest_directory')) {
    function manifest_directory($path = null)
    {
        $directory = rtrim(config('app.manifest_directory'), '/');
        if (!is_null($path)) {
            $directory .= '/' . ltrim($path, '/');
        }
        return $directory;
    }
}

if (!function_exists('trans_has')) {
    /**
     * Determine if a translation exists.
     *
     * @param string $key
     * @param string|null $locale
     * @param bool $fallback
     *
     * @return bool
     */
    function trans_has($key, $locale = null, $fallback = true)
    {
        return app('translator')->has($key, $locale, $fallback);
    }
}

if (!function_exists('hijri')) {
    /**
     * helper convert to hijri
     *
     * @param string $date
     *
     * @return \GeniusTS\HijriDate\Date
     */
    function hijri($date = '')
    {
        if ($date instanceof \GeniusTS\HijriDate\Date)
            return $date;
        if (!$date instanceof \Illuminate\Support\Carbon) {
            $temp = \Illuminate\Support\Carbon::make($date);

            # Hijri
            if ($temp->year < 1990) {
                $ex = explode("-", $date);
                count($ex) < 3 && ($ex = explode("/", $date));

                $year = $temp->year;
                $month = isset($ex[1]) && strlen($ex[1]) == 2 ? $ex[1] : 1;
                $day = strpos("$date", "$year") === 0 && isset($ex[2]) ? $ex[2] : 1;

                $date = \GeniusTS\HijriDate\Hijri::convertToGregorian($day, $month, $year);
            }
            else {
                $date = $temp;
            }
        }

        return \GeniusTS\HijriDate\Hijri::convertToHijri($date);
    }
}

if (!function_exists('arabic_date')) {
    /**
     * @param $string
     * @param bool $prefix
     *
     * @return string
     */
    function arabic_date($string, $prefix = false)
    {
        $ar = [
            '/',
            '٠',
            '١',
            '٢',
            '٣',
            '٤',
            '٥',
            '٦',
            '٧',
            '٨',
            '٩',
        ];

        $notAr = [
            '-',
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
        ];

        $val = str_ireplace($notAr, $ar, $string);
        return (string) ($val . ($prefix ? " هـ" : ''));
    }
}
