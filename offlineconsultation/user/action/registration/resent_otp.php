<?php
session_start();
$otp = 0;
function generateNumericOTP($n) {
    $generator = "1357902468";
    $result = "";
    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, (rand()%(strlen($generator))), 1);
    }
    return $result;
}
if(isset($_SESSION['phn_number'])){
$phn_number = $_SESSION['phn_number'];
//$otp = generateNumericOTP(6);
$otp = 123456;
$_SESSION['otp'] = $otp;
if($otp != 0){
echo 1;
}else {
	echo 0;
}
}else{
	echo 0;
}
?>