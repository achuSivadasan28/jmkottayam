<?php
session_start();
unset($_SESSION['admin_login_id']);
unset($_SESSION['admin_role']);
header('Location:../../../index.php')
?>