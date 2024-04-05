$.ajax({
	url:"action/appointment/all-appointments.php",
	success:function(today_result){
		let today_result_json = jQuery.parseJSON(today_result)
		if(today_result_json[0]['status'] !=0){
			$('#appointment_count').text(today_result_json[0]['appointment_count'])
		}else{
			$('.toasterMessage').text(today_result_json[0]['msg'])
			$('.errorTost').css('display','none')
			$('.successTost').css('display','flex')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			if(today_result_json[0]['status'] == 0){
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
		}
	}
})