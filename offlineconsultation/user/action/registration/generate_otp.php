<?php
require_once '../../../_class/query.php';
$obj=new query();
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
$phn_number = $_POST['phn_number'];
$check_phn_number = $obj->selectData("phone_number","tbl_login","where status=1 and phone_number='$phn_number'");
if(mysqli_num_rows($check_phn_number)>0){
	unset($_SESSION['otp']);
	unset($_SESSION['phn_number']);
}else{
$_SESSION['phn_number'] = $phn_number;
//$otp = generateNumericOTP(6);
$otp = 123456;
$_SESSION['otp'] = $otp;
}
if($otp != 0){
echo 1;
}else {
	echo 0;
}
?>