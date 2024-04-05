<?php 
session_start();
if(isset($_SESSION['adminLogId'])){
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

        <!-- delete alert  -->
        <div class="deleteAlert">
            <div class="deleteAlertMian">
                <div class="deleteAlertThumbnail">
                    <img src="assets/images/icon/delete-alert.gif" alt="">
                </div>
                <div class="deleteAlertContent">
                    <p>Do you want to delete ?</p>
                    <div class="deleteAlertBtnArea">
                        <div class="closedeleteAlert">No</div>
                        <div class="confirmdeleteAlert">Delete</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- delete alert close -->
        
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
                        <h1>Whatsapp API</h1>
                        <div class="breadCrumbs">
                            <a href="settings.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="settings.php">Settings</a>
                        </div>
                    </div><div class="canvasHeadBox2">
                        <a href="add-whatsapp-api.php" class="addBtn">Add Whatsapp API</a>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
                    <div class="consultAppointmentList">
                        <div class="tabcontent" style="display: block;">
                            <div class="consultAppointmentListTable">
                                <div class="consultAppointmentListTableHead">
                                    <!--<div class="searchBox">
                                        <input type="search" placeholder="Search..." id="search_val">
                                        <button type="submit" id="search_btn"><i class="uil uil-search"></i></button>
                                    </div>-->
                                </div>
                                <div class="consultAppointmentListTableBody">
                                    <div class="tableWraper">
										<div class="sckelly">
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>

											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
										</div>
                                        <table id="tbl_details_api">
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>API</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <!--<tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
                                                    </td>
                                                    <td data-label="Payment Option">
                                                        <p>Google Pay</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="tableDeleteBtn" title="Delete">
                                                                <i class="uil uil-trash"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Payment Option">
                                                        <p>Phone Pay</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="tableDeleteBtn" title="Delete">
                                                                <i class="uil uil-trash"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>3</p>
                                                    </td>
                                                    <td data-label="Payment Option">
                                                        <p>Cash</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="tableDeleteBtn" title="Delete">
                                                                <i class="uil uil-trash"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>4</p>
                                                    </td>
                                                    <td data-label="Payment Option">
                                                        <p>Debit Card</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="tableDeleteBtn" title="Delete">
                                                                <i class="uil uil-trash"></i>
                                                            </div>
                                                        </div>
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
    <!-- script close -->
	<script src="js/add_api.js"></script>
    <script>
	
		//sckelly
		$(window).load(function() {
			 $('.sckelly').css({
				display: 'none',
			 });
		});

    </script>
</body>
</html>
<?php
}else{
header('Location:../login.php');
}
?>