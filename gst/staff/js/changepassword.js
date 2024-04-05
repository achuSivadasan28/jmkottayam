$('#changepassword').submit(function (e) {
	$('#error').text('')
	$('#OldConfError').text('')
    e.preventDefault();
$('.submitBtn').text('Loading...')	
const oldp =$('#oldpassword').val();
const npass =$('#password-field').val();
const cpass=$('#cpassword').val();

if(npass == cpass){
const newpass = {
        oldpassword: oldp,
        nepas: npass,
        cpassword: cpass
    }


    fetch('action/changepassword.php', {
        method: "POST",
        header: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(newpass)


    })
 .then(Response => Response.text())
        .then(data => {
            console.log(data)
            
            if (data == 0) {
                $('#OldConfError').css('color', 'red')
                $('#OldConfError').text("*Incorrect Password!")
				$('.submitBtn').text('Save')
            } else {
				$('.submitBtn').text('Success')
				$('.submitBtn').css('background-color','blue')
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
$('#error').css({'color':'red','font-size':'16px'}).append('Password not matching!.');
$('.submitBtn').text('Save')
}

})


//session checking
fetch('action/logincheck.php')
.then(Response=>Response.json())
.then(data=>{
    console.log(data)
    if(data!=1)
{
 location.replace('login.php')
}
})
$('body').delegate('#logout','click', function(e){
    e.preventDefault()
    fetch('action/logout.php')
    .then(Response=>Response.text())
    .then(data=>{
        if(data == 1){
            location.replace('login.php');
        }
    })
})