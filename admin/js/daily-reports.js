let search_val = '';
fetch_current_data_report()
function fetch_current_data_report(){
	 $('.sckelly').css({
			display: 'flex',
		 });
$.when(fetch_current_date()).then(function(date){
	$.ajax({
	url:"action/fetch_all_daily_report.php",
	type:"POST",
	data:{date:date},
	success:function(result_data){
		console.log(result_data)
		let result_data_json = jQuery.parseJSON(result_data)
		let si_no = 0;
		$('#total_amount1').text('₹ '+result_data_json[0]['total_price'])
		$('#invoice_count1').text(result_data_json[0]['total_invoice'])
		
		$('#total_amount').text('₹ '+result_data_json[0]['total_price'])
		$('#invoice_count').text(result_data_json[0]['total_invoice'])
		for(let x=0;x<result_data_json.length;x++){
			si_no+=1;
			$('table tbody').append(`<tr>
                                         <td data-label="Sl No">
                                            <p>${si_no}</p>
                                          </td>
                                          <td data-label="Products Name">
                                             <p>${result_data_json[x]['product_name']}</p>
                                          </td>
                                          <td data-label="Products Quantity">
                                             <p>${result_data_json[x]['product_total_q']}</p>
                                           </td>
                                           <td data-label="Price">
											 <p>₹ ${result_data_json[x]['product_total_price']}</p>
                                           </td>
                                      </tr>`)
		}
	}
	})
	.then(() =>{
		$('.sckelly').css({
			display: 'none',
		 });
	
	})
	
})
}

$('#search_val').keyup(function(){
	search_val = $(this).val()
	fetch_current_data_report()
})

function fetch_current_date(){
	let url_val = window.location.href
	let url_split = url_val.split("=")
	let date = url_split[1];
	$('#date_data').text(date)
	return date;
}
