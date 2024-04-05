<?php 
session_start();
if(isset($_SESSION['adminLogId'])){
	require_once '../_class/query.php';
$obj=new query();
$version_variable = '';
$select_version = $obj->selectData("id,version_id","tbl_version","");
	if(mysqli_num_rows($select_version)){
	while($select_version_row = mysqli_fetch_array($select_version)){
$version_variable = $select_version_row['version_id'];
		
	}
	}
?>
<!DOCTYPE html>
<html lang="en">

    <!-- head -->
    <?php
        include "assets/includes/head/head.php";
    ?>
    <!-- head close -->

<body>
		<style>
			/*.pagination{
				display:flex;
				width:100%;
				
			}
		.pagination ul{
  width: 100%;
  display: flex;
  flex-direction:row;
  align-items:center;
  background: #fff;
  padding: 8px;
  border-radius: 10px;
  box-shadow: 0px 10px 15px rgba(0,0,0,0.1);
}
.pagination ul li{
  color: black;
  list-style: none;
  line-height: 45px;
  text-align: center;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  user-select: none;
  transition: all 0.3s ease;
}
.pagination ul li.numb{
  list-style: none;
  height: 45px;
  width: 45px;
  margin: 0 3px;
  line-height: 45px;
  border-radius: 10px;
}
.pagination ul li.numb.first{
  margin: 0px 3px 0 -5px;
}
.pagination ul li.numb.last{
  margin: 0px -5px 0 3px;
}
.pagination ul li.dots{
  font-size: 22px;
  cursor: default;
}
.pagination ul li.btn{
  padding: 0 20px;
  border-radius: 50px;
}
.pagination li.active,
.pagination ul li.numb:hover,
.pagination ul li:first-child:hover,
.pagination ul li:last-child:hover{
  color: #fff;
  background: #ff6d01;
}*/
	
	</style>
    
    
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
                        <h1>Customer Details</h1>
                        <div class="breadCrumbs">
                            <a href="reports.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="reports.php">Reports</a>
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
                                        <input type="search" placeholder="Search..." id="search_val">
                                        <button type="submit" id="search_btn"><i class="uil uil-search"></i></button>
                                    </div>
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
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Customer Name</th>
                                                    <th>Phone</th>
                                                    <th>Place</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="customers">
                                                <!--<tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
                                                    </td>
                                                    <td data-label="Customer Name">
                                                        <p>Afsal Nazeer</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>9876543210</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Palakkad</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
															<a href="view-customer-details.php" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
															</a>
															<a href="edit-customer-details.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
															</a>
															<div class="tableDeleteBtn" title="Delete" data-id="24">
																<i class="uil uil-trash"></i>
															</div>
														</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Customer Name">
                                                        <p>Afsal Nazeer</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>9876543210</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Palakkad</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
															<a href="view-customer-details.php" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
															</a>
															<a href="edit-customer-details.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
															</a>
															<div class="tableDeleteBtn" title="Delete" data-id="24">
																<i class="uil uil-trash"></i>
															</div>
														</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>3</p>
                                                    </td>
                                                    <td data-label="Customer Name">
                                                        <p>Afsal Nazeer</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>9876543210</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Palakkad</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
															<a href="view-customer-details.php" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
															</a>
															<a href="edit-customer-details.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
															</a>
															<div class="tableDeleteBtn" title="Delete" data-id="24">
																<i class="uil uil-trash"></i>
															</div>
														</div>
                                                    </td>
                                                </tr>-->
                                            </tbody>
                                        </table>
										
										<div class="elseDesign">
                                        <div class="elseDesignthumbnail">
                                            <img src="assets/images/empty.png" alt="">
                                        </div>
                                        <p>No Data Available</p>
                                    </div>
                                    </div>
									
									<div class="pagination">
										<ul>
										  <!--pages or li are comes from javascript --> 
										</ul>
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
	<script src="js/customer_details.js?v=<?php echo $version_variable;?>"></script>
<script>
	
	//sckelly
	$(window).load(function() {
		 $('.sckelly').css({
			display: 'none',
		 });
	});

        
        fetch('action/dashboard.php')
    .then(Response => Response.json())
    .then(data => {
        console.log(data)
        $('.navProfileName p').append(`${data[0]['user']}`)
        $('.navProfileName span').append(`${data[0]['srole']}`)
    })
    </script>
    <script>

//session checking
fetch('action/logincheck.php')
.then(Response=>Response.json())
.then(data=>{
console.log(data)
if(data!=1)
{
location.replace('../login.php')
}
})
$('body').delegate('#logout','click', function(e){
e.preventDefault()
fetch('action/logout.php')
.then(Response=>Response.text())
.then(data=>{
if(data == 1){
location.replace('../login.php');
}
})
})
</script>
</body>
</html>
<?php
}else{
header('Location:../login.php');
}
?>