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
                        <h1>View Customer Details</h1>
                        <div class="breadCrumbs">
                            <a href="category.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="customer-details.php">Customer Details</a>
                            <span>/</span>
                            <a href="view-customer-details.php">View Customer Details</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
				
				<!-- custmer details section -->
				<div class="customerDetailsSection">
					<div class="customerDetailsSectionBox">
						<div class="customerDetailsSectionBoxHead">
							<div class="customerDetailsSectionBoxHeadProfile">
								<img src="assets/images/avatarOrange2.png">
							</div>
							<div class="customerDetailsSectionBoxHeadProfileName">
								<h1></h1>
							</div>
							<p id="place"></p>
							<p id="phn"></p>
							<div class="customerDetailsSectionBoxHeadAction">
								
							</div>
						</div>
						<!--<div class="customerDetailsSectionBoxDetails">
							<div class="customerDetailsSectionBoxDetailsList">
								<div class="customerDetailsSectionBoxDetailsListtitle">
									<p>Phone Number</p>
								</div>
								<div class="customerDetailsSectionBoxDetailsListContent">
									<p>+91 98765 43210</p>
								</div>
							</div>
							<div class="customerDetailsSectionBoxDetailsList">
								<div class="customerDetailsSectionBoxDetailsListtitle">
									<p>Place</p>
								</div>
								<div class="customerDetailsSectionBoxDetailsListContent">
									<p>Palakkad</p>
								</div>
							</div>
						</div>	-->					
					</div>
					<h2><i class="uil uil-history"></i> History</h2>
					<div class="customerDetailsSectionBox">
						<div class="customerDetailsSectionBoxHistory">
							<div class="customerDetailsSectionBoxHistoryBox">
								<!--<div class="customerDetailsSectionBoxHistoryDate">
									<span>10-10-2020</span>
									<div class="line"></div>
								</div>
								<div class="customerDetailsSectionBoxHistoryDetails">
									<div class="productName">Super 3</div>
									<div class="productQTY"><span>-</span> 2 QTY</div>
								</div>
								<div class="customerDetailsSectionBoxHistoryDetails">
									<div class="productName">ULTRA OMEGA</div>
									<div class="productQTY"><span>-</span> 1 QTY</div>
								</div>-->
							</div>
							
						</div>
					</div>
				</div>
				<!-- custmer details section close -->

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
	
	<script src="js/view_customer_details.js"></script>
    <script>
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