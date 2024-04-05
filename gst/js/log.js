
$('#loginadmin').submit(function (e) {
    e.preventDefault();
 const adminname = $('#uname').val();
 
const pass = $('#password-field').val();

const formData ={
    email :adminname,
    Password:pass,
}
fetch('action/loginAction.php',{
    method: "POST",
    header: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(formData)
})
.then(Response => Response.text())
    .then(data => {
        console.log(data)
        if(data == 'admin'){
            window.location.href="admin/index.php";
        }else if(data == 'counter'){
			window.location.href="staff/index.php";
		}else if(data == 'inventory'){
			window.location.href="Inventory/index.php";
		}else{
            $('#loginError').css('display','block')
            $('#loginError').css('color','red')
            $('#loginError').text('*Username or password is incorrect!')
        }
      
    })

});



        //forget password
$('#forgetpassword').submit(function(e){
    e.preventDefault()
    
    const email_for = $('#getmail').val();
    const forget ={
        email :email_for,
        
    }
    fetch('action/forgetpwd.php',{
        method: "POST",
        header: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(forget)
    })
    .then(Response => Response.text())
        .then(data => {
            console.log(data)
           let result_data = jQuery.parseJSON(data);
            if(result_data[0]['status'] == 'success'){
             $('#forgetbutton').text('Success')
                $('#forgetbutton').css('background-color','green')
                setTimeout(function(){
                    window.location.href="login.php";
                },1500)
            }else{
                $('#forgetbutton').text('Get Password')
                $('#forgetbutton').prop('disabled',false)
                $('#emailError').text(result_data[0]['msg']).css("color", "red");
            }
           

          
        })
  

});
