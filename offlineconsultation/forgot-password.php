<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>John Marians</title>
    <meta name="theme-color" content="#557bfe">


    <!-- unicon  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- style -->
    <link rel="stylesheet" href="admin/assets/css/style.css">
</head>
<body>
    
    <main>
		
		<!-- toaster-->
<div class="toaster">
	<div class="toasterIcon successTost" style="display:none"><i class="uil uil-check"></i></div>
<!--<div class="toasterIcon"><i class="uil uil-check"></i></div>-->
	<div class="toasterIcon errorTost" style="display:none"><i class="uil uil-times"></i></div>
	<div class="toasterMessage"></div>
</div>
<!-- toaster close -->

        <!-- shimmer -->
        <div class="shimmer"></div>
        <!-- shimmer close -->

        <!-- nav  -->
        <nav>
            <div class="container">
                <a href="#" class="navLogo">
                    <img src="admin/assets/images/johnmariansLogo.png" alt="John Marians Logo">
                </a>
            </div>
        </nav>
        <!-- nav close -->

        <!-- form section  -->
        <section id="formSection">
            <div class="container">
                <div class="formSectionMain">
                    <div class="form">
                       <h1>Password Recovery</h1>
                      <!--   <p>No need to rush to the hospital through the busy traffic and then wait another 45 minutes just to see a Doctor!</p>-->
                        <form action="" id="forgot_pwd_from">
                            <div class="formGroup">
                                <label for="">Enter Your Registered Email</label>
                                <input type="email" id="email" required>
                            </div>
                            
                            <div class="forgtPsd">
                                <a href="login.php">Login</a>
                            </div>
                            <button id="recover_pwd_btn">Recover Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- form section close -->

        <!-- footer  -->
        <footer class="foot2">
            <div class="container">
                <div class="footerMain">
                    <div class="footerStripRights">
                        <p>© 2022, All Rights Reserved.</p>
                    </div>
                    <div class="footerStripCreat">
                        <p>Designed with <i class="uil uil-heart"></i><a href="https://esightsolutions.com/" target="_blank">Esight Solutions</a></p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer close -->

    </main>


    <!-- jquery  -->
    <script src="admin/assets/js/jquery.js"></script>
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/4022a59704.js" crossorigin="anonymous"></script>
    <!-- main -->
    <script src="admin/assets/js/main.js"></script>
 	<script src="fwd/fwd.js"></script>
    <script>

        // toogle password 
        $(".togglePassword").click(function() {

            $(this).toggleClass("uil uil-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        
    </script>

</body>
</html>