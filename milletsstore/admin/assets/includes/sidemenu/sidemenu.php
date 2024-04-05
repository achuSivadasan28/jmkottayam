
<!-- sidemenu  -->
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
if($first_part == 'index.php' || $first_part == ''){
	$active_class_index = 'sidemenuLinkActive';
}else if($first_part == 'inventory-management.php' || $first_part == 'category.php' || $first_part == 'view-category.php' || $first_part == 'edit-category.php' || $first_part == 'add-category.php' || $first_part == 'products.php' || $first_part == 'edit-product.php' || $first_part == 'add-products.php'){
	$active_class_inventory = 'sidemenuLinkActive';
}else if($first_part == 'reports.php' || $first_part == 'stock-analysis.php' || $first_part == 'top-selling-products.php' || $first_part == 'least-selling-products.php' || $first_part == 'invoice-reports.php' || $first_part == 'daily-reports.php' || $first_part == 'inner-daily-reports.php' || $first_part == 'cancelled-reports.php' || $first_part == 'stock_activity.php'){
	$active_class_report = 'sidemenuLinkActive';
}else if($first_part == 'staff-management.php' || $first_part == 'edit-staff.php' || $first_part == 'add-staff.php'){
	$active_class_staff = 'sidemenuLinkActive';
}else if($first_part == 'profile.php' || $first_part == 'edit-profile.php'){
	$active_class_profile = 'sidemenuLinkActive';
}else if($first_part == 'change-password.php'){
	$active_class_chng_pwd = 'sidemenuLinkActive';
}else if($first_part == 'generate-bill.php'){
	$active_class_g_bill = 'sidemenuLinkActive';
}else if($first_part == 'settings.php' || $first_part == 'add-api.php' || $first_part == 'add-whatsapp-api.php' || $first_part == 'payment-option.php' || $first_part == 'payment-option.php' || $first_part =='add-payment-option.php'){
	$active_class_settings = 'sidemenuLinkActive';
}else if($first_part == 'patient-list.php'){
	$active_class_patient_list = 'sidemenuLinkActive';
}else if($first_part == 'error-log.php' || $first_part == 'add-error-log.php'){
	$error_active = 'sidemenuLinkActive';
}
?>
<div class="sidemenu">
	<div class="sidemenuMain">
	<?php if($super_admin_role == 1){ ?>
	<h2>Super Admin</h2>
    <ul>
        <li>
            <a href="https://jmwell.in/SuperAdmin/home.php" class="<?php //echo $active_class_index;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-estate"></i>
                </div>
                <p>Dashboard</p>
            </a>
        </li>
		<li>
            <a href="https://jmwell.in/offlineconsultation/demo1/admin/" class="<?php //echo $active_class_index;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-estate"></i>
                </div>
                <p>Consultation Software</p>
            </a>
        </li>
	</ul>
	<?php } ?>
    <h2>Menu</h2>
    <ul>
        <li>
            <a href="index.php" class="<?php echo $active_class_index;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-estate"></i>
                </div>
                <p>Dashboard</p>
            </a>
        </li>
        <li>
            <a href="inventory-management.php" class="<?php echo $active_class_inventory;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-medkit"></i>
                </div>
                <p>Millets Inventory</p>
            </a>
        </li>
        <li>
            <a href="generate-bill.php" class="<?php echo $active_class_g_bill;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-invoice"></i>
                </div>
                <p>Generate Bill</p>
            </a>
        </li>
        <li>
            <a href="reports.php" class="<?php echo $active_class_report;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-file-graph"></i>
                </div>
                <p>Reports</p>
            </a>
        </li>
        <li>
            <a href="staff-management.php" class="<?php echo $active_class_staff;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-users-alt"></i>
                </div>
				<p>Staff Management</p>
			</a>
		</li>

		<li>
			<a href="error-log.php" class="<?php echo $error_active;?>">
				<div class="sidemenuIcon">
					<i class="uil uil-exclamation-triangle"></i>
				</div>
				<p>Error Log</p>
			</a>
		</li>
		<!--	<li>
			<a href="patient-list.php" class="<?php echo $active_class_patient_list;?>">
				<div class="sidemenuIcon">
					<i class="uil uil-accessible-icon-alt"></i>
				</div>
				<p>Patient List</p>
			</a>
		</li> -->
		</ul>
    <h2 style="display: none;">Appearance</h2>
    <ul style="display: none;">
        <li>
            <a href="settings.php" class="<?php echo $active_class_settings;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-setting"></i>
                </div>
                <p>Settings</p>
            </a>
        </li>
        <li>
            <a href="profile.php" class="<?php echo $active_class_profile;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-user"></i>
                </div>
                <p>Profile</p>
            </a>
        </li>
        <li>
            <a href="change-password.php" class="<?php echo $active_class_chng_pwd;?>">
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
		<?php if($super_admin_role == 1){ ?>
        <li>
            <a href="https://jmwell.in/SuperAdmin/action/logout_action.php" id="logout">
                <div class="sidemenuIcon">
                    <i class="uil uil-sign-out-alt"></i>
                </div>
                <p>Log Out</p>
            </a>
        </li>
		<?php } else { ?>
		<li>
            <a href="login.php" id="logout">
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