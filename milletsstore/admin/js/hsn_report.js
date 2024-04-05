let start_date = '';
let end_date = '';
let search_data = '';
$('#date_btn').click(function(){
	$('.pageLoader').css('display','flex')
	start_date = $('#date_val').val()
	end_date = $('#date_val1').val()
	fetch_report()
})

$('#search_btn').click(function(e){
	$('.pageLoader').css('display','flex')
	e.preventDefault();
	search_data = $('#search_val').val()
	fetch_report()
})

$.ajax({
	url:"action/fetch_month_details.php",
	success:function(result_data){
		$('.pageLoader').css('display','flex')
		let result_data_json = jQuery.parseJSON(result_data)
		start_date = result_data_json[0]['start_date']
		end_date = result_data_json[0]['end_date']
		$.when(update_date_filed(start_date,end_date)).then(function(){
			
		})
		fetch_report()
	}
})

function update_date_filed(start_date,end_date){
	$('#date_val').val(start_date)
	$('#date_val1').val(end_date)
}

function fetch_report(){
$.ajax({
	url:"action/hsn_report_data.php",
	type:"POST",
	data:{start_date:start_date,
		 end_date:end_date,
		 search_data:search_data,
		 },
	success:function(result_data){
		let result_data_json = jQuery.parseJSON(result_data)
		console.log(result_data_json)
		let siNo = 0;
		$('#tbl_details tbody').empty()
		$('#actual_amt_data').text(result_data_json[0]['total_taxable_value'])
		$('#total_tax_data').text(result_data_json[0]['total_tax_amt'])
		$('#total_amt_data').text(result_data_json[0]['total_amount'])
		if(result_data_json[0]['data_exist'] == 1){
			$('.elseDesign').css('display','none')
			let exe_num = 1;
		for(let x = 0;x<result_data_json.length;x++){
			siNo++;
			let cgst = result_data_json[x]['tax_data']/2;
			let sgst = result_data_json[x]['tax_data']/2;
			$('#tbl_details tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p>${siNo}</p>
                                                    </td>
													<td data-label="HSNCode">
                                                        <p>${result_data_json[x]['hsn_number']}</p>
                                                    </td>
													<td data-label="Tax">
                                                        <p>${result_data_json[x]['tax_in_per']}%</p>
                                                    </td>
													<td data-label="Quantity">
                                                        <p>${result_data_json[x]['no_quantity']}</p>
                                                    </td>
													<td data-label="Total Value">
                                                        <p>${result_data_json[x]['total_price']}</p>
                                                    </td>
													<td data-label="Taxable Value">
                                                        <p>${result_data_json[x]['taxable_value'].toFixed(2)}</p>
                                                    </td>
													<td data-label="CGST">
                                                        <p>${cgst.toFixed(2)}</p>
                                                    </td>
													<td data-label="SGST">
                                                        <p>${sgst.toFixed(2)}</p>
                                                    </td>
													<td data-label="IGST">
                                                        <p>0</p>
                                                    </td>
													<td data-label="Total Tax">
                                                        <p>${Number(result_data_json[x]['tax_data']).toFixed(2)}</p>
                                                    </td>
											</tr>`)
			exe_num++;
			if(result_data_json.length  == exe_num){
				$('.pageLoader').css('display','none')
			}
		}
		}else{
			$('.elseDesign').css('display','flex')
		}
		
	}
})
}

$('body').delegate('.export_reports','click', function(e){
	e.preventDefault()
	$('.export_reports').text('Exporting..')
	  $('.export_reports').attr("disabled", true);
	window.location.href="action/export_hsn_report.php?start_date="+start_date+"&end_date="+end_date+"&search_data="+search_data;
	
	/**$.ajax({
		url:"action/export_tax_invoice_report.php",
		type:"POST",
		data:{start_date:start_date,
		 	  end_date:end_date,
		 	  search_data:search_data},
		success:function(result_data){
			console.log(result_data)
			$('.export_reports').text('Export Excel')
	  		$('.export_reports').attr("disabled", false);
		}
	})**/
});