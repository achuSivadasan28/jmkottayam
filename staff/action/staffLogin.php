<?php
session_start();
include '../../_class/query.php';
$obj = new Query();
header('Content-type:application/json;charset=utf-8');
$data = json_decode(file_get_contents('php://input'),true);

$email= $data['email'];
$password=md5($data['Password']);
$loginAction=$obj->selectData("id,username,password,role,status","tbl_login","where username='$email' && password='$password'");
 if ( mysqli_num_rows( $loginAction ) > 0 ) {
  $loginActionRow = mysqli_fetch_array( $loginAction );

  if($loginActionRow['status'] == 2){
      echo 2;
  }
else if ( $loginActionRow['status'] == 0 ) { 
      echo 1;
  } else {
      $role = "";
      if ( $loginActionRow['role'] == 'staff' ) {
          $_SESSION['staffId'] = $loginActionRow['id'];
          $_SESSION['staffrole']  = $loginActionRow['role'];
          $_SESSION['staff']= $loginActionRow['id'];
          $role  = $_SESSION['staffrole'];
      } else if ( $loginActionRow['role'] == 'admin' ) {
          $_SESSION['adminLogId'] = $loginActionRow['loginId'];
          $_SESSION['adminrole']  = $loginActionRow['role'];
          $role = $_SESSION['adminrole'];
      } 
      echo $role;
  }
} else {
  echo 0;
}
  

    ?>
