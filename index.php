<?php
header('Content-Type: application/json');
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
require 'src/CalendarHelper.class.php';
require 'src/Day.class.php';
require 'src/CalendarDayObject.class.php';
require 'src/Calendar.class.php';

$year = $_GET["year"];
if (!isset($year) || $year == null) {
	$year = date('Y');
}
$calendar = new cbenco\Calendar($year);
print_r($calendar->__to_sorted_json());
