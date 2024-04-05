<?php
require_once '../../_class/query.php';
$obj=new query();
$response_arr = array();
$hsn_number_data = array();
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
		}else{
			$where_search_date .= " or tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'";
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
		$where_search_date .= " and (tbl_customer.created_date like '%$date1%' or tbl_customer.created_date like '%$date1_new%')";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"Y-m-d");
		$date2_new = date_format($end_date1,"d-m-Y");
		$where_search_date .= " and (tbl_customer.created_date like '%$date2%' or tbl_customer.created_date like '%$date2_new%')";
	}
}

// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

// Excel file name for download 
$fileName = "HSN_Sales_Report_trsr" . date('d-m-Y') . ".xls"; 

$fields = array('Sl No','HSN Code','Tax Rate','Quantity','Total Value','Taxable Value','CGST','SGST','IGST','Total Tax');

$excelData = implode("\t", array_values($fields)) . "\n"; 

//$excelData .= 'Invoice Report'. "\n"; 
$select_product_details = $obj->selectData("tbl_productdetails.id,tbl_productdetails.customer_id,tbl_productdetails.category_name,tbl_productdetails.no_quantity,tbl_productdetails.hsn_number,tbl_productdetails.price,tbl_productdetails.total_price,tbl_productdetails.tax_in_per,tbl_productdetails.tax_data,tbl_product.product_name,tbl_productdetails.product_name as pm","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id=tbl_customer.id INNER JOIN tbl_product on tbl_productdetails.product_id=tbl_product.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0   $where_search_date $search_where");
/**$select_product_details = $obj->selectData("tbl_productdetails.id,tbl_productdetails.customer_id,tbl_productdetails.category_name,sum(tbl_productdetails.no_quantity) as no_quantity,tbl_productdetails.hsn_number,sum(tbl_productdetails.price) as price ,sum(tbl_productdetails.total_price) as total_price,tbl_productdetails.tax_in_per,sum(tbl_productdetails.tax_data) as tax_data,tbl_product.product_name,tbl_productdetails.product_name as pm","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id=tbl_customer.id INNER JOIN tbl_product on tbl_productdetails.product_id=tbl_product.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0   $where_search_date $search_where  group by hsn_number");**/
//and tbl_productdetails.tax_in_per!=0
//echo $select_product_details;exit();
if(mysqli_num_rows($select_product_details)>0){
	$x = 0;
	while($select_product_details_row = mysqli_fetch_array($select_product_details)){
		$hsn_data = $select_product_details_row['hsn_number']."%".$select_product_details_row['tax_in_per'];
		
		if(in_array($hsn_data,$hsn_number_data)){
			for($y = 0;$y<sizeof($response_arr);$y++){
				if($response_arr[$y]['hsn_number_com'] == $hsn_data){
					$response_arr[$y]['no_quantity'] += $select_product_details_row['no_quantity'];
					$response_arr[$y]['price'] += $select_product_details_row['price'];
					$response_arr[$y]['total_price'] += $select_product_details_row['total_price'];
					$response_arr[$y]['tax_data'] += $select_product_details_row['tax_data'];
					//$response_arr[$y]['tax_data'] = $response_arr[$y]['tax_data'];
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
			array_push($hsn_number_data,$hsn_data);
			$response_arr[$x]['id'] = $select_product_details_row['id'];
			$response_arr[$x]['customer_id'] = $select_product_details_row['customer_id'];
			$response_arr[$x]['no_quantity'] = $select_product_details_row['no_quantity'];
			$response_arr[$x]['hsn_number'] = $select_product_details_row['hsn_number'];
			$response_arr[$x]['hsn_number_com'] = $hsn_data;
			$response_arr[$x]['price'] = $select_product_details_row['price'];
			$response_arr[$x]['total_price'] = $select_product_details_row['total_price'];
			$response_arr[$x]['taxable_value']  = $select_product_details_row['total_price']-$select_product_details_row['tax_data'];
			$response_arr[$x]['tax_data'] = $select_product_details_row['tax_data'];
			$response_arr[$x]['tax_per'] = $select_product_details_row['tax_in_per']."%";
			$total_tax_amt += $select_product_details_row['tax_data'];
			$total_amount += $select_product_details_row['total_price'];
			/*$total_tax = $response_arr[$x]['tax_data'];
			$cgst = $response_arr[$x]['tax_data']/2;
			$sgst = $response_arr[$x]['tax_data']/2;
			$response_arr[$x]['cgst'] = round($cgst,2);
			$response_arr[$x]['sgst'] = round($sgst,2);*/
			$x++;
		}
		
	$sino++;
	}
}
$sino = 0;
if(sizeof($response_arr) !=0){
for($x1 = 0;$x1<sizeof($response_arr);$x1++){
	$sino++;
	$no_quantity = $response_arr[$x1]['no_quantity'];
	$hsn_number = $response_arr[$x1]['hsn_number'];
	$price = $response_arr[$x1]['price'];
	$total_price = round($response_arr[$x1]['total_price'],2);
	$tax_data = round($response_arr[$x1]['tax_data'],2);
	$taxable_value = round($response_arr[$x1]['taxable_value'],2);
	$tax_per = $response_arr[$x1]['tax_per'];
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
?>