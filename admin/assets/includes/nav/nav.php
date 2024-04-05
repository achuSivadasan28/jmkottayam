<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$arr_size = sizeof($components);
$last_index = $arr_size-1;
$first_part = $components[$last_index];
if($first_part == 'index.php' || $first_part == ''){
	$active_class_index = 'Dashboard';
}else if($first_part == 'inventory-management.php'){
	$active_class_index = 'Inventory Management';
}else if($first_part == 'reports.php'){
	$active_class_index = 'Reports';
}else if($first_part == 'stock-analysis.php'){
	$active_class_index = 'Stock Analysis';
}else if($first_part == 'top-selling-products.php'){
	$active_class_index = 'Top Selling Products';
}else if($first_part == 'least-selling-products.php'){
	$active_class_index = 'Least Selling Products';
}else if($first_part ==   'invoice-reports.php'){
	$active_class_index = 'Invoice Report';
}else if($first_part ==   'daily-reports.php'){
	$active_class_index = 'Daily reports';
}else if($first_part ==   'inner-daily-reports.php'){
	$active_class_index = 'Inner Daily Reports';
}else if($first_part ==   'daily-reports.php'){
	$active_class_index = 'Daily Reports';
}else if($first_part ==   'cancelled-reports.php'){
	$active_class_index = 'Cancelled Reports';
}else if($first_part ==   'category.php'){
	$active_class_index = 'Category';
}else if($first_part ==   'view-category.php'){
	$active_class_index = 'View Category';
}else if($first_part ==   'edit-category.php'){
	$active_class_index = 'Edit Category';
}else if($first_part ==   'add-category.php'){
	$active_class_index = 'Add Category';
}else if($first_part ==   'products.php'){
	$active_class_index = 'Products';
}else if($first_part ==   'edit-product.php'){
	$active_class_index = 'Edit Product';
}else if($first_part ==   'add-products.php'){
	$active_class_index = 'Add Products';
}else if($first_part ==   'stock_activity.php'){
	$active_class_index = 'Stock Activity';
}
else if($first_part == 'customer-details.php'){
	$active_class_index = 'Customer Details';
}

else if($first_part == 'staff-management.php'){
	$active_class_index = 'Staff Management';
}
else if($first_part == 'view-customer-details.php'){
	$active_class_index = 'View Customer Details';
}
else if($first_part == 'edit-customer-details.php'){
	$active_class_index = 'Edit Customer Details';
}
else if($first_part == 'staff-management.php'){
	$active_class_index = 'Staff Management';
}else if($first_part == 'edit-staff.php'){
	$active_class_index = 'Edit Staff';
}else if($first_part == 'add-staff.php'){
	$active_class_index = 'Add Staff';
}else if($first_part == 'profile.php'){
	$active_class_index = 'Profile';
}else if($first_part == 'edit-profile.php'){
	$active_class_index = 'Edit Profile';
}else if($first_part == 'change-password.php'){
	$active_class_index = 'Change Password';
}else if($first_part == 'generate-bill.php'){
	$active_class_index = 'Generate Bill';
}else if($first_part == 'settings.php'){
	$active_class_index = 'Settings';
}else if($first_part == 'patient-list.php'){
	$active_class_index = 'Patients List';
}else if($first_part == 'payment-option.php'){
	$active_class_index = 'Payment Option';
}else if($first_part == 'add-api.php'){
	$active_class_index = 'WhatsappApi';
}else if($first_part == 'add-whatsapp-api.php'){
	$active_class_index = 'Add WhatsappApi';
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
                    <img src="assets/images/doctorAvatar.png" alt="">
                </div>
                <div class="navProfileName">
                    <p></p>
                  
                </div>
            </div>
			<div class="navDropDown">
				<a href="settings.php">
					<span><i class="uil uil-setting"></i></span>
					<p>Settings</p>
				</a>
				<a href="profile.php">
					<span><i class="uil uil-user"></i></span>
					<p>Profile</p>
				</a>
				<a href="change-password.php">
					<span><i class="uil uil-key-skeleton-alt"></i></span>
					<p>Change Password</p>
				</a>
				<a href="tel:+919876543210">
					<span><i class="uil uil-question-circle"></i></span>
					<p>Help ?</p>
				</a>
				<a href="" id="logout">
					<span><i class="uil uil-sign-out-alt"></i></span>
					<p>Log Out</p>
				</a>
			</div>
        </div>
    </div>
</div>
