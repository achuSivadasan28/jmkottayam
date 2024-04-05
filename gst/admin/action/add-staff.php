<?php

//session_start();
//$adminLogId=$_SESSION['adminLogId'];
require_once '../../_class/query.php';
require '../smtp/PHPMailerAutoload.php';
$obj = new query();
header('Content-type:application/json;charset=utf-8');
$data = json_decode(file_get_contents('php://input'),true);
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-y');
//$days=date('d-m-Y');
$times=date('h:i:s A');


$staffname = $_POST['sname'];
$phonenum = $_POST['phone'];
$staffemail = $_POST['email'];
$branch = $_POST['branch'];
$role_data = $_POST['role_data'];
$login_id = 0;
$password = random_string(6);
$Staffpassword=md5($password);   //md5 conversion of password

$infor = array(
'username'=>$staffemail,
'password'=>$Staffpassword,
'role'=>'staff',
'status'=>1
);
//inserting staff login info to login table
$insertData=$obj->insertData("tbl_login",$infor);
$select_login_id = $obj->selectData("id","tbl_login","where username='$staffemail' and password='$Staffpassword' and role='staff' and status =1");
if(mysqli_num_rows($select_login_id)>0){
	while($select_login_id_row = mysqli_fetch_array($select_login_id)){
		$login_id = $select_login_id_row['id'];
	}
}
//branch_id
        $info = array(
			"staff_login" => $login_id,
            "created_date"=>$date,
            "time"=>$times,
            "staff_name"=>$staffname,
            "phone"=>$phonenum,
			"branch" => $branch,
			"email"=>$staffemail,
			"role" => $role_data,
			'status'=>1,
        );
        

        // inserting into database
        $insertData=$obj->insertData("tbl_staff",$info);
    
    
//generating random password
function random_string($length)
{
   $string = "";
   $chars = "abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   $size = strlen($chars);
   for ($i = 0; $i < $length; $i++) {
       $string .= $chars[rand(0, $size - 1)];
   }
   return $string; 
}





        

//mail sending to staff

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
    $mail->AddAddress($staffemail);
  


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'details';
    $mail->Body    = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

    <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
    <head>
    <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
    <meta content="width=device-width" name="viewport"/>
    <!--[if !mso]><!-->
    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
    <!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-->
    <link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css"/>
    <!--<![endif]-->
    <style type="text/css">
            body {
                margin: 0;
                padding: 0;
            }
    
            table,
            td,
            tr {
                vertical-align: top;
                border-collapse: collapse;
            }
    
            * {
                line-height: inherit;
            }
    
            a[x-apple-data-detectors=true] {
                color: inherit !important;
                text-decoration: none !important;
            }
        </style>
    <style id="media-query" type="text/css">
            @media (max-width: 620px) {
    
                .block-grid,
                .col {
                    min-width: 320px !important;
                    max-width: 100% !important;
                    display: block !important;
                }
    
                .block-grid {
                    width: 100% !important;
                }
    
                .col {
                    width: 100% !important;
                }
    
                .col_cont {
                    margin: 0 auto;
                }
    
                img.fullwidth,
                img.fullwidthOnMobile {
                    max-width: 100% !important;
                }
    
                .no-stack .col {
                    min-width: 0 !important;
                    display: table-cell !important;
                }
    
                .no-stack.two-up .col {
                    width: 50% !important;
                }
    
                .no-stack .col.num2 {
                    width: 16.6% !important;
                }
    
                .no-stack .col.num3 {
                    width: 25% !important;
                }
    
                .no-stack .col.num4 {
                    width: 33% !important;
                }
    
                .no-stack .col.num5 {
                    width: 41.6% !important;
                }
    
                .no-stack .col.num6 {
                    width: 50% !important;
                }
    
                .no-stack .col.num7 {
                    width: 58.3% !important;
                }
    
                .no-stack .col.num8 {
                    width: 66.6% !important;
                }
    
                .no-stack .col.num9 {
                    width: 75% !important;
                }
    
                .no-stack .col.num10 {
                    width: 83.3% !important;
                }
    
                .video-block {
                    max-width: none !important;
                }
    
                .mobile_hide {
                    min-height: 0px;
                    max-height: 0px;
                    max-width: 0px;
                    display: none;
                    overflow: hidden;
                    font-size: 0px;
                }
    
                .desktop_hide {
                    display: block !important;
                    max-height: none !important;
                }
            }
        </style>
    <style id="icon-media-query" type="text/css">
            @media (max-width: 620px) {
                .icons-inner {
                    text-align: center;
                }
    
                .icons-inner td {
                    margin: 0 auto;
                }
            }
        </style>
    </head>
    <body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: rgb(248, 252, 252); padding-bottom: 50px;">
    <!--[if IE]><div class="ie-browser"><![endif]-->
    <table bgcolor="rgb(248, 252, 252)" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: rgb(248, 252, 252); width: 100%;" valign="top" width="100%">
    <tbody>
    <tr style="vertical-align: top;" valign="top">
    <td style="word-break: break-word; vertical-align: top;" valign="top">
    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:rgb(248, 252, 252)"><![endif]-->
    <div style="background-color:transparent;">
    <div class="block-grid" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;">
    <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
    <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:transparent;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
    <div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
    <div class="col_cont" style="width:100% !important;">
    <!--[if (!mso)&(!IE)]><!-->
    <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
    <!--<![endif]-->
    <div class="mobile_hide">
    <table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
    <tbody>
    <tr style="vertical-align: top;" valign="top">
    <td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;" valign="top">
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="40" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 40px; width: 100%;" valign="top" width="100%">
    <tbody>
    <tr style="vertical-align: top;" valign="top">
    <td height="40" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    <!--[if (!mso)&(!IE)]><!-->
    </div>
    <!--<![endif]-->
    </div>
    </div>
    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
    </div>
    </div>
    </div>
    <div style="background-color:transparent;">
    <div class="block-grid" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: #FFFFFF;">
    <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:#FFFFFF"><![endif]-->
    <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#FFFFFF;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 35px; padding-left: 35px; padding-top:35px; padding-bottom:40px;"><![endif]-->
    <div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
    <div class="col_cont" style="width:100% !important;">
    <!--[if (!mso)&(!IE)]><!-->
    <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:35px; padding-bottom:40px; padding-right: 35px; padding-left: 35px;">
    <!--<![endif]-->
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
    <div style="color:#132F40;font-family:Cabin, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
    <div class="txtTinyMce-wrapper" style="font-size: 12px; line-height: 1.2; color: #132F40; font-family: Cabin, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
    <p style="margin: 0; font-size: 22px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 26px; margin-top: 0; margin-bottom: 0;"><span style="font-size: 20px;">Hello '.$staffname.', This is your login credantials</span></p>
    </div>
    </div>
    <!--[if mso]></td></tr></table><![endif]-->
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 30px; font-family: Arial, sans-serif"><![endif]-->
    <div style="color:#555555;font-family:Cabin, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:5px;padding-right:10px;padding-bottom:30px;padding-left:10px;">
    
    <!--[if mso]></td></tr></table><![endif]-->
    <div align="center" class="img-container center fixedwidth" style="padding-right: 0px;padding-left: 0px;">
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 0px;padding-left: 0px;" align="center"><![endif]--><img align="center" alt="Image" border="0" class="center fixedwidth" src="https://esightsolutions.in/johnmarians/billing1/admin/assets/images/email/login.jpg" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 350px; display: block;" title="Image" width="530"/>
    <!--[if mso]></td></tr></table><![endif]-->
    </div>
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 20px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
    <div style="color:#555555;font-family:Cabin, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:20px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
    <div class="txtTinyMce-wrapper" style="font-size: 12px; line-height: 1.2; color: #555555; font-family: Cabin, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
    <div class="txtTinyMce-wrapper" style="font-size: 12px; line-height: 1.5; color: #555555; font-family: Cabin, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;">
    <p style="margin: 0; font-size: 14px; line-height: 1.5; word-break: break-word; mso-line-height-alt: 21px; margin-top: 0; margin-bottom: 0;">Your Username and Password here.</p>
    </div>
    </div>
    <p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;"><br/><span style="font-size: 16px;">Your username is : <span style="color: #1100ff; font-size: 16px;"><strong>'.$staffemail
    .'</strong></span></span><span style="font-size: 16px;"></span></p>
    <p style="margin: 0; font-size: 16px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 19px; margin-top: 20px; margin-bottom: 0;"><span style="font-size: 16px;">Your Password is : <span style="color: #1100ff;"> <strong>'.$password.'</strong></span></span></p>
    </div>
    <div style="background-image:url("assets/images/email/bg_password.gif");background-position:top center;background-repeat:no-repeat;background-color:white;">
    <div class="block-grid no-stack" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: white;">
    <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-image:url("assets/images/email/bg_password.gif");background-position:top center;background-repeat:no-repeat;background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
    <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:transparent;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 35px; padding-left: 35px; padding-top:15px; padding-bottom:2px;"><![endif]-->
    <div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
    <div class="col_cont" style="width:100% !important;">
    <!--[if (!mso)&(!IE)]><!-->
    <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:15px; padding-bottom:2px; padding-right: 35px; padding-left: 35px;">
    <!--<![endif]-->
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 10px; padding-left: 10px; padding-top: 15px; padding-bottom: 15px; font-family: Arial, sans-serif"><![endif]-->
    <div style="color:#555555;font-family:Cabin, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:15px;padding-right:10px;padding-bottom:15px;padding-left:10px;">
    <div class="txtTinyMce-wrapper" style="font-size: 12px; line-height: 1.2; color: #555555; font-family: Cabin, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;">
    <p style="margin: 0; font-size: 16px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 19px; margin-top: 0; margin-bottom: 0;"><span style="font-size: 16px;">To finish signing up and <span style="color: #132f40; font-size: 16px;"><strong>activate your account </strong></span></span></p>
    <p style="margin: 0; font-size: 16px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 19px; margin-top: 0; margin-bottom: 0;"><span style="font-size: 16px;">you just need to set you password.</span></p>
    </div>
    </div>
    <!--[if mso]></td></tr></table><![endif]-->
    <div align="left" class="button-container" style="padding-top:5px;padding-right:10px;padding-bottom:35px;padding-left:10px;">
    <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-top: 5px; padding-right: 10px; padding-bottom: 35px; padding-left: 10px" align="left"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="sfs1india.com" style="height:31.5pt;width:186pt;v-text-anchor:middle;" arcsize="120%" stroke="false" fillcolor="rgb(3, 183, 123)"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#132F40; font-family:Arial, sans-serif; font-size:15px"><![endif]--><a href="https://jmwell.in" style="-webkit-text-size-adjust: none; text-decoration: none; display: inline-block; color: #132F40; background-color: rgb(3, 183, 123); border-radius: 50px; -webkit-border-radius: 50px; -moz-border-radius: 50px; width: auto; width: auto; border-top: 1px solid rgb(3, 183, 123); border-right: 1px solid rgb(3, 183, 123); border-bottom: 1px solid rgb(3, 183, 123); border-left: 1px solid rgb(3, 183, 123); padding-top: 5px; padding-bottom: 5px; font-family: Cabin, Arial, Helvetica Neue, Helvetica, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;" target="_blank"><span style="padding-left:40px;padding-right:40px;font-size:15px;display:inline-block;letter-spacing:undefined;"><span style="font-size: 16px; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;"><span data-mce-style="font-size: 15px; line-height: 30px;" style="font-size: 15px; line-height: 30px;"><span data-mce-style="line-height: 30px; font-size: 15px;" style="line-height: 30px; font-size: 15px; color: white;">Login Now</span></span></span></span></a>
    <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
    </div>
    <!--[if (!mso)&(!IE)]><!-->
    </div>
    <!--<![endif]-->
    </div>
    </div>
    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
    </div>
    </div>
    </div>
    <div style="background-color:transparent;">
    <div class="block-grid" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;">
    <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
    <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:transparent;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
    <div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
    <div class="col_cont" style="width:100% !important;">
    <!--[if (!mso)&(!IE)]><!-->
    <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
    <!--<![endif]-->
    <table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
    <tbody>
    <tr style="vertical-align: top;" valign="top">
    <td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;" valign="top">
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" height="30" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 30px; width: 100%;" valign="top" width="100%">
    <tbody>
    <tr style="vertical-align: top;" valign="top">
    <td height="30" style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    <!--[if (!mso)&(!IE)]><!-->
    </div>
    <!--<![endif]-->
    </div>
    </div>
    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
    <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
    </div>
    </div>
    </div>
    <div style="background-color:transparent;">
    <div class="block-grid" style="min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;">
    <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
    <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:transparent;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
    <div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
    <div class="col_cont" style="width:100% !important;">
    <!--[if (!mso)&(!IE)]><!-->
    <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
    <!--<![endif]-->
    <table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%">
    <tr style="vertical-align: top;" valign="top">
    <td align="center" style="word-break: break-word; vertical-align: top; padding-top: 5px; padding-right: 0px; padding-bottom: 5px; padding-left: 0px; text-align: center;" valign="top">
    <!--[if vml]><table align="left" cellpadding="0" cellspacing="0" role="presentation" style="display:inline-block;padding-left:0px;padding-right:0px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;"><![endif]-->
    <!--[if !vml]><!-->
    <table cellpadding="0" cellspacing="0" class="icons-inner" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;" valign="top">
    <!--<![endif]-->
    <!--<tr style="vertical-align: top;" valign="top">-->
    <!--<td align="center" style="word-break: break-word; vertical-align: top; text-align: center; padding-top: 5px; padding-bottom: 5px; padding-left: 5px; padding-right: 6px;" valign="top"><a href="https://www.designedwithbee.com/"><img align="center" alt="Designed with BEE" class="icon" height="32" src="https://esightsolutions.com/sfs1india/admin/assets/images/email/bee.png" style="border:0;" width="null"/></a></td>-->
 ';

    $mail->send();
    //echo 1;
} catch (Exception $e) {
    echo 1;
}
 
echo 0;


?>






