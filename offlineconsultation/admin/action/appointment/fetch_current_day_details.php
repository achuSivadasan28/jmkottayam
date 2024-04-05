<?php
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d');
$response_arr[0]['start_date'] = $currentDate;
echo json_encode($response_arr);
?>



