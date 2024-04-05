<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr=array();
$search=$_GET['searchval'];
$search_where='';
if($search != ''){
$search_where = " and (staff_name like '%$search%' OR phone like '%$search%')";
}
$fetch_data = $obj1->selectData("id,staff_name,phone","tbl_staff","where status!=0  $search_where ORDER BY id DESC");
if(mysqli_num_rows($fetch_data)>0){
    $x = 0;
 while($fetch_data_row = mysqli_fetch_array($fetch_data)){
    $response_arr[$x]['id'] = $fetch_data_row['id'] ;
    $response_arr[$x]['staff_name'] = $fetch_data_row['staff_name'];
    $response_arr[$x]['phone'] = $fetch_data_row['phone'];
	 $x++;
 }
}else{
    
}
echo json_encode($response_arr);
?>
