<?php

/****

Author: Litao Fu
Date:   2012-07-29

This application will read through all of the log files and print out
   * a count of the number of unique users per day and
   * a total count of the number of unique users based on the userid associated with each line.
You will only need to change the starting date, the ending date and the location of the log files. 

****/

require_once 'functions.php';

// Starting date to count
$strDateFrom = '2012-07-23';
// Ending date to count
$strDateTo = '2012-07-27';
// Location of the log files
$dir = 'C:/wamp/www/testenv/logs/exercise1/';

// Check starting and ending date format and compare
try {
  if (!checkDateFormat($strDateFrom) || !checkDateFormat($strDateTo)) {
    // throw exception if date format is false
    throw new Exception("Error Message: Please change the starting and/or the ending date format to yyyy-mm-dd.");
  } elseif (!compareDates($strDateFrom, $strDateTo)) {
    // throw exception if compare two dates returns false
    throw new Exception("Error Message: Please check if the starting date is smaller than the ending date.");
  }
}
catch (Exception $e) {
  echo $e->getMessage();
  exit;
}
  
// Create an array of dates
$aryDates = dateRangeArray($strDateFrom,$strDateTo);
$total_days = count($aryDates);
// Array changes to string
$strDates = implode(",", $aryDates);
// print_r($strDates);

// Create an array of the log file names
$files = glob($dir."*{".$strDates."}.txt", GLOB_BRACE);
// Count the number of log files in the directory
try {
  if (count($files) == 0) {
    // throw exception if no match file was found
    throw new Exception("Error Message: No match log file found. Please check the location for the log files.");
  }
}
catch (Exception $e) {
  echo $e->getMessage();
  exit;
}
//var_dump($files);

// The array contains all the unique user IDs
$total_unique_userids = array();
// The total number of unique users 
$total_users_count = 0;

// All the log files one by one
foreach ($files as $file) {

  $data = file_get_contents($file);
  $lines = explode("\r\n", $data);
  // var_dump($lines); exit;

  // The array with data from each line of the log files
  $exploded_data = array();
  // The array for all the user IDs in one log file
  $userids = array();
  // The log file creation date 
  $strDate = "";

  // All the log lines on by one
  foreach ($lines as $v) {

    $exploded_data = explode(" ", $v);
    if (checkDateFormat($exploded_data[0]) && checkLogLine($exploded_data[3]) ) {
      // var_dump($exploded_data); exit;
      $userid = trim($exploded_data[3], '[]');
      $userid = substr($userid, 0, strpos($userid, '@'));
      $userids[] = $userid;
      // var_dump($userids); exit;
      $total_unique_userids[] = $userid;
      $strDate = $exploded_data[0];
    }
  }

  // The array for all the unique user IDs in one log file
  $daily_unique_userids = array_unique($userids);
  // var_dump($daily_unique_userids);
  // The total number of unique users in one day 
  $daily_unique_user_count = count($daily_unique_userids);
  if ($daily_unique_user_count > 0) {
    echo "<p>There are $daily_unique_user_count unique users on $strDate.</p>\n";
  }
  // var_dump($daily_unique_user_count);
  $total_unique_userids = array_unique($total_unique_userids);
}
// var_dump($total_unique_userids);
$total_users_count = count($total_unique_userids);
// var_dump($total_users_count);
echo "\n<p>The total number of unique users over the course of a $total_days-day period is $total_users_count.</p>";

?>
