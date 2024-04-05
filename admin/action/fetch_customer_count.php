<?php
include '../../_class/query.php';
session_start();
$obj = new Query();
$Searchval = $_POST['Searchval'];

$newDate = date("d-m-Y", strtotime($added_date));
 $vazhipad_reports = [];
$dataArray=[];
$length = 0;

$where_clause = '';
if($Searchval != ''){
	 $fetchReports = $obj->selectData("count(DISTINCT phone) as total_id","tbl_customer","where status = 1 and phone  like '%$Searchval%' and customer_status = 1");
}
else{
$fetchReports = $obj->selectData("count(DISTINCT phone) as total_id ","tbl_customer","where status = 1 and customer_status = 1");
}
$fetchReports_row = mysqli_fetch_array($fetchReports);
if($fetchReports_row['total_id'] != null){
	$length = $fetchReports_row['total_id'];
}
echo $length;
?>