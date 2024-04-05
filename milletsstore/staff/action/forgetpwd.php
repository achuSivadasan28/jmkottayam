<?php
session_start();
include_once '../../_class/query.php';
require '../../admin/smtp/PHPMailerAutoload.php';
// include_once 'send_mailer.php';
$obj = new query();
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$time = date('h:i:s A');
$reaponse = array();
$data = json_decode(file_get_contents("php://input"),true);
$email = $data['email'];
//echo $email;

$check_user_exist = $obj->selectData("staff_log_id","tbl_login","where username='$email' and status=1");
if(mysqli_num_rows($check_user_exist)>0){
    $check_user_exist_row = mysqli_fetch_array($check_user_exist);
    $login_id = $check_user_exist_row['staff_log_id'];

  $select_staff_name = $obj->selectData("id,staff_name","tbl_staff","where id=$login_id and status=1");
    if(mysqli_num_rows($select_staff_name)>0){
        $select_staff_name_row = mysqli_fetch_array($select_staff_name);
        $staff_name = $select_staff_name_row['staff_name'];
       
    }
    $new_pwd = randomPassword(6);
    $new_pwd_security = md5($new_pwd);
    $update_new_pwd = array(
        "password" => $new_pwd_security
    );
    $obj->updateData("tbl_login",$update_new_pwd,"where staff_log_id=$login_id");

    send_forgot_pwd_email($email,$new_pwd,$staff_name);
    $reaponse[0]['status'] = 'success';
    $reaponse[0]['msg'] = 'your new password created successfully!';
}else{
    $reaponse[0]['status'] = 'error';
    $reaponse[0]['msg'] = '*User not found';
}
echo json_encode($reaponse);

function randomPassword($c) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $c; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}



function send_forgot_pwd_email($email,$new_pwd,$staff_name)
 {
 
    $mail = new PHPMailer(true);
    try {
        //Server settings
      //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        // $mail->SMTPDebug = 4;
    
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
        $mail->Subject = 'Password changed successfully';
        $mail->Body    = '
        <html>
  <head>
    <title></title>
  </head>
  <body>
    <h3>"New Password"</h3>
    <table >
<tr><td>Hai '.$staff_name.'</td></tr>
<tr><td>Your new password is '.$new_pwd.'</td></tr>
    </table>
  </body>
</html>
        ';
    
        $mail->send();
     //   echo 1;
    } catch (Exception $e) {
        echo 0;
    }


  }
    //return send_email($email, $subject, $body_heading, $body_content,'');


?>