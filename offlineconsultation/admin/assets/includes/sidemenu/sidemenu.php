<?php
session_start();
$super_admin_role = 0;
if($_SESSION['super_admin_role']){
	$super_admin_role = 1;
}
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$arr_size = sizeof($components);
$last_index = $arr_size-1;
$first_part = $components[$last_index];
$index_active = '';
$s_index_active = '';
$reports_active = '';
if($first_part == 'index.php' || $first_part == ''){
	$index_active = 'sidemenuLinkActive';
}else if($first_part == 'branch-management.php' || $first_part == 'edit-branch.php' || $first_part == 'add-branch.php'){
	$branch_active = 'sidemenuLinkActive';
}else if($first_part == 'department-management.php' || $first_part == 'add-department.php' || $first_part == 'edit-department.php'){
	$department_active = 'sidemenuLinkActive';
}else if($first_part == 'doctor-management.php' || $first_part == 'add-doctor.php' || $first_part == 'view-doctor.php' || $first_part == 'edit-doctor.php'){
	$doctor_active = 'sidemenuLinkActive';
}else if($first_part == 'appointments.php' || $first_part == 'view-appointment-details.php'){
	$appointment_active = 'sidemenuLinkActive';
}else if($first_part == 'staff-management.php' || $first_part == 'view-staff.php' || $first_part == 'edit-staff.php' || $first_part =='add-staff.php'){
	$staff_active = 'sidemenuLinkActive';
}else if($first_part == 'core-data.php' || $first_part == 'appointment-fee.php' || $first_part == 'appointment-slot.php' || $first_part == 'add-slot.php' || $first_part == 'edit-slot.php' || $first_part == 'core-data.php'){
	$core_active = 'sidemenuLinkActive';
}else if($first_part == 'profile.php'){
	$profile_active = 'sidemenuLinkActive';
}else if($first_part == 'change-password.php'){
	$changePwd_active = 'sidemenuLinkActive';
}else if($first_part == 'reports.php' || $first_part == 'patient_list.php' || $first_part == 'doctor-report.php'){
	$reports_active = 'sidemenuLinkActive';
}else if($first_part == 'nurse-station.php'){
	$nurse_active = 'sidemenuLinkActive';
}else if($first_part == 'lab-station.php'){
	$lab_active = 'sidemenuLinkActive';
}
?>
<!-- sidemenu  -->
<div class="sidemenu">
    
    <div class="sidemeuMain">
		<?php if($super_admin_role == 1){ ?>
	
		<h2>Super Admin </h2>
	<ul>
		<li>
            <a href="https://pala.jmwell.in/SuperAdmin/index.php" class="<?php //echo $s_index_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-create-dashboard"></i>
                </div>
                <p>Dashboard</p>
            </a>
        </li>
		<li>
            <a href="" class="<?php //echo $s_index_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-receipt-alt"></i>
                </div>
                <p>Billing Software</p>
            </a>
        </li>
		</ul>
		<?php } ?>
	<h2>Menu</h2>
		<ul>
        <li>
            <a href="index.php" class="<?php echo $index_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-estate"></i>
                </div>
                <p>Dashboard</p>
            </a>
        </li>
        <li>
            <a href="branch-management.php" class="<?php echo $branch_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-code-branch"></i>
                </div>
                <p>Branch</p>
            </a>
        </li>
        <li>
            <a href="department-management.php" class="<?php echo $department_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-clinic-medical"></i>
                </div>
                <p>Departments</p>
            </a>
        </li>
        <li>
            <a href="doctor-management.php" class="<?php echo $doctor_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-user-md"></i>
                </div>
                <p>Doctors</p>
            </a>
        </li>
        <li>
            <a href="appointments.php" class="<?php echo $appointment_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-calendar-alt"></i>
                </div>
                <p>Appointments</p>
            </a>
        </li>
			<li>
            <a href="reports.php" class="<?php echo $reports_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-file-graph"></i>
                </div>
                <p>Reports</p>
            </a>
        </li>
        <li>
            <a href="staff-management.php" class="<?php echo $staff_active;?>">
                <div class="sidemenuIcon">
                <i class="uil uil-users-alt"></i>
                </div>
                <p>Staff Management</p>
            </a>
        </li>
		<li>
            <a href="nurse-station.php" class="<?php echo $nurse_active;?>">
                <div class="sidemenuIcon">
                <i class="uil uil-user-nurse"></i>
                </div>
                <p>Nurse Station</p>
            </a>
        </li>
		<li>
            <a href="lab-station.php" class="<?php echo $lab_active;?>">
                <div class="sidemenuIcon">
                <i class="uil uil-user-nurse"></i>
                </div>
                <p>Lab Staff</p>
            </a>
        </li>
        <li>
            <a href="core-data.php" class="<?php echo $core_active;?>">
                <div class="sidemenuIcon">
                <i class="uil uil-server-network"></i>
                </div>
                <p>Core Data</p>
            </a>
        </li>
		<!--<li>
            <a target="_blank" href="https://pala.jmwell.in/SuperAdmin/index.php">
                <div class="sidemenuIcon">
                <i class="uil uil-head-side"></i>
                </div>
                <p>Super  Admin</p>
            </a>
        </li>-->
    </ul>
    <h2>Appearance</h2>
    <ul>
        <li>
            <a href="profile.php" class="<?php echo $profile_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-user"></i>
                </div>
                <p>Profile</p>
            </a>
        </li>
		<?php if($super_admin_role == 0){ ?>
        <li>
            <a href="change-password.php" class="<?php echo $changePwd_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-key-skeleton-alt"></i>
                </div>
                <p>Change Password</p>
            </a>
        </li>
	 <?php } ?>
        <li>
            <a href="tel:+919876543210">
                <div class="sidemenuIcon">
                    <i class="uil uil-question-circle"></i>
                </div>
                <p>Help ?</p>
            </a>
        </li>
		<?php if($super_admin_role == 1){ ?>
        <li>
            <a href="" id="logout">
                <div class="sidemenuIcon">
                    <i class="uil uil-sign-out-alt"></i>
                </div>
                <p>Log Out</p>
            </a>
        </li>
		<?php } else { ?>
		<li>
            <a href="action/logout/logout_action.php">
                <div class="sidemenuIcon">
                    <i class="uil uil-sign-out-alt"></i>
                </div>
                <p>Log Out</p>
            </a>
        </li>
		<?php } ?>
        
    </ul>
	</div>
    <div class="sidemenuFooter">
        <span>Version : 1.1</span>
        <span>Powered by Esight Business Solutions Pvt Ltd</span>
    </div>
</div>
<!-- sidemenu close -->