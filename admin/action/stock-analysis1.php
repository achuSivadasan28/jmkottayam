<?php
require_once '../../_class/query.php';
$obj=new query();
$product_quantity = 0;
$response_arr = array();
$search=$_GET['searchval'];
$start_date=$_GET['start_date'];
$end_date=$_GET['end_date'];
$search_where='';
if($search != ''){
$search_where = " and (tbl_product.product_name like '%$search%')";
}

$where_search_date = '';
if($start_date != '' and $end_date !=''){
	$start_date1 = date_create($start_date);
	$end_date1 = date_create($end_date);
	$start_date2 = $start_date1;
	$diff=date_diff($start_date1,$end_date1);
	$diff1 =  $diff->format("%a");
	//$loop_date = date_create($start_date);
	$y1 = 0;
	$loop_date = date_format($start_date1,'d-m-Y');
	$loop_date_new = date_format($start_date1,'Y-m-d');
	for($x1=0;$x1<=$diff1;$x1++){
		if($where_search_date == ""){
			$where_search_date .= " and (tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'"; 
		}else{
			$where_search_date .= " or tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'";
		}
		date_add($start_date2,date_interval_create_from_date_string("1 days"));
		$loop_date = date_format($start_date2,"d-m-Y");
		$start_date2 = date_create($loop_date);
	}
	
	$where_search_date .= ")";
}else if($start_date !='' or $end_date!= ''){
	if($where_search ==''){
		$where_search_date = " ";
	}
	if($start_date != ''){
		$start_date1 = date_create($start_date);
		$date1 = date_format($start_date1,"d-m-Y");
		$date1_new = date_format($start_date1,"Y-m-d");
		$where_search_date .= " and (tbl_customer.created_date like '%$date1%' or tbl_customer.created_date like '%$date1_new%')";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"d-m-Y");
		$date2_new = date_format($end_date1,"d-m-Y");
		$where_search_date .= " and (tbl_customer.created_date like '%$date2%'  or tbl_customer.created_date like '%$date2_new%')";
	}
}
$fetch_all_product = $obj->selectData("tbl_product.id,tbl_product.product_name,tbl_product.category_id,tbl_medicine_details.quantity,tbl_medicine_details.no_of_pills","tbl_product inner join tbl_medicine_details on tbl_product.id=tbl_medicine_details.product_id","where tbl_product.status!=0 and tbl_medicine_details.status != 0 $search_where ORDER BY tbl_product.id DESC");
if(mysqli_num_rows($fetch_all_product)>0){
	$x = 0;
	while($fetch_all_product_row = mysqli_fetch_array($fetch_all_product)){
		$product_id = $fetch_all_product_row['id'];
		$product_name = $fetch_all_product_row['product_name'];
		$category_id = $fetch_all_product_row['category_id'];
		$quantity = $fetch_all_product_row['quantity'];
		$no_of_pills = $fetch_all_product_row['no_of_pills'];
		$category_name = '';
		$select_cat_name = $obj->selectData("category_name","tbl_category","where id=$category_id and status!=0");
		if(mysqli_num_rows($select_cat_name)>0){
			$select_cat_name_row = mysqli_fetch_array($select_cat_name);
			$category_name = $select_cat_name_row['category_name'];
		}
		$quantity_details = 0;
		$sold_analysis = 0;
		$blance_analysis = 0;
		
		$select_sold_product_stock = $obj->selectData("sum(tbl_productdetails.no_quantity) as no_quantity","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id=tbl_customer.id","where tbl_productdetails.product_id=$product_id  $where_search_date and tbl_customer.status !=0 and tbl_productdetails.status != 0 ");
		$select_sold_product_stock_row = mysqli_fetch_array($select_sold_product_stock);				if($select_sold_product_stock_row['no_quantity'] != null){
			$quantity_details = $select_sold_product_stock_row['no_quantity'];
		}
		
		$total_quantity_details = $quantity+$quantity_details;
		$balance_product = $total_quantity_details-$quantity_details;
		if($quantity_details !=0 or $total_quantity_details !=0){
			$sold_analysis = ($quantity_details/$total_quantity_details)*100;
		}
		if($balance_product !=0 or $total_quantity_details !=0){
			$blance_analysis = ($balance_product/$total_quantity_details)*100;
		}
		$response_arr[$x]['product_id'] = $product_id;
		$response_arr[$x]['product_name'] = $product_name;
		$response_arr[$x]['category_name'] = $category_name;
		$response_arr[$x]['quantity'] = $quantity;
		$response_arr[$x]['total_quantity_details'] = $total_quantity_details;
		$response_arr[$x]['quantity_details'] = $quantity_details;
		$response_arr[$x]['balance_product'] = $balance_product;
		$response_arr[$x]['no_of_pills'] = $no_of_pills;
		$response_arr[$x]['sold_analysis'] = round($sold_analysis);
		$response_arr[$x]['blance_analysis'] = round($blance_analysis);
		$x++;
	}
}

function sortByOrder($a, $b) {
    return $a['total_quantity_details'] - $b['total_quantity_details'];
}

usort($response_arr, 'sortByOrder');
//echo "haii";exit();
echo json_encode($response_arr);
//print_r($response_arr);
?>
