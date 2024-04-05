<?php
require_once 'action/sidemenu/sidemenu.php';
require_once '../_class/query.php';
$obj=new query();
$staff_name = fetch_user_name($_SESSION['admin_login_id'],$obj);

$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$arr_size = sizeof($components);
$last_index = $arr_size-1;
$first_part = $components[$last_index];
if($first_part == 'index.php' || $first_part == ''){
	$active_class_index = 'Dashboard';
}else if($first_part == 'branch-management.php'){
	$active_class_index = 'Branch Management';
}else if($first_part == 'add-branch.php'){
	$active_class_index = 'Add Branch';
}else if($first_part == 'edit-branch.php'){
	$active_class_index = 'Edit Branch';
}else if($first_part == 'department-management.php'){
	$active_class_index = 'Department Management';
}else if($first_part == 'edit-department.php'){
	$active_class_index = 'Edit Department';
}else if($first_part ==   'add-department.php'){
	$active_class_index = 'Add Department';
}else if($first_part ==   'doctor-management.php'){
	$active_class_index = 'Doctor Management';
}else if($first_part ==   'add-doctor.php'){
	$active_class_index = 'Add Doctor';
}else if($first_part ==   'edit-doctor.php'){
	$active_class_index = 'Edit Doctor';
}else if($first_part ==   'appointments.php'){
	$active_class_index = 'Appointments';
}else if($first_part ==   'staff-management.php'){
	$active_class_index = 'Staff Management';
}else if($first_part ==   'add-staff.php'){
	$active_class_index = 'Add Staff';
}else if($first_part ==   'edit-staff.php'){
	$active_class_index = 'Edit Staff';
}else if($first_part ==   'core-data.php'){
	$active_class_index = 'Core Data';
}else if($first_part ==   'appointment-fee.php'){
	$active_class_index = 'Appointment Fee';
}else if($first_part ==   'appointment-slot.php'){
	$active_class_index = 'Appointment Slot';
}else if($first_part ==   'add-slot.php'){
	$active_class_index = 'Add Slot';
}else if($first_part ==   'change-password.php'){
	$active_class_index = 'Change Password';
}else if($first_part ==   'reports.php'){
	$active_class_index = 'Reports';
}else if($first_part ==   'patient_list.php'){
	 $active_class_index = 'Patients List';
}


?>
<div class="nav">
    <div class="container">
        <a href="index.php" class="navLogo">
            <img src="assets/images/johnmariansLogo.png" alt="">
        </a>
        <div class="navBar">
            <div class="navBarBox">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
		<div class="navHeadBox1">
			<h1><?php echo $active_class_index;?></h1>
			<div class="breadCrumbs">
				<!---<a href="settings.php" class="back"><i class="uil uil-angle-left-b"></i></a>
				<!---<span>/</span>
				<a href="settings.php">Settings</a>--->
			</div>
		</div>
        <div class="navProfile">
            <div class="navProfileBox">
                <div class="navProfileThumbnail">
                    <img src="assets/images/avatarOrange.png" alt="">
                </div>
                <div class="navProfileName">
                    <p><?php echo $staff_name;?></p>
                    <span>admin</span>
                </div>
            </div>
        </div>
    </div>
</div>