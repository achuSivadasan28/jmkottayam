



<?php 
// Load the database configuration file 
require_once '../../_class/query.php';
$obj1=new query();

 
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "Johnmarians_bill" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('Sl No','Product', 'Category', 'Total Stocks', 'Sold', 'Left','Sold Analysis','Left Analysis'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 

require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$x=0;
$fetch_data = $obj1->selectData("tbl_product.id,tbl_product.product_name,tbl_product.category_id,tbl_medicine_details.no_of_pills,tbl_medicine_details.quantity","tbl_product inner join tbl_medicine_details on tbl_product.id=tbl_medicine_details.product_id","where tbl_product.status!=0 ORDER BY id DESC");
if(mysqli_num_rows($fetch_data)>0){
	$y=1;
 while($fetch_data_row = mysqli_fetch_array($fetch_data)){

    $id=$fetch_data_row['category_id'];
    $category = $obj1->selectData("id,category_name","tbl_category","where status!=0 and id=$id ORDER BY id DESC");

    if(mysqli_num_rows($category)>0){
        while($category_row = mysqli_fetch_array($category)){
    $category_name= $category_row['category_name'] ;
	 $response_arr[$x]['category']=$category_name;		
    $product_id= $fetch_data_row['id'] ;
	$response_arr[$x]['category']=$product_id;		
    $product_name = $fetch_data_row['product_name'];
	$response_arr[$x]['category']=$product_name;		
    $quantity = $fetch_data_row['quantity'] ;
			
    $product_quantity =0;
    $product_id=$fetch_data_row['id'];
    $p_details=$obj1->selectData("no_quantity,product_id","tbl_productdetails","where product_id=$product_id");
    if(mysqli_num_rows($p_details)>0){
        while($p_details_row = mysqli_fetch_array($p_details)){
            $product_quantity += $p_details_row['no_quantity'];
        }
    }
    $quanity = $product_quantity;
	$response_arr[$x]['no_quantity']= $quanity;		
        }
    }

    $total = $quantity;
    $t_qunatity=$total+$product_quantity;
    $totals=$t_qunatity;

 $left=0;   
$left=$totals-$product_quantity;
$response_arr[$x]['left']=$left;

$analysis=0;
$cal=$product_quantity/$totals;
$analysis=round($cal*100);
$response_arr[$x]['analysis']=round($analysis);
	 
$l_analysis=0;
$calc=$left/$totals;
$l_analysis=round($calc*100);
$response_arr[$x]['l_analysis']=round($l_analysis);
$x++;
        //$status = ($row['status'] == 1)?'Active':'Inactive'; 
        $lineData = array($x,$product_name, $category_name,$totals,$quanity,$left,$analysis,$l_analysis); 
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
 
exit;