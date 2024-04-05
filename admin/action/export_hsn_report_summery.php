<?php
require_once '../../_class/query.php';
$obj=new query();
$response_arr = array();
$hsn_number_data1 = array();
$hsn_number_data2 = array();
$where_search_date = '';
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$search_data = $_GET['search_data'];
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
		$where_search_date .= " and (tbl_customer.created_date like '%$date1%' or tbl_customer.created_date like '%$date1_new%' )";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"Y-m-d");
		$date2_new = date_format($end_date1,"d-m-Y");
		//$where_search_date .= " and (tbl_customer.created_date like '%$date2%' or tbl_customer.created_date like '%$date2_new%')";
		$where_search_date .= " and (tbl_customer.created_date like '%$date2%' or tbl_customer.created_date like '%$date2_new%')";
	}
}
$fileName = "HSN_reports_Summery_trsr" . date('d-m-Y') . ".xls"; 

$fields = array('Sl No','HSN Code','Tax Rate','Quantity','Total Value','Taxable Value','CGST','SGST','IGST','Total Tax');

$excelData = implode("\t", array_values($fields)) . "\n"; 
$response_arr1 = [];
$response_arr1[0]['data_exist'] = 0;
$select_product_details = $obj->selectData("tbl_productdetails.id,tbl_productdetails.customer_id,tbl_productdetails.category_name,tbl_productdetails.no_quantity,tbl_productdetails.hsn_number,tbl_productdetails.price,tbl_productdetails.total_price,tbl_productdetails.tax_in_per,tbl_productdetails.tax_data,tbl_product.product_name,tbl_productdetails.product_name as pm","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id=tbl_customer.id INNER JOIN tbl_product on tbl_productdetails.product_id=tbl_product.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0   $where_search_date $search_where");
/**$select_product_details = $obj->selectData("tbl_productdetails.id,tbl_productdetails.customer_id,tbl_productdetails.category_name,sum(tbl_productdetails.no_quantity) as no_quantity,tbl_productdetails.hsn_number,sum(tbl_productdetails.price) as price ,sum(tbl_productdetails.total_price) as total_price,tbl_productdetails.tax_in_per,sum(tbl_productdetails.tax_data) as tax_data,tbl_product.product_name,tbl_productdetails.product_name as pm","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id=tbl_customer.id INNER JOIN tbl_product on tbl_productdetails.product_id=tbl_product.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0   $where_search_date $search_where  group by hsn_number");**/
//echo $select_product_details;exit();
//and tbl_productdetails.tax_in_per!=0
//echo $select_product_details;exit();
if(mysqli_num_rows($select_product_details)>0){
	$response_arr1[0]['data_exist'] = 1;
	$x = 0;
	while($select_product_details_row = mysqli_fetch_array($select_product_details)){
		$pm = trim($select_product_details_row['pm']);
		$hsn_tax = $select_product_details_row['hsn_number']."%".$select_product_details_row['tax_in_per'];
		if(in_array($hsn_tax,$hsn_number_data1)){
			for($y = 0;$y<sizeof($response_arr1);$y++){
				if($response_arr1[$y]['hsn_number_com'] == $hsn_tax){
					$response_arr1[$y]['no_quantity'] += $select_product_details_row['no_quantity'];
					$response_arr1[$y]['price'] += $select_product_details_row['price'];
					$response_arr1[$y]['total_price'] += $select_product_details_row['total_price'];
					$response_arr1[$y]['tax_data'] += $select_product_details_row['tax_data'];
					$taxable_value = $response_arr1[$y]['total_price']-$response_arr1[$y]['tax_data'];
					$response_arr1[$y]['taxable_value']  = $taxable_value;
					$total_tax_amt += $select_product_details_row['tax_data'];
					$total_amount += $select_product_details_row['total_price'];
					/*$cgst = $response_arr[$y]['tax_data']/2;
					$sgst = $response_arr[$y]['tax_data']/2;
					$response_arr[$y]['cgst'] = round($cgst,2);
					$response_arr[$y]['sgst'] = round($sgst,2);*/
				}
				
			}
		}else{
			array_push($hsn_number_data1,$hsn_tax);
			$response_arr1[$x]['id'] = $select_product_details_row['id'];
			$response_arr1[$x]['customer_id'] = $select_product_details_row['customer_id'];
			$response_arr1[$x]['product_name'] = $select_product_details_row['product_name'];
			$response_arr1[$x]['no_quantity'] = $select_product_details_row['no_quantity'];
			$response_arr1[$x]['hsn_number'] = $select_product_details_row['hsn_number'];
			$response_arr1[$x]['hsn_number_com'] = $hsn_tax;
			$response_arr1[$x]['price'] = $select_product_details_row['price'];
			$response_arr1[$x]['total_price'] = $select_product_details_row['total_price'];
			$response_arr1[$x]['taxable_value']  = $select_product_details_row['total_price']-$select_product_details_row['tax_data'];
			$response_arr1[$x]['tax_in_per'] = $select_product_details_row['tax_in_per'];
			$response_arr1[$x]['tax_data'] = $select_product_details_row['tax_data'];
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

if($search_data != ''){
	$search_where1 = " and (tbl_medicine_details.hsn_number like '%$search_data%')";
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
		if($where_search_date1 == ""){
			$where_search_date1 .= " and (tbl_credit_note.addedDate like '%$loop_date%' or tbl_credit_note.addedDate like '%$loop_date_new%'"; 
			//$where_search_date .= " and (tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'"; 
		}else{
			$where_search_date1 .= " or tbl_credit_note.addedDate like '%$loop_date%' or tbl_credit_note.addedDate like '%$loop_date_new%'";
			//$where_search_date .= " or tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'";
		}
		date_add($start_date2,date_interval_create_from_date_string("1 days"));
		$loop_date = date_format($start_date2,"Y-m-d");
		$loop_date_new = date_format($start_date2,"d-m-Y");
		$start_date2 = date_create($loop_date);
	}
	
	$where_search_date1 .= ")";
}else if($start_date !='' or $end_date!= ''){
	if($where_search ==''){
		$where_search_date1 = " ";
	}
	if($start_date != ''){
		$start_date1 = date_create($start_date);
		$date1 = date_format($start_date1,"Y-m-d");
		$date1_new = date_format($start_date1,"d-m-Y");
		//$where_search_date .= " and (tbl_customer.created_date like '%$date1%' or tbl_customer.created_date like '%$date1_new%')";
		$where_search_date1 .= " and (tbl_credit_note.addedDate like '%$date1%' or tbl_credit_note.addedDate like '%$date1_new%' )";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"Y-m-d");
		$date2_new = date_format($end_date1,"d-m-Y");
		//$where_search_date .= " and (tbl_customer.created_date like '%$date2%' or tbl_customer.created_date like '%$date2_new%')";
		$where_search_date1 .= " and (tbl_credit_note.addedDate like '%$date2%' or tbl_credit_note.addedDate like '%$date2_new%')";
	}
}
$response_arr2 = [];
$select_product_details = $obj->selectData("tbl_medicine_details.hsn_sac as hsn_number,tbl_medicine_details.tax_data as tax_in_per,tbl_credit_note_products.id,tbl_credit_note_products.returned_qty as no_quantity,tbl_credit_note_products.returned_amount as price,tbl_credit_note_products.returned_amount as total_price,tbl_product.product_name,tbl_credit_note_products.product_name as pm","tbl_credit_note_products INNER JOIN tbl_medicine_details on tbl_credit_note_products.meds_tbl_id=tbl_medicine_details.id INNER JOIN tbl_product on tbl_credit_note_products.product_id=tbl_product.id  inner join tbl_credit_note on tbl_credit_note_products.tbl_credit_note_id = tbl_credit_note.id","where tbl_credit_note.status!=0 and tbl_credit_note_products.status!=0   $where_search_date1 $search_where1");
//echo $select_product_details;exit();
/**$select_product_details = $obj->selectData("tbl_productdetails.id,tbl_productdetails.customer_id,tbl_productdetails.category_name,sum(tbl_productdetails.no_quantity) as no_quantity,tbl_productdetails.hsn_number,sum(tbl_productdetails.price) as price ,sum(tbl_productdetails.total_price) as total_price,tbl_productdetails.tax_in_per,sum(tbl_productdetails.tax_data) as tax_data,tbl_product.product_name,tbl_productdetails.product_name as pm","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id=tbl_customer.id INNER JOIN tbl_product on tbl_productdetails.product_id=tbl_product.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0   $where_search_date $search_where  group by hsn_number");**/
//echo $select_product_details;exit();
//and tbl_productdetails.tax_in_per!=0
//echo $select_product_details;exit();
if(mysqli_num_rows($select_product_details)>0){
	
	$response_arr[0]['data_exist'] = 1;
	$x = 0;
	while($select_product_details_row = mysqli_fetch_array($select_product_details)){
		
		$pm = trim($select_product_details_row['pm']);
		$hsn_tax = $select_product_details_row['hsn_number']."%".$select_product_details_row['tax_in_per'];
		//echo $hsn_tax;exit();
		if(in_array($hsn_tax,$hsn_number_data2)){
			for($y = 0;$y<sizeof($response_arr2);$y++){
				if($response_arr2[$y]['hsn_number_com'] == $hsn_tax){
					$response_arr2[$y]['no_quantity'] += $select_product_details_row['no_quantity'];
					$response_arr2[$y]['price'] += $select_product_details_row['price'];
					$response_arr2[$y]['total_price'] += $select_product_details_row['total_price'];
					$response_arr2[$y]['tax_data'] += $select_product_details_row['total_price'] - including_tax_desi($select_product_details_row['tax_in_per'],$select_product_details_row['total_price']);
					$taxable_value = $response_arr2[$y]['total_price']-$response_arr2[$y]['tax_data'];
					$response_arr2[$y]['taxable_value']  = $taxable_value;
					$total_tax_amt += $response_arr2[$x]['tax_data'];
					$total_amount += $select_product_details_row['total_price'];
					/*$cgst = $response_arr[$y]['tax_data']/2;
					$sgst = $response_arr[$y]['tax_data']/2;
					$response_arr[$y]['cgst'] = round($cgst,2);
					$response_arr[$y]['sgst'] = round($sgst,2);*/
					//echo"hi";
				}
				
			}
		}else{
			array_push($hsn_number_data2,$hsn_tax);
			$response_arr2[$x]['id'] = $select_product_details_row['id'];
			$response_arr2[$x]['customer_id'] = $select_product_details_row['customer_id'];
			$response_arr2[$x]['product_name'] = $select_product_details_row['product_name'];
			$response_arr2[$x]['no_quantity'] = $select_product_details_row['no_quantity'];
			$response_arr2[$x]['hsn_number'] = $select_product_details_row['hsn_number'];
			$response_arr2[$x]['hsn_number_com'] = $hsn_tax;
			$response_arr2[$x]['price'] = $select_product_details_row['price'];
			$response_arr2[$x]['total_price'] = $select_product_details_row['total_price'];
			//$response_arr[$x]['taxable_value']  = $select_product_details_row['total_price']-$select_product_details_row['tax_data'];
			$response_arr2[$x]['tax_in_per'] = $select_product_details_row['tax_in_per'];
			$response_arr2[$x]['tax_data'] = $select_product_details_row['total_price'] - 	including_tax_desi($select_product_details_row['tax_in_per'],$select_product_details_row['total_price']);
			$total_tax_amt += $response_arr2[$x]['tax_data'];
			$response_arr2[$x]['taxable_value']  = $select_product_details_row['total_price']-$response_arr2[$x]['tax_data'];
			$total_amount += $select_product_details_row['total_price'];
			//echo "hi";exit();
			/*$total_tax = $response_arr[$x]['tax_data'];
			$cgst = $response_arr[$x]['tax_data']/2;
			$sgst = $response_arr[$x]['tax_data']/2;
			$response_arr[$x]['cgst'] = round($cgst,2);
			$response_arr[$x]['sgst'] = round($sgst,2);*/
			//echo"hi";
			$x++;
			
		}
	
	}
}
function including_tax_desi($tax_ratio,$amount){
    $tax_in_hund = $tax_ratio+100;
    $y = ((int)$amount/$tax_in_hund)*100;
    return round($y,2);
}
for($i = 0; $i < count($response_arr1);$i++){
	//echo count($response_arr2);exit();
	for($j = 0; $j < count($response_arr2);$j++){
		//echo $response_arr1[$i]['hsn_number_com'].' '.$response_arr2[$j]['hsn_number_com'];
		if($response_arr1[$i]['hsn_number_com'] == $response_arr2[$j]['hsn_number_com']){
			$response_arr1[$i]['no_quantity'] -= $response_arr2[$j]['no_quantity'];
			$response_arr1[$i]['price'] -= $response_arr2[$j]['price'];
			$response_arr1[$i]['total_price'] -= $response_arr2[$j]['total_price'];
			$response_arr1[$i]['tax_data'] -= $response_arr2[$j]['tax_data'];
			$response_arr1[$i]['taxable_value'] -= $response_arr2[$j]['taxable_value'];

		}
		
		
	}
	//$response_arr1[$i]['tax_data'] = $response_arr1[$i]['total_price'] - including_tax_desi($response_arr1[$i]['tax_in_per'],$response_arr1[$i]['total_price']);
	//$response_arr1[$i]['taxable_value'] = $response_arr1[$i]['total_price']-$response_arr1[$i]['tax_data'];
	$total_amount_final += $response_arr1[$i]['total_price'];
	$total_tax_amt_final += $response_arr1[$i]['tax_data'];
	//$total_taxable_value += $response_arr1[$i]['taxable_value'];
	$sino++;
}

$sino = 0;
if(sizeof($response_arr1) !=0){
for($x1 = 0;$x1<sizeof($response_arr1);$x1++){
	$sino++;
	$no_quantity = $response_arr1[$x1]['no_quantity'];
	$hsn_number = $response_arr1[$x1]['hsn_number'];
	$price = $response_arr1[$x1]['price'];
	$total_price = round($response_arr1[$x1]['total_price'],2);
	$tax_data = round($response_arr1[$x1]['tax_data'],2);
	$taxable_value = round($response_arr1[$x1]['taxable_value'],2);
	$tax_per = $response_arr1[$x1]['tax_per'];
	$cgst = $tax_data/2;
	$sgst = $tax_data/2;
	$lineData = array($sino,$hsn_number,$tax_per,$no_quantity,
$total_price,$taxable_value,$cgst,$sgst,0,$tax_data); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";
}
}else{
	$excelData .= 'No records found...'. "\n"; 
}
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
// Render excel data 
echo $excelData; 
//print_r($hsn_number_data);
?>