<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$search_val = $_GET['search_val'];
$limit = $_GET['limit'];
$search_where = "";
if($search_val != ''){
	$search_where = " and (staff_name like '%$search_val%' or email like '%$search_val%' or phone like '%$search_val%')";
}
$fetch_data = $obj1->selectData("id,staff_name,phone,branch","tbl_staff","where status!=0 $search_where ORDER BY id DESC limit $limit");
if(mysqli_num_rows($fetch_data)>0){
    $x = 0;
 while($fetch_data_row = mysqli_fetch_array($fetch_data)){
    $response_arr[$x]['id'] = $fetch_data_row['id'] ;
    $response_arr[$x]['staff_name'] = $fetch_data_row['staff_name'] ;
    $response_arr[$x]['phone'] = $fetch_data_row['phone'];
	 $response_arr[$x]['branch'] = $fetch_data_row['branch'];
    $x++;
 }
}else{
    
}
echo json_encode($response_arr);
?>
