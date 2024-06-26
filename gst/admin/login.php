<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
        if(isset($_SESSION['adminLogId'])){
        header("Location:index.php");
    }
        else{
        
        }
        ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>John Marians</title>
    <meta name="theme-color" content="#557bfe">


    <!-- unicon  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- style -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
    <main>

        <!-- shimmer -->
        <div class="shimmer"></div>
        <!-- shimmer close -->

        <!-- nav  -->
        <nav>
            <div class="container">
                <a href="index.html" class="navLogo">
                    <img src="assets/images/johnmariansLogo.png" alt="John Marians Logo">
                </a>
            </div>
        </nav>
        <!-- nav close -->

        <!-- form section  -->
        <section id="formSection">
            <div class="container">
                <div class="formSectionMain">
                    <div class="form">
                        <h1>Welcome to Johnmarian's</h1>
                        <p>No need to rush to the hospital through the busy traffic and then wait another 45 minutes just to see a Doctor!</p>
                        <form action="" id="loginadmin">
                            <div class="formGroup">
                                <label for="">User Name</label>
                                <input type="text" id="uname">
                            </div>
                            <div class="formGroup">
                                <label for="">Password</label>
                                <div class="formPassword">
                                    <input id="password-field" type="password" name="password" class="passwordinput"  >
                                    <i toggle="#password-field" class="uil uil-eye togglePassword"></i>
                                </div>
                            </div>
                            <span style="display:none" id="loginError"></span>
                            <div class="forgtPsd">
                                <a href="forgot-password.html">Recovery Password</a>
                            </div>
                            <button type="submit" id="submit">Login</button>
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
    <script src="assets/js/jquery.js"></script>
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/4022a59704.js" crossorigin="anonymous"></script>
    <!-- main -->
    <script src="assets/js/main.js"></script>

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
        }) 
    </script>
    <script src="js/adminlog.js"> </script>
</body>
</html>