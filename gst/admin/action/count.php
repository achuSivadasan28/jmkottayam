<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$fetch_data = $obj1->selectData(" count(id) as id","tbl_product","where status=1 and quantity<=10");
if(mysqli_num_rows($fetch_data)>0){
    $x = 0;
    while($fetch_data_row = mysqli_fetch_array($fetch_data)){
        $response_arr[$x]['id'] = $fetch_data_row['id'] ;
$x++;
}
}
echo json_encode($response_arr);
?>