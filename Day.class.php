<?php 

namespace cbenco;

class Day extends CalendarHelper {
    private $day;
    private $month;
    private $weekday;
    private $week;
    public function setWeek($week) {
        $this->week = $week;
    }
    public function getWeek() {
        return $this->week;
    }
    public function __construct($day, $month, $year, $timezone) {
        parent::__construct($year, $timezone);
        if (parent::isDigitNumber($day, 2, true) &&
            parent::isDigitNumber($month, 2, true)) {
            $this->day = $day;
            $this->month = $month;
        } else {
            throw new \Exception($day." & ".$month." Wrong Format", 1);
        }
        $this->setWeekday();
    }
    public function isWeekend() {
        if ($this->getWeekday() >= 6) {
            return true;
        }
        return false;
    }
    public function getWeekday() {
        return $this->weekday;
    }
    public function getWeekdayName() {
        return parent::getWeekdayName($this->weekday, "de");
    }
    private function setWeekday() {
        $datestring = parent::stringToDate($this->day, $this->month);
        $this->weekday = $datestring->format('N');
    }
    public function isToday() {
        $today = parent::stringToDate($this->day, $this->month);
        if ($today == new \DateTime('now')) {
            return true;
        } 
        return false;
    }
}
