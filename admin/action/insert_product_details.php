<?php
//session_start();
require_once '../../_class/query.php';
$obj=new query();
// $staff_id=$_SESSION['staffId'];
$product_id=$_POST['product_id']; 
$quantity= $_POST['Quantity'];
$Productnopill_id= $_POST['Productnopill_id'];
$selectData=$obj->selectData("quantity","tbl_medicine_details","where status!=0 and id=$Productnopill_id");
if(mysqli_num_rows($selectData)>0){
    while($data=mysqli_fetch_array($selectData))
    {
       $checkq=$data['quantity'];
		if($checkq !=0){
       if($quantity<=$checkq){
   
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$gross=$_POST['gross']; 
$disc=$_POST['disc'];
$customer_id=$_POST['customer_id'];
$product_name= $_POST['ProductName'];
$category_name= $_POST['CategoryName'];
$price= $_POST['Price'];
$discount= $_POST['discount'];
$rate1= $_POST['Rate'];
$tax_in_per= $_POST['tax_in_per'];
$tax_data= $_POST['tax_data'];
$rate = $price*$quantity;
$hsn_number = '';
$batch_name = '';
$expiry_date = '';
$no_of_pills = '';
$select_product_basic_details = $obj->selectData("hsn_sac,batch,expiry_date,no_of_pills","tbl_medicine_details","where id=$Productnopill_id and status!=0");
if(mysqli_num_rows($select_product_basic_details)){
	$select_product_basic_details_row = mysqli_fetch_array($select_product_basic_details);
	$hsn_number = $select_product_basic_details_row['hsn_sac'];
	$batch_name = $select_product_basic_details_row['batch'];
	$expiry_date = $select_product_basic_details_row['expiry_date'];
}
$info_user = array(
    "product_id"=>$product_id,
    "gross"=>$gross,
    "customer_id"=>$customer_id,
	"no_pills" => $no_of_pills,
	"pills_id" => $Productnopill_id,
    "product_name" => $product_name,
    "category_name"=> $category_name,
    "price"=>$price,
    "discount"=>$discount,
    "no_quantity"=>$quantity,
	"hsn_number" => $hsn_number,
	"batch_name" => $batch_name,
	"expiry_date" => $expiry_date,
    "added_date"=>$days,
    "total_price"=>$rate,
	"disc"=>$disc,
    "status"=>1,
	"tax_in_per" => $tax_in_per,
	"tax_data" => $tax_data,
);

$insert=$obj->insertData("tbl_productdetails",$info_user);
		$total_price_data = 0;
	$select_sum_data = $obj->selectData("sum(total_price) as total_price","tbl_productdetails","where 	customer_id=$customer_id");
	$select_sum_data_row = mysqli_fetch_array($select_sum_data);
if($select_sum_data_row['total_price'] != null){
	$total_price_data = $select_sum_data_row['total_price'];
	$info_update_data = array(
		"total_price" => $total_price_data,
		"total_amonut" => $total_price_data,
	);
	$obj->updateData("tbl_customer",$info_update_data,"where id=$customer_id");
	//tbl_customer
}


$select=$obj->selectData("quantity","tbl_medicine_details","where id=$Productnopill_id and status!=0");
// echo $select; exit();
if(mysqli_num_rows($select)>0){
    while($data=mysqli_fetch_array($select)){
        $qunatity1=$data['quantity'];
    }
}
$p_qunatity=$qunatity1-$quantity;
$info = array(
"quantity"=>$p_qunatity
);
$update=$obj->updateData("tbl_medicine_details",$info,"where id=$Productnopill_id");
echo 0;


}
		}
else{
    echo 1; 
}
}
}
?>