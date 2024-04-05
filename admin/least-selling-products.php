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
                        <h1>Least Selling Products</h1>
                        <div class="breadCrumbs">
                            <a href="reports.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="reports.php">Reports</a>
                        </div>
                    </div>
                    <div class="canvasHeadBox2">
                        <a href="action/least_export.php" class="addBtn">Export Excel</a>
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
                                    <div class="dateRange">
                                        <input type="date" id="start_date">
                                        <span></span>
                                        <input type="date" id="end_date">
                                        <button id="date_filter"><i class="uil uil-search"></i></button>
                                    </div>
								<a href="action/least_export.php" class="addBtn">Export Excel</a>
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
                                                    <th>Products Name</th>
                                                    <th>Category</th>
                                                    <th>Total Stock</th>
                                                    <th>Sold</th>
                                                    <th>Left</th>
                                                    <th>Analysis</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <!-- <tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
                                                    </td>
                                                    <td data-label="Products Name">
                                                        <p>Paracetamol</p>
                                                    </td>
                                                    <td data-label="Category">
                                                        <p>Medicin Category</p>
                                                    </td>
                                                    <td data-label="Total Stocks">
                                                        <p>100</p>
                                                    </td>
                                                    <td data-label="Sold">
                                                        <p>80</p>
                                                    </td>
                                                    <td data-label="Left">
                                                        <p>20</p>
                                                    </td>
                                                    <td data-label="Analysis">
                                                        <p class="belowAvarage">10%</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Products Name">
                                                        <p>Paracetamol</p>
                                                    </td>
                                                    <td data-label="Category">
                                                        <p>Medicin Category</p>
                                                    </td>
                                                    <td data-label="Total Stocks">
                                                        <p>100</p>
                                                    </td>
                                                    <td data-label="Sold">
                                                        <p>50</p>
                                                    </td>
                                                    <td data-label="Left">
                                                        <p>50</p>
                                                    </td>
                                                    <td data-label="Analysis">
                                                        <p class="belowAvarage">10%</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>3</p>
                                                    </td>
                                                    <td data-label="Products Name">
                                                        <p>Paracetamol</p>
                                                    </td>
                                                    <td data-label="Category">
                                                        <p>Medicin Category</p>
                                                    </td>
                                                    <td data-label="Total Stocks">
                                                        <p>100</p>
                                                    </td>
                                                    <td data-label="Sold">
                                                        <p>20</p>
                                                    </td>
                                                    <td data-label="Left">
                                                        <p>80</p>
                                                    </td>
                                                    <td data-label="Analysis">
                                                        <p class="belowAvarage">5%</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>4</p>
                                                    </td>
                                                    <td data-label="Products Name">
                                                        <p>Paracetamol</p>
                                                    </td>
                                                    <td data-label="Category">
                                                        <p>Medicin Category</p>
                                                    </td>
                                                    <td data-label="Total Stocks">
                                                        <p>100</p>
                                                    </td>
                                                    <td data-label="Sold">
                                                        <p>75</p>
                                                    </td>
                                                    <td data-label="Left">
                                                        <p>25</p>
                                                    </td>
                                                    <td data-label="Analysis">
                                                        <p class="belowAvarage">25%</p>
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
	<script src="js/least-selling-products.js"> </script>
</body>
</html>
<?php
}else{
header('Location:../login.php');
}
?>