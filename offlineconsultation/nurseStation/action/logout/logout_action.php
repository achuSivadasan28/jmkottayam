<?php
session_start();
unset($_SESSION['doctor_login_id']);
unset($_SESSION['doctor_role']);
header('Location:../../../login.php')
?>