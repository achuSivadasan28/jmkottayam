<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$arr_size = sizeof($components);
$last_index = $arr_size-1;
$first_part = $components[$last_index];
$index_active = '';
$appointments = '';
$profile_data = '';
$offline_active = '';
$watting_active = '';
$appointment_active = '';
$all_appointment = '';
if($first_part == 'index.php' || $first_part == ''){
	$index_active = 'sidemenuLinkActive';
}else if($first_part == 'old-appointments.php' || $first_part == 'today-appointments.php' || $first_part == 'old-offline-appointments.php' || $first_part == 'view-appointment-details.php' || $first_part== 'edit-appointment.php'){
	$appointments = 'sidemenuLinkActive';
}else if($first_part == 'profile.php' || $first_part == 'edit-personal-details.php' || $first_part =='edit-professional-details.php'){
	$profile_data = 'sidemenuLinkActive';
}else if( $first_part == 'all-appointment.php'){
	$all_appointment = 'sidemenuLinkActive';
}else if($first_part == 'change-password.php'){
	$changePwd_active = 'sidemenuLinkActive';
}else if($first_part == 'offline-appointments.php'){
	$offline_active = 'sidemenuLinkActive';
}else if($first_part == 'offline-waiting-list.php'){
	$watting_active = 'sidemenuLinkActive';
}else if($first_part == 'appointments.php' || $first_part = 'add-appointment.php'){
	$appointment_active = 'sidemenuLinkActive';
}
	?>
<!-- sidemenu  -->
<div class="sidemenu">
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
            <a href="old-appointments.php" class="<?php echo $appointments;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-list-ol-alt"></i>
                </div>
                <p>Appointments</p>
            </a>
        </li>
        <li>
            <a href="offline-appointments.php" class="<?php echo $offline_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-calender"></i>
                </div>
                <p>Today's Appointments</p>
            </a>
        </li>
       <!-- <li>
            <a href="offline-waiting-list.php" class="<?php echo $watting_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-hourglass"></i>
                </div>
                <p>Waiting List</p>
            </a>
        </li>-->
		<!--<li>
            <a href="appointments.php" class="<?php echo $appointment_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-calendar-alt"></i>
                </div>
                <p>Take Appointments</p>
            </a>
        </li>-->
		<!--<li>
            <a href="all-appointment.php" class="<?php echo $all_appointment;?>">
                <div class="sidemenuIcon">
					<i class="uil uil-users-alt"></i>
                </div>
                <p>All Appointments</p>
            </a>
        </li>-->
    </ul>
    <h2 style="display: none;">Appearance</h2>
    <ul style="display: none;">
        <li>
            <a href="profile.php" class="<?php echo $profile_data;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-user"></i>
                </div>
                <p>Profile</p>
            </a>
        </li>
        <li>
            <a href="change-password.php" class="<?php echo $changePwd_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-key-skeleton-alt"></i>
                </div>
                <p>Change Password</p>
            </a>
        </li>
        <li>
            <a href="tel:+919876543210">
                <div class="sidemenuIcon">
                    <i class="uil uil-question-circle"></i>
                </div>
                <p>Help ?</p>
            </a>
        </li>
        <li>
            <a href="action/logout/logout_action.php">
                <div class="sidemenuIcon">
                    <i class="uil uil-sign-out-alt"></i>
                </div>
                <p>Log Out</p>
            </a>
        </li>
    </ul>
</div>
<!-- sidemenu close -->