let start_limit = 0;
let end_limit = 25;
let limit_range = start_limit+','+end_limit
let search_val = '';
let start_date = 0;
let end_date = 0;



$('#date_btn').click(() => {
	
start_date = $('#date_val').val();
end_date = $('#date_val1').val();
credit_reports()
	fetch_total()
	
	fetch_credit_count()
	let page = 1;
let row_count = 0;
	$.when(fetch_credit_count()).then(function(result){
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


$.ajax({
	url:"action/fetch_month_details.php",
	success:function(result_data){
		$('.pageLoader').css('display','flex')
		let result_data_json = jQuery.parseJSON(result_data)
		start_date = result_data_json[0]['start_date']
		end_date = result_data_json[0]['end_date']
		$.when(update_date_filed(start_date,end_date)).then(function(){
			
		})
		 credit_reports()
		fetch_total()
	}
})

function update_date_filed(start_date,end_date){
	$('#date_val').val(start_date)
	$('#date_val1').val(end_date)
}


$('body').delegate('#search_btn', 'click', function () {
    search_val = $('#search_val').val();
   credit_reports()
	fetch_credit_count()
	let page = 1;
let row_count = 0;
	$.when(fetch_credit_count()).then(function(result){
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
//credit_reports()
function credit_reports(){
fetch('action/fetchcreditreports.php?search_val='+search_val+'&start_date='+start_date+'&end_date='+end_date+'&limit_range='+limit_range)
.then(Response=>Response.json())
.then(data=>{
	console.log(data)
	$('#credit_reports').empty();
	let b=start_limit;
	if (data.length == 0) {
		 $('.pagination').hide();
    $('.elseDesign').css({
      display: 'flex'
    })
  }else {
	  $('.elseDesign').css({
              display: 'none'
            })
	for(let x=0;x<data.length;x++){
		b++;
		let template=`

<tr>
                        <td data-label="Sl No">
                            <p>${b}</p>
                        </td>
                        <td data-label="Invoice No">
                            <p>${data[x]['credit_note_invoice_number']}</p>
							
                        </td>
                       
                        <td data-label="Customer Name">
                            <p>${data[x]['customer_name']}</p>
                        </td>
                        <td data-label="Products Name">
                            <p>${data[x]['phone']}</p>
                        </td>
                       <td data-label="Actual Price">
                            <p>₹ ${data[x]['total_price_1']}</p>
                        </td>
                        <td data-label="Date">
                            <p>${data[x]['date']}</p>
                        </td>
                       	
						 <td data-label="Action">
                            <div class="tableBtnArea">
                                <a href="" data-id="${data[x]['id']}" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>`
		
		$('#credit_reports').append(template)
	}
  }
})
	$('.export_reports').attr('href', 'action/export_all_creditreports.php?search_val='+search_val+'&start_date='+start_date+'&end_date='+end_date)
$('.export_reports').text('Export Excel')

}

$("body").delegate('.tablePrintBtn','click',function(e){
    e.preventDefault();
    let customer_id = $(this).attr('data-id')    
    $.when(printbill(customer_id)).then(function(){
        window.print()
    });
})
	
function printbill(customer_id) {              
	return $.ajax({
		url: "action/fetchcreditnotebill.php",
		type:"POST",
		data:{tbl_id:customer_id},
		success: function (result) {
			if(result != 0){
				let result_json = jQuery.parseJSON(result)
				console.log(result_json)

				let tax_in_per_data = result_json[0]['tax_in_per']
				$('#unique_id_text').text(result_json[0]['credit_note_invoice_number'])
				$('#customer_name_text').text(result_json[0]['customer_name'])
				$('#mob_num_text').text(result_json[0]['phone'])
				$('#order_date_text').text(result_json[0]['date'])
				$('#invoice_data_details').css('display','none')
				if(result_json[0]['tax_apply']  == 1){
					$('#g_total_tax').text('₹ '+result_json[0]['total_tax_amt'])
					$('#invoice_data_details').css('display','flex')
					$('#tax_id_text').text(result_json[0]['tax_compained_val'])
				}else{
					$('#g_total_tax').text('₹ '+0)
				}
				$('#total_disc_val').text('₹ '+result_json[0]['total_discount'])
				$('#g_total_amt').text('₹ '+result_json[0]['total_amount'])
				$('#amt_in_words').text('('+result_json[0]['amount_words']+' only)')
				$('#quantity_class').text(result_json[0]['total_quantity'])
				$('#total_amt_1').text('₹ '+result_json[0]['total_price_1'])
				$('#total_amt_3').text('₹ '+result_json[0]['total_price_1'])
				//$('#tax_total').text('₹ '+result_json[0]['total_tax'])
				$('#cgst').text('₹ '+result_json[0]['total_cgst'])
				$('#sgst').text('₹ '+result_json[0]['total_sgst'])
				let product_details = result_json[0]['product']
				$('.printDesignTable tbody').empty();
				let SINO = 0;
				for(let x=0;x<product_details.length;x++){
					SINO++;
					let net_total = product_details[x]['price']*product_details[x]['quantity']
					$('.printDesignTable .tableInvoice').append(`
					<tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>${SINO}</td>
                            <td>${product_details[x]['product_name']}</td>
                            <td>${product_details[x]['hsn']}</td>
							<td>${product_details[x]['batch']}</td>
							<td>${product_details[x]['expiry']}</td>
                            <td>${product_details[x]['returned_qty']}</td>
							<td>₹ ${product_details[x]['returned_amount']-product_details[x]['tax_data']}</td> 
                            <td>${product_details[x]['tax_in_per']} %</td> 
							<td>₹ ${product_details[x]['cgst']}</td> 
							<td>₹ ${product_details[x]['sgst']}</td> 

							 <td>₹ ${product_details[x]['returned_amount']}</td> 
                        </tr>`)
				}




			}

		} 
	});
}

//fetch total amount
fetch_total()
function fetch_total(){
fetch('action/fetch_credit_totalamount.php?start_date='+start_date+'&end_date='+end_date)
.then(Response=>Response.json())
.then(data=>{
	console.log(data)
	$('#actual_amt_data').empty();
	$('#actual_amt_data').append(`₹  ${data[0]['total_amount']}`)
})
}

	
	
	
//fetch count
fetch_credit_count()
function fetch_credit_count(){
	
	return $.ajax({
		url:"action/fetch_credit_count.php",
		type:"POST",
		data:{search_val:search_val,
			  start_date:start_date,
			  end_date:end_date,
			  
			 },
		success:function(result){
			console.log(result)
			
		credit_reports()
		
		}
	})
}

//pagination
const element = document.querySelector(".pagination ul");

let page = 1;
let row_count = 0;
//console.log(row_count)


$.when(fetch_credit_count()).then(function(result){
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
			credit_reports()
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

	