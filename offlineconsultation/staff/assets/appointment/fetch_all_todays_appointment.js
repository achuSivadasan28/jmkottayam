fetch_all_todays_appointments();
function fetch_all_todays_appointments(){
	$.ajax({
		url:"action/appointment/fetch_all_todays_appointments_data.php",
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			console.log(result_data_json)
		}
	})
}