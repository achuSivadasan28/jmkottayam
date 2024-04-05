<?php
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$x = 0;
$search_val = $_GET['search_val'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$status_id = $_GET['status_id'];

$search_where = "";
if($search_val != ''){
	$search_where = " and (tax_compained_val like '%$search_val%' or customer_name like '%$search_val%' or phone like '%$search_val%' or invoice_no like '%$search_val%')";
}
$where_staff_clause = '';
if($status_id != 0){
	$where_staff_clause = " and staff_id = $status_id";
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
$sino = 1;
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

// Excel file name for download 
$fileName = "Invoice_reports_trsr" . date('d-m-Y') . ".xls"; 

$fields = array('No','Invoice No','Customer Name','Phone','Products Name','Date','Staff Name','Actual Amount','Total Tax','Total Amount','Payment Option');

$excelData = implode("\t", array_values($fields)) . "\n"; 


$customer = $obj1->selectData("id,customer_name,invoice_no,staff_id,phone,created_date,total_price,total_discount,total_amonut,payment_option","tbl_customer","where status!=0 $search_where $where_staff_clause $where_search_date ORDER BY id DESC");
if(mysqli_num_rows($customer)>0){
    while($customer_row = mysqli_fetch_array($customer)){
		
		
        $response_arr[$x]['id'] = $customer_row['id'];
		$customer_id = $customer_row['id'];
        $response_arr[$x]['invoice_no'] = $customer_row['invoice_no'];
        $response_arr[$x]['customer_name'] = $customer_row['customer_name'];
        $response_arr[$x]['phone'] = $customer_row['phone'];
        $response_arr[$x]['date'] = $customer_row['created_date'];
        $response_arr[$x]['price'] = $customer_row['total_price'];
        $response_arr[$x]['discount'] = $customer_row['total_discount'];
        $response_arr[$x]['total_price'] = $customer_row['total_amonut'];
		$payment_option = $customer_row['payment_option'];
		$payment_option_data_1 = '';
		$select_payment_op = $obj1->selectData("payment_option,amount","tbl_payment_recived_type","where customer_id=$customer_id and status!=0");
		if(mysqli_num_rows($select_payment_op)>0){
			while($select_payment_op_row = mysqli_fetch_array($select_payment_op)){
				$paymet_op_id = $select_payment_op_row['payment_option'];
				$select_option_data = $obj1->selectData("payment_option","tbl_payment_option","where id=$paymet_op_id");
				if(mysqli_num_rows($select_option_data)>0){
					$select_option_data_row = mysqli_fetch_array($select_option_data);
					$payment_option_data_1 .= $select_option_data_row['payment_option']."(".$select_payment_op_row['amount'].") ";
				}
				
			}
		}
		$response_arr[$x]['payment_option_data'] = $payment_option_data_1;
		//tbl_payment_option
        $id = $customer_row['id'];
        $product_name = '';
        $product_quantity = 0;
        $product_cat = '';
        $cat_arr = [];
		$tax_data = 0;
		$total_price = 0;
		$actual_amt = 0;
        $fetch_data = $obj1->selectData("id,customer_id,category_name,product_name,tax_data,total_price","tbl_productdetails","where customer_id=$id and status!=0 ORDER BY id DESC");
        if(mysqli_num_rows($fetch_data)>0){
            while($fetch_data_row = mysqli_fetch_array($fetch_data)){
				$total_price += $fetch_data_row['total_price'];
				$tax_data += $fetch_data_row['tax_data'];
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
		$actual_amt = round($total_price-$tax_data,2);
		$response_arr[$x]['actual_amt'] = round($total_price-$tax_data,2);
		$response_arr[$x]['total_price1'] = $total_price;
		$response_arr[$x]['tax_data'] = $tax_data;
        $response_arr[$x]['product_name'] = $product_name;
        //$response_arr[$x]['quantity'] = $product_quantity;
        $response_arr[$x]['category_name'] = $product_cat;

        $log_id=$customer_row['staff_id'];
 $staff=$obj1->selectData("id,staff_name","tbl_staff","where staff_login=$log_id");
    $staff_name='';
             if(mysqli_num_rows($staff)>0){
                while($staff_row = mysqli_fetch_array($staff)){ 
                    $response_arr[$x]['staff_name'] = $staff_row['staff_name'];
					$staff_name = $staff_row['staff_name'];
                    
                }
            }else{
			 	$response_arr[$x]['staff_name'] = "Admin";
				 $staff_name ="Admin";
			 }
       
$x++;
       $lineData = array($sino,  $customer_row['invoice_no'],$customer_row['customer_name'],$customer_row['phone'],$product_name,$customer_row['created_date'],
$staff_name,$actual_amt,$tax_data,$total_price,$payment_option_data_1); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";
	$sino++;
    }
}
else{ 
    $excelData .= 'No records found...'. "\n"; 
} 


// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 

?>
