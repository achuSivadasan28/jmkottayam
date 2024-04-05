<?php
function appointment_success_sms($number,$name,$token_num,$date){
	$msg = "Hi $name, Your Appointment has been successfully placed.Token number : $token_num Date : $date For assistance call : 7994885474 Thanks.";
$mob = $number;
$code = '+91';
$new_mob = '';
if(strpos($mob, $code) !== false){
    $new_mob = $mob;
} else{
		$code_sym = "91";
		$code_symb = "+";
	if(strpos($mob, $code_sym) !== false){
		 $new_mob = $code_symb.$mob;
	}else{
		 $new_mob = $code.$mob;
	}
   
}
$sender_id = "JMWELL";
$ch = curl_init();
$SINO = 'HXIN1718319102IN';
$template_id = '1207166091433110178';
$api_key = 'Ae337f3425f337d8fbc9810ad3f812091';
curl_setopt($ch, CURLOPT_URL, "https://api.kaleyra.io/v1/$SINO/messages");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "to=$new_mob&type=OTP&sender=$sender_id&body=$msg&template_id=$template_id");

$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
$headers[] = "Api-Key: $api_key";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
	return $result;
if (curl_errno($ch)) {
    $result1 =  'Error:' . curl_error($ch);
}
 return curl_close($ch);
}

?>