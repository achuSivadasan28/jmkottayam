<?php
session_start();
require_once '../../_class/query.php';
$obj = new query();
header('Content-type:application/json;charset=utf-8');
$data = json_decode(file_get_contents('php://input'),true);

$email= $data['email'];
$password=md5($data['Password']);

 $loginAction=$obj->selectData("id,username,password,role,status","tbl_login","where username='$email' && password='$password' && status=1");

 if ( mysqli_num_rows( $loginAction ) > 0 ) {
  $loginActionRow = mysqli_fetch_array( $loginAction );
  if ( $loginActionRow['status'] == 0 ) {
      echo 1;
  } else {
      $role = "";
      if ( $loginActionRow['role'] == 'admin' ) {
        $_SESSION['adminLogId'] = $loginActionRow['id'];
        $_SESSION['adminrole']  = $loginActionRow['role'];
        $role = $_SESSION['adminrole'];
      } 
      echo $role;
  }
} else {
  echo 0;
}
  

    ?>
