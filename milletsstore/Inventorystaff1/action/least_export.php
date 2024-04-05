<?php 

// Load the database configuration file 
 
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "Johnmarians_Least_Selling_report" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('ID','Products Name','Category','Total Stock', 'Sold','Left','Analysis'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();
$export_arr = array();
$x = 0;
$fetch_data = $obj1->selectData("id,product_name,category_id,quantity","tbl_product","where status!=0 ORDER BY id DESC");
if(mysqli_num_rows($fetch_data)>0){
    $y=1;
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
    $p_details=$obj1->selectData("no_quantity,product_id","tbl_productdetails","where product_id=$product_id");
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
        
        
        if($analysis<50){
		$response_arr[$x]['category'] = $category_name ;
    	$response_arr[$x]['id'] = $cat_id ;	
    	$response_arr[$x]['product_name'] = $product_name;
		$response_arr[$x]['left'] =$left ;
			$response_arr[$x]['quantity'] =$t_qunatity;
			$response_arr[$x]['leftanalysis'] =$analysis;
			$response_arr[$x]['no_quantity'] = $product_quantity;
        $x++;
		
	 
           

$lineData = array($x,$product_name,$category_name,$t_qunatity,$product_quantity,$left,$analysis); 
array_walk($lineData, 'filterData'); 
$excelData .= implode("\t", array_values($lineData)) . "\n"; 
$y++;
		}
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