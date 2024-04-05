<?php
session_start();
if(isset($_SESSION['doctor_login_id'])){
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
<!--<style>
.pagination ul{
  width: 100%;
  display: flex;
  flex-wrap: wrap;
  background: #fff;
  padding: 8px;
  border-radius: 50px;
  box-shadow: 0px 10px 15px rgba(0,0,0,0.1);
}
.pagination ul li{
  color: black;
  list-style: none;
  line-height: 45px;
  text-align: center;
  font-size: 18px;
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
  border-radius: 50%;
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
  background: #1c9900;
}
  </style>-->

        <!-- print design  -->
		<div class="printPage">
			<div class="printPageHead">
				<h1>JOHNMARIAN'S</h1>
				<p>A Speciality Health Care</p>
			</div>
			<div class="printPageProfile">
				<div class="printPageProfileRow">
					<div class="name" id="name_data"></div>
					<div class="gender">Gender : <b id="gender_data"></b></div>
					<div class="age">Age : <b id="age_data"></b></div>
					<div class="id">ID : <b id="unique_id">JMW/2022/3</b></div>
					<div class="totalVisit">Total Visit : <b id="total_visit">3</b></div>
					<div class="FirstVisit">First Visit : <b id="first_visit"></b></div>
					<div class="LastVisit">Last Visit : <b id="last_visit"></b></div>
					<div class="LastVisit2 p_height">Height : <b id="height_data"></b></div>
					<div class="LastVisit2 p_weight">Weight : <b id="weight_data"></b></div>
					<div class="LastVisit2 p_bmi">BMI : <b id="bmi_data">s</b></div>
					<div class="LastVisit2 p_category">Category : <b id="weight_cat"></b></div>
					
					
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
				</div>
			</div>
			<div class="printPageBody">
				<div class="printPageBodyRow1">
					<div class="printPageBox">
						<h2>Our Doctors</h2>
						<div class="doctorDetailBox">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
					<div class="doctorDetailBox dynamic_doctor">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
						<!--<div class="doctorDetailBox dynamic_doctor">
							<ul>
								<li><b>Dr Reshma Biju</b></li>
								<li>BNYS, DNHE</li>
								<li>TCMC 380</li>
								<li>Naturopathy Yoga Physician</li>
							</ul>
						</div>-->
						<div class="doctorDetailBox">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
						<div class="doctorDetailBox">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
					</div>
					<div class="printPageBox prescription_data_print">
						<h2>Prescription</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.	</p>
						<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
					<div class="printPageBox complaints_data_print">
						<h2>Complaints</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
				</div>
				<div class="printPageBodyRow1">
					<div class="printPageBox medical_history_print">
						<h2>Medical History</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
						<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
					<div class="printPageBox Investigations_data">
						<h2>Investigations</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
						<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
				</div>
				<div class="printPageBodyRow1">
					<div class="printPageBox">
						<h2>Diet to be followed / പാലിക്കേണ്ട ഭക്ഷണക്രമം.</h2>
						<ul class="food_to_follow">
						<!--	<li>Weight Management Diet</li>
							<li>Low Protein Diet</li>
							<li>Low Carb Diet</li>-->
							
							<!--<li><b>No. of Days : 10 Days</b></li>-->
						</ul>
					</div>
					<div class="printPageBox">
						<h2>Foods to be avoided / ഒഴിവാക്കേണ്ടവ.</h2>
						<ul class="food_to_avoid">
							<!--<li>Milk, Milk with tea, Ice Cream</li>
							<li>Wheat, Maida, Oats, Rava, Atta</li>
							<li>Soy Products</li>
							<li>Coffee</li>-->
						</ul>
					</div>
				</div>
				<div class="printPageBodyRow2">
					<div class="printPageBox">
						<h2>Remark</h2>
						<p id="all_remark"></p>
					</div>
				</div>
			</div>
			<div class="printPageFooter">
				<h1>JOHNMARIAN WELLNESS HOSPITAL</h1>
				<p><i class="uil uil-location-point"></i> P.P Road kottayam,Meenachil p.o, Pala, Kottayam- 686577 <br><i class="uil uil-phone-alt"></i> Ph: (Reg) +91 7736077731 || 8714161636 <i class="uil uil-envelope"></i> johnmarianwellness@gmail.com <i class="uil uil-globe"></i> www.drmanojjohnson.com</p>
			</div>
		</div>
        <!-- print design close -->
    
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
                        <h1>Consulted Patient</h1>
                        <div class="breadCrumbs">
                            <a href="index.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="index.php">Dashboard</a>
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
                                    <div class="dateRange">
                                        <input type="date" id="date_val">
                                        <span></span>
                                        <input type="date" id="date_val1">
                                        <button type="submit" id="date_btn"><i class="uil uil-search"></i></button>
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
                                                    <th>Patient Name</th>
                                                    <th>Phone No</th>
                                                    <th>Doctor</th>
                                                    <th>Place</th>
													<th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <!-- <tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
                                                    </td>
                                                    <td data-label="Patient Name">
                                                        <p>Afsal KT</p>
                                                    </td>
                                                    <td data-label="Phone No">
                                                        <p>9876543210</p>
                                                    </td>
                                                    <td data-label="Doctor">
                                                        <p>Dr. Stranger</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Angamaly</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="" onclick="print()" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                                            </a>
                                                            <a href="generate-bill.php" class="nextBtn">Generate</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Patient Name">
                                                        <p>Afsal KT</p>
                                                    </td>
                                                    <td data-label="Phone No">
                                                        <p>9876543210</p>
                                                    </td>
                                                    <td data-label="Doctor">
                                                        <p>Dr. Stranger</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Angamaly</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="" onclick="print()" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                                            </a>
                                                            <a href="generate-bill.php" class="nextBtn">Generate</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>3</p>
                                                    </td>
                                                    <td data-label="Patient Name">
                                                        <p>Afsal KT</p>
                                                    </td>
                                                    <td data-label="Phone No">
                                                        <p>9876543210</p>
                                                    </td>
                                                    <td data-label="Doctor">
                                                        <p>Dr. Stranger</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Angamaly</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="" onclick="print()" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                                            </a>
                                                            <a href="generate-bill.php" class="nextBtn">Generate</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>4</p>
                                                    </td>
                                                    <td data-label="Patient Name">
                                                        <p>Afsal KT</p>
                                                    </td>
                                                    <td data-label="Phone No">
                                                        <p>9876543210</p>
                                                    </td>
                                                    <td data-label="Doctor">
                                                        <p>Dr. Stranger</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>Angamaly</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="" onclick="print()" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                                            </a>
                                                            <a href="generate-bill.php" class="nextBtn">Generate</a>
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
							 
            							</ul>
          							</div>
									<!--<div class="pagination">
										<div class="pageCount">
											<p>Page per row</p>
											<select id="pagenation_drop">
												
											</select>
										</div>-->
										
										<!--<div class="paginationCount">
											<ul>
												<li id="first_row">First</li>
												<li id="prev_page"><i class="uil uil-angle-left-b"></i></li>
												<div id="page_num" style="display:flex">
												
												</div>
												<li id="nxt_page"><i class="uil uil-angle-right-b"></i></li>
												<li id="last_row">Last</li>
											</ul>
										</div>-->
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
<script src="assets/appointment/patient-prescriptions.js?v=<?php echo $version_variable;?>"> </script>
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
    //session handling
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
header("Location:../login.php");
}	
?>