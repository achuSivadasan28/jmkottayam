let searchval_name = '';
let start_limit = 0;
let end_limit = 25;
let limit_range = start_limit+','+end_limit

let startDate = 0;
let endDate = 0;
$('#date_filter').click(() => {
startDate = $('#startdate').val();
 endDate = $('#enddate').val();
	fee_report()
	fetch_fee_reports()
	//sum_total()
	
	let page = 1;
let row_count = 0;
	$.when(fetch_fee_reports()).then(function(result){
		console.log(result)
		row_count=result;
	console.log(row_count)
	})
	.then(() => {
	
let count_no = row_count/end_limit;
let totalPages = parseInt(count_no);
//console.log(totalPages)
	 if(row_count % end_limit != 0){
                    	totalPages += 1;
	 }
//calling function with passing parameters and adding inside element which is ul tag
element.innerHTML = createPagination(totalPages, page);
})
        })

$('body').delegate('#serach_btn', 'click', function () {
    searchval_name = $('#search_val').val();
   
	
	let page = 1;
let row_count = 0;
	$.when(fetch_fee_reports()).then(function(result){
		console.log(result)
		row_count=result;
	console.log(row_count)
	})
	.then(() => {
	
let count_no = row_count/end_limit;
let totalPages = parseInt(count_no);
//console.log(totalPages)
	 if(row_count % end_limit != 0){
                    	totalPages += 1;
	 }
//calling function with passing parameters and adding inside element which is ul tag
element.innerHTML = createPagination(totalPages, page);
	
}).then(()=>{
	
		 fee_report()
	})
})


fee_report();
function fee_report(){
	$('.pageLoader').css('display','flex');
	
fetch('action/appointment/fetch_all_appointmentfeereport.php?startdate=' + startDate + '&enddate=' + endDate + '&search=' + searchval_name +'&limit_range='+limit_range)
    .then(Response => Response.json())
    .then(data => {
        console.log(data)
	$('.tableWraper table tbody').empty()
	 if (data.length == 0) {
		 $('.pagination').hide();
    $('.elseDesign').css({
      display: 'flex'
    })
  }else {
	  $('.elseDesign').css({
              display: 'none'
            })
	let b = start_limit;
	  let gpay = data[0]['n_fee']
	  let cash = data[0]['nr_fee']
	  let card = data[0]['online_sum']
	  let treatment = data[0]['treat_sum']
	  let new_patients = data[0]['n_count']
	  let nr_patients = data[0]['nr_count']
	  let online_patient_count = data[0]['online_count'] == null ? '0' :  data[0]['online_count']
	  let treatment_count = data[0]['treat_count'] == null ? '0' :  data[0]['treat_count']
	  console.log(treatment)
	  if(gpay == undefined){
	  	gpay = 0;
	  }
	  if(cash == undefined){
	  	cash = 0;
	  }
	  if(card == undefined){
	  	card = 0;
	  }
	  if(treatment == null || treatment == undefined){
	  	treatment = 0;
	  }
	  
	  $('#gpay_amt_data').text('₹ '+gpay)
	  $('#cash_tax_data').text('₹ '+cash)
	  $('#card_amt_data').text('₹ '+card)
	   $('#trtment_amnt').text('₹ '+treatment)
	  $('#new_patients').text(`${ new_patients.toString().length === 1 ? '0' + new_patients.toString() : new_patients.toString()}`)
	  $('#renew_patients').text(`${ nr_patients.toString().length === 1 ? '0' + nr_patients.toString() : nr_patients.toString()}`)
	  //online_patients
	   $('#online_patients').text(`${ online_patient_count.toString().length === 1 ? '0' + online_patient_count.toString() : online_patient_count.toString()}`)
	  $('#treatment_count').text(`${ treatment_count.toString().length === 1 ? '0' + treatment_count.toString() : treatment_count.toString()}`)
	  let total_amt = parseInt(gpay)+parseInt(cash)+parseInt(card)
	  $('#tmt_amt_data').text('₹ '+total_amt)
	for (let x = 0; x < data.length; x++) {
		 b++;
      let template = `
 <tr>
                                                    <td data-label="Sl No">
                                                        <p>${b}</p>
                                                    </td>
                                                      <td data-label="Name">
                                                        <p>${data[x]['invoice_campain']}</p>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>${data[x]['patient_name']}</p>
                                                    </td>
                                                   <td data-label="Date">
                                                        <p>${data[x]['addedDate']}</p>
                                                    </td>
                                                <td data-label="Date">
                                                        <p>${data[x]['appointment_fee']}</p>
                                                    </td>
													<td data-label="payment mode data">
                                                        <p>${data[x]['payment_mode_data']}</p>
                                                    </td>
													
													<td data-label="Date">
                                                        <p>${data[x]['patient_type']}</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href=""  data-id="${data[x]['id']}" class="tablePrintBtn print_data" title="Print"><i class="uil uil-print"></i>
    </a>
                                                        </div>
                                                    </td>
                                                </tr>


`
	  
	   $('#fee_reports').append(template);
}
  }
})
	.then(() => {
$('.pageLoader').css('display','none')
})
	$('.export_reports').attr('href', 'action/appointment/export_all_apmntfee.php?startdate=' + startDate + '&enddate=' + endDate  + '&search=' + searchval_name)
}






//fetch count
fetch_fee_reports()
function fetch_fee_reports(){
	
	return $.ajax({
		url:"action/appointment/fetch_appointmentfee_count.php",
		type:"POST",
		data:{Searchval:searchval_name,
			  startdate:startDate,
			  enddate:endDate,
			  
			 },
		success:function(result){
			console.log(result)
			
		fee_report()
		
		}
	})
}


//print 
$('body').delegate('.print_data','click',function(e){
	e.preventDefault();
	$('.pageLoader').css('display','flex')
	let invoice_id = $(this).attr('data-id')
	//alert(invoice_id)
	$.when(print_appointmentfee_data(invoice_id)).then(function(){
				
				
				setTimeout(function(){
					window.print()
					$('.pageLoader').css('display','none')
				},2000)			
				})
})

function print_appointmentfee_data(invoice_id){
	$('.printDesign').empty()
	 $.ajax({
       url:"action/appointment/fetch_appointmentfee_print.php",
       type:"POST",
       data:{
        invoice_id:invoice_id,
           
           
       },
       success:function(data1){
	let data = jQuery.parseJSON(data1);
   console.log(data)
		   
		   
		 let template =``;
        let b = 0;
		 
        for(let x1=0;x1<data.length;x1++){
      b++;
 
      
template+=`<div class="printDesignHead">
                <div class="printDesignHeadLogo">
                    <img src="assets/images/johnmariansLogo.png" alt="">
                </div>
                <div class="printDesignHeadAddress">
					<h2>JOHNMARIAN WELLNESS HOSPITAL</h2>
					<p>P.P Road Kottayam , Meenachil P.O pala ,Kottayam 686577</p>
                    <p>Ph : 7736077731 || 8714161636 | E-mail : johnmarianwellness@gmail.com | Web : drmanojjohnson.com</p>
                    <p><b>GST Number : 32BNFPG3513BIZV</b></p>
					<h2>Tax invoice</h2>
                </div>
            </div>
            <div class="printDesignProfile">
                <div class="printDesignProfileBox">
                    <ul>
                        <li>
                            <span>Invoice No <b>:</b></span>
                            <p id="unique_id_text">${data[x1]['invoice_campain']}</p>
                        </li>
                        <li>
                            <span>Patient Name <b>:</b></span>
                            <p id="customer_name_text">${data[x1]['patient_name']}</p>
                        </li>
                       <li>
                            <span>Added Date <b>:</b></span>
                            <p id="mob_num_text">${data[x1]['addedDate']}</p>
                        </li>
                    </ul>
                </div>
                <div class="printDesignProfileBox">
                    <ul>
                        <li id="invoice_data_details" style="display:none">
                            <span>Invoice Id <b>:</b></span>
                            <p id="tax_id_text"></p>
                        </li>
                        <li style="display:none">
                            <span>Order Date & Time<b>:</b></span>
                            <p id="order_date_text"></p>
                        </li>
                    </ul>
                </div> 
            </div>
            <div class="printDesignTable">
				<div class="printDesignTable2">

     <ul>
						
						<li>
							<span>Type</span>
							<p>${data[x1]['patient_type']}</p>
						</li>
						<li>
							<span>Total Amount</span>
							<p>${data[x1]['total_paid']}</p>
						</li>
</ul>`
 

  
			
for(let y=0; y<data[x1]['appoinment_details'].length; y++){
	

	
	
    
           
              
}
            
         
  
    template+=`  </div>
               
            </div>
            <div class="printDesignTC" style="page-break-inside: avoid; page-break-after: auto;">
				<!--<h2>Bank Details</h2>
				<p>Account Name : JOHNMARIAN WELLNESS CLINIC</p>
				<p>Account Number : 306530123456789</p>
				<p>Branch: KALAMASSERY</p>
				<p>Account Type : Current Account</p>
				<p>IFSC Code : TMBL0000306</p>
				<p>MICR Code : 682060003</p>-->
                <h2>Terms & Conditions</h2>
                <p>You should not make any change in your current medications or health regimen before consulting a registered medical practitioner</p>
            </div>
    `
    
    $('.printDesign').append(template);   
		   
		  
	   }
}
	 })
}



//pagination
const element = document.querySelector(".pagination ul");

let page = 1;
let row_count = 0;
//console.log(row_count)


$.when(fetch_fee_reports()).then(function(result){
		console.log(result)
		row_count=result;
	console.log(row_count)
	
	})

	
.then(() => {
	
let count_no = row_count/end_limit;
let totalPages = parseInt(count_no);
//console.log(totalPages)
	 if(row_count % end_limit != 0){
                    	totalPages += 1;
	 }
//calling function with passing parameters and adding inside element which is ul tag
element.innerHTML = createPagination(totalPages, page);
})

function createPagination(totalPages, page){
	//console.log(totalPages)
  let liTag = '';
  let active;
  let beforePage = page - 1;
  let afterPage = page + 1;
  if(page > 1){ //show the next button if the page value is greater than 1
    liTag += `<li class="btn prev" onclick="createPagination(${totalPages}, ${page - 1})"><span><i class="fas fa-angle-left"></i> Prev</span></li>`;
  }

  if(page > 2){ //if page value is less than 2 then add 1 after the previous button
    liTag += `<li class="first numb" onclick="createPagination(${totalPages}, 1)"><span>1</span></li>`;
    if(page > 3){ //if page value is greater than 3 then add this (...) after the first li or page
      liTag += `<li class="dots"><span>...</span></li>`;
    }
  }

  for (var plength = beforePage; plength <= afterPage; plength++) {
    if (plength > totalPages) { //if plength is greater than totalPage length then continue
      continue;
    }
    if (plength == 0) { //if plength is 0 than add +1 in plength value
      plength = plength + 1;
    }
    if(page == plength){ //if page is equal to plength than assign active string in the active variable
      active = "active";
    }else{ //else leave empty to the active variable
      active = "";
    }
	  let page_num = page;
	// console.log(page_num);
          let last_limit_count = page_num-1;
            start_limit = last_limit_count*end_limit
            limit_range = start_limit+','+end_limit
			fee_report()
    liTag += `<li class="numb  ${active}" onclick="createPagination(${totalPages},${plength})"><span>${plength}</span></li>`;
  }

  if(page < totalPages - 1){ //if page value is less than totalPage value by -1 then show the last li or page
    if(page < totalPages - 2){ //if page value is less than totalPage value by -2 then add this (...) before the last li or page
      liTag += `<li class="dots"><span>...</span></li>`;
    }
    liTag += `<li class="last numb" onclick="createPagination(${totalPages}, ${totalPages})"><span>${totalPages}</span></li>`;
  }

  if (page < totalPages) { //show the next button if the page value is less than totalPage(20)
	  
    liTag += `<li class="btn next" onclick="createPagination(${totalPages}, ${page + 1})"><span>Next <i class="fas fa-angle-right"></i></span></li>`;
  }
  element.innerHTML = liTag; //add li tag inside ul tag
  return liTag; //reurn the li tag
}


