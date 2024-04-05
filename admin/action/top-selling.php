<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = [];
$search=$_GET['searchval'];
$start_date=$_GET['start_date'];
$end_date=$_GET['end_date'];
$search_where = '';
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
			$where_search_date .= " and (tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date%'"; 
		}else{
			$where_search_date .= " or tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date%'";
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
		$date2_new = date_format($end_date1,"Y-m-d");
		$where_search_date .= " and (tbl_customer.created_date like '%$date2%' or tbl_customer.created_date like '%$date2_new%')";
	}
}

$fetch_data = $obj1->selectData("tbl_product.id,tbl_product.product_name,tbl_product.category_id,tbl_medicine_details.quantity","tbl_product inner join tbl_medicine_details on tbl_product.id=tbl_medicine_details.product_id","where tbl_product.status!=0 $search_where ORDER BY tbl_product.id DESC");
//echo print_r($obj1);exit();
if(mysqli_num_rows($fetch_data)>0){
	$x = 0;
	while($fetch_data_row = mysqli_fetch_array($fetch_data)){

		$id=$fetch_data_row['category_id'];
		$category = $obj1->selectData("id,category_name","tbl_category","where status!=0 and id=$id ORDER BY id DESC");
		//print_r($obj1);exit();
		if(mysqli_num_rows($category)>0){
			while($category_row = mysqli_fetch_array($category)){
				//$response_arr[$x]['category'] = $category_row['category_name'] ; 
				$category_name=$category_row['category_name'] ;	
				//$response_arr[$x]['id'] = $fetch_data_row['id'] ;
				$cat_id=$fetch_data_row['id'];	
				//$response_arr[$x]['product_name'] = $fetch_data_row['product_name'];
				$product_name=$fetch_data_row['product_name'];	
				$product_quantity =0;
				$product_id=$fetch_data_row['id'];
				$p_details = $obj1->selectData("tbl_productdetails.no_quantity,tbl_productdetails.product_id","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id=tbl_customer.id","where tbl_productdetails.product_id=$product_id $where_search_date");

				if(mysqli_num_rows($p_details)>0){
					while($p_details_row = mysqli_fetch_array($p_details)){
						$product_quantity += $p_details_row['no_quantity'];
					}
				}
				//$response_arr[$x]['no_quantity'] = $product_quantity;
			}
		}

		$total = $fetch_data_row['quantity'] ;
		$t_qunatity=$total+$product_quantity;
		//$response_arr[$x]['quantity'] =$t_qunatity;

		$left=0;   
		$left=$t_qunatity-$product_quantity;
		//$response_arr[$x]['left'] =$left;

		$analysis=0;
		$cal=$product_quantity/$t_qunatity;
		$analysis=floor($cal*100);


		if($analysis>50){
			//echo 1;exit();
			$response_arr[$x]['category'] = $category_name ;
			$response_arr[$x]['id'] = $cat_id ;	
			$response_arr[$x]['product_name'] = $product_name;
			$response_arr[$x]['left'] =$left ;
			$response_arr[$x]['quantity'] =$t_qunatity;
			$response_arr[$x]['analysis'] =$analysis;
			$response_arr[$x]['no_quantity'] = $product_quantity;
			$x++;
			//print_r($response_arr);
		}

	}
}
//print_r($response_arr);exit();
// Function to recursively remove Inf, -Inf, and NaN from an array
function removeInvalidValues(&$arr) {
    foreach ($arr as $key => &$value) {
        if (is_array($value)) {
            removeInvalidValues($value);
        } elseif (is_float($value) && (is_infinite($value) || is_nan($value))) {
            $value = null; // Replace invalid values with null or handle them as needed
        }
    }
}

// Clean the array
removeInvalidValues($response_arr);

// Encode the cleaned array
$json_encoded = json_encode($response_arr);

// Check for errors
if ($json_encoded === false) {
    echo 'JSON encoding failed with error: ' . json_last_error_msg();
} else {
    echo $json_encoded;
}

?>
