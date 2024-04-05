$.ajax({
	url:"action/registration/check_otp_varify.php",
	success:function(result){
		if(result == 0){
			window.location.href="mobile-verification.html";
		}else{
			$('#number_data').val(result)
		}
	}

})

$('#registration_details').submit(function(e){
	e.preventDefault();
	$('#number_error').text('')
	$('#email_error').text('')
	$('.toasterPopup').removeClass('toasterPopupActive')
	$('.toasterPopup').removeClass('error')
	$('.toasterPopup').removeClass('success')
	let Name = $('#Name').val().trim()
	let number_data = $('#number_data').val().trim()
	let email = $('#email').val().trim()
	let validate_r = validation(Name,number_data,email);
	if(validate_r == 0){
			$('.registerBtn').text('Loading...')
			$('.registerBtn').prop('disabled',true)
		$.ajax({
			url:"action/registration/add-user-basicdetails.php",
			type:"POST",
			data:{Name:Name,
				  number_data:number_data,
				  email:email,
				 },
			success:function(signup_result){
				let signup_result_json = jQuery.parseJSON(signup_result)
				if(signup_result_json[0]['status'] == 1){
					$('.toasterPopupIcon').empty()
					$('.toasterPopupIcon').append(`<i class="uil uil-check-circle"></i>`)
					//<i class="uil uil-exclamation-triangle"></i>
					$('.toasterPopup').addClass('success')
					$('.toasterPopup').addClass('toasterPopupActive')
					$('#stage').text('Success')
					$('#msg').text(signup_result_json[0]['msg']+'. Check Email for username and password')
					setTimeout(function(){
						window.location = 'book-doctor.html'
					},2500)

				}else if(signup_result_json[0]['status'] == 2){
					$('.toasterPopupIcon').empty()
					$('.toasterPopupIcon').append(`<i class="uil uil-times-circle"></i>`)
					$('.toasterPopup').addClass('error')
					$('.toasterPopup').addClass('toasterPopupActive')
					$('#stage').text('Error')
					$('#msg').text(signup_result_json[0]['msg'])
					$('#number_error').text(signup_result_json[0]['phn_error'])
					$('#email_error').text(signup_result_json[0]['email_error'])
					$('.registerBtn').text('Submit')
					$('.registerBtn').prop('disabled',false)
				}else if(signup_result_json[0]['status'] == 3){
					$('.toasterPopupIcon').empty()
					$('.toasterPopupIcon').append(`<i class="uil uil-times-circle"></i>`)
					$('.toasterPopup').addClass('error')
					$('.toasterPopup').addClass('toasterPopupActive')
					$('#stage').text('Error')
					$('#msg').text(signup_result_json[0]['error_log'])
					$('#number_error').text(signup_result_json[0]['error_log'])
					$('.registerBtn').text('Submit')
					$('.registerBtn').prop('disabled',false)
				}
				else if(signup_result_json[0]['status'] == 0){
					$('.toasterPopupIcon').empty()
					$('.toasterPopupIcon').append(`<i class="uil uil-exclamation-triangle"></i>`)
					//<i class="uil uil-exclamation-triangle"></i>
					$('.toasterPopup').addClass('wranning')
					$('.toasterPopup').addClass('toasterPopupActive')
					$('#stage').text('warning')
					$('#msg').text(signup_result_json[0]['error_log'])
					$('.registerBtn').text('Submit')
					$('.registerBtn').prop('disabled',false)
				}
			}
		})
	}
})
$('.toasterPopupClose').click(function(){
	$('.toasterPopup').removeClass('toasterPopupActive')
	$('.toasterPopup').removeClass('error')
	$('.toasterPopup').removeClass('success')
})

function validation(Name,number_data,email){
	let valide = 0;
	if(Name == ''){
		$('#name_error').text('Required!')
		valide++
	}else{
		$('#name_error').text('')
	}
	if(number_data == ''){
		$('#number_error').text('Required!')
		valide++
	}else{
		$('#number_error').text('')
	}
	if(email == ''){
		$('#email_error').text('Required!')
		valide++
	}else{
		$('#email_error').text('')
	}
	return valide
}