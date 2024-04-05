$.ajax({
	url:"action/fetch_all_daily_report_date.php",
	success:function(result_data){
		
		let result_data_json = jQuery.parseJSON(result_data)
		console.log(result_data_json)
		let si_no = 0;
		$('#total_income').text('₹ '+result_data_json[0]['total_income'])
		$('#total_bill').text(result_data_json[0]['total_invoice'])
		if(result_data_json[0]['data_exist'] == 1){
			$('.elseDesign').css('display','none')
		for(let x=0;x<result_data_json.length;x++){
			si_no+=1;
			$('table tbody').append(`<tr>
                                         <td data-label="Sl No">
                                            <p>${si_no}</p>
                                          </td>
                                          <td data-label="Products Name">
                                             <p>${result_data_json[x]['date']}</p>
                                          </td>
                                          <td data-label="Products Quantity">
                                             <p>₹ ${result_data_json[x]['total_price']}</p>
                                           </td>
                                           <td data-label="Price">
											 <p>${result_data_json[x]['total_patient']}</p>
                                           </td>
											<td data-label="Action">
                                                <div class="tableBtnArea">
                                                  <a href="inner-daily-reports.php?date=${result_data_json[x]['date']}" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
                                                   	</a>
												</div>
                                             </td>
                                      </tr>`)
		}
		}else{
			$('.elseDesign').css('display','flex')
		}
	}
})