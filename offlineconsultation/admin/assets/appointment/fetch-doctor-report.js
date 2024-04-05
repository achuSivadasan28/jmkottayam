let search_val = '';
let start_val = '';
let end_val = '';
$.ajax({
	url:"action/appointment/fetch_month_details.php",
	success:function(result_data){
		let result_data_json = jQuery.parseJSON(result_data)
		start_val = result_data_json[0]['start_date']
		end_val = result_data_json[0]['end_date']
		$.when(update_date_filed(start_val,end_val)).then(function(){
			
		})
		//fetch_report()
	}
})
function update_date_filed(start_date,end_date){
	$('#start_date').val(start_date)
	$('#end_date').val(end_date)
	fetch_doctor_report()
}
$('#date_filter').click(function(){
	start_val = $('#start_date').val()
	end_val = $('#end_date').val()
	fetch_doctor_report()
	
})

$('#serach_btn').click(function(){
	search_val = $('#search_val').val()
	console.log(search_val)
	fetch_doctor_report()
})
//fetch_doctor_report()
function fetch_doctor_report(){
	console.log("hi")
	console.log(search_val)
$.ajax({
	url:"action/appointment/fetch_doctor_data.php",
	type:"POST",
	data:{search_val:search_val,
		 start_val:start_val,
		  end_val:end_val,
		 },
	success:function(doctor_result){
	//console.log(doctor_result)
		let doctor_result_json = jQuery.parseJSON(doctor_result)
		console.log(doctor_result_json)
		$('.tableWraper tbody').empty()
		if(doctor_result_json.length !=0){
			let si_no = 0;
			for(let x = 0;x<doctor_result_json.length;x++){
				si_no++;
				$('.tableWraper tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p>${si_no}</p>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>${doctor_result_json[x]['doctor_name']}</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>${doctor_result_json[x]['phone_no']}</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>${doctor_result_json[x]['patient_num_offline']}</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>${doctor_result_json[x]['new_patient_count']}</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>${doctor_result_json[x]['old_patient_count']}</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>${doctor_result_json[x]['patient_num_online']}</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>${doctor_result_json[x]['online_old_patient_count']}</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>${doctor_result_json[x]['new_online_patient_count']}</p>
                                                    </td>
                                                    
                                                    
                                                </tr>`)
			}
		}
		$('.pageLoader').fadeOut();
	}
})
}