$('#forgot_pwd_from').submit(function(e){
	e.preventDefault()
	let email = $('#email').val().trim()
	if(email != ''){
		button_loader('recover_pwd_btn');
		$.ajax({
			url:"action/recover_pwd.php",
			type:"POST",
			data:{email:email},
			success:function(pwd_result){
				let pwd_result_json = jQuery.parseJSON(pwd_result);
				$('.toaster').addClass('toasterActive');
				if(pwd_result_json[0]['status'] == 1){
					$('.toasterMessage').text(pwd_result_json[0]['msg'])
					$('.successTost').css('display','flex')
					$('.errorTost').css('display','none')
					setTimeout(function(){
					$('.toaster').removeClass('toasterActive');
					},2000)
					setTimeout(function(){
						window.location.href="login.php"
					},2100)
				}else{
					stop_loader('recover_pwd_btn')
					$('.toasterMessage').text(pwd_result_json[0]['error_log'])
					$('.successTost').css('display','none')
					$('.errorTost').css('display','flex')
					setTimeout(function(){
						$('.toaster').removeClass('toasterActive');
					},2000)
				}
			}
		})
	}
})
