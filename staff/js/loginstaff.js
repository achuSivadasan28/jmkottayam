
$('#loginstaff').submit(function (e) {
    e.preventDefault();

 const staffname = $('#username').val();
const pass = $('#password-field').val();

const formData ={
    email :staffname,
    Password:pass,
}
fetch('action/staffLogin.php',{
    method: "POST",
    header: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(formData)
})
.then(Response => Response.text())
    .then(data => {
        console.log(data)
        if(data == 0){
           $('#loginError').css('display','block')
         $('#loginError').css('color','red')
         $('#loginError').text('*Username or password is incorrect!')
        }
        else if(data == 2){
            $('#loginError').css('display','block')
            $('#loginError').css('color','red')
            $('#loginError').text('*your account has been blocked please contact admin')
        }
        else if(data == 1){
            $('#loginError').css('display','block')
            $('#loginError').css('color','red')
            $('#loginError').text('*your account has been deleted please contact admin')
        }
        else{
window.location.href="index.php"
        }
      
    })

});


//forget password
$('#forgetpassword').submit(function(e){
    e.preventDefault()
    $('#forgetbutton').text('Getting new password...').css('background-color','#c1f741')
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
