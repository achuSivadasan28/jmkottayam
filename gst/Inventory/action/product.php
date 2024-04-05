<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$id=$_POST['urlv'];
$fetch_data = $obj1->selectData("id,product_name,category_id,price,discount,quantity","tbl_product","where status!=0 and id=$id ORDER BY id DESC");
if(mysqli_num_rows($fetch_data)>0){
    $x = 0;
 while($fetch_data_row = mysqli_fetch_array($fetch_data)){

    $id=$fetch_data_row['category_id'];
    $category = $obj1->selectData("id,category_name","tbl_category","where status!=0 and id=$id ORDER BY id DESC");

    if(mysqli_num_rows($category)>0){
        while($category_row = mysqli_fetch_array($category)){
    $response_arr[$x]['category'] = $category_row['category_name'] ;        
    $response_arr[$x]['id'] = $fetch_data_row['id'] ;
    $response_arr[$x]['product_name'] = $fetch_data_row['product_name'] ;
    $response_arr[$x]['price'] = $fetch_data_row['price'] ;
    $response_arr[$x]['discount'] = $fetch_data_row['discount'] ;
    $response_arr[$x]['quantity'] = $fetch_data_row['quantity'] ;
    $response_arr[$x]['category_id'] = $fetch_data_row['category_id'] ;
    

        }
    }
    $x++;
 }
}
echo json_encode($response_arr);
?>
