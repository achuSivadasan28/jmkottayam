<?php
include '../../_class/query.php';
$obj = new query();
$pid = $_GET['pid'];
$quantity_need = $_GET['quantity'];
$dataArray=[];
//$product_name = $_POST['product_name'];
$selectData=$obj->selectData("id,product_name","tbl_product","where status!=0 and id=$pid");
if(mysqli_num_rows($selectData)>0){
$x=0;
while($data=mysqli_fetch_array($selectData))
{
    $dataArray[$x]['id'] = $data['id'];
	
	$product_id = $data['id'];
	//fetch product no of pills
	$select_no_of_pills = $obj->selectData("id,no_of_pills,expiry_date","tbl_medicine_details","where product_id=$pid and status != 0 and quantity>0");

	if(mysqli_num_rows($select_no_of_pills)>0){
		$x2 = 0;
		while($select_no_of_pills_row = mysqli_fetch_array($select_no_of_pills)){
			$dataArray[$x]['product_no_pills'][$x2]['no_of_pills'] = $select_no_of_pills_row['no_of_pills'];
			$dataArray[$x]['product_no_pills'][$x2]['pillid'] = $select_no_of_pills_row['id'];
			$exp_date = date_create($select_no_of_pills_row['expiry_date']);
			$dataArray[$x]['product_no_pills'][$x2]['expiry_date'] = date_format($exp_date,"d-m-Y");
			$x2++;
		}
	}else{
	$select_no_of_pills = $obj->selectData("id,no_of_pills,expiry_date","tbl_medicine_details","where product_id=$pid and status != 0");
		if(mysqli_num_rows($select_no_of_pills)>0){
			$x2 = 0;
		while($select_no_of_pills_row = mysqli_fetch_array($select_no_of_pills)){
			$dataArray[$x]['product_no_pills'][$x2]['no_of_pills'] = $select_no_of_pills_row['no_of_pills'];
			$dataArray[$x]['product_no_pills'][$x2]['pillid'] = $select_no_of_pills_row['id'];
			$exp_date = date_create($select_no_of_pills_row['expiry_date']);
			$dataArray[$x]['product_no_pills'][$x2]['expiry_date'] = date_format($exp_date,"d-m-Y");
			$x2++;
		}
		}
	}
	$product_name = $data['product_name'];
    $dataArray[$x]['product_name'] = $data['product_name'];
	
	$select_product_details = $obj->selectData("id,product_id,no_of_pills,price,quantity,tax_data,expiry_date","tbl_medicine_details","where 		no_of_pills>=$quantity_need and product_id=$pid and status != 0 and quantity>0 ORDER by no_of_pills ASC limit 1");
	if(mysqli_num_rows($select_product_details)>0){
		$select_product_details_row = mysqli_fetch_array($select_product_details);
	$price = $select_product_details_row['price'];
	$quantity = $select_product_details_row['quantity'];
	$dataArray[$x]['price'] = $price;
	$dataArray[$x]['quantity'] = $quantity;
	$dataArray[$x]['pill_id'] = $select_product_details_row['id'];
	$dataArray[$x]['no_of_pills'] = $select_product_details_row['no_of_pills'];
	$exp_date_1 = date_create($select_product_details_row['expiry_date']);
	$dataArray[$x]['expiry_date'] = date_format($exp_date_1,"d-m-Y");
	$dataArray[$x]['quantity_need'] = $quantity_need;
	$tax_data = $select_product_details_row['tax_data'];
	$total_amt = $price*1;
		
	$actual_amt = including_tax_desi($tax_data,$total_amt);
	$tax_amt = $total_amt-$actual_amt;
	$dataArray[$x]['ebs_tax'] = round($tax_amt,2);
	$dataArray[$x]['total_p'] = $total_amt;
		
		$dataArray[$x]['actual_quantity'] = 1;
	if(1 <= $quantity){
		$dataArray[$x]['stock_status'] = 1;
	}else{
		$dataArray[$x]['stock_status'] = 0;
	}
	}else{
		$quantity_data = 0;
	       $select_product_details_last = $obj->selectData("id,product_id,no_of_pills,price,quantity,tax_data,expiry_date","tbl_medicine_details","where status != 0 and product_id=$pid and quantity>0  ORDER BY no_of_pills DESC limit 1");
		if(mysqli_num_rows($select_product_details_last)){
			$select_product_details_last_row = mysqli_fetch_array($select_product_details_last);
			
				$price = $select_product_details_last_row['price'];
				$quantity = $select_product_details_last_row['quantity'];
				$dataArray[$x]['price'] = $price;
				$dataArray[$x]['quantity'] = $quantity;
				$dataArray[$x]['pill_id'] = $select_product_details_last_row['id'];
				$dataArray[$x]['no_of_pills'] = $select_product_details_last_row['no_of_pills'];
				$dataArray[$x]['quantity_need'] = $quantity_need;
				$exp_date_2 = date_create($select_product_details_last_row['expiry_date']);
				$dataArray[$x]['expiry_date'] = date_format($exp_date_2,"d-m-Y");
			    $tax_data = $select_product_details_row['tax_data'];
				$no_of_pills = $select_product_details_last_row['no_of_pills'];
				$total_amt = $price*1;
		$select_no_of_pills = $obj->selectData("id,no_of_pills,expiry_date","tbl_medicine_details","where product_id=$pid and status != 0 and quantity>0");
	if(mysqli_num_rows($select_no_of_pills)>0){
		$x2 = 0;
		while($select_no_of_pills_row = mysqli_fetch_array($select_no_of_pills)){
			$dataArray[$x]['product_no_pills'][$x2]['no_of_pills'] = $select_no_of_pills_row['no_of_pills'];
			$dataArray[$x]['product_no_pills'][$x2]['pillid'] = $select_no_of_pills_row['id'];
			$exp_date_3 = date_create($select_no_of_pills_row['expiry_date']);
			$dataArray[$x]['product_no_pills'][$x2]['expiry_date'] = date_format($exp_date_3,"d-m-Y");
			$x2++;
		}
	}
				$actual_amt = including_tax_desi($tax_data,$total_amt);
				$tax_amt = $total_amt-$actual_amt;
				$dataArray[$x]['ebs_tax'] = round($tax_amt,2);
				$dataArray[$x]['total_p'] = $total_amt;
			$quantity_data = 1;
			$dataArray[$x]['actual_quantity'] = $quantity_data;
				
				$less_stock = $quantity_need-$no_of_pills;
			if($less_stock>0){
				$product_med_id = exe_query_data($pid,$less_stock,$obj,$x,$product_id,$product_name);
				
				}
			$quantity_data = $dataArray[$x]['actual_quantity'];
			if($quantity_data <= $quantity){
					$dataArray[$x]['stock_status'] = 1;
				}else{
					$dataArray[$x]['stock_status'] = 0;
				}
				
			}else{
				$quantity_data = 0;
	       $select_product_details_last = $obj->selectData("id,product_id,no_of_pills,price,quantity,tax_data,expiry_date","tbl_medicine_details","where status != 0 and product_id=$pid  ORDER BY no_of_pills DESC limit 1");
		if(mysqli_num_rows($select_product_details_last)){
			$select_product_details_last_row = mysqli_fetch_array($select_product_details_last);
			
				$price = $select_product_details_last_row['price'];
				$quantity = $select_product_details_last_row['quantity'];
				$dataArray[$x]['price'] = $price;
				$dataArray[$x]['quantity'] = $quantity;
				$dataArray[$x]['pill_id'] = $select_product_details_last_row['id'];
				$dataArray[$x]['no_of_pills'] = $select_product_details_last_row['no_of_pills'];
				$dataArray[$x]['quantity_need'] = $quantity_need;
				$exp_date_2 = date_create($select_product_details_last_row['expiry_date']);
				$dataArray[$x]['expiry_date'] = date_format($exp_date_2,"d-m-Y");
			    $tax_data = $select_product_details_row['tax_data'];
				$no_of_pills = $select_product_details_last_row['no_of_pills'];
				$total_amt = $price*1;
		$select_no_of_pills = $obj->selectData("id,no_of_pills,expiry_date","tbl_medicine_details","where product_id=$pid and status != 0");
	if(mysqli_num_rows($select_no_of_pills)>0){
		$x2 = 0;
		while($select_no_of_pills_row = mysqli_fetch_array($select_no_of_pills)){
			$dataArray[$x]['product_no_pills'][$x2]['no_of_pills'] = $select_no_of_pills_row['no_of_pills'];
			$dataArray[$x]['product_no_pills'][$x2]['pillid'] = $select_no_of_pills_row['id'];
			$exp_date_3 = date_create($select_no_of_pills_row['expiry_date']);
			$dataArray[$x]['product_no_pills'][$x2]['expiry_date'] = date_format($exp_date_3,"d-m-Y");
			$x2++;
		}
	}
				$actual_amt = including_tax_desi($tax_data,$total_amt);
				$tax_amt = $total_amt-$actual_amt;
				$dataArray[$x]['ebs_tax'] = round($tax_amt,2);
				$dataArray[$x]['total_p'] = $total_amt;
			$quantity_data = 1;
			$dataArray[$x]['actual_quantity'] = $quantity_data;
				
				$less_stock = $quantity_need-$no_of_pills;
			if($less_stock>0){
				$product_med_id = exe_query_data_null($pid,$less_stock,$obj,$x,$product_id,$product_name);
				
				}
			$quantity_data = $dataArray[$x]['actual_quantity'];
				if($quantity_data <= $quantity){
					$dataArray[$x]['stock_status'] = 1;
				}else{
					$dataArray[$x]['stock_status'] = 0;
				}
				
			}
			}
			
		}
	}
    
}
for($y1 = 0; $y1<sizeof($dataArray);$y1++){
	$total_price = $dataArray[$y1]['total_p'];
	$pill_id = $dataArray[$y1]['pill_id'];
	$select_tax_ratio =  $obj->selectData("tax_data","tbl_medicine_details","where id=$pill_id and status!=0 and quantity>0");
	if(mysqli_num_rows($select_tax_ratio)>0){
		$select_tax_ratio_row = mysqli_fetch_array($select_tax_ratio);
		$tax_data = $select_tax_ratio_row['tax_data'];
		$exe_tax = including_tax_desi($tax_data,$total_price);
		$tax_amt = $total_price-$exe_tax;
		$dataArray[$y1]['ebs_tax_per'] = $tax_data;
		$dataArray[$y1]['ebs_tax'] = round($tax_amt,2);
	}
}
echo json_encode($dataArray);
function exe_query_data($pid,$less_stock,$obj,$x,$product_id,$product_name){
	global $dataArray,$quantity_need; 
	$num_of_pills_1 = 0;
	
	$select_product_details = $obj->selectData("id,product_id,no_of_pills,price,quantity,tax_data,expiry_date","tbl_medicine_details","where no_of_pills>=$less_stock and product_id=$pid and status != 0 and quantity>0 ORDER by no_of_pills ASC limit 1");
	if(mysqli_num_rows($select_product_details)>0){
		$select_product_details_row = mysqli_fetch_array($select_product_details);
		$pill_id = $select_product_details_row['id'];
		$tax_data = $select_product_details_row['tax_data'];
		$exp_date_4 = date_create($select_product_details_row['expiry_date']);
		$expiry_date_data = date_format($exp_date_4,"d-m-Y");
		$match_val = 0;
		$num_of_pills_1 = $select_product_details_row['no_of_pills'];
		for($x1 = 0;$x1<sizeof($dataArray);$x1++){
			if($dataArray[$x1]['pill_id'] == $pill_id){
				$price = $select_product_details_row['price'];
				$match_val = 1;
				$exe_quantity = $dataArray[$x1]['actual_quantity'];
				$exe_quantity += 1;
				$total_amt = $price*$exe_quantity;
				$dataArray[$x1]['actual_quantity'] = $exe_quantity;
				$dataArray[$x1]['total_p'] = $total_amt;
				$actual_amt = including_tax_desi($tax_data,$total_amt);
				$tax_amt = $total_amt-$actual_amt;
				$dataArray[$x1]['ebs_tax'] = round($tax_amt,2);
				//$dataArray[$x1]['no_of_pills'] += $select_product_details_row['no_of_pills'];
			}
		}
	if($match_val == 0){
			$x++;
	$price = $select_product_details_row['price'];
	$quantity = $select_product_details_row['quantity'];
	$dataArray[$x]['id'] = $product_id;
	$dataArray[$x]['product_name'] = $product_name;
	$dataArray[$x]['price'] = $price;
	$dataArray[$x]['quantity'] = $quantity;
	$dataArray[$x]['pill_id'] = $select_product_details_row['id'];
	$dataArray[$x]['no_of_pills'] = $select_product_details_row['no_of_pills'];
	$dataArray[$x]['quantity_need'] = $quantity_need;
	$total_amt = $price*1;
		$select_no_of_pills = $obj->selectData("id,no_of_pills,expiry_date","tbl_medicine_details","where product_id=$pid and status != 0 and quantity>0");
	if(mysqli_num_rows($select_no_of_pills)>0){
		$x2 = 0;
		while($select_no_of_pills_row = mysqli_fetch_array($select_no_of_pills)){
			$dataArray[$x]['product_no_pills'][$x2]['no_of_pills'] = $select_no_of_pills_row['no_of_pills'];
			$dataArray[$x]['product_no_pills'][$x2]['pillid'] = $select_no_of_pills_row['id'];
			$exp_date_5 = date_create($select_no_of_pills_row['expiry_date']);
			$dataArray[$x]['product_no_pills'][$x2]['expiry_date'] = date_format($exp_date_5,"d-m-Y");
			$x2++;
		}
	}
	$dataArray[$x]['total_p'] = $total_amt;
	$actual_amt = including_tax_desi($tax_data,$total_amt);
	$tax_amt = $total_amt-$actual_amt;
	$dataArray[$x1]['ebs_tax'] = round($tax_amt,2);
		$dataArray[$x]['actual_quantity'] = 1;
	if(1 <= $quantity){
		$dataArray[$x]['stock_status'] = 1;
	}else{
		$dataArray[$x]['stock_status'] = 0;
	}
		}
	}else{
		$select_product_details = $obj->selectData("id,product_id,no_of_pills,price,quantity,tax_data,expiry_date","tbl_medicine_details","where product_id=$pid and status != 0 and quantity>0 ORDER BY no_of_pills DESC limit 1");
		if(mysqli_num_rows($select_product_details)>0){
			$select_product_details_row = mysqli_fetch_array($select_product_details);
			$pill_id = $select_product_details_row['id'];
			$num_of_pills_1 = $select_product_details_row['no_of_pills'];
			$tax_data = $select_product_details_row['tax_data'];
			$match_val = 0;
			for($x1 = 0;$x1<sizeof($dataArray);$x1++){
				if($dataArray[$x1]['pill_id'] == $pill_id){
				$price = $select_product_details_row['price'];
				$match_val = 1;
				$exe_quantity = $dataArray[$x1]['actual_quantity'];
				$exe_quantity += 1;
				$total_amt = $price*$exe_quantity;
				$dataArray[$x1]['actual_quantity'] = $exe_quantity;
				$dataArray[$x1]['total_p'] = $total_amt;
				$actual_amt = including_tax_desi($tax_data,$total_amt);
				$tax_amt = $total_amt-$actual_amt;
				$dataArray[$x1]['ebs_tax'] = round($tax_amt,2);
				//$dataArray[$x1]['no_of_pills'] += $select_product_details_row['no_of_pills'];
				
				}
			}
			
			if($match_val == 0){
				$x++;
			$price = $select_product_details_row['price'];
				
	$quantity = $select_product_details_row['quantity'];
				
	$dataArray[$x]['id'] = $product_id;
	$dataArray[$x]['product_name'] = $product_name;
	$dataArray[$x]['price'] = $price;
	$dataArray[$x]['quantity'] = $quantity;
	$dataArray[$x]['pill_id'] = $select_product_details_row['id'];
	$dataArray[$x]['no_of_pills'] = $select_product_details_row['no_of_pills'];
	$dataArray[$x]['quantity_need'] = $quantity_need;
	$total_amt = $price*1;
	$select_no_of_pills = $obj->selectData("id,no_of_pills,expiry_date","tbl_medicine_details","where product_id=$pid and status != 0 and quantity>0");
	if(mysqli_num_rows($select_no_of_pills)>0){
		$x2 = 0;
		while($select_no_of_pills_row = mysqli_fetch_array($select_no_of_pills)){
			$dataArray[$x]['product_no_pills'][$x2]['no_of_pills'] = $select_no_of_pills_row['no_of_pills'];
			$dataArray[$x]['product_no_pills'][$x2]['pillid'] = $select_no_of_pills_row['id'];
			$exp_date_6 = date_create($select_no_of_pills_row['expiry_date']);
			$dataArray[$x]['product_no_pills'][$x2]['expiry_date'] = date_format($exp_date_6,"d-m-Y");
			$x2++;
		}
	}
	$dataArray[$x]['total_p'] = $total_amt;
	$actual_amt = including_tax_desi($tax_data,$total_amt);
	$tax_amt = $total_amt-$actual_amt;
	$dataArray[$x]['ebs_tax'] = round($tax_amt,2);
		$dataArray[$x]['actual_quantity'] = 1;
	if(1 <= $quantity){
		$dataArray[$x]['stock_status'] = 1;
	}else{
		$dataArray[$x]['stock_status'] = 0;
	}
			}
		}
	}
	
	$last_quantity_val = $less_stock-$num_of_pills_1;
	if($last_quantity_val >0){
		exe_query_data($pid,$last_quantity_val,$obj,$x,$product_id,$product_name);
		//echo "match_val ";exit();
	}
}

function exe_query_data_null($pid,$less_stock,$obj,$x,$product_id,$product_name){
	global $dataArray,$quantity_need; 
	$num_of_pills_1 = 0;
	
	$select_product_details = $obj->selectData("id,product_id,no_of_pills,price,quantity,tax_data,expiry_date","tbl_medicine_details","where no_of_pills>=$less_stock and product_id=$pid and status != 0 ORDER by no_of_pills ASC limit 1");
	if(mysqli_num_rows($select_product_details)>0){
		$select_product_details_row = mysqli_fetch_array($select_product_details);
		$pill_id = $select_product_details_row['id'];
		$tax_data = $select_product_details_row['tax_data'];
		$exp_date_4 = date_create($select_product_details_row['expiry_date']);
		$expiry_date_data = date_format($exp_date_4,"d-m-Y");
		$match_val = 0;
		$num_of_pills_1 = $select_product_details_row['no_of_pills'];
		for($x1 = 0;$x1<sizeof($dataArray);$x1++){
			if($dataArray[$x1]['pill_id'] == $pill_id){
				$price = $select_product_details_row['price'];
				$match_val = 1;
				$exe_quantity = $dataArray[$x1]['actual_quantity'];
				$exe_quantity += 1;
				$total_amt = $price*$exe_quantity;
				$dataArray[$x1]['actual_quantity'] = $exe_quantity;
				$dataArray[$x1]['total_p'] = $total_amt;
				$actual_amt = including_tax_desi($tax_data,$total_amt);
				$tax_amt = $total_amt-$actual_amt;
				$dataArray[$x1]['ebs_tax'] = round($tax_amt,2);
				//$dataArray[$x1]['no_of_pills'] += $select_product_details_row['no_of_pills'];
			}
		}
	if($match_val == 0){
			$x++;
	$price = $select_product_details_row['price'];
	$quantity = $select_product_details_row['quantity'];
	$dataArray[$x]['id'] = $product_id;
	$dataArray[$x]['product_name'] = $product_name;
	$dataArray[$x]['price'] = $price;
	$dataArray[$x]['quantity'] = $quantity;
	$dataArray[$x]['pill_id'] = $select_product_details_row['id'];
	$dataArray[$x]['no_of_pills'] = $select_product_details_row['no_of_pills'];
	$dataArray[$x]['quantity_need'] = $quantity_need;
	$total_amt = $price*1;
		$select_no_of_pills = $obj->selectData("id,no_of_pills,expiry_date","tbl_medicine_details","where product_id=$pid and status != 0");
	if(mysqli_num_rows($select_no_of_pills)>0){
		$x2 = 0;
		while($select_no_of_pills_row = mysqli_fetch_array($select_no_of_pills)){
			$dataArray[$x]['product_no_pills'][$x2]['no_of_pills'] = $select_no_of_pills_row['no_of_pills'];
			$dataArray[$x]['product_no_pills'][$x2]['pillid'] = $select_no_of_pills_row['id'];
			$exp_date_5 = date_create($select_no_of_pills_row['expiry_date']);
			$dataArray[$x]['product_no_pills'][$x2]['expiry_date'] = date_format($exp_date_5,"d-m-Y");
			$x2++;
		}
	}
	$dataArray[$x]['total_p'] = $total_amt;
	$actual_amt = including_tax_desi($tax_data,$total_amt);
	$tax_amt = $total_amt-$actual_amt;
	$dataArray[$x1]['ebs_tax'] = round($tax_amt,2);
		$dataArray[$x]['actual_quantity'] = 1;
	if(1 <= $quantity){
		$dataArray[$x]['stock_status'] = 1;
	}else{
		$dataArray[$x]['stock_status'] = 0;
	}
		}
	}else{
		$select_product_details = $obj->selectData("id,product_id,no_of_pills,price,quantity,tax_data,expiry_date","tbl_medicine_details","where product_id=$pid and status != 0 ORDER BY no_of_pills DESC limit 1");
		if(mysqli_num_rows($select_product_details)>0){
			$select_product_details_row = mysqli_fetch_array($select_product_details);
			$pill_id = $select_product_details_row['id'];
			$num_of_pills_1 = $select_product_details_row['no_of_pills'];
			$tax_data = $select_product_details_row['tax_data'];
			$match_val = 0;
			for($x1 = 0;$x1<sizeof($dataArray);$x1++){
				if($dataArray[$x1]['pill_id'] == $pill_id){
				$price = $select_product_details_row['price'];
				$match_val = 1;
				$exe_quantity = $dataArray[$x1]['actual_quantity'];
				$exe_quantity += 1;
				$total_amt = $price*$exe_quantity;
				$dataArray[$x1]['actual_quantity'] = $exe_quantity;
				$dataArray[$x1]['total_p'] = $total_amt;
				$actual_amt = including_tax_desi($tax_data,$total_amt);
				$tax_amt = $total_amt-$actual_amt;
				$dataArray[$x1]['ebs_tax'] = round($tax_amt,2);
				//$dataArray[$x1]['no_of_pills'] += $select_product_details_row['no_of_pills'];
				
				}
			}
			
			if($match_val == 0){
				$x++;
			$price = $select_product_details_row['price'];
				
	$quantity = $select_product_details_row['quantity'];
				
	$dataArray[$x]['id'] = $product_id;
	$dataArray[$x]['product_name'] = $product_name;
	$dataArray[$x]['price'] = $price;
	$dataArray[$x]['quantity'] = $quantity;
	$dataArray[$x]['pill_id'] = $select_product_details_row['id'];
	$dataArray[$x]['no_of_pills'] = $select_product_details_row['no_of_pills'];
	$dataArray[$x]['quantity_need'] = $quantity_need;
	$total_amt = $price*1;
	$select_no_of_pills = $obj->selectData("id,no_of_pills,expiry_date","tbl_medicine_details","where product_id=$pid and status != 0");
	if(mysqli_num_rows($select_no_of_pills)>0){
		$x2 = 0;
		while($select_no_of_pills_row = mysqli_fetch_array($select_no_of_pills)){
			$dataArray[$x]['product_no_pills'][$x2]['no_of_pills'] = $select_no_of_pills_row['no_of_pills'];
			$dataArray[$x]['product_no_pills'][$x2]['pillid'] = $select_no_of_pills_row['id'];
			$exp_date_6 = date_create($select_no_of_pills_row['expiry_date']);
			$dataArray[$x]['product_no_pills'][$x2]['expiry_date'] = date_format($exp_date_6,"d-m-Y");
			$x2++;
		}
	}
	$dataArray[$x]['total_p'] = $total_amt;
	$actual_amt = including_tax_desi($tax_data,$total_amt);
	$tax_amt = $total_amt-$actual_amt;
	$dataArray[$x]['ebs_tax'] = round($tax_amt,2);
		$dataArray[$x]['actual_quantity'] = 1;
	if(1 <= $quantity){
		$dataArray[$x]['stock_status'] = 1;
	}else{
		$dataArray[$x]['stock_status'] = 0;
	}
			}
		}
	}
	
	$last_quantity_val = $less_stock-$num_of_pills_1;
	if($last_quantity_val >0){
		exe_query_data_null($pid,$last_quantity_val,$obj,$x,$product_id,$product_name);
		//echo "match_val ";exit();
	}
}


function including_tax_desi($tax_ratio,$amount){
    $tax_in_hund = $tax_ratio+100;
    $y = ((int)$amount/$tax_in_hund)*100;
    return round($y,2);
}
?>