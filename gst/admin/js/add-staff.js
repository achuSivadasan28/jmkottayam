
    $('#form_act').submit(function(e){
        e.preventDefault()
         $('.submitBtn').text('Loading...')
    let sname = $('#sname').val()
    let phone = $('#phone').val()
    let email = $('#email').val()
	let branch = $('.current').text()
	let role_data = $('#role_data').val()
    let fb = new FormData();
    fb.append('sname', sname)
    fb.append('phone', phone)
    fb.append('email', email)
	fb.append('branch', branch)
	fb.append('role_data', role_data)
    fetch('action/add-staff.php',{
        method:'POST',
        body:fb,
    })
    .then(Response=>Response.text())
    .then(data=>{
        console.log(data)
        if(data==1){
            $('.submitBtn').removeAttr('disabled');
            $('.submitBtn').text('data not inserted');

        }
        else {
           
            setTimeout(function () {
                $('.submitBtn').text('success');
                 $('.submitBtn').css('background-color', 'green');
             }, 1500);
         setTimeout(function () {
                window.location.href="staff-management.php";
             }, 2000);
        //window.location.href="index.html";
        }
    })

})