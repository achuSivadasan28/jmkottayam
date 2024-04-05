<?php
require_once '../../_class/query.php';
$obj=new query();
$response_arr = array();
$customer_id = $_POST['customer_id'];
$apmnt_id=$_POST['bill_data'];
$select_customer_data = $obj->selectData("phone,customer_name","tbl_customer","where id=$customer_id");
if(mysqli_num_rows($select_customer_data)){
	$select_customer_data_row = mysqli_fetch_array($select_customer_data);
	$phone = $select_customer_data_row['phone'];
	$customer_name = $select_customer_data_row['customer_name'];
					/*	$headers = array();
						$headers[] = 'Content-Type: application/x-www-form-urlencoded';
						$headers[] = "Api-Key: Abee8be961d4edf4c2cfff0ab886f5540";
						//$headers[] = "Api-Key: $api_key";
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						$result = curl_exec($ch);
						if (curl_errno($ch)) {
    						$result1 =  'Error:' . curl_error($ch);
						}	
						$api_val = "Abee8be961d4edf4c2cfff0ab886f5540";
						$create_link = "https://feedback.jmwell.in/index.php?branch_id=5&&id=".$apmnt_id;
	$encoded_link = urlencode($create_link);
				
	$msg = 'Dear '.$customer_name.'.
		Your feedback is important to us.please use the following link to share your thoughts.'.'   '.$encoded_link.'  Please reply to this message to activate the link Johnmarians Hospital';
						$link = "https://api.bulkwhatsapp.net/wapp/api/send?apikey=".$api_val;*/
	

// API endpoint URL
$url = 'https://api.kaleyra.io/v1/HXIN1718319102IN/messages';

// Form data to be sent in the request
$data = [
    'to' => '91'.$phone,
    'from' => '918111869977',
    'channel' => 'whatsapp',
    'type' => 'mediatemplate',
    'template_name' => 'feedbacksms',
    'param_header' => ''.$customer_name.'', 
    'param_url' => 'index.php?branch_id=21&&id='.$apmnt_id.''
];

// API key in the request header
$headers = [
    'api-key: Abee8be961d4edf4c2cfff0ab886f5540'
];

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Encode the data as form data

// Execute the cURL request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    // Display the response from the API
    echo $response;
}

// Close the cURL session
curl_close($ch);


	
	
	
						
						//$response_arr[0]['link'] = $link;
	//$response_arr[0]['created_link'] = $create_link;
						$response_arr[0]['phn'] = $phone;
						//$response_arr[0]['sms'] = $msg;
						echo json_encode($response_arr);
	
}
?>