<?php
date_default_timezone_set('Asia/Kolkata');
$days=date('Y-m-d');
// Given current date in string format 
$datestring = $days;
  
// Converting string to date
$date = strtotime($datestring);
   
// Last date of current month.
$lastdate = strtotime(date("Y-m-t", $date ));
  
  
// Day of the last date 
$last_date = date("d", $lastdate);
$month_end_date = date("Y-m-$last_date");
$month_start_date = date('Y-m-01');
$response_arr[0]['start_date'] = $month_start_date;
$response_arr[0]['end_date'] = $month_end_date;
echo json_encode($response_arr);
?>