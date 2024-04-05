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
				$('#profile_name').text(profile_result_json[0]['doctor_name'])
				$('#staff_profile_branch').text(profile_result_json[0]['branch_name'])
				if(profile_result_json[0]['proPic'] != ''){
				$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				}
			}
		}
	})
}

$.ajax({
	url:"action/profile/profile_details.php",
	success:function(profile_result_data){
		let profile_result_data_json = jQuery.parseJSON(profile_result_data)
		if(profile_result_data_json[0]['status'] == 1){
			$('#phnNum').text(profile_result_data_json[0]['phone_no'])
			$('#email').text(profile_result_data_json[0]['email'])
			$('#address').text(profile_result_data_json[0]['department_name'])
			$('#place').text(profile_result_data_json[0]['branch_name'])
			
			if(profile_result_data_json[0]['proPic'] != ''){
				$('#pro_pic1').attr('src','assets/images/profile_pic/'+profile_result_data_json[0]['proPic'])
				}
		}
	}
})
$.ajax({
	url:"action/profile/fetch_professional.php",
	success:function(result_data){
		let result_data_json = jQuery.parseJSON(result_data)
		//console.log(result_data_json)
		if(result_data_json[0]['status'] == 1){
			if(result_data_json[0]['designation_data'] != ''){
				$('#designation_data').text(result_data_json[0]['designation_data'])
			}else{
				$('#designation_data').text('No Data')
			}
			if(result_data_json[0]['qualification_data'] != ''){
				$('#qualification_data').text(result_data_json[0]['qualification_data'])
			}else{
				$('#qualification_data').text('No Data')
			}
			if(result_data_json[0]['experiance_data'] != ''){
				$('#experiance_data').text(result_data_json[0]['experiance_data'])
			}else{
				$('#experiance_data').text('No Data')
			}
			if(result_data_json[0]['reg_num'] != ''){
				$('#reg_num').text(result_data_json[0]['reg_num'])
			}else{
				$('#reg_num').text('No Data')
			}
		}else{
			window.location.href="../login.php"
		}
		
	}
})