fetch_doctor_profile_data()
function fetch_doctor_profile_data(){
	$.ajax({
		url:"action/profile/profile_data.php",
		success:function(profile_result){
			let profile_result_json = jQuery.parseJSON(profile_result)
			if(profile_result_json[0]['status'] == 1){
				$('#name').text(profile_result_json[0]['doctor_name'])
				$('#branch').text(profile_result_json[0]['branch_name'])
				if(profile_result_json[0]['proPic'] != ''){
				$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				}
			}
		}
	})
}
fetch_doctor_profile_data()
function fetch_doctor_profile_data(){
	$.ajax({
		url:"action/profile/profile_data.php",
		success:function(profile_result){
			let profile_result_json = jQuery.parseJSON(profile_result)
			console.log(profile_result_json)
			if(profile_result_json[0]['status'] == 1){
				$('#name').text(profile_result_json[0]['doctor_name'])
				$('#branch').text(profile_result_json[0]['branch_name'])
				if(profile_result_json[0]['proPic'] != ''){
				$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				}
			}
		}
	})
}

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
			url:"action/changePwd/change_pwd.php",
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

/**let btn_text = '';
let Loading_text = "Loading...";
let Success_text = "Success";
let Error_text = "Error";
function button_loader(btn_id){
	let btn_id_compain = $('#'+btn_id)
	btn_text = btn_id_compain.text()
	btn_id_compain.text(Loading_text)
	btn_id_compain.attr('disabled',true)
}

function button_loader_success(btn_id){
	let btn_id_compain = $('#'+btn_id)
	btn_id_compain.css('background-color','blue')
	btn_id_compain.text(Success_text)
	btn_id_compain.attr('disabled',false)
}

function button_loader_Error(btn_id){
	let btn_id_compain = $('#'+btn_id)
	btn_id_compain.css('background-color','red')
	btn_id_compain.text(Error_text)
	btn_id_compain.attr('disabled',false)
}

function stop_loader(btn_id){
	let btn_id_compain = $('#'+btn_id)
	btn_id_compain.text(btn_text)
	btn_id_compain.attr('disabled',false)
}**/