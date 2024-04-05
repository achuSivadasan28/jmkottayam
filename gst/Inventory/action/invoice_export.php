<?php 

// Load the database configuration file 
 
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "Johnmarians_invoice" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('ID','Invoice No', 'Customer Name', 'Products Name', 'Category', 'Date', 'Staff Name','Total Amount'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$export_arr = array();
$x = 0;

$customer = $obj1->selectData("id,customer_name,invoice_no,staff_id,phone,created_date,total_price,total_discount,total_amonut","tbl_customer","where status!=0 ORDER BY id DESC");

if(mysqli_num_rows($customer)>0){
    $y=1;
    while($customer_row = mysqli_fetch_array($customer)){
        $response_arr[$x]['id'] = $customer_row['id'];
        $invoice= $customer_row['invoice_no'];
        $response_arr[$x]['invoice_no']=$invoice;
        $customers= $customer_row['customer_name'];
        $response_arr[$x]['customer_name']=$customers; 
        $date = $customer_row['created_date'];
        $response_arr[$x]['date']= $date;
        $total_amt= $customer_row['total_amonut'];
        $response_arr[$x]['total_price'] =$total_amt;
        $id = $customer_row['id'];
        $product_name = '';
        $product_quantity = 0;
        $product_cat = '';
        $cat_arr = [];
        $fetch_data = $obj1->selectData("id,customer_id,category_name,product_name","tbl_productdetails","where customer_id=$id ORDER BY id DESC");
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
        $staff=$obj1->selectData("id,staff_name","tbl_staff","where id=$log_id and status!=0");

        if(mysqli_num_rows($staff)>0){
           while($staff_row = mysqli_fetch_array($staff)){ 
               $staff_name = $staff_row['staff_name'] ;   
               $response_arr[$x]['staff_name']=$staff_name;
           }
       }
  

        $x++;
  

$lineData = array($x,$invoice, $customers,$product_name,$product_cat,$date,$staff_name,$total_amt); 
array_walk($lineData, 'filterData'); 
$excelData .= implode("\t", array_values($lineData)) . "\n"; 
$y++;
     
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