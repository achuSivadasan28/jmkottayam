<?php
session_start();
unset($_SESSION['lab_login_id']);
unset($_SESSION['lab_role']);
header('Location:../../../login.php')
?>