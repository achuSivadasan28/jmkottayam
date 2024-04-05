
<!-- sidemenu  -->
<?php
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
}
/**else if($first_part == 'reports.php' || $first_part == 'stock-analysis.php' || $first_part == 'top-selling-products.php' || $first_part == 'least-selling-products.php' || $first_part == 'invoice-reports.php'){
	$active_class_report = 'sidemenuLinkActive';
}else if($first_part == 'staff-management.php' || $first_part == 'edit-staff.php' || $first_part == 'add-staff.php'){
	$active_class_staff = 'sidemenuLinkActive';
}else if($first_part == 'profile.php' || $first_part == 'edit-profile.php'){
	$active_class_profile = 'sidemenuLinkActive';
}else if($first_part == 'change-password.php'){
	$active_class_chng_pwd = 'sidemenuLinkActive';
}else if($first_part == 'generate-bill.php'){
	$active_class_g_bill = 'sidemenuLinkActive';
}**/
?>
<div class="sidemenu">
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
                <p>Inventory Management</p>
            </a>
        </li>
        <!--<li>
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
        </li>-->
    </ul>
    <h2>Appearance</h2>
    <ul>
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
        <li>
            <a href="login.php" id="logout">
                <div class="sidemenuIcon">
                    <i class="uil uil-sign-out-alt"></i>
                </div>
                <p>Log Out</p>
            </a>
        </li>
    </ul>
    <div class="sidemenuFooter">
        <span>Version : 1.1</span>
        <span>Powered by Esight Business Solutions Pvt Ltd</span>
    </div>
</div>
<!-- sidemenu close -->