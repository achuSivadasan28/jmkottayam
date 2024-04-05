<?php
require_once '../../_class/query.php';
$obj=new query();
$response_arr = array();
$hsn_number_data = array();
$where_search_date = '';
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$search_data = $_POST['search_data'];
$search_where = '';
$total_taxable_value = 0;
$total_tax_amt = 0;
$total_amount = 0;
if($search_data != ''){
	$search_where = " and (tbl_productdetails.hsn_number like '%$search_data%')";
}
if($start_date != '' and $end_date !=''){

	$start_date1 = date_create($start_date);
	$end_date1 = date_create($end_date);
	$start_date2 = $start_date1;
	$diff=date_diff($start_date1,$end_date1);
	$diff1 =  $diff->format("%a");
	//$loop_date = date_create($start_date);
	$y1 = 0;
	$loop_date = date_format($start_date1,'Y-m-d');
	$loop_date_new = date_format($start_date1,'d-m-Y');
	for($x1=0;$x1<=$diff1;$x1++){
		if($where_search_date == ""){
			$where_search_date .= " and (tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'"; 
			//$where_search_date .= " and (tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'"; 
		}else{
			$where_search_date .= " or tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'";
			//$where_search_date .= " or tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'";
		}
		date_add($start_date2,date_interval_create_from_date_string("1 days"));
		$loop_date = date_format($start_date2,"Y-m-d");
		$loop_date_new = date_format($start_date2,"d-m-Y");
		$start_date2 = date_create($loop_date);
	}
	
	$where_search_date .= ")";
}else if($start_date !='' or $end_date!= ''){
	if($where_search ==''){
		$where_search_date = " ";
	}
	if($start_date != ''){
		$start_date1 = date_create($start_date);
		$date1 = date_format($start_date1,"Y-m-d");
		$date1_new = date_format($start_date1,"d-m-Y");
		//$where_search_date .= " and (tbl_customer.created_date like '%$date1%' or tbl_customer.created_date like '%$date1_new%')";
		$where_search_date .= " and (tbl_customer.created_date like '%$date1%' or tbl_customer.created_date like '%$date1_new%')";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"Y-m-d");
		$date2_new = date_format($end_date1,"d-m-Y");
		//$where_search_date .= " and (tbl_customer.created_date like '%$date2%' or tbl_customer.created_date like '%$date2_new%')";
		$where_search_date .= " and (tbl_customer.created_date like '%$date2%' or tbl_customer.created_date like '%$date2_new%')";
	}
}
$response_arr[0]['data_exist'] = 0;
$select_product_details = $obj->selectData("tbl_productdetails.id,tbl_productdetails.customer_id,tbl_productdetails.category_name,tbl_productdetails.no_quantity,tbl_productdetails.hsn_number,tbl_productdetails.price,tbl_productdetails.total_price,tbl_productdetails.tax_in_per,tbl_productdetails.tax_data,tbl_product.product_name","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id=tbl_customer.id INNER JOIN tbl_product on tbl_productdetails.product_id=tbl_product.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0   $where_search_date $search_where");
//and tbl_productdetails.tax_in_per!=0
//echo $select_product_details;exit();
if(mysqli_num_rows($select_product_details)>0){
	$response_arr[0]['data_exist'] = 1;
	$x = 0;
	while($select_product_details_row = mysqli_fetch_array($select_product_details)){
		
		if(in_array($select_product_details_row['hsn_number'],$hsn_number_data)){
			for($y = 0;$y<sizeof($response_arr);$y++){
				if($response_arr[$y]['hsn_number'] == $select_product_details_row['hsn_number']){
					$response_arr[$y]['no_quantity'] += $select_product_details_row['no_quantity'];
					$response_arr[$y]['price'] += $select_product_details_row['price'];
					$response_arr[$y]['total_price'] += $select_product_details_row['total_price'];
					$response_arr[$y]['tax_data'] += $select_product_details_row['tax_data'];
					$taxable_value = $response_arr[$y]['total_price']-$response_arr[$y]['tax_data'];
					$response_arr[$y]['taxable_value']  = $taxable_value;
					$total_tax_amt += $select_product_details_row['tax_data'];
					$total_amount += $select_product_details_row['total_price'];
					/*$cgst = $response_arr[$y]['tax_data']/2;
					$sgst = $response_arr[$y]['tax_data']/2;
					$response_arr[$y]['cgst'] = round($cgst,2);
					$response_arr[$y]['sgst'] = round($sgst,2);*/
				}
				
			}
		}else{
			array_push($hsn_number_data,$select_product_details_row['hsn_number']);
			$response_arr[$x]['id'] = $select_product_details_row['id'];
			$response_arr[$x]['customer_id'] = $select_product_details_row['customer_id'];
			$response_arr[$x]['product_name'] = $select_product_details_row['product_name'];
			$response_arr[$x]['no_quantity'] = $select_product_details_row['no_quantity'];
			$response_arr[$x]['hsn_number'] = $select_product_details_row['hsn_number'];
			$response_arr[$x]['price'] = $select_product_details_row['price'];
			$response_arr[$x]['total_price'] = $select_product_details_row['total_price'];
			$response_arr[$x]['taxable_value']  = $select_product_details_row['total_price']-$select_product_details_row['tax_data'];
			$response_arr[$x]['tax_in_per'] = $select_product_details_row['tax_in_per'];
			$response_arr[$x]['tax_data'] = $select_product_details_row['tax_data'];
			$total_tax_amt += $select_product_details_row['tax_data'];
			$total_amount += $select_product_details_row['total_price'];
			
			/*$total_tax = $response_arr[$x]['tax_data'];
			$cgst = $response_arr[$x]['tax_data']/2;
			$sgst = $response_arr[$x]['tax_data']/2;
			$response_arr[$x]['cgst'] = round($cgst,2);
			$response_arr[$x]['sgst'] = round($sgst,2);*/
			$x++;
			
		}
		
		
	}
}
$total_taxable_value = $total_amount-$total_tax_amt;
$response_arr[0]['total_taxable_value'] = round($total_taxable_value,2);
$response_arr[0]['total_tax_amt'] = round($total_tax_amt,2);
$response_arr[0]['total_amount'] = round($total_amount,2);
echo json_encode($response_arr);
//print_r($hsn_number_data);
?>