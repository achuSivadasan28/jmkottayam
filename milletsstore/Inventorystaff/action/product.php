<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$id=$_POST['urlv'];
$fetch_data = $obj1->selectData("id,product_name,category_id,price,discount,quantity,hsn_number,batch_name,expiry_date","tbl_product","where status!=0 and id=$id ORDER BY id DESC");
if(mysqli_num_rows($fetch_data)>0){
    $x = 0;
 while($fetch_data_row = mysqli_fetch_array($fetch_data)){
	 $exp_date= $fetch_data_row['expiry_date'] ;
	 if($exp_date != ''){
	 	$new_date = date("Y-m-d", strtotime($exp_date));
	 }else{
	 	$new_date = '';
	 }
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
    $response_arr[$x]['hsn_number'] = $fetch_data_row['hsn_number'] ;
	$response_arr[$x]['batch_name'] = $fetch_data_row['batch_name'] ;
	$response_arr[$x]['exp_date'] =$new_date;
        }
    }
    $x++;
 }
}
echo json_encode($response_arr);
?>
