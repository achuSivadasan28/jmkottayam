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
                        <h1>Department Management</h1>
                    </div>
                    <div class="canvasHeadBox2">
                        <a href="add-department.php" class="addBtn">Add Department</a>
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
                                        <input type="search" placeholder="Search..." id="search_val">
                                        <button id="search_btn"><i class="uil uil-search"></i></button>
                                    </div>
                        <a href="add-department.php" class="addBtn">Add Department</a>
                                </div>
                                <div class="consultAppointmentListTableBody">
                                    <div class="tableWraper">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Department Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <!-- <tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Cardiology</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="edit-department.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                                            </a>
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
                                                    <td data-label="Name">
                                                        <p>Ortho</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="edit-department.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                                            </a>
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
                                                    <td data-label="Name">
                                                        <p>Ophthalmology</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="edit-department.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                                            </a>
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
                                                    <td data-label="Name">
                                                        <p>Dermatology</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="edit-department.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                                            </a>
                                                            <div class="tableDeleteBtn" title="Delete">
                                                                <i class="uil uil-trash"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>-->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pagination">
            							<ul>
              <!--pages or li are comes from javascript --> 
            							</ul>
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
	<script src="assets/department/department-management.js?v=<?php echo $version_variable;?>"></script>
    <!-- script close -->

    <script>


    </script>

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