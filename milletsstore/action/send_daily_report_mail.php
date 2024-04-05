<?php

//session_start();
//$adminLogId=$_SESSION['adminLogId'];
$connect=mysqli_connect("localhost","johnmarians_2","qh0o4Z&0","db_johnmarians_2");
date_default_timezone_set('Asia/Kolkata');
$days = date('d-m-Y');
require 'smtp/PHPMailerAutoload.php';
header('Content-type:application/json;charset=utf-8');
$data = json_decode(file_get_contents('php://input'),true);
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-y');
//$days=date('d-m-Y');
$times=date('h:i:s A');
$email = 'albin@esightsolutions.com';
$grand_total = 0;
$product_id_arr = array();
$response_arr = array();
$total_income = 0;
$select_todays_report = "SELECT id,customer_id,product_id,price,discount,no_quantity,total_price from tbl_productdetails where added_date='$days' and status!=0";
$select_todays_report_exe = mysqli_query($connect,$select_todays_report);
if(mysqli_num_rows($select_todays_report_exe)>0){
	$x = 0;
	while($select_todays_report_exe_row = mysqli_fetch_array($select_todays_report_exe)){
		$product_id = $select_todays_report_exe_row['product_id'];
		$price = $select_todays_report_exe_row['price'];
		$discount = $select_todays_report_exe_row['discount'];
		$quantity = $select_todays_report_exe_row['no_quantity'];
		$total_price_all = $select_todays_report_exe_row['total_price'];
		if(in_array($product_id,$product_id_arr)){
			$main_index = 0;
			$mult_arr_len = sizeof($response_arr);
			for($x1 = 0;$x1<$mult_arr_len;$x1++){
				$p_id = $response_arr[$x1]['product_id'];
				if($p_id == $product_id){
					$main_index = $x1;
					break;
				}
			}
			$total_quantity = $quantity+$response_arr[$main_index]['product_total_q'];
			$total_amt_details = $total_price_all;
			$total_price = $total_amt_details+$response_arr[$main_index]['product_total_price'];
			$total_income += $total_amt_details;
			$response_arr[$main_index]['product_total_q'] =  $total_quantity;
			$response_arr[$main_index]['product_total_price'] =  $total_price;
			$grand_total += $total_price;
		}else{
			$select_product_name = "Select product_name from tbl_product where id=$product_id";
			$select_product_name_exe = mysqli_query($connect,$select_product_name);
			if(mysqli_num_rows($select_product_name_exe)>0){
				$select_product_name_exe_row = mysqli_fetch_array($select_product_name_exe);
				$response_arr[$x]['date'] = $days;
				$response_arr[$x]['product_id'] = $product_id;
				$response_arr[$x]['product_name'] = $select_product_name_exe_row['product_name'];
				$response_arr[$x]['product_total_q'] =  $quantity;
				$total_amt_details = $total_price_all;
				$total_income += $total_amt_details;
				$response_arr[$x]['product_total_price'] =  $total_amt_details;
				$grand_total += $total_amt_details;
				}
			$x++;
			array_push($product_id_arr,$product_id);
		}
	}
}
$response_arr[0]['total_price'] = $total_income;

//total invoice
$select_all_total_invoice = "SELECT count(id) as id from tbl_customer where created_date='$days' and status!=0";
$select_all_total_invoice_exe = mysqli_query($connect,$select_all_total_invoice);
$select_all_total_invoice_exe_row = mysqli_fetch_array($select_all_total_invoice_exe);
if($select_all_total_invoice_exe_row['id'] != null){
	$response_arr[0]['total_invoice'] = $select_all_total_invoice_exe_row['id'];
}else{
	$response_arr[0]['total_invoice'] = 0;
}

//md5 conversion of password

//mail sending to staff
if(sizeof($response_arr) !=0){
	$response_len = sizeof($response_arr);
$mail = new PHPMailer(true);
try {
    //Server settings
$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
   $mail->SMTPDebug = 4;
	
	
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host       = 'esightsolutions.in';
  $mail->SMTPSecure = 'ssl';                   //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
  $mail->Username   = 'johnmarians@esightsolutions.in';                     //SMTP username
  $mail->Password   = '&s1b4o5D'; 
  $mail->SMTPAutoTLS = false;
  $mail->SMTPSecure = false;//SMTP password
  $mail->Port       = 25; 
  

        
      
    
    //Recipients
    $mail->setFrom('test@gmail.com', 'Test Email');
    $mail->AddAddress($email);
  


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'details';
    $template_val    = '
	<div style="width: 1200px; background: #004fff0d; padding: 50px;">
		<div style="Width: 100%; background: #1c9900; display: flex;"> 
			<div style="width: 50%;"> 
				<div style="width: 200px; padding: 20px;"> 
					<h1 style="color: white; font-size: 28px; font-weight: normal;">Johnmarians</h1>
				</div> 
			</div>
			<div style="width: 50%; padding: 20px;"> 
				<p style="text-align: right; font-size: 14px; line-height: 1.5; color: white;">31/410A, NELSON MANDELA ROAD, KOONAMTHAI,<br> EDAPPALLY ERNAKULAM Pin 682024</p> 
				<p style="text-align: right; font-size: 14px; line-height: 1.5; color: white;">Ph : 8086250300 | E-mail : johnmarians@gmail.com | Web : johnmarians.com</p> 
			</div> 
		</div>
		<div style="width: calc(100% - 25px); display: flex; background: white; padding: 25px 0 0px 25px;">
			<div style="width: 200px; margin-right: 20px; padding: 20px; border: 1px solid #d9d9d9; border-radius: 10px;">
				<h1 style="font-size: 22px; font-weight: 600; color: #1c9900; width: 100%; margin: 0;">₹ '.$grand_total.'</h1>
				<p style="font-size: 14px; font-weight: 500; margin-top: 10px; width: 100%; margin: 0;">Total Amount of bills</p>
			</div>
			<div style="width: 200px; margin-right: 20px; padding: 20px; border: 1px solid #d9d9d9; border-radius: 10px;">
				<h1 style="font-size: 22px; font-weight: 600; color: #1c9900; width: 100%; margin: 0;">'.$response_arr[0]['total_invoice'].'</h1>
				<p style="font-size: 14px; font-weight: 500; margin-top: 10px; width: 100%; margin: 0;">Total No.of bills</p>
			</div>
			<div style="width: 200px; margin-right: 20px; padding: 20px; border: 1px solid #d9d9d9; border-radius: 10px;">
				<h1 style="font-size: 22px; font-weight: 600; color: #1c9900; width: 100%; margin: 0;">'.$response_arr[0]['total_invoice'].'</h1>
				<p style="font-size: 14px; font-weight: 500; margin-top: 10px; width: 100%; margin: 0;">Total No.of patient</p>
			</div>
		</div>
		<div style="background: white; padding: 20px;">
			<table style="width: 100%;">
				<thead style="background: black;">
					<tr>
						<th style="color: white; padding: 12px; text-align: left;">Sl No</th>
						<th style="color: white; padding: 12px; text-align: left;">Products Name</th>
						<th style="color: white; padding: 12px; text-align: left;">Products Quantity</th>
						<th style="color: white; padding: 12px; text-align: left;">Amount</th>
					</tr>
				</thead>
				<tbody>';
	$siNo = 0;
		for($x2 = 0; $x2 < $response_len; $x2++){
			$siNo++;
			$template_val .= '<tr>
						<td style="padding: 12px;">'.$siNo.'</td>
						<td style="padding: 12px;">'.$response_arr[$x2]['product_name'].'</td>
						<td style="padding: 12px;">'.$response_arr[$x2]['product_total_q'].'</td>
						<td style="padding: 12px;">₹ '.$response_arr[$x2]['product_total_price'].'</td>
					</tr>';
		}
		$template_val .='
				</tbody>
			</table>
		</div>
	</div>
	
	';
	$mail->Body = $template_val;
    $mail->send();
    //echo 1;
} catch (Exception $e) {
    echo 1;
}
}
 
echo 0;


?>






