<?php
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['admin_login_id']) and $_SESSION['admin_role'] == 'admin'){
$obj=new query();
$login_id = $_SESSION['admin_login_id'];
$api_key_value = $_SESSION['api_key_value'];
$admin_unique_code = $_SESSION['admin_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$admin_unique_code);
	//echo $check_security;exit();
	$version_variable = '';
$select_version = $obj->selectData("id,version_id","tbl_version","");
	if(mysqli_num_rows($select_version)){
	while($select_version_row = mysqli_fetch_array($select_version)){
$version_variable = $select_version_row['version_id'];
		
	}
	}
if($check_security == 1){
?>
<!DOCTYPE html>
<html lang="en">

    <!-- head -->
    <?php
        include "assets/includes/head/head.php";
    ?>
    <!-- head close -->

<body>
    
    <main>

        <!-- shimmer -->
        <div class="shimmer"></div>
        <!-- shimmer close -->
        
        <!-- dashboard  -->
        <section id="dashboard">

            <!-- nav -->
            <?php
                include "assets/includes/nav/nav.php";
            ?>
            <!-- nav close -->

            <!-- sidemenu  -->
            <?php
                include "assets/includes/sidemenu/sidemenu.php";
            ?>
            <!-- sidemenu close -->

            <!-- canvas  -->
            <div class="canvas">
            
                <!-- canvas head  -->
                <div class="canvasHead">
                    <div class="canvasHeadBox1">
                        <h1>Appointment Fee</h1>
                        <div class="breadCrumbs">
                            <a href="core-data.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="core-data.php">Core Data</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
                    <form action="" id="add_appointment">
                       
						
						 <div class="formGroup">
                            <label for="">Appointment Fee</label>
                            <input type="number" id="appointment" required>
                        </div>
						
						 <div class="formGroup">
                            <label for="">Appointment Renewal fee</label>
                            <input type="number" id="appointment_renewal_fee" required>
                        </div>

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down -->

                        <div class="formBtnArea">
                            <button id="appointment_fee_btn">Save</button>
                        </div>
                    </form>
                </div>
                <!-- form section close -->
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
                    <div class="consultAppointmentList">
                        <div class="tabcontent" style="display: block;">
                            <div class="consultAppointmentListTable">
                                <div class="consultAppointmentListTableBody">
                                    <div class="tableWraper">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Fee</th>
													<th>NR Fee</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <!-- <tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
                                                    </td>
                                                    <td data-label="Fee">
                                                        <p>₹ 150 <span class="ongoing">Ongoing</span></p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>03-08-2022</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Fee">
                                                        <p>₹ 150</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>03-08-2022</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>3</p>
                                                    </td>
                                                    <td data-label="Fee">
                                                        <p>₹ 150</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>03-08-2022</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>4</p>
                                                    </td>
                                                    <td data-label="Fee">
                                                        <p>₹ 150</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>03-08-2022</p>
                                                    </td>
                                                </tr>-->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="elseDesign">
                                        <div class="elseDesignthumbnail">
                                            <img src="assets/images/empty.png" alt="">
                                        </div>
                                        <p>No Data Available</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- consultingWindow close -->

            </div>
            <!-- canvas close -->

        </section>
        <!-- dashboard close -->

    </main>


    <!-- script  -->
        <?php
            include "assets/includes/script/script.php";
        ?>
	<script src="assets/appointmentFee/add-appointment.js?v=<?php echo $version_variable;?>"></script>
    <!-- script close -->

</body>
</html>
<?php
}else{
	header('Location:../login.php');
}
}else{
	header('Location:../login.php');
}	
?>