<?php

require_once '../../../_class/query.php';
$obj = new query();

date_default_timezone_set('Asia/Kolkata');
$current_date=date('d-m-Y');

$invoice_id= $_POST['invoice_id'];

$dataArray=[];

	

$fetch_main_details=$obj->selectData("id,appointment_id,patient_id,invoice_id,invoice_campain,addedDate,status","tbl_appointment_modeinvoice","where id=$invoice_id  and status = 1");
if(mysqli_num_rows($fetch_main_details)>0){
$x=0;
while($data=mysqli_fetch_array($fetch_main_details))
{
	
   $dataArray[$x]['id']=$data['id'];
   $dataArray[$x]['appointment_id']=$data['appointment_id'];
  $dataArray[$x]['patient_id']=$data['patient_id'];
  $dataArray[$x]['invoice_campain']=$data['invoice_campain'];
  $dataArray[$x]['addedDate']=$data['addedDate'];
	  
	
	$table_id = $data['id'];
	$patient_id=$data['patient_id'];
		$selectData1=$obj->selectData("id,name,patient_type","tbl_patient","where id=$patient_id");
$temp_name= mysqli_fetch_assoc($selectData1);
$patient_name=$temp_name['name'];
	$patient_t=$temp_name['patient_type'];
	
	$patient_type='';
	if($patient_t =='N')
	{
	$patient_type = 'New Patient';
	
	}
	else if($patient_t =='Renewal'){
		
	$patient_type = 'Renewal';
		
	}else{
		
	}
	
		$appointment_id=$data['appointment_id'];
		$selectappointment=$obj->selectData("id,appointment_fee","tbl_appointment","where id=$appointment_id");
$temperory_name= mysqli_fetch_assoc($selectappointment);
$appoinment_fee=$temperory_name['appointment_fee'];
	
   $dataArray[$x]['patient_name']=$patient_name;
	$dataArray[$x]['appointment_fee']=$appoinment_fee;
	$dataArray[$x]['patient_type']=$patient_type;
	 
	
	$selectsum=$obj->selectData("SUM(payment_amnt) AS total_payment","tbl_appoinment_payment","where tbl_apmnt_mode_payid=$table_id");
$paid= mysqli_fetch_assoc($selectsum);
$total_paid=$paid['total_payment'];
	$dataArray[$x]['total_paid']=$total_paid;
	$fetch_sub_details=$obj->selectData("id,tbl_apmnt_mode_payid,payment_id,apmnt_id,patient_id,payment_amnt,addedDate,status","tbl_appoinment_payment","where tbl_apmnt_mode_payid=$invoice_id  and  status = 1");
if(mysqli_num_rows($fetch_sub_details)>0){
$y=0;
while($row=mysqli_fetch_array($fetch_sub_details)){

		 

	
	$payment_id = $row['payment_id'];
	$payment_name='';
	if($payment_id == 1){
	$payment_name='Gpay';
	}else if($payment_id == 2){
	$payment_name='Cash';	
		
	}
	else if($payment_id == 3){
	$payment_name='Card';	
		
	}else{
	}
	
	
	
	
$dataArray[$x]['appoinment_details'][$y]['payment_id']=$payment_id;
 $dataArray[$x]['appoinment_details'][$y]['payment_name']=$payment_name;
$dataArray[$x]['appoinment_details'][$y]['patient_id']=$row['patient_id'];
$dataArray[$x]['appoinment_details'][$y]['apmnt_id']=$row['apmnt_id'];
	$dataArray[$x]['appoinment_details'][$y]['payment_amnt']=$row['payment_amnt'];
	$dataArray[$x]['appoinment_details'][$y]['addedDate']=$row['addedDate'];
					

	
	

$y++;	
}
}
	$x++;
		}
	
}

echo json_encode($dataArray);

?>