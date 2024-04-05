<?php

include '../../_class/query.php';
$obj = new Query();

$dataArray=array();
$tax_array = array();
$tax_name=array();


date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$time = date('h:i:s A');
$sino = 1;
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

// Excel file name for download 
$fileName = "Taxslab_Reports_trsr" . date('d-m-Y') . ".xls"; 

$fields = array('Date','Total Amount','sales@12%','CGST@(6 %)','SGST@(6%)','Taxable value','sales@18%','CGST@(9%)','SGST@(9%)','Taxable value','sales@5%','CGST@(2.5%)','SGST@(2.5%)','Taxable value');

$excelData = implode("\t", array_values($fields)) . "\n"; 

$start_date = $_GET['startdate'];

$end_date = $_GET['enddate'];

$where_search_date = '';

// date filter
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
			$where_search_date .= " and (tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'"; 
			//$where_search_date .= " and (tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'"; 
		}else{
			$where_search_date .= " or tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'";
			//$where_search_date .= " or tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'";
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
		//$where_search_date .= " and (tbl_customer.created_date like '%$date1%' or tbl_customer.created_date like '%$date1_new%')";
		$where_search_date .= " and (tbl_customer.created_date like '%$date1%' or tbl_customer.created_date like '%$date1_new%')";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"Y-m-d");
		$date2_new = date_format($end_date1,"d-m-Y");
		//$where_search_date .= " and (tbl_customer.created_date like '%$date2%' or tbl_customer.created_date like '%$date2_new%')";
		$where_search_date .= " and (tbl_customer.created_date like '%$date2%' or tbl_customer.created_date like '%$date2_new%')";
	}
}


/* $fetchdistincttaxpercentage = $obj->selectData("DISTINCT tbl_productdetails.tax_in_per","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id = tbl_customer.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0 $date_where_clause");


 $fetchdistinctdate = $obj->selectData("DISTINCT created_date,status", "tbl_customer", "Where  status!=0 $where_search_date");*/
 $fetchdistinctdate = $obj->selectData("DISTINCT tbl_customer.created_date","tbl_customer INNER JOIN tbl_productdetails on tbl_customer.id = tbl_productdetails.customer_id","where tbl_customer.status!=0 and tbl_productdetails.status!=0 $where_search_date");
	 if(mysqli_num_rows($fetchdistinctdate)>0){

		$x=0;
	  while($rows = mysqli_fetch_assoc($fetchdistinctdate)){
  $distinct_dates = $rows['created_date'];
		  
		  	
		  
		  if($distinct_dates !=null){
			  
			   
			  
 $total_sum = $obj->selectData("sum(tbl_productdetails.total_price) as total_amounts","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id = tbl_customer.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0 and tbl_customer.created_date like '%$distinct_dates%'");	
 if(mysqli_num_rows($total_sum)>0){
	$total_price='';
			 $rowsdata = mysqli_fetch_assoc($total_sum);
	 $sum = $rowsdata['total_amounts'];
	if($sum !=null){
	
	$total_price = $sum;
}else{
	$total_price = 0;
	}	  
 }
			  
			  $lineData = array($distinct_dates,$total_price); 
			$excelData .= implode("\t", array_values($lineData)) . "\t"; 
			  
		  	 $dataArray[$x]['total_sum'] = $total_price;  
			  
			  
			  
		  $fetchdistincttaxpercentage = $obj->selectData("DISTINCT tbl_productdetails.tax_in_per","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id = tbl_customer.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0");
if(mysqli_num_rows($fetchdistincttaxpercentage)>0){
		$y=0;
	while($row = mysqli_fetch_assoc($fetchdistincttaxpercentage)){
		
		
		   $tax_id =$row['tax_in_per'];
		
		/*$tax_name[] = array(
    'tax_percent' => $tax_id,
    );*/
		 
		  
		
 $dataArray[$x]['product_details'][$y]['product_amount']=$row['product_amount'];
	$selectData = $obj->selectData("sum(tbl_productdetails.tax_data) as total_amount","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id = tbl_customer.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0 and tbl_productdetails.tax_in_per ='$tax_id' and tbl_customer.created_date like '%$distinct_dates%' ");	  

		  if(mysqli_num_rows($selectData)>0){
			  $total_amount=0;
		$maxidRow = mysqli_fetch_assoc($selectData);
	if($maxidRow !=null){
	$total_amount = $maxidRow['total_amount'];
}else{
	$total_amount = 0;
	}	  
		  }else{
			  
			  
 }
		
		
		$dataArray[$x]['tax_details'][$y]['tax_in_per']=$tax_id;
		$dataArray[$x]['tax_details'][$y]['taxpercent_totalamount']=round($total_amount,2);
	
		  $selectsum = $obj->selectData("sum(tbl_productdetails.total_price) as total_price","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id = tbl_customer.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0 and tbl_productdetails.tax_in_per ='$tax_id'and tbl_customer.created_date like '%$distinct_dates%'");	
	
		  if(mysqli_num_rows($selectsum)>0){
			  $total_price=0;
		$maxiRow = mysqli_fetch_assoc($selectsum);
	if($maxiRow !=null){
	$total_price =$maxiRow['total_price'];
}else{
	$total_price = 0;
	}	  
		  }else{
 }
		
		$dataArray[$x]['tax_details'][$y]['total_amnt']=round($total_price,2);
		  
		  
		$total_meds_price =  $total_price - $total_amount;
		  
		  
		  
		  
		  $cgst = $total_amount/2;
					$sgst = $total_amount/2;
					$dataArray[$x]['tax_details'][$y]['cgst']= round($cgst,2);
					$dataArray[$x]['tax_details'][$y]['sgst'] = round($sgst,2);
		  
		  
		 
		$dataArray[$x]['tax_details'][$y]['total_excluding_tax']=round($total_meds_price,2);
		
		
		 
	
	 
		  
		$lineData = array($dataArray[$x]['tax_details'][$y]['total_amnt'],$dataArray[$x]['tax_details'][$y]['cgst'],$dataArray[$x]['tax_details'][$y]['sgst'],$dataArray[$x]['tax_details'][$y]['total_excluding_tax']); 
      array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\t";
	
$y++;
}	
}else{

}
	
			  
		
		// exit();
		$dataArray[$x]['created_date']=$distinct_dates;
		  
			  
			 $lineData = array(); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";
	$sino++;
		 
		$x++;
			  
			  
		 

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