<?php
session_start();
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$staff_id=$_SESSION['staff']; 
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
			$where_search_date .= " (created_date like '%$loop_date%'"; 
		}else{
			$where_search_date .= " or created_date like '%$loop_date%'";
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
		$where_search_date .= "created_date like '%$date1%'";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"d-m-Y");
		$where_search_date .= "created_date like '%$date2%'";
	}
}
$x = 0;
$customer = $obj1->selectData("id,customer_name,invoice_no,staff_id,phone,created_date,total_price,total_discount,total_amonut","tbl_customer"," where status!=0 and staff_id=$staff_id and $where_search_date ORDER BY id DESC");
// echo $customer; exit();
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
        $id = $customer_row['id'];
        $product_name = '';
        $product_quantity = 0;
        $product_cat = '';
        $cat_arr = [];
        $fetch_data = $obj1->selectData("id,customer_id,category_name,product_name,no_quantity","tbl_productdetails","where customer_id=$id ORDER BY id DESC");
        if(mysqli_num_rows($fetch_data)>0){
            while($fetch_data_row = mysqli_fetch_array($fetch_data)){
                if($product_name == ''){
                    $product_name = $fetch_data_row['product_name'];
                }else{
                    $product_name .= ','.$fetch_data_row['product_name'];

                }
                $product_quantity += $fetch_data_row['no_quantity']; //$product_quantity = $product_quantity+$fetch_data_row['quantity']

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
        $response_arr[$x]['quantity'] = $product_quantity;
        $response_arr[$x]['category_name'] = $product_cat;
        $x++;
    }
}

echo json_encode($response_arr);
?>
