let search_val = '';
let start_val = '';
let end_val = '';
$('#date_filter').click(function(){
	start_val = $('#start_date').val()
	end_val = $('#end_date').val()
	fetch_doctor_report()
	
})

$('#serach_btn').click(function(){
	search_val = $('.search_val').val()
	fetch_doctor_report()
})
fetch_doctor_report()
function fetch_doctor_report(){
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
	}
})
}