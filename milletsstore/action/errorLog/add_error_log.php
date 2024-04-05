<?php
require_once '../../../../class_error_log/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$added_date=date('d-m-Y');
$added_time=date('h:i:s A');
$issue_info=$_POST['issue_info'];
$priority_data=$_POST['priority_data'];
$branch_name=$_POST['branch_name'];
$admin_type=$_POST['admin_type'];
$baseUrl=$_POST['baseUrl'];
$file_input_val1=$_FILES['image']['name'];
$upload_dir = "../../assets/images/error_log/";
$file_input_file_val1=str_replace("'", "`", $file_input_val1);		
$ext = pathinfo($file_input_file_val1, PATHINFO_EXTENSION);
$file_name=pathinfo($file_input_file_val1, PATHINFO_FILENAME);	
$random_no=rand(0,100);
$file_val1=$file_name.'_'.$added_date.'_'.$added_time.'.'.$ext;
$path = $upload_dir . $file_val1;
compressFile($_FILES['image']['tmp_name'], $path, 55);
$info=[
"issue_info"=>$issue_info,
"priority_data"=>$priority_data,
"upload_img"=>$file_val1,
"branch_name"=>$branch_name,
"admin_type"=>$admin_type,
"baseurl"=>$baseUrl,	
"error_status"=>3,	
"added_date"=>$added_date,
"added_time"=>$added_time,
"status"=>1	
];
$insert=$obj->insertData("tbl_error_log",$info);

$select_max=$obj->selectData("max(id) as id","tbl_error_log","where status!=0 and added_date='$added_date' and added_time='$added_time' and branch_name='$branch_name' and admin_type='$admin_type'");
if(mysqli_num_rows($select_max)>0){
$select_max_row=mysqli_fetch_assoc($select_max);
	$error_id_val=$select_max_row['id'];
}

$info_remark=[
"action_perfomed"=>'Query submitted on',
"error_id_val"=>$error_id_val,	
"branch_name"=>$branch_name,
"admin_type"=>$admin_type,	
"added_date"=>$added_date,	
"added_time"=>$added_time,
"r_status"=>1,	
"status"=>1	
];
$insert_remark=$obj->insertData("tbl_remark",$info_remark);

$select_branch=$obj->selectData("branch_name,admin_type","tbl_error_log","where id=$error_id_val");
if(mysqli_num_rows($select_branch)>0){
	while($select_branch_row=mysqli_fetch_array($select_branch)){
	$project_from=$select_branch_row['branch_name'].' '.$select_branch_row['admin_type'];
	}
}

$phone_number='6282833642';
$mob_val = corrept_mob($phone_number);
function corrept_mob($mob){
	$code = '+91';
	$new_mob = '';
	if(strpos($mob, $code) !== false){
		$new_mob = $mob;
	} else{
			$code_sym = "91";
			$code_symb = "+";
		if(strpos($mob, $code_sym) !== false){
			 if(strpos($mob, $code_sym) !=0){
				$new_mob = $code.$mob;
			}else{
				 $new_mob = $code_symb.$mob;
			}
		}else{
			 $new_mob = $code.$mob;
		}
	   
	}
		return $new_mob;
	}
$user_name='Dr. Marian George';
$msg=" Hi $user_name,
You have received an error report from project $project_from.
Thanks %26 Regards,
Team ESIGHT";
$sender_id = "ESIGHT";
$ch = curl_init();
$SINO = 'HXIN1718319102IN';
$template_id = '1207170858240164136';
curl_setopt($ch, CURLOPT_URL, "https://api.kaleyra.io/v1/$SINO/messages");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "to=$mob_val&type=OTP&sender=$sender_id&body=$msg&template_id=$template_id");
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
$headers[] = "Api-Key: A9c926ea892613838ec202f9d1d1ab25b";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
   // $result1 =  'Error:' . curl_error($ch);
}
else{
	//echo 1;
}

echo 1;
function compressFile($source, $destination, $quaity)
{
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);
    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);
    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);
    elseif ($info['mime'] == 'image/webp')
        $image = imagecreatefromwebp($source);
    imagejpeg($image, $destination, $quaity);
}
?>