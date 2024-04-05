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
                        <h1>Reports</h1>
                    </div>
                </div>
                <!-- canvas head close -->

                <!-- dashboard page -->
                <div class="dashboardPage">
                    <div class="dashboardMenuList">
                        <a href="stock-analysis.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-analytics"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Stock Analysis</h2>
                            </div>
                        </a>
                        <a href="top-selling-products.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-presentation-line"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Top Selling Products</h2>
                            </div>
                        </a>
                        <a href="least-selling-products.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-analysis"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Least Selling Products</h2>
                            </div>
                        </a>
                        <a href="invoice-reports.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-invoice"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Invoice Report</h2>
                            </div>
                        </a>
                        <a href="daily-reports.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-file-graph"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Daily Reports</h2>
                            </div>
                        </a>
						<a href="cancelled-reports.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-cancel"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Cancelled Invoice</h2>
                            </div>
                        </a>
						<a href="stock_activity.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-capsule"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Stock Activity</h2>
                            </div>
                        </a>
						<!--<a href="activity-log.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-icons"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Activity Log</h2>
                            </div>
                        </a>-->
						<a href="customer-details.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-users-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Customer Details</h2>
                            </div>
                        </a>
						<a href="tax_report.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-percentage"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>GST Report</h2>
                            </div>
                        </a>
						<a href="sales_report.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-file-medical-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Sales Report</h2>
                            </div>
                        </a>
						<a href="hsn_report.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-percentage"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>HSN Report</h2>
                            </div>
                        </a>

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down close -->

                    </div>
                </div>
                <!-- dashboard page close -->

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
location.replace('../index.php')
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