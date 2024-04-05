<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$search=$_GET['searchval'];
$start_date=$_GET['start_date'];
$end_date=$_GET['end_date'];
$search_where = '';
if($search != ''){
$search_where = " and (product_name like '%$search%')";
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
	for($x1=0;$x1<=$diff1;$x1++){
		if($where_search_date == ""){
			$where_search_date .= " and (added_date like '%$loop_date%'"; 
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
		$where_search_date .= " and added_date like '%$date1%'";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"d-m-Y");
		$where_search_date .= " and added_date like '%$date2%'";
	}
}

$fetch_data = $obj1->selectData("id,product_name,category_id,quantity","tbl_product","where status!=0 $search_where ORDER BY id DESC");
if(mysqli_num_rows($fetch_data)>0){
    $x = 0;
 while($fetch_data_row = mysqli_fetch_array($fetch_data)){

    $id=$fetch_data_row['category_id'];
    $category = $obj1->selectData("id,category_name","tbl_category","where status!=0 and id=$id ORDER BY id DESC");

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
    $p_details=$obj1->selectData("no_quantity,product_id","tbl_productdetails","where product_id=$product_id $where_search_date");
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
		$response_arr[$x]['category'] = $category_name ;
    	$response_arr[$x]['id'] = $cat_id ;	
    	$response_arr[$x]['product_name'] = $product_name;
		$response_arr[$x]['left'] =$left ;
			$response_arr[$x]['quantity'] =$t_qunatity;
			$response_arr[$x]['analysis'] =$analysis;
			$response_arr[$x]['no_quantity'] = $product_quantity;
        $x++;
		}
	 
            }
        }
echo json_encode($response_arr);
?>
