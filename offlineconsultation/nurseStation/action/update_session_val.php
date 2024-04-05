<?php
session_start();
$appointment_data = $_POST['appointment_data'];
$_SESSION['appointment_list'] = $appointment_data;
echo $_SESSION['appointment_list'];
?>