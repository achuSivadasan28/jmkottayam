<?php
session_start();
if(isset($_SESSION['appointment_list'])){
	if($_SESSION['appointment_list'] == 1){
		echo 1;
	}else{
		echo 0;
	}
}else{
	echo 0;
}
?>