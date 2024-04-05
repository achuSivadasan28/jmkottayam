<?php
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
$search_val = $_POST['search_val'];
$where_search = '';
	if($search_val != ''){
		$where_search = " and branch_name like '%$search_val%'";
	}
$select_all_count = $obj->selectData("count(id) as id","tbl_branch","where status!=0 $where_search");
$select_all_count_row = mysqli_fetch_array($select_all_count);
if($select_all_count_row['id'] != null){
	echo $select_all_count_row['id'];
}else{
	echo 0;
}
?>