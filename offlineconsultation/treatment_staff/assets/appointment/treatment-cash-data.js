$.ajax({
	url:"action/appointment/fetch-all-treatment-cash.php",
	success:function(treatment_result){
		let treatment_result_json = jQuery.parseJSON(treatment_result)
		$('#treatment_report').append(`<tr>
			<td>1</td>
			<td>${treatment_result_json[0]['date']}</td>
			<td>${treatment_result_json[0]['invoice_count']}</td>
			<td>${treatment_result_json[0]['total_collection_gpay']}</td>
			<td>${treatment_result_json[0]['total_collection_cash']}</td>
			<td>${treatment_result_json[0]['total_collection_card']}</td>
			<td>${treatment_result_json[0]['total_collection']}</td>
		</tr>`)
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