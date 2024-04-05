setInterval(todays_appointments, 1000);
todays_appointments()
function todays_appointments(){
$.ajax({
	url:"action/appointment/todays-appointments.php",
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
}
fetch_doctor_profile_data()
function fetch_doctor_profile_data(){
	$.ajax({
		url:"action/profile/profile_data.php",
		success:function(profile_result){
			let profile_result_json = jQuery.parseJSON(profile_result)
			console.log(profile_result_json)
			if(profile_result_json[0]['status'] == 1){
				$('#name').text(profile_result_json[0]['staff_name'])
				$('#branch').text(profile_result_json[0]['branch_name'])
				//$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				
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
				$('#name').text(profile_result_json[0]['staff_name'])
				$('#branch').text(profile_result_json[0]['branch_name'])
				if(profile_result_json[0]['proPic'] != ''){
				//$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				}
			}
		}
	})
}