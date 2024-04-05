<?php

include '../../_class/query.php';
$obj = new query();
$pid = $_GET['pid'];
$quantity_need = $_GET['quantity'];
$dataArray=[];
//$product_name = $_POST['product_name'];
$selectData=$obj->selectData("id,product_name,status,price,quantity","tbl_product","where status!=0 and id=$pid");

if(mysqli_num_rows($selectData)>0){
$x=0;
while($data=mysqli_fetch_array($selectData))
{
	$price = $data['price'];
	$quantity = $data['quantity'];
    $dataArray[$x]['id'] = $data['id'];
    $dataArray[$x]['product_name'] = $data['product_name'];
	$dataArray[$x]['price'] = $price;
	$dataArray[$x]['quantity'] = $quantity;
	$total_amt = $price*$quantity_need;
	$dataArray[$x]['total_p'] = $total_amt;
	if($quantity_need <= $quantity){
		$dataArray[$x]['stock_status'] = 1;
	}else{
		$dataArray[$x]['stock_status'] = 0;
	}
    $x++;
}
}
echo json_encode($dataArray);
?>