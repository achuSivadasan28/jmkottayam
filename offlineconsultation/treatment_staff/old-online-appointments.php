<?php
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['doctor_login_id']) and $_SESSION['doctor_role'] == 'doctor'){
$login_id = $_SESSION['doctor_login_id'];
$obj = new query();
$api_key_value = $_SESSION['api_key_value_doctor'];
$staff_unique_code = $_SESSION['doctor_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
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
        
        <!-- profile Details Popup  -->
        <div class="profileDetailsPopup">
            <div class="profileDetailsPopupMain">
                <div class="profileDetailsPopupBox1">
                    <div class="profileDetailsHead">
                        <div class="UniqueId">
                            <span>AKR120622</span>
                        </div>
                        <h1>Muhammed Afsal K T</h1>
                    </div>
                    <div class="totalVisit">
                        <span>Total Visit : <b>5</b></span>
                    </div>
                    <div class="profileDetailsBody">
                        <ul>
                            <li>
                                <span>Age <b>:</b></span>
                                <p>24</p>
                            </li>
                            <li>
                                <span>Gender <b>:</b></span>
                                <p>Male</p>
                            </li>
                            <li>
                                <span>Phone <b>:</b></span>
                                <p>7356339750</p>
                            </li>
                            <li>
                                <span>Address <b>:</b></span>
                                <p>Kottiyottuthodi (H)</p>
                            </li>
                            <li>
                                <span>Place <b>:</b></span>
                                <p>Palakkadu</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="profileDetailsPopupBox2">
                    <h2>Comments <i class="uil uil-angle-down"></i></h2>
                    <div class="commentsPopupPreviousList">
                        <dl>
                            <dt class="PreviousListDate">
                                <span>06-07-2022</span>
                            </dt>
                            <dd class="commentsPopupPreviousBox">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
                            </dd>
                            <dd class="commentsPopupPreviousBox">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
                            </dd>
                            <dd class="commentsPopupPreviousBox">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
                            </dd>
                            <dt class="PreviousListDate">
                                <span>05-07-2022</span>
                            </dt>
                            <dd class="commentsPopupPreviousBox">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
                            </dd>
                            <dd class="commentsPopupPreviousBox">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
                            </dd>
                            <dd class="commentsPopupPreviousBox">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
                            </dd>
                            <dd class="commentsPopupPreviousBox">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
                            </dd>
                        </dl>
                        <div class="elseDesign">
                            <div class="elseDesignthumbnail">
                                <img src="assets/images/empty.png" alt="">
                            </div>
                            <p>No Previous Comments</p>
                        </div>
                    </div>
                    <div class="profileDetailsPopupBtnArea">
                        <div class="closeProfileDetailsPopup">Close</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- profile Details Popup close -->
        
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
                        <h1>Old Online Appointments</h1>
                        <div class="breadCrumbs">
                            <a href="old-appointments.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="old-appointments.php">Old Appointments</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
                    <div class="consultAppointmentList">
                        <div class="tabcontent" style="display: block;">
                            <div class="consultAppointmentListTable">
                                <div class="consultAppointmentListTableHead">
                                    <div class="searchBox">
                                        <input type="search" placeholder="Search...">
                                        <button><i class="uil uil-search"></i></button>
                                    </div>
                                    <div class="dateRange">
                                        <input type="date">
                                        <span></span>
                                        <input type="date">
                                        <button><i class="uil uil-search"></i></button>
                                    </div>
                                </div>
                                <div class="consultAppointmentListTableBody">
                                    <div class="tableWraper">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Unique ID</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Place</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>AKR120622</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="viewDetailsBtn">View Details</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>AKR120622</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="viewDetailsBtn">View Details</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>3</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>AKR120622</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="viewDetailsBtn">View Details</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>4</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>AKR120622</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="viewDetailsBtn">View Details</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>5</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>AKR120622</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="viewDetailsBtn">View Details</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="elseDesign">
                                        <div class="elseDesignthumbnail">
                                            <img src="assets/images/empty.png" alt="">
                                        </div>
                                        <p>No Appointments</p>
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

    <script>

        // view Details popup
        $('.viewDetailsBtn').click(function(){
            $('.shimmer').fadeIn();
            $('.profileDetailsPopup').fadeIn();
        });
        $('.closeProfileDetailsPopup').click(function(){
            $('.shimmer').fadeOut();
            $('.profileDetailsPopup').fadeOut();
        });

    </script>

</body>
</html>
<?php
}else{
	header("Location:../login.php");
}
}else{
	header("Location:../login.php");
}
?>