<?php 
session_start();
if(isset($_SESSION['adminLogId'])){
?><!DOCTYPE html>
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
                        <h1>Millets Inventory</h1>
                    </div>
                </div>
                <!-- canvas head close -->

                <!-- dashboard page -->
                <div class="dashboardPage">
                    <div class="dashboardMenuList">
                        <a href="category.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-apps"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Category</h2>
                            </div>
                        </a>
                        <a href="products.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-medical-drip"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Products</h2>
                            </div>
                            <div class="stockNotificationCount cnts">Limited Supplies Available </div>
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

fetch('action/count.php')
           .then(Response=>Response.json())
           .then(data=>{
               console.log(data)
               $('.cnts').append(`
               ${data[0]['id']}
                    `);
            })
</script>
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