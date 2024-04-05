$.ajax({
	url:"action/appointment/fetch_online_appointment_count.php",
	success:function(online_result){
		let online_result_json = jQuery.parseJSON(online_result)
		console.log(online_result_json)
		$('#online_appointment_count').text(online_result_json[0]['online_count'])
		$('#all_appointment_count').text(online_result_json[0]['all_online_count'])
		$('#scheduled_appointment_data').text(online_result_json[0]['sheduled_count'])
	}
})

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