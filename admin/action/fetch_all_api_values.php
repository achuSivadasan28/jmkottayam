<?php
require_once '../../_class/query.php';
$obj=new query();
$select_data = $obj->selectData("api_key","api_key","where status!=0");
if(mysqli_num_rows($select_data)>0){
	while($select_data_row = mysqli_fetch_array($select_data)){
		$api_key = $select_data_row['api_key'];
	}
}
$response_arr[0]['api_key'] = $api_key;
echo json_encode($response_arr);
?>