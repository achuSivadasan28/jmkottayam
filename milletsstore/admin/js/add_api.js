$.ajax({
	url:"action/fetch_all_api_values.php",
	success:function(api_value){
		let api_value_json = jQuery.parseJSON(api_value)
		$('#tbl_details_api tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
                                                    </td>
                                                    <td data-label="Payment Option">
                                                        <p>${api_value_json[0]['api_key']}</p>
                                                    </td>
                                                    
                                                </tr>`)
	}
})