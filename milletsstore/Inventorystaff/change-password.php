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
                        <h1>Change Password</h1>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
                    <form action="" id="changepassword">
                        <div class="formGroup">
                            <label for="">Old Password</label>
                            <input type="text" id="old">
                            <span id="oldpwdErre"></span>
                        </div>
                        <div class="formGroup">
                            <label for="">New Password</label>
                            <div class="formPassword">
                                <input id="password-field" type="password" name="password" class="passwordinput">
                                <i toggle="#password-field" class="uil uil-eye togglePassword"></i>
                            </div>
                            <span id="newpwdError" style="margin-bottom: -20px;"></span>
                        </div>
                        <div class="formGroup">
                            <label for="">Confirm Password</label>
                            <input type="text" id="cpassword">
                            <span id="conPwderror"></span>
                        </div>

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down -->

                        <div class="formBtnArea">
                            <button  type="submit" id="submit" class="formSbttn">Save</button>
                        </div>
                    </form>
                </div>
                <!-- form section close -->

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
        

        $('#changepassword').submit(function (e) {
        e.preventDefault();
	$('.formSbttn').text('submit')	
            // var x = document.getElementById("toast")
            // x.className = "show";
            // setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
      	 
   const oldp =$('#old').val();
  
   const npass =$('#password-field').val();
   const cpass=$('#cpassword').val();
   
    if(npass == cpass){
    const newpass = {
                oldpassword: oldp,
                nepas: npass,
                cpassword: cpass
            }
            fetch('action/changepwd.php', {
                method: "POST",
                header: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(newpass)
            })
         .then(Response => Response.text())
                .then(data => {
                    console.log(data)                   
           if(data==0)
           {
            $('#oldpwdErre').css('color', 'red')
                $('#oldpwdErre').text("*Incorrect Password!")
               
           }
           else{
			   setTimeout(function () {
                           $('.formSbttn').text('success');
                            $('.formSbttn').css('background-color', 'green');
                        }, 1500);
					setTimeout(function () {
                           window.location.href="change-password.php";
                        }, 2000);
                   //window.location.href="index.html";
           }

         })
    }else{
        $('#newpwdError').css({'color':'red','font-size':'16px'}).append('Password not matching!.');

    }
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