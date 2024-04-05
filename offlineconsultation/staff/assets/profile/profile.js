$.ajax({
	url:"action/profile/fetch_all_profile_details.php",
	success:function(profile_result){
		let profile_result_json = jQuery.parseJSON(profile_result)
		if(profile_result_json[0]['status'] == 1){
			$('#phone_num').text(profile_result_json[0]['staff_phone'])
			$('#email').text(profile_result_json[0]['staff_email'])
			$('#address').text(profile_result_json[0]['staff_phone'])
			$('#place').text(profile_result_json[0]['branch_name'])
			$('#staff_name').text(profile_result_json[0]['staff_name'])
			//$('#edit_data').attr('href','edit-profile.php?id='+profile_result_json[0]['login_id'])
			$('#edit_data').attr('href','edit-profile.php')
		}else{
			$('.toasterMessage').text(profile_result_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
		}
	}
})