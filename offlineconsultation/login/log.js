$('#login_from').submit(function(e){
	$('#span_error').text('')
	e.preventDefault()
	let username = $('#username').val()
	let pwd = $('.passwordinput').val()
	$('#login_btn').text('Loading...')
	$.ajax({
		url:"action/login_action.php",
		type:"POST",
		data:{username:username,
			 pwd:pwd
			 },
		success:function(login_data){
			//console.log(login_data)
			let login_data_json = jQuery.parseJSON(login_data);
			$('#login_btn').text('Success')
			$('#login_btn').css('background-color','blue')
			if(login_data_json[0]['status'] == 0){
				if(login_data_json[0]['role'] == 'admin'){
					window.location.href="admin/index.php";
				}else if(login_data_json[0]['role'] == 'staff'){
					window.location.href="staff/appointments.php";
				}else if(login_data_json[0]['role'] == 'doctor'){
					window.location.href="doctor/index.php";
				}else if(login_data_json[0]['role'] == 'nurse'){
					window.location.href="nurseStation/index.php";
				}else if(login_data_json[0]['role'] == 'lab'){
					window.location.href="lab/index.php";
				}else if(login_data_json[0]['role'] == 'treatment_staff'){
					window.location.href="treatment_staff/index.php";
				}
			}else{
				$('#login_btn').text('Login')
				$('#span_error').text(login_data_json[0]['msg'])
			}
		}
	})
})