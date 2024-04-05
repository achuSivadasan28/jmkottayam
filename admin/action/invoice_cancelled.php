<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$x = 0;
$search_val = $_GET['search_val'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$status_id = $_GET['status_id'];
$limit_range = $_GET['limit_range'];
$search_where = "";
if($search_val != ''){
	$search_where = " and (tax_compained_val like '%$search_val%' or customer_name like '%$search_val%' or phone like '%$search_val%' or invoice_no like '%$search_val%')";
}
$where_staff_clause = '';
if($status_id != 0){
	$where_staff_clause = " and staff_id = $status_id";
}

//$where_search_date = '';
/*if($start_date != '' and $end_date !=''){

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
			$where_search_date .= " and (created_date like '%$loop_date%' or created_date like '%$loop_date_new%'"; 
		}else{
			$where_search_date .= " or created_date like '%$loop_date%' or created_date like '%$loop_date_new%'";
		}
		date_add($start_date2,date_interval_create_from_date_string("1 days"));
		$loop_date = date_format($start_date2,"Y-m-d");
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
		$where_search_date .= " and (created_date like '%$date1%' or created_date like '%$date1_new%')";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"Y-m-d");
		$date2_new = date_format($end_date1,"d-m-Y");
		$where_search_date .= " and (created_date like '%$date2%' or created_date like '%$date2_new%')";
	}
}
*/


$where_search_date = '';
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
			$where_search_date .= " and (created_date like '%$loop_date%' or created_date like '%$loop_date_new%'"; 
		}else{
			$where_search_date .= " or created_date like '%$loop_date%' or created_date like '%$loop_date_new%'";
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
		$where_search_date .= " and (created_date like '%$date1%' or created_date like '%$date1_new%')";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"Y-m-d");
		$date2_new = date_format($end_date1,"d-m-Y");
		$where_search_date .= " and (created_date like '%$date2%' or created_date like '%$date2_new%')";
	}
}


  $customer = $obj1->selectData("id,customer_name,invoice_no,staff_id,phone,created_date,total_price,total_discount,total_amonut,reson","tbl_customer","where status=0 $search_where $where_staff_clause $where_search_date ORDER BY id DESC limit $limit_range");
if(mysqli_num_rows($customer)>0){
    while($customer_row = mysqli_fetch_array($customer)){
        $response_arr[$x]['id'] = $customer_row['id'];
        $response_arr[$x]['invoice_no'] = $customer_row['invoice_no'];
        $response_arr[$x]['customer_name'] = $customer_row['customer_name'];
        $response_arr[$x]['phone'] = $customer_row['phone'];
        $response_arr[$x]['date'] = $customer_row['created_date'];
        $response_arr[$x]['price'] = $customer_row['total_price'];
        $response_arr[$x]['discount'] = $customer_row['total_discount'];
        $response_arr[$x]['total_price'] = $customer_row['total_amonut'];
		$response_arr[$x]['reson'] = $customer_row['reson'];
        $id = $customer_row['id'];
        $product_name = '';
        $product_quantity = 0;
        $product_cat = '';
        $cat_arr = [];
        $fetch_data = $obj1->selectData("id,customer_id,category_name,product_name","tbl_productdetails","where customer_id=$id and status!=0 ORDER BY id DESC");
        if(mysqli_num_rows($fetch_data)>0){
            while($fetch_data_row = mysqli_fetch_array($fetch_data)){
                if($product_name == ''){
                    $product_name = $fetch_data_row['product_name'];
                }else{
                    $product_name .= ','.$fetch_data_row['product_name'];

                }
                //$product_quantity += $fetch_data_row['quantity']; //$product_quantity = $product_quantity+$fetch_data_row['quantity']

                if($product_cat == ''){
                    $product_cat = $fetch_data_row['category_name'];
                }else{
                    if(!in_array($fetch_data_row['category_name'],$cat_arr)){
                    $product_cat .= ','.$fetch_data_row['category_name'];
                    array_push($cat_arr,$fetch_data_row['category_name']);
                    }

                }
            }
        }
        $response_arr[$x]['product_name'] = $product_name;
        //$response_arr[$x]['quantity'] = $product_quantity;
        $response_arr[$x]['category_name'] = $product_cat;

        $log_id=$customer_row['staff_id'];
             $staff=$obj1->selectData("id,staff_name","tbl_staff","where staff_login=$log_id");
    
             if(mysqli_num_rows($staff)>0){
                while($staff_row = mysqli_fetch_array($staff)){ 
                    $response_arr[$x]['staff_name'] = $staff_row['staff_name'] ;   
                    
                }
            }else{
			 	$response_arr[$x]['staff_name'] = "Admin";
			 }
       

        $x++;
    }
}

echo json_encode($response_arr);
?>
