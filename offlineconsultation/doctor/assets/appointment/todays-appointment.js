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
let end_date = '';
let start_date = '';
$('#date_filter_btn').click(function(){
	end_date = $('.end_date').val();
	start_date = $('.start_date').val();
	doctor_report();
	

})
doctor_report();
function doctor_report(){
	$.ajax({
		url : "action/appointment/doctor_report.php",
		type : 'post',
		data:{
			end_date:end_date,
			start_date:start_date,
		},
		success:function(result){
			console.log(result)
			let result_json = JSON.parse(result);
			$('#new_off').text(result_json[0]['new_patient'])
			$('#old_off').text(result_json[0]['old_patient'])
			$('#tot_off').text(result_json[0]['total_patient'])
			$('#new_on').text(result_json[0]['new_online_patient'])
			$('#old_on').text(result_json[0]['old_online_patient'])
			$('#tot_on').text(result_json[0]['total_online_patient'])
			$('#missed_on').text(result_json[0]['missed_online_patient'])
		}
  })
}

