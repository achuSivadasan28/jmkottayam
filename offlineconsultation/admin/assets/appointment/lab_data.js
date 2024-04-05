$.ajax({
	url:"action/appointment/fetch_lab_data.php",
	success:function(result){
		let result_json = jQuery.parseJSON(result)
		let si_no = 0;
		if(result_json[0]['status'] !=0){
			if(result_json[0]['data_exist'] !=0){
				$('.elseDesign').css('display','none')
		for(let x=0;x<result_json.length;x++){
			si_no++;
			$('.tableWraper table tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p>${si_no}</p>
                                                    </td>
                                                    <td data-label="Lab Name">
                                                        <p>${result_json[x]['test_name']}</p>
                                                    </td>
                                                    <td data-label="Amount">
                                                        <p>₹ ${result_json[x]['mrp']}</p>
                                                    </td>
                                                </tr>`)
			
		}
			}else{
				$('.elseDesign').css('display','flex')
			}
		}else{
			
		}
	}
})