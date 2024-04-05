<?php
$branch = 5;
$section = 'con';
require_once '../../../_class/query.php';
$obj=new query();
$response_arr = array();
date_default_timezone_set('Asia/Kolkata');
$days=date('Y-m-d');
$times=date('h:i:s A');

$choose_date = $_POST['choose_date'];
if($choose_date != ''){
$days = $choose_date;
}
$start_date = $days;
$end_date = '';
$where_date_clause = '';
$where_date_clause_tretment = '';
$where_date_online_clause = '';
$patient_num_online = 0;
$where_appointment_fee_mode = '';
$grand_total_appointment_fee = 0;
	if($start_date != '' and $end_date == ''){
		$where_date_clause = " and appointment_date='$start_date'";
		$start_date1 = date("d-m-Y", strtotime($start_date));
		$where_date_online_clause = "and appointment_taken_date='$start_date1'";
		$where_date_clause_tretment = " and added_date='$start_date1'";
		$where_appointment_fee_mode = " and tbl_appoinment_payment.addedDate='$start_date1'";
	}else if($end_date !='' and $start_date == ''){
		$where_date_clause = " and appointment_date='$end_date'";
		$end_date1 = date("d-m-Y", strtotime($end_date));
		$where_date_online_clause = "and appointment_taken_date='$end_date1'";
		$where_date_clause_tretment = " and added_date='$end_date1'";
		$where_appointment_fee_mode = " and tbl_appoinment_payment.addedDate='$end_date1'";
	}else if($start_date !='' and $end_date !=''){
		$new_start_Date = date("Y-m-d", strtotime($start_date));
		$new_end_Date = date("Y-m-d", strtotime($end_date));
		$End_new_Date = strtotime($new_end_Date);
		$start_new_Date = strtotime($new_start_Date);
		$date_diff = ($End_new_Date-$start_new_Date)/60/60/24;
		
		if($date_diff!=0){
			$where_date_clause = " and (";
			$where_date_clause_tretment = " and (";
			$where_date_online_clause = " and (";
			for($x1=0;$x1<=$date_diff;$x1++){
				$new_date = date('Y-m-d',strtotime($new_start_Date . ' +'.$x1.' day'));
				if($x1 == $date_diff){
					$where_date_clause .= "appointment_date='$new_date')";
					$where_date_clause_tretment .= "added_date='$new_date')";
					$where_date_online_clause .= "appointment_taken_date='$new_date')";
				}else{
					$where_date_clause .= "appointment_date='$new_date' or ";
					$where_date_clause_tretment .= "added_date='$new_date' or ";
					$where_date_online_clause .= "appointment_taken_date='$new_date' or ";
				}
			}
		}
	}
$x = 0;
$select_patient_list_offline = $obj->selectData("count(id) as id","tbl_appointment","where status!=0 and appointment_taken_type='Offline' and cross_branch_status=0 $where_date_clause");
		$select_patient_list_offline_row = mysqli_fetch_array($select_patient_list_offline);
		if($select_patient_list_offline_row['id'] != null){
			$response_arr[$x]['patient_num_offline'] = $select_patient_list_offline_row['id'];
		}
		$new_patient_count = 0;
		$select_patient_list_new_offline = $obj->selectData("id,patient_id","tbl_appointment","where appointment_taken_type='Offline' and status!=0 and old_patient!=1 and cross_branch_status=0 and appointment_fee=500 $where_date_clause");
		if(mysqli_num_rows($select_patient_list_new_offline)>0){
			while($select_patient_list_new_offline_row = mysqli_fetch_array($select_patient_list_new_offline)){
				$patient_id = $select_patient_list_new_offline_row['patient_id'];
				$appointment_id = $select_patient_list_new_offline_row['id'];
				$check_patient_id = $obj->selectData("count(id) as id","tbl_appointment","where patient_id=$patient_id and appointment_taken_type='Offline' and status!=0 and branch_id = real_branch_id and id<=$appointment_id");
				$check_patient_id_row = mysqli_fetch_array($check_patient_id);
				if($check_patient_id_row['id'] != null){
					if($check_patient_id_row['id'] == 1){
						$new_patient_count += 1;
					}
				}
			}
		}
		$select_patient_list_online = $obj->selectData("count(id) as id","tbl_appointment","where appointment_taken_type='online' and status!=0 and appointment_fee_status!=0 and cross_branch_status=0 $where_date_online_clause");
		$select_patient_list_online_row = mysqli_fetch_array($select_patient_list_online);
		if($select_patient_list_online_row['id'] != null){
			$patient_num_online = $select_patient_list_online_row['id'];
			//$response_arr[$x]['patient_num_online'] = $select_patient_list_online_row['id'];
		}else{
			$patient_num_online = 0;
		}
		$response_arr[$x]['patient_num_online'] = $patient_num_online;
		$response_arr[$x]['new_patient_count'] = $new_patient_count;
		$response_arr[$x]['old_patient_count'] =$response_arr[$x]['patient_num_offline']-$new_patient_count;
		
		
		$new_online_patient_count = 0;
		$select_patient_list_new_online = $obj->selectData("patient_id","tbl_appointment","where appointment_taken_type='online' and status!=0 and appointment_fee_status!=0 and cross_branch_status=0 $where_date_online_clause");
		if(mysqli_num_rows($select_patient_list_new_offline)>0){
			while($select_patient_list_new_online_row = mysqli_fetch_array($select_patient_list_new_online)){
				$patient_id = $select_patient_list_new_online_row['patient_id'];
				$check_patient_id_online = $obj->selectData("count(id) as id","tbl_appointment","where patient_id=$patient_id and appointment_taken_type='online' and status!=0 and appointment_fee_status!=0 and cross_branch_status=0 $where_date_online_clause");
				$check_patient_id_online_row = mysqli_fetch_array($check_patient_id_online);
				if($check_patient_id_online_row['id'] != null){
					if($check_patient_id_online_row['id'] == 1){
						$new_online_patient_count += 1;
					}
				}
			}
		}
		$response_arr[$x]['online_old_patient_count'] =$response_arr[$x]['patient_num_online']-$new_online_patient_count;
		$response_arr[$x]['new_online_patient_count'] = $new_online_patient_count;
//total_appointment_fee online
$total_online_appointment_fee = 0;
$select_patient_list_online_fee = $obj->selectData("sum(appointment_fee) as appointment_fee","tbl_appointment","where appointment_taken_type='online' and status!=0 and appointment_fee_status!=0 and cross_branch_status=0 $where_date_online_clause");
		$select_patient_list_online_fee_row = mysqli_fetch_array($select_patient_list_online_fee);
		if($select_patient_list_online_fee_row['appointment_fee'] != null){
			$response_arr[$x]['total_online_appointment_fee'] = $select_patient_list_online_fee_row['appointment_fee'];
			$total_online_appointment_fee = $select_patient_list_online_fee_row['appointment_fee'];
		}else{
			$response_arr[$x]['total_online_appointment_fee'] = 0;
		}

//total_appointment_fee
$total_offline_appointment_fee = 0;
$select_patient_list_offline_fee = $obj->selectData("sum(appointment_fee) as appointment_fee","tbl_appointment","where appointment_taken_type='Offline' and status!=0 and cross_branch_status=0 $where_date_clause");
		$select_patient_list_offline_row_fee = mysqli_fetch_array($select_patient_list_offline_fee);
		if($select_patient_list_offline_row_fee['appointment_fee'] != null){
			$response_arr[$x]['total_appointment_fee'] = $select_patient_list_offline_row_fee['appointment_fee'];
			$total_offline_appointment_fee = $response_arr[$x]['total_appointment_fee'];
		}else{
			$response_arr[$x]['total_appointment_fee'] = 0;
		}
$grand_total_appointment_fee = $total_offline_appointment_fee+$total_online_appointment_fee;
//fetch all new appointmet fee details
$select_new_patient_list_offline_fee = $obj->selectData("sum(appointment_fee) as appointment_fee","tbl_appointment","where status!=0 and appointment_taken_type='Offline' and appointment_fee='500' and cross_branch_status=0 $where_date_clause");
		$select_new_patient_list_offline_fee_row = mysqli_fetch_array($select_new_patient_list_offline_fee);
		if($select_new_patient_list_offline_fee_row['appointment_fee'] != null){
			$response_arr[$x]['total_new_appointment_fee'] = $select_new_patient_list_offline_fee_row['appointment_fee'];
		}else{
			$response_arr[$x]['total_new_appointment_fee'] = 0;
		}

$select_rv_patient_list_offline_fee = $obj->selectData("sum(appointment_fee) as appointment_fee","tbl_appointment","where status!=0 and appointment_taken_type='Offline' and appointment_fee!='500' and cross_branch_status=0 $where_date_clause");
		$select_rv_patient_list_offline_fee_row = mysqli_fetch_array($select_rv_patient_list_offline_fee);
		if($select_patient_list_offline_row_fee['appointment_fee'] != null){
			$response_arr[$x]['total_rv_appointment_fee'] = $select_rv_patient_list_offline_fee_row['appointment_fee'];
		}else{
			$response_arr[$x]['total_rv_appointment_fee'] = 0;
		}
if($response_arr[$x]['total_rv_appointment_fee'] != 0){
		$total_num_nr = $response_arr[$x]['total_rv_appointment_fee']/100;
	}else{
		$total_num_nr = 0;
	}

$total_re_visit = $response_arr[$x]['old_patient_count']-$total_num_nr;
$response_arr[$x]['total_num_nr'] = $total_num_nr;
$response_arr[$x]['total_re_visit'] = $total_re_visit;

$select_treatment_patient_list_offline_fee = $obj->selectData("sum(total_amt) as total_amt","tbl_treatment_invoice","where status!=0   $where_date_clause_tretment");
		$select_treatment_patient_list_offline_fee_row = mysqli_fetch_array($select_treatment_patient_list_offline_fee);
		if($select_treatment_patient_list_offline_fee_row['total_amt'] != NULL){
			$response_arr[$x]['total_treatment_appointment_fee'] = $select_treatment_patient_list_offline_fee_row['total_amt'];
		}else{
			$response_arr[$x]['total_treatment_appointment_fee'] = 0;
		}
$grand_total_appointment_fee += $response_arr[$x]['total_treatment_appointment_fee'];

$response_arr[0]['grand_total_appointment_fee'] = $grand_total_appointment_fee;

//sum of appointment fee paied in gpay mode
$select_gpay_mode = $obj->selectData("sum(tbl_appoinment_payment.payment_amnt) as payment_amnt","tbl_appoinment_payment  inner join tbl_appointment on tbl_appoinment_payment.apmnt_id=tbl_appointment.id","where tbl_appoinment_payment.payment_id=1 and tbl_appoinment_payment.status!=0 and tbl_appointment.status!=0 $where_appointment_fee_mode");
$select_gpay_mode_row = mysqli_fetch_array($select_gpay_mode);
if($select_gpay_mode_row['payment_amnt'] != null){
	$response_arr[$x]['ap_total_gpay'] = $select_gpay_mode_row['payment_amnt'];
}else{
	$response_arr[$x]['ap_total_gpay'] = 0;
}

//sum of appointment fee paied in Cash mode
$select_cash_mode = $obj->selectData("sum(tbl_appoinment_payment.payment_amnt) as payment_amnt","tbl_appoinment_payment  inner join tbl_appointment on tbl_appoinment_payment.apmnt_id=tbl_appointment.id","where tbl_appoinment_payment.payment_id=2 and tbl_appoinment_payment.status!=0 and tbl_appointment.status!=0 $where_appointment_fee_mode");
$select_cash_mode_row = mysqli_fetch_array($select_cash_mode);
if($select_cash_mode_row['payment_amnt'] != null){
	$response_arr[$x]['ap_total_cash'] = $select_cash_mode_row['payment_amnt'];
}else{
	$response_arr[$x]['ap_total_cash'] = 0;
}

//sum of appointment fee paied in card mode
$select_card_mode = $obj->selectData("sum(tbl_appoinment_payment.payment_amnt) as payment_amnt","tbl_appoinment_payment  inner join tbl_appointment on tbl_appoinment_payment.apmnt_id=tbl_appointment.id","where tbl_appoinment_payment.payment_id=3 and tbl_appoinment_payment.status!=0 and tbl_appointment.status!=0 $where_appointment_fee_mode");
$select_card_mode_row = mysqli_fetch_array($select_card_mode);
if($select_card_mode_row['payment_amnt'] != null){
	$response_arr[$x]['ap_total_card'] = $select_card_mode_row['payment_amnt'];
}else{
	$response_arr[$x]['ap_total_card'] = 0;
}

echo json_encode($response_arr);
?>
