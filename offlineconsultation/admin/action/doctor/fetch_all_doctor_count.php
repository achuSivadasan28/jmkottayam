<?php
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
$search_val = $_POST['search_val'];
$dep_id = $_POST['dep_id'];
$branch_id_f = $_POST['branch_id_f'];
$where_search = '';
$where_dep = '';
$where_branch = '';
if($search_val != ''){
	$where_search = " and (doctor_name like '%$search_val%' or phone_no like '%$search_val%' or email like '%$search_val%')";
}
if($dep_id !=0){
	$where_dep = " and department_id=$dep_id";
}
if($branch_id_f !=0){
	$where_branch = " and branch_id=$branch_id_f";
}
$select_all_count = $obj->selectData("count(id) as id","tbl_doctor","where status=1 $where_search $where_dep $where_branch");
$select_all_count_row = mysqli_fetch_array($select_all_count);
if($select_all_count_row['id'] != null){
	echo $select_all_count_row['id'];
}else{
	echo 0;
}
?>