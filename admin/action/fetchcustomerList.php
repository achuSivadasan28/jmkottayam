<?php

include '../../_class/query.php';
$obj = new Query();

$dataArray=[];
$search =$_GET['searchKey'];
$limit =$_GET['limit_range'];


$where_clause = '';
if($search != ''){
	$selectData1=$obj->selectData("DISTINCT phone","tbl_customer","where status = 1 and phone like '%$search%' and customer_status = 1  ORDER BY id DESC limit $limit");
}
else{
 $selectData1=$obj->selectData("DISTINCT phone","tbl_customer","where status = 1 and customer_status = 1 ORDER BY id DESC limit $limit");
}
if(mysqli_num_rows($selectData1)>0)
$x=0;
while($data=mysqli_fetch_array($selectData1))
{
	
	$customer_phone=$data['phone'];
	
	$selectData3=$obj->selectData("id,customer_name,place","tbl_customer","where phone = '$customer_phone' and status = 1 LIMIT 1");
$fetch_data = mysqli_fetch_assoc($selectData3);
$id=$fetch_data['id'];
	$customer_name=$fetch_data['customer_name'];
	$customer_place=$fetch_data['place'];
	$places ='';
	if($customer_place == ''){
		$places = 'No Data';
	}else{
		$places = $customer_place;
	}
	
 $dataArray[$x]['id']=$id;
	  $dataArray[$x]['customer_phn']=$customer_phone;
   $dataArray[$x]['customer_name']=$customer_name;
$dataArray[$x]['customer_place']=$places;
$x++;
    }
echo json_encode($dataArray);





?>