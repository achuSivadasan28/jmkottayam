<?php
include_once '../../_class/query.php';
$obj = new query();
$response_arr = array();
$id = $_GET['id'];


	
$selectData=$obj->selectData("DISTINCT added_date","tbl_productdetails","where customer_id	= '$id'");
if(mysqli_num_rows($selectData)>0)
$x=0;
while($data=mysqli_fetch_array($selectData))
{
	$added_date = $data['added_date'];
	 $response_arr[$x]['added_date']=$added_date;
	
$selectData3=$obj->selectData("id,customer_name,place,phone","tbl_customer","where id = '$id' and status = 1 limit 1");
$fetch_data = mysqli_fetch_assoc($selectData3);
	$customer_name=$fetch_data['customer_name'];
	$customer_place=$fetch_data['place'];
	$customer_phn=$fetch_data['phone'];
	$places ='';
	if($customer_place == ''){
		$places = 'No Data';
	}else{
		$places = $customer_place;
	}
	
	 $response_arr[$x]['customer_name']=$customer_name;
	 $response_arr[$x]['place']=$places;
	 $response_arr[$x]['phn']=$customer_phn;
	
$select_product_details = $obj->selectData("id,product_name,no_quantity","tbl_productdetails","where customer_id = '$id' and added_date = '$added_date'");
if(mysqli_num_rows($select_product_details)>0)
	$y= 0;
while($datas=mysqli_fetch_array($select_product_details))
{
	$product_name = $datas['product_name'];
	$qty = $datas['no_quantity'];
	
	
	$response_arr[$x]['products'][$y]['product_name']=$product_name;
	$response_arr[$x]['products'][$y]['qty']= $qty;
	$y++;
	
}
	$x++;
	
}

echo json_encode($response_arr);