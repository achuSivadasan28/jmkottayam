<?php

include '../../_class/query.php';
$obj = new query();


$dataArray=[];
$product_name = $_POST['product_name'];
$selectData=$obj->selectData("tbl_product.id,tbl_product.product_name,tbl_product.status","tbl_product inner join tbl_category on tbl_product.category_id=tbl_category.id","where tbl_product.product_name like '%$product_name%' and tbl_product.status!=0 and tbl_category.status!=0");

if(mysqli_num_rows($selectData)>0){
$x=0;
while($data=mysqli_fetch_array($selectData))
{  
    $dataArray[$x]['product_name'] = $data['product_name'];
    $dataArray[$x]['id'] = $data['id'];
    $x++;
}
}
echo json_encode($dataArray);
?>