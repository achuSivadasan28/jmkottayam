<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days1 = $_POST['date'];
$days = date("Y-m-d", strtotime($days1));
$response_arr = array();
 $dataArray = [];

/*
$startDate_url        =   $_GET['startdate'];
$startDate_new_format =   date("d-m-Y", strtotime($startDate_url));
$start_date            =   strtotime($startDate_new_format);
$EndDate_url          =   $_GET['enddate'];
$EndDate_new_format   =   date("d-m-Y", strtotime($EndDate_url));
$end_date              =   strtotime($EndDate_new_format);
$date_diff            = 0;
$date_where_clause    = '';*/

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


/* $fetchdistincttaxpercentage = $obj->selectData("DISTINCT tbl_productdetails.tax_in_per","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id = tbl_customer.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0 $date_where_clause");*/


/* $fetchdistinctdate = $obj->selectData("DISTINCT DATE_FORMAT(`created_date`, '%d-%m-%Y') AS formatted_date,status", "tbl_customer", "Where status!=0 $where_search_date"); */
 /*$fetchdistinctdate = $obj->selectData("DISTINCT created_date,status", "tbl_customer", "Where  status!=0 $where_search_date");*/
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
		  	 $dataArray[$x]['total_sum'] = $total_price;  
			  
			  
			  
		  $fetchdistincttaxpercentage = $obj->selectData("DISTINCT tbl_productdetails.tax_in_per","tbl_productdetails INNER JOIN tbl_customer on tbl_productdetails.customer_id = tbl_customer.id","where tbl_customer.status!=0 and tbl_productdetails.status!=0");
if(mysqli_num_rows($fetchdistincttaxpercentage)>0){
		 $y=0;
	while($row = mysqli_fetch_assoc($fetchdistincttaxpercentage)){
		   $tax_id =$row['tax_in_per'];
		 
		  
		
 //$dataArray[$x]['product_details'][$y]['product_amount']=$row['product_amount'];
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
		
		
		
		$dataArray[$x]['tax_details'][$y]['tax_in_per']=$tax_id;
		$dataArray[$x]['tax_details'][$y]['taxpercent_totalamount']=round($total_amount,2);
		$dataArray[$x]['tax_details'][$y]['total_amnt']=round($total_price,2);
		  
		  
		$total_meds_price =  $total_price - $total_amount;
		  
		  
		  
		  
		  $cgst = $total_amount/2;
					$sgst = $total_amount/2;
					$dataArray[$x]['tax_details'][$y]['cgst']= round($cgst,2);
					$dataArray[$x]['tax_details'][$y]['sgst'] = round($sgst,2);
		  
		  
		 
		 $dataArray[$x]['tax_details'][$y]['total_excluding_tax']=round($total_meds_price,2);
		   
		/*  $dataArray[$x]['total_taxable_value']=round($total_meds_price,2);
		    $dataArray[$x]['total_amnt']=round($total_price,2);*/
		  
		  
	 
$y++;
}	
}else{

}
		 
		  $dataArray[$x]['created_date']=$distinct_dates;
		  
		 
		 $x++; 
		  
	  }
	}
 }
	

    echo json_encode($dataArray);
?>