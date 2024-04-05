<?php
session_start();
function fetch_unique_code($obj,$login_id){
	$unique_code = '';
	$select_code = $obj->selectData("unique_code","tbl_login","where id=$login_id and status!=0");
	if(mysqli_num_rows($select_code)>0){
		while($select_code_row = mysqli_fetch_array($select_code)){
			$unique_code = $select_code_row['unique_code'];
		}
	}else{
		$unique_code = 'Error';
	}
	return $unique_code;
}

function fetch_Api_Key($obj){
	$api_key = '';
	$select_api_key = $obj->selectData("api_val","tbl_api_key","where status!=0");
	if(mysqli_num_rows($select_api_key)>0){
		while($select_api_key_row = mysqli_fetch_array($select_api_key)){
			$api_key = $select_api_key_row['api_val'];
		}
	}else{
		$api_key = 'Error';
	}
	return $api_key;
}
?>