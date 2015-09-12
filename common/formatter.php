<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 16.08.2015
 * Time: 22:11
 */

function format_DateTimeNumbers($input)
{
    $res = date("d.m.Y H:i", strtotime($input));
    if ($res == "01.01.1970 01:00")
        $res = "";
    return $res;
}

function format_DateTimeText($input, $input2 = null)
{
    $res = date("d.m.Y H:i", strtotime($input));
    if ($res == "01.01.1970 01:00")
        return "";
    $date = format_DateText($input);
    $res = $date . " um " . date("H:i", strtotime($input));
    if ($input2 != null) {
        $date2 = format_DateText($input2);
        if ($date2 != $date) {
            $date2text = format_DateTimeText($input2);
            if ($date2text != "")
                $res .= " bis " . $date2text;
        } else
            $res .= " bis ca " . date("H:i", strtotime($input2));
    }
    return $res;
}

function format_DateText($input)
{
    $time = strtotime($input);
    $days = unserialize(LOCALE_DAYS_SER);
    $months = unserialize(LOCALE_MONTHS_SER);
    $res = $days[date("w", $time)] . ", " . date("d", $time) . " " . $months[date("n", $time)] . " " . date("Y", $time);
    return $res;
}