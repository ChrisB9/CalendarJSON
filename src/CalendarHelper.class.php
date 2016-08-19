<?php

namespace cbenco;

class CalendarHelper extends \DateTime {
    private $year;
    private $timezone;
    public function getWeekdayName($weekday, $lang) {
        if ($weekday < 0 || $weekday > 7) {
            throw new \Exception($weekday." not a valid weekday", 1);
        }
        if ($weekday == 0) {
            $weekday = 6;
        } else {
            $weekday--;
        }
        $json = file_get_contents("dayofweek.json");
        $daysofweek = json_decode($json);
        if (!array_key_exists($lang, $daysofweek)) {
            throw new \Exception($lang." language not (yet) supported", 1);
        }
        $daysofweek_lang = $daysofweek->$lang;
        return $daysofweek_lang[$weekday]; 
    }
    public function getYear() {
        return $this->year;
    }
    public function getTimezone() {
        return $this->timezone;
    }
    public function setTimezone($timezone) {
        $this->timezone = new \DateTimeZone($timezone);
    }
    public function __construct($year, $timezone) {
        $this->setTimezone($timezone);
        if ($this->isDigitNumber($year, 4)) {
            $this->year = $year;
        } else if ($year == null) {
            $this->year = date('Y');
        } else {
            throw new \Exception("Wrong Year-Format", 1);
        } 
    }
    public function isDigitNumber($number, $length, $ismaxlength = false) {
        if (!is_numeric($length)) {
            throw new \Exception($length . "is not a number", 1);
        }
        if (is_numeric($number)) {
            if (!$ismaxlength) {
                if (strlen((string)$number) === $length) {
                    return true;
                } throw new \Exception($number." hasn't the correct size", 1);
            } else {
                if (strlen((string)$number) <= $length
                && strlen((string)$number) > 0) {
                    return true;
                } throw new \Exception($number." out of limit", 1);
            }
        } else {
            throw new \Exception($length . "is not a number", 1);
        }
        return false;
    }
    public function isLeapYear() {
        if ($this->year % 4 == 0) {
            if ($this->year % 100 == 0) {
                if ($this->year % 400 == 0) {
                    return true;
                }
                return false;
            }
            return true;
        }
        return false;
    }
    public function isDayDigit($day, $month) {
        if (!$this->isMonthDigit($month)) {
            throw new \Exception($month." is not a correct Month", 1);
        } else {
            if ($day > 31 || $day < 0) {
                return false;
            } else {
                if ($month == 2) {
                    if ($this->isLeapYear()) {
                        return $day <= 29 ? true : false;
                    } else {
                        return $day <= 28 ? true : false;
                    }
                }
                if ($month < 8) {
                    return ($month % 2 == 0) && ($day == 31) ? false : true; 
                } else {
                    return ($day <= 30) ? true :
                        (($month % 2 == 0) && ($day == 31)? true : false);
                }
            }
        }
    }
    public function isMonthDigit($month) {
        return $month < 13 && $month > 0 ? true : false;
    }
    public function stringToDate($day, $month) {
        if ($this->isDigitNumber($day, 2, true) &&
            $this->isDigitNumber($month, 2, true)) {
            return parent::createFromFormat(
                "d-m-Y",
                ($day."-".$month."-".$this->year),
                $this->timezone
            );
        }
    }
}
