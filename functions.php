<?php
  
// Compare two dates
function compareDates($date1, $date2) {
  list($year, $month, $day) = preg_split("/\-/", date("Y-m-d"));
  $today = sprintf('%04d%02d%02d', $year, $month, $day);

  list($year, $month, $day) = preg_split("/\-/", $date1);
  $new_date1 = sprintf('%04d%02d%02d', $year, $month, $day);

  list($year, $month, $day) = preg_split("/\-/", $date2);
  $new_date2 = sprintf('%04d%02d%02d', $year, $month, $day);

  if ($new_date1 > $today || $new_date2 > $today) {
    return false;
  }

  return ($new_date1 <= $new_date2);
}

// Return the array with dates format yyyy-mm-dd
function dateRangeArray($start, $end) {
  $range = array();
  if (is_string($start) === true) $start = strtotime($start);
  if (is_string($end) === true ) $end = strtotime($end);
  
  do {
    $range[] = date('Y-m-d', $start);
    $start = strtotime("+ 1 day", $start);
  } while($start <= $end);

  return $range;
}

// Check date format yyyy-mm-dd
function checkDateFormat($date) {
  if (preg_match("/^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/", $date)) {
    return true;
  } else {
    return false;
  }
}

// Check log lines that contain user IDs
function checkLogLine($check_userid) {
  if (preg_match("/^\[[a-zA-Z]*@[0-9.]*\]$/", $check_userid)) {
    return true;
  } else {
    return false;
  }
}

?>
