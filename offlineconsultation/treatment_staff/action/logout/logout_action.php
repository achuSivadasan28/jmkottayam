<?php
session_start();
unset($_SESSION['staff_login_id']);
unset($_SESSION['staff_role']);
session_destroy();
header('Location:../../../login.php')
?>