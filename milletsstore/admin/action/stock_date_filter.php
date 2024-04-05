<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$start_date = $_GET['date1'];
$end_date = $_GET['date2'];
$where_search='';

$where_search_date = '';

if($start_date != '' and $end_date !=''){
	
	if($where_search == ''){
		$where_search_date = "";
	}
	$start_date1 = date_create($start_date);
	$end_date1 = date_create($end_date);
	$start_date2 = $start_date1;
	$diff=date_diff($start_date1,$end_date1);
	$diff1 =  $diff->format("%a");
	//$loop_date = date_create($start_date);
	$y1 = 0;
	$loop_date = date_format($start_date1,'d-m-Y');
	for($x1=0;$x1<=$diff1;$x1++){
		if($where_search_date == ""){
			$where_search_date .= " (added_date like '%$loop_date%'"; 
		}else{
			$where_search_date .= " or added_date like '%$loop_date%'";
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
		$where_search_date .= "added_date like '%$date1%'";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"d-m-Y");
		$where_search_date .= "added_date like '%$date2%'";
	}
}
$x=0;

$fetch_data = $obj1->selectData("id,product_name,category_id,quantity,added_date","tbl_product","where status!=0");
if(mysqli_num_rows($fetch_data)>0){
 while($fetch_data_row = mysqli_fetch_array($fetch_data)){
$id=$fetch_data_row['id'];

$p_details=$obj1->selectData("no_quantity,product_id,added_date","tbl_productdetails","where product_id=$id and $where_search_date");
if(mysqli_num_rows($p_details)>0){
    while($p_details_row = mysqli_fetch_array($p_details)){
		$product_quantity = '';
        $cat_arr = [];
		
		if($product_quantity == ''){
			$product_quantity = $p_details_row['no_quantity'];
		}else{
			if(!in_array($p_details_row['product_id'],$cat_arr)){
			$product_quantity += $p_details_row['no_quantity'];
			//echo $product_quantity; exit();
			array_push($cat_arr,$p_details_row['product_id']);
			} 

		}
		$response_arr[$x]['no_quantity'] = $product_quantity;
		
    $cate_id=$fetch_data_row['category_id'];
    $category = $obj1->selectData("id,category_name","tbl_category","where status!=0 and id=$cate_id ORDER BY id DESC");

    if(mysqli_num_rows($category)>0){
        while($category_row = mysqli_fetch_array($category)){
    $response_arr[$x]['category'] = $category_row['category_name'] ;        
    $response_arr[$x]['id'] = $fetch_data_row['id'] ;
    $response_arr[$x]['product_name'] = $fetch_data_row['product_name'];

            	}
        	}
			$response_arr[$x]['no_quantity'] = $product_quantity;
			$total = $fetch_data_row['quantity'] ;
			$t_qunatity=$total+$product_quantity;
			$response_arr[$x]['quantity'] =$t_qunatity;
		
			$left=0;   
			$left=$t_qunatity-$product_quantity;
			$response_arr[$x]['left'] =$left;
	
			$analysis=0;
			$cal=$product_quantity/$t_qunatity;
			$analysis=$cal*100;
			$response_arr[$x]['analysis'] =$analysis;
			
			$l_analysis=0;
			$calc=$left/$t_qunatity;
			$l_analysis=$calc*100;
			$response_arr[$x]['leftanalysis'] =$l_analysis;
			$response_arr[$x]['no_quantity'] = $product_quantity;
		$x++;
    	}
    }
	
}
}
echo json_encode($response_arr);
?>
