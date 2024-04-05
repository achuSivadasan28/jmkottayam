$('#changePwd').submit(function(e){
	e.preventDefault();
	$('#pwd_error').text('')
	$('#old_pwd').text('')
	$('#conf_pwd').text('')
	let oldPwd = $('#oldPwd').val()
	let passwordinput = $('.passwordinput').val()
	let confim_pwd = $('#confim_pwd').val()
	let valid = validate_pwd(passwordinput,confim_pwd);
	console.log(valid)
	if(valid == 1){
		button_loader('changePwd_btn')
		$.ajax({
			url:"action/profile/change_pwd.php",
			type:"POST",
			data:{oldPwd:oldPwd,
				 passwordinput:passwordinput,
				  confim_pwd:confim_pwd,
				 },
			success:function(result_data){
				console.log(result_data)
				let result_data_json = jQuery.parseJSON(result_data)
			$('.toasterMessage').text(result_data_json[0]['msg'])
			if(result_data_json[0]['status'] == 1){
				$('.successTost').css('display','flex')
				$('.errorTost').css('display','none')
			}else if(result_data_json[0]['status'] == 0){
				stop_loader('changePwd_btn')
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
				console.log(result_data_json[0]['passw_error'])
				if(result_data_json[0]['passw_error'] == 1){
					$('#old_pwd').text('*Password Is Incorrect!')
				}
			}
			$('.toaster').addClass('toasterActive');
		setTimeout(function () {
			$('.toaster').removeClass('toasterActive');
		}, 2000)
			if(result_data_json[0]['status'] == 0){
				if(result_data_json[0]['passw_error'] == 0){
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
				}
			}else{
			setTimeout(function () {
				window.location.href="index.php";
			}, 2500)
			}
			}
		})
	}
})

function validate_pwd(passwordinput,confim_pwd){
	
	let valid = 0;
	if(passwordinput.length>=6){
	if(passwordinput == confim_pwd){
		valid = 1;
	}else{
		$('#conf_pwd').text('*password and confirmation password is not match! ')
	}
	}else{
		$('#pwd_error').text('*Password Must Be At Least 6 Characters!')
		
	}
	return valid;
}