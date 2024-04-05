
let start_date = '';
let end_date = '';

/*let startDate = '01-05-2023';
let endDate = '04-05-2023';*/
$('#date_btn').click(() => {
	
start_date = $('#date_val').val();
end_date = $('#date_val1').val();
tax_slab()	
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
		tax_slab()
	}
})

function update_date_filed(start_date,end_date){
	$('#date_val').val(start_date)
	$('#date_val1').val(end_date)
}




//tax_slab()
function tax_slab(){
fetch('action/fetchalltaxslab.php?startdate=' + start_date + '&enddate=' + end_date)
    .then(Response => Response.json())
    .then(data => {
        console.log(data)
		$('#thead_dynamic').empty()
	$('#taxslab_reports').empty()
	let b = 0;
	
  let thead =``;
  
	let tax_len =data[0]['tax_details'];
		console.log(tax_len)
	
	thead 
   += ` <th>Sl No</th>
                                                    <th>Date</th>
                                                   <th>Total_amount</th>`;
	for(let c = 0;c<tax_len.length;c++){
		let csgst = tax_len[c]['tax_in_per']/2;
		let sgst = tax_len[c]['tax_in_per']/2;
	thead 
   += `
   
   <th>Sales@${tax_len[c]['tax_in_per']}%</th>
    <th>CGST@${csgst}%</th>
	 <th>SGST@${sgst}%</th>
	 <th>Taxable Value</th>
`
  }
	//thead +=` <th>Taxable Value</th>`
	$('#thead_dynamic').append(thead);
	
	
	
	
	for (let x1 = 0; x1 < data.length; x1++) {
		 b++;
		let created_date = data[x1]['created_date']
		let tax_details=data[x1]['tax_details'];
		
	
	
		
		let cgst = '';
		let sgst='';
		
		let template =` <tr>
      <td>${b}</td>
    <td>${created_date}</td>
	<td>${data[x1]['total_sum']}</td>`
		for(let z=0;z<tax_details.length;z++){
   template +=` <td>${tax_details[z]['total_amnt']}</td>
<td>${tax_details[z]['cgst']}</td>
<td>${tax_details[z]['sgst']}</td>
<td>${tax_details[z]['total_excluding_tax']}</td>`

   
		}
 template +=`</tr>`		  
	   $('#taxslab_reports').append(template);
		
	}
	
	
})
}

$('body').delegate('.export_reports','click', function(e){
	e.preventDefault()
	//$('.export_reports').text('Exporting..')
	  $('.export_reports').attr("disabled", true);
	window.location.href="action/export_taxslabreport.php?startdate="+start_date+"&enddate="+end_date;
	
	
});