<?php

namespace cbenco;

class Calendar extends Day {
    private $year;
    private $calendarDayObjectArray;
    private $calendarObjectArray;
    private $timezone;
    public function __construct($year, $timezone = null) {
        $this->year = $year;
        if ($timezone == null) {
            $timezone = "Europe/Berlin";
        }
        $this->timezone = $timezone;
        $this->initializeCalendarYear();
    }
    public function initializeCalendarYear() {
        $week = 1;
        $month = 1;
        while (parent::isMonthDigit($month)) {
            $day = 1;
            while (parent::isDayDigit($day, $month)) {
                $calendardayobject = new CalendarDayObject();
                parent::__construct(
                    $day,
                    $month,
                    $this->year,
                    $this->timezone
                );
                parent::setWeek($week);
                $calendardayobject->year = $this->year;
                $calendardayobject->month = $month;
                $calendardayobject->week = parent::getWeek();
                $calendardayobject->weekday = parent::getWeekday();
                $calendardayobject->isWeekend = parent::isWeekend();
                $calendardayobject->isToday = parent::isToday();
                $calendardayobject->day = $day;
                $this->calendarObjectArray[$this->year][$month][$day] = 
                array(
                    "properties" => array(
                        "week" => $calendardayobject->week,
                        "weekday" => $calendardayobject->weekday,
                        "weekdayname" => parent::getWeekdayName(),
                        "isWeekend" => $calendardayobject->isWeekend,
                        "isToday" => $calendardayobject->isToday
                    )
                );
                $this->calendarDayObjectArray[] = $calendardayobject;
                if (parent::getWeekday() == 7) {
                    $week++;
                }
                $day++;
            }
            $month++;
        }
    }
    public function getCalendarYear() {
        return $this->calendarDayObjectArray;
    }
    public function __to_json() {
        return json_encode($this->calendarDayObjectArray);
    }
    public function __to_sorted_json() {
        return json_encode($this->calendarObjectArray);
    }
}
