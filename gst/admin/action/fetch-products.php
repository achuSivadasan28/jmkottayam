<?php

include '../../_class/query.php';
$obj = new query();


$dataArray=[];
$product_name = $_POST['product_name'];
$selectData=$obj->selectData("id,product_name,status","tbl_product","where product_name like '%$product_name%' and status!=0");

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