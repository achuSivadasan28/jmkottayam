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
?><!DOCTYPE html>
<html lang="en">

    <!-- head -->
    <?php
        include "assets/includes/head/head.php";
    ?>
    <!-- head close -->

<body>
	
	<div class="printTable">
			<div class="printTableHead">
				<div class="printTableHeadBox">
					<div class="printTableHeadBoxLogo">
						<img src="assets/images/johnmariansLogo.png">
					</div>
				</div>
				<div class="printTableHeadBox1">
					<p>31/410A, NELSON MANDELA ROAD, KOONAMTHAI, EDAPPALLY ERNAKULAM Pin 682024</p>
					<p>Ph : 8086250300 | E-mail : johnmarians@gmail.com | Web : johnmarians.com</p>
				</div>
			</div>
			<div class="printTableValue">
				<div class="printTableValueBox">
					<h1 id="total_amount1"></h1>
					<p>Total Amount of bills</p>
				</div>
				<div class="printTableValueBox">
					<h1 id="invoice_count1"></h1>
					<p>Total No.of bills</p>
				</div>
			</div>
			<div class="printTableBody">
				<table>
					<thead>
						<tr>
							<th>Sl No</th>
							<th>Products Name</th>
							<th>Products Quantity</th>
							<th>Price</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
    
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
                        <h1>Inner Daily Reports</h1>
                        <div class="breadCrumbs">
                            <a href="inventory-management.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="reports.php">Reports</a>
                            <span>/</span>
                            <a href="daily-reports.php">Daily Report</a>
							<span>/</span>
                            <a id="date_data"></a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->

                <!-- table head tile  -->
                <div class="tableHeadTile">
                    <div class="tableHeadTileBox">
                        <h1 id="total_amount"></h1>
                        <p>Total Amount of bills</p>
                    </div>
                    <div class="tableHeadTileBox">
                        <h1 id="invoice_count"></h1>
                        <p>Total No.of bills</p>
                    </div>

                    <div class="dummyBox"></div>
                </div>
                <!-- table head tile close -->
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
                    <div class="consultAppointmentList">
                        <div class="tabcontent" style="display: block;">
                            <div class="consultAppointmentListTable">
                                <div class="consultAppointmentListTableHead">
                                   <!-- <div class="searchBox">
                                        <input type="search" placeholder="Search..." id="search_val">
                                        <button type="submit" id="search_btn"><i class="uil uil-search"></i></button>
                                    </div>-->
									<div onclick="print()" class="printBtn"><i class="uil uil-print"></i></div>
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
                                                    <th>Products Quantity</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
									<!--<div class="pagination">
										<div class="pageCount">
											<p>Page per row</p>
											<select id="pagenation_drop">
												
											</select>
										</div>
										<div class="paginationCount">
											<ul>
												<li id="first_row">First</li>
												<li id="prev_page"><i class="uil uil-angle-left-b"></i></li>
											   <div id="page_num" style="display:flex">
												
												</div>
												
												<li id="nxt_page"><i class="uil uil-angle-right-b"></i></li>
												<li id="last_row">Last</li>
											</ul>
										</div>
									</div>-->
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
	<script src="js/daily-reports.js?v=<?php echo $version_variable;?>"></script>
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