<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$fetch_data = $obj1->selectData(" id,staff_name,staff_login","tbl_staff","where status=1");
if(mysqli_num_rows($fetch_data)>0){
    $x = 0;
 while($fetch_data_row = mysqli_fetch_array($fetch_data)){
    $response_arr[$x]['id'] = $fetch_data_row['staff_login'] ;
    $response_arr[$x]['staff_name'] = $fetch_data_row['staff_name'] ;
    $x++;
 }
}else{
    
}
echo json_encode($response_arr);
?>