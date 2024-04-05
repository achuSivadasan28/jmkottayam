<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$id=$_GET['id'];
$fetch_data = $obj1->selectData("id,product_name,category_id,price,discount,quantity","tbl_product","where status!=0 and category_id=$id ORDER BY id DESC");
if(mysqli_num_rows($fetch_data)>0){
    $x = 0;
 while($fetch_data_row = mysqli_fetch_array($fetch_data)){    
    $response_arr[$x]['id'] = $fetch_data_row['id'] ;
    $response_arr[$x]['product_name'] = $fetch_data_row['product_name'] ;
    
    $x++;
 }
}
echo json_encode($response_arr);
?>
