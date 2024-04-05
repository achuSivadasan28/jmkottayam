$('#professional_data').submit(function(e){
	e.preventDefault()
	$('#save_data').text('Loading...')
	let designation_data = $('#designation_data').val()
	let qualification_data = $('#qualification_data').val()
	let experiance_data = $('#experiance_data').val()
	let reg_num = $('#reg_num').val()
	$.ajax({
		url:"action/profile/add_professional.php",
		type:"POST",
		data:{designation_data:designation_data,
			 qualification_data:qualification_data,
			  experiance_data:experiance_data,
			  reg_num:reg_num
			 },
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			if(result_data_json[0]['status'] ==1){
			$('#save_data').text('Success')
			setTimeout(function(){
				window.location.href="profile.php"
			},1000)
			}else{
				window.location.href="../login.php"
			}
		}
	})
})

$.ajax({
	url:"action/profile/fetch_professional.php",
	success:function(result_data){
		let result_data_json = jQuery.parseJSON(result_data)
		//console.log(result_data_json)
		if(result_data_json[0]['status'] == 1){
			$('#designation_data').val(result_data_json[0]['designation_data'])
			$('#qualification_data').val(result_data_json[0]['qualification_data'])
			$('#experiance_data').val(result_data_json[0]['experiance_data'])
			$('#reg_num').val(result_data_json[0]['reg_num'])
		}
		
	}
})

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