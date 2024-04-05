<?php
require_once '../../_class/query.php';
$obj=new query();
$select_invoice_code = $obj->selectData("main_code,branch_code","tbl_invoice_code","");
if(mysqli_num_rows($select_invoice_code)>0){
$select_invoice_code_row = mysqli_fetch_array($select_invoice_code);
$main_code = $select_invoice_code_row['main_code'];
$branch_code = $select_invoice_code_row['branch_code'];
$select_all_appointment = $obj->selectData("*","tbl_customer","where added_date='01-04-2023' ORDER BY id ASC");
$invoice_no = 1;
if(mysqli_num_rows($select_all_appointment)>0){
	while($select_all_appointment_row = mysqli_fetch_array($select_all_appointment)){
		$id = $select_all_appointment_row['id'];
		$main_code = $select_all_appointment_row['main_code'];
		$branch_code = $select_all_appointment_row['branch_code'];
		$invoice_num = $select_all_appointment_row['invoice_num'];
		
		$invoice_no++;
	}
}
}
?>
