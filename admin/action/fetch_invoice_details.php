<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$invoice_id = $_POST['url_val'];
$response_arr = array();
$select_customer_details = $obj->selectData("id,customer_name,phone,place,total_price,total_discount,total_amonut","tbl_customer","where id=$invoice_id");
if(mysqli_num_rows($select_customer_details)>0){
	while($select_customer_details_row = mysqli_fetch_array($select_customer_details)){
		$id = $select_customer_details_row['id'];
		$customer_name = $select_customer_details_row['customer_name'];
		$phone = $select_customer_details_row['phone'];
		$place = $select_customer_details_row['place'];
		$total_price = $select_customer_details_row['total_price'];
		$total_discount = $select_customer_details_row['total_discount'];
		$total_amonut = $select_customer_details_row['total_amonut'];
		$response_arr[0]['customer_name'] = $customer_name;
		$response_arr[0]['phone'] = $phone;
		$response_arr[0]['place'] = $place;
		$total_price = 0;
		$total_discount = 0;
		$total_amonut = 0;
		$select_product_price = $obj->selectData("id,total_price,price,tax_in_per,tax_data","tbl_productdetails","where customer_id=$id and status!=0");
		if(mysqli_num_rows($select_product_price)>0){
			while($select_product_price_row = mysqli_fetch_array($select_product_price)){
				$total_amonut += $select_product_price_row['total_price'];
				$total_price += $select_product_price_row['price'];
			}
		}
		$select_all_payment_op = $obj->selectData("id,payment_option,amount","tbl_payment_recived_type","where customer_id=$id");
		if(mysqli_num_rows($select_all_payment_op)>0){
			$y = 0;
			while($select_all_payment_op_row = mysqli_fetch_array($select_all_payment_op)){
				$response_arr[0]['payment'][$y]['id'] = $select_all_payment_op_row['id'];
				$response_arr[0]['payment'][$y]['payment_option'] = $select_all_payment_op_row['payment_option'];
				$response_arr[0]['payment'][$y]['amount'] = $select_all_payment_op_row['amount'];
				$y++;
			}
		}
		$response_arr[0]['total_price'] = $total_price;
		$response_arr[0]['total_discount'] = $total_discount;
		$response_arr[0]['total_amonut'] = $total_amonut;
		$select_all_products = $obj->selectData("id,product_name,discount,no_quantity,price,total_price,product_id,no_pills,pills_id,tax_in_per,tax_data,expiry_date","tbl_productdetails","where customer_id=$invoice_id and status !=0");
		if(mysqli_num_rows($select_all_products)>0){
			$x = 0;
			while($select_all_products_row = mysqli_fetch_array($select_all_products)){
				$response_arr[0]['product_details'][$x]['p_d_id'] = $select_all_products_row['id'];
				$product_id = $select_all_products_row['product_id'];
				$select_product_price_des = $obj->selectData("id,no_of_pills,expiry_date","tbl_medicine_details","where product_id=$product_id and status!=0");
				
				if(mysqli_num_rows($select_product_price_des)>0){
					$y1 = 0;
					while($select_product_price_des_row = mysqli_fetch_array($select_product_price_des)){
							$response_arr[0]['product_details'][$x]['product_price_details'][$y1]['id'] = $select_product_price_des_row['id'];
						$response_arr[0]['product_details'][$x]['product_price_details'][$y1]['no_of_pills'] = $select_product_price_des_row['no_of_pills'];
						$expiry_date_1 = date_create($select_product_price_des_row['expiry_date']);
						$response_arr[0]['product_details'][$x]['product_price_details'][$y1]['expiry_date'] = date_format($expiry_date_1,"d-m-Y");
						$y1++;
					}
				}
				$response_arr[0]['product_details'][$x]['product_name'] = $select_all_products_row['product_name'];
				$response_arr[0]['product_details'][$x]['discount'] = $select_all_products_row['discount'];
				$response_arr[0]['product_details'][$x]['no_quantity'] = $select_all_products_row['no_quantity'];
				$response_arr[0]['product_details'][$x]['price'] = $select_all_products_row['price'];
				$response_arr[0]['product_details'][$x]['total_price'] = $select_all_products_row['total_price'];
				$response_arr[0]['product_details'][$x]['product_id'] = $select_all_products_row['product_id'];
				$response_arr[0]['product_details'][$x]['no_pills'] = $select_all_products_row['no_pills'];
				$expiry_date = date_create($select_all_products_row['expiry_date']);
				$response_arr[0]['product_details'][$x]['expiry_date'] =  date_format($expiry_date,"d-m-Y");
				$response_arr[0]['product_details'][$x]['pills_id'] = $select_all_products_row['pills_id'];
				$response_arr[0]['product_details'][$x]['tax_in_per'] = $select_all_products_row['tax_in_per'];
				$response_arr[0]['product_details'][$x]['tax_data'] = $select_all_products_row['tax_data'];
				$x++;
			}
		}
	}
}
echo json_encode($response_arr);
?>