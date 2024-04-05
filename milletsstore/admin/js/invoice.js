let start_limit = 0;
let end_limit = 25;
let limit_range = start_limit+','+end_limit
let search_val = '';
let start_date = '';
let end_date = '';
let last_num = '';
let status_id = 0;
fetch_bill_count()
function fetch_bill_count(){
	$.ajax({
		url:"action/fetch_bill_count.php",
		type:"POST",
		data:{search_val:search_val,
			 start_date:start_date,
			  end_date:end_date,
			  status_id:status_id
			 },
		success:function(result){
			
			pageCount_drop_down(end_limit,result)
			pageSplit_num(end_limit,result)
			fetch_all_bill_details()
		}
	})
}

$('#pagenation_drop').change(function(){
    let page_count_val = $(this).val()
    limit_range = start_limit+","+page_count_val;
    end_limit = page_count_val;
	fetch_bill_count()
})

        // delete alert 
        $(document).ready(function () {
                    let id = 0;
    $('body').delegate('.tableDeleteBtn','click',function(e){
		id = $(this).attr('data-id')
              e.preventDefault();
            $('.deleteAlert').fadeIn();
            $('.shimmer').fadeIn();
           
        });
        $('.closedeleteAlert').click(function(){
            $('.deleteAlert').fadeOut();
            $('.shimmer').fadeOut();
        });
        $('.confirmdeleteAlert').click(function(){
			$.ajax({
				url:"action/delete_invoice.php",
				type:"POST",
				data:{id:id},
				success:function(result_data){
					$('.deleteAlert').fadeOut();
            		$('.shimmer').fadeOut();
					fetch_bill_count()
				}
			})
            
        });
        
    })

        function pageSplit_num(end_limit,total_num){
            $('#page_num').empty()
            let num = 0;
            if(total_num <=end_limit){
				$('.paginationCount').css('display','none')
                num = 1;
            }else{
				$('.paginationCount').css('display','flex')
                let div_num = total_num/end_limit
                if(div_num <= 1){
                    num = 2;
                }else{
                    num = parseInt(div_num);
                    if(total_num % end_limit != 0){
                    	num += 1;
                	}
                }
                
            }
            let x1 = 1;
		
           while(x1<=num){
				last_num = num;
                if(x1 == 1){
                    $('#page_num').append(`<li class="navigationActive"><span>${x1}</span></li>`)
                }else{
                    $('#page_num').append(`<li><span>${x1}</span></li>`)
                }
                x1++;
            }
        }

function pageCount_drop_down(end_limit,total_num){
	let current_limit = end_limit;
    $('#pagenation_drop').empty()
    while(total_num>0){
        $('#pagenation_drop').append(`<option value="${current_limit}">${current_limit}</option>`)
        total_num -= current_limit;
        if(current_limit == 15){
            current_limit = 25;
        }else{
            current_limit += 25;
        }
    }
}
        $('#first_row').click(function(){
			
            $('#page_num li').removeClass('navigationActive')
            $('#page_num li').each(function(){
                if($(this).text() == 1){
                    $(this).addClass('navigationActive')
                }
            })
            start_limit = 0;
            limit_range = start_limit+","+end_limit
			fetch_all_bill_details()
        })

        $('#last_row').click(function(){
            $('#page_num li').removeClass('navigationActive')
            $('#page_num li').each(function(){
                if($(this).text() == last_num){
                    $(this).addClass('navigationActive')
                }
            })
            start_limit = (last_num-1)*end_limit;
            limit_range = start_limit+","+end_limit
            fetch_all_bill_details()
        })

        $('body').delegate('#page_num li','click',function(){
            let page_num = $(this).text()
            $('#page_num li').removeClass('navigationActive')
            $(this).addClass('navigationActive')
            let last_limit_count = page_num-1;
            start_limit = last_limit_count*end_limit
            limit_range = start_limit+','+end_limit
			fetch_all_bill_details()
        })
        $('#pagenation_drop').change(function(){
            let page_count_val = $(this).val()
            limit_range = start_limit+","+page_count_val;
            last_limit = page_count_val;
            end_limit = page_count_val;
            fetch_bill_count()
        })

function fetch_all_bill_details(){
	console.log("status_id "+status_id)
fetch('action/invoice.php?search_val='+search_val+'&start_date='+start_date+'&end_date='+end_date+'&status_id='+status_id+'&limit_range='+limit_range)
.then(Response=>Response.json())
.then(data=>{
    let si_No=start_limit;
    //let html_name = '';
    console.log(data)
	$('#tbl_details tbody').empty()
if(data.length!=0){
	$('#actual_amt_data').text(`₹ ${data[0]['total_actual_amt']}`)
	$('#total_tax_data').text(`₹ ${data[0]['total_tax_amt']}`)
	$('#total_amt_data').text(`₹ ${data[0]['total_amt_data']}`)
	$('.elseDesign').css('display','none')
   for(let x=0;x<data.length;x++){
	    si_No++;
                        $('#tbl_details tbody').append(`<tr>
                        <td data-label="Sl No">
                            <p>${si_No}</p>
                        </td>
                        <td data-label="Invoice No">
                            <p>${data[x]['invoice_no']}</p>
							<div class="cancelledAlert"><i class="uil uil-info-circle"></i> Cancelled</div>
                        </td>
                        <td data-label="Action">
                            <div class="tableBtnArea">
                                <a href="" data-id="${data[x]['id']}" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                </a>
                            </div>
                        </td>
                        <td data-label="Customer Name">
                            <p>${data[x]['customer_name']}</p>
                        </td>
                        <td data-label="Products Name">
                            <p>${data[x]['product_name']}</p>
                        </td>
                        <!--<td data-label="Category">
                            <p>${data[x]['category_name']}</p>
                        </td>-->
                        <td data-label="Date">
                            <p>${data[x]['date']}</p>
                        </td>
                        <td data-label="Staff Name">
                            <p>${data[x]['staff_name']}</p>
                        </td>
						<td data-label="Actual Price">
                            <p>₹ ${data[x]['actual_amt']}</p>
                        </td>
 						<td data-label="Total Tax">
                            <p>₹ ${data[x]['total_tax']}</p>
                        </td>
                        <!--<td data-label="Branch">
                            <p>Palakkadu</p>
                        </td>-->
                        <td data-label="Total Amount">
                            <p>₹ ${data[x]['total_price']}</p>
                        </td>
                        <td data-label="Cancel Receipt">
                            <div class="cancelReceipt" data-id=${data[x]['id']}>Cancel Receipt</div>
                        </td>
						<td data-label="Action">
                            <div class="tableBtnArea">
                                <a href="edit-bill.php?id=${data[x]['id']}" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                </a>
                                
                            </div>
                        </td>
                    </tr>
            `)
           
}
}else{
	$('.elseDesign').css('display','flex')
	$('#actual_amt_data').text(`₹ 0`)
	$('#total_tax_data').text(`₹ 0`)
	$('#total_amt_data').text(`₹ 0`)
}
})
	$('.export_reports').attr('href', 'action/export_all_invoicereports.php?search_val='+search_val+'&start_date='+start_date+'&end_date='+end_date+'&status_id='+status_id)
$('.export_reports').text('Export Excel')
 }



	  

// serach status
$('#search_btn').click(function(){
    search_val = $('#search_val').val();
	fetch_bill_count()
})


fetch('action/filter_staff.php')
            .then(Response=>Response.json())
            .then(data=>{
                console.log(data)
           if(data.length!=0)
               for(let x=0;x<data.length;x++){
                //    console.log(data)
$('.staff').append(`
                    <div class="formGroup">
                            <input type="checkbox" class="filter_staff" id="test${x}"  value="${data[x]['id']}">
                            <label for="test${x}">${data[x]['staff_name']}</label>
                        </div>

`);
}
})


//date range filter
$('#date_btn').click(function(){
	start_date = $('#date_val').val();
	end_date = $('#date_val1').val();
	fetch_bill_count()
	fetch_all_bill_details()
})


$("body").delegate('.tablePrintBtn','click',function(e){
    e.preventDefault();
    let customer_id = $(this).attr('data-id')    
    $.when(printbill(customer_id)).then(function(){
        window.print()
    });  
	function printbill(customer_id) {
		return $.ajax({
                        url: "action/fetchbill.php",
                        type:"POST",
                        data:{customer_id:customer_id},
                        success: function (result) {
							if(result != 0){
								let result_json = jQuery.parseJSON(result)
							
								let tax_in_per_data = result_json[0]['tax_in_per']
								$('#unique_id_text').text(result_json[0]['invoice_no'])
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
								$('#total_amt_3').text('₹ '+result_json[0]['total_price_q'])
								//$('#tax_total').text('₹ '+result_json[0]['total_tax'])
								$('#cgst').text('₹ '+result_json[0]['total_cgst'])
								$('#sgst').text('₹ '+result_json[0]['total_sgst'])
								let product_details = result_json[0]['product']
								//$('.printDesignTable tbody').empty();
								$('.printDesignTable2').empty();
								
								$('.taxDiv').empty();
								let SINO = 0;
								for(let x=0;x<product_details.length;x++){
									SINO++;
									let net_total = product_details[x]['price']*product_details[x]['quantity']
									$('.printDesignTable2').append(`

					<ul>
						<li>
							<p style="font-size: 16px;">${SINO} - ${product_details[x]['product_name']}</p>
						</li>
						<li>
							<span>HSN Code</span>
							<p>${product_details[x]['hsn_number']}</p>
						</li>
						<li>
							<span>Batch No</span>
							<p>${product_details[x]['batch_name']}</p>
						</li>
						<li>
							<span>Expire Date</span>
							<p>${product_details[x]['expiry_date']}</p>
						</li>
						<li>
							<span>QTY</span>
							<p>${product_details[x]['quantity']}</p>
						</li>
						<li>
							<span>Taxable Value</span>
							<p>₹ ${net_total-product_details[x]['tax_data']}</p>
						</li>
						<li>
							<span>Tax %</span>
							<p>${product_details[x]['tax_in_per']} %</p>
						</li>
						<li>
							<span>CGST</span>
							<p>₹ ${product_details[x]['cgst']}</p>
						</li>
						<li>
							<span>SGST</span>
							<p>₹ ${product_details[x]['sgst']}</p>
						</li>
						<li>
							<span>Amount(Incl Tax)</span>
							<p>₹ ${net_total}</p>
						</li>
					</ul>
					
`)
									/*$('.printDesignTable .tableInvoice').append(`
					<tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>${SINO}</td>
                            <td>${product_details[x]['product_name']}</td>
                            <td>${product_details[x]['hsn_number']}</td>
							<td>${product_details[x]['batch_name']}</td>
							<td>${product_details[x]['expiry_date']}</td>
                            <td>${product_details[x]['quantity']}</td>
                            <td>₹ ${net_total-product_details[x]['tax_data']}</td>
							<td>${product_details[x]['tax_in_per']} %</td>
							<td>₹ ${product_details[x]['cgst']}</td>
							<td>₹ ${product_details[x]['sgst']}</td>
							
                            <td>₹ ${net_total}</td>
                        </tr>`)*/
								/*}
							for(let x1 = 0;x1<tax_in_per_data.length;x1++){
								$('.taxDiv').append(`<tr>
                            <td colspan="5" class="tax_val_dis1"><b></b></td>
                            <td colspan="1"><b id="quantity_class1"></b></td>
							<td colspan="1"><b id="tax_in_per_data"></b></td>
							<td colspan="1"><b id="tax_in_per_data">@${tax_in_per_data[x1]['tax_per']}%</b></td>
							
							 <td colspan="1"><b id="total_cgst_in_per">₹ ${tax_in_per_data[x1]['total_cgst_in']}</b></td>
							 <td colspan="1"><b id="total_sgst_in_per">₹ ${tax_in_per_data[x1]['total_sgst_in']}</b></td>
							
                            <!--<td colspan="1"><b id="total_amt_3"></b></td>-->
							<!--<td></td>-->
                            <td colspan="0" style="text-align: left;"><b id="total_amt_11"></b></td>
                            <!--<td colspan="1"><b id="total_disc_val"></b></td>
                            <td colspan="1"><b id="g_total_amt"></b></td>-->
                        </tr>`)*/
									
									
									
									
									
									}
							for(let x1 = 0;x1<tax_in_per_data.length;x1++){
								let tax_temp = '';
								if(x1 == 0){	
									tax_temp = `<tr>
                            <td colspan="1"></td>
                            <td colspan="1">CGST</td>
                            <td colspan="1">SGST</td>
						</tr>`
						}
						tax_temp +=`<tr>
                            
							<td colspan="1"><b id="tax_in_per_data">Tax @ ${tax_in_per_data[x1]['tax_per']}%</b></td>
							
							 <td colspan="1"><b id="total_cgst_in_per">₹ ${tax_in_per_data[x1]['total_cgst_in']}</b></td>
							 <td colspan="1"><b id="total_sgst_in_per">₹ ${tax_in_per_data[x1]['total_sgst_in']}</b></td>
							
                            <!--<td colspan="1"><b id="total_amt_3"></b></td>-->
							<!--<td></td>-->
                            <!--<td colspan="0" style="text-align: left;"><b id="total_amt_11"></b></td>-->
                            <!--<td colspan="1"><b id="total_disc_val"></b></td>-->
                            <!--<td colspan="1"><b id="g_total_amt"></b></td>-->
                        </tr>`						
						$('.taxDiv').append(tax_temp)
							}
								
							}
                           
                        } 
                    });
	}
        function printbill1(customer_id) {
            console.log(customer_id)
            return $.ajax({
                url: "action/billprint.php",
                type:"POST",
                data:{
                    customer_id:customer_id,
                },
                success: function (result) {
                    if (result == 0) {
                        $('.printDesignProfile').empty();
                        $('.printDesignTable  table tbody').empty();
                    } else {
                        $('.printDesignProfile').empty();
                        $('.printDesignTable  table tbody').empty();
                        let datas = jQuery.parseJSON(result)
						console.log(datas)
                        let siNo = 1;
                        let template = '';
                        for (let x = 0; x < datas.length; x++) {
                        template += `
                        <tr style="page-break-inside: avoid; page-break-after: auto;">
                        <td>${siNo}</td>
                        <td>${datas[x]['product_name']}</td>
                        <td>123</td>
                        <td>${datas[x]['quantity']}</td>
                        <td>₹ ${datas[x]['price']}</td>
                        <td>₹${datas[x]['gross']}</td>
                        <td>₹ ${datas[x]['disc']}</td>
                        <td>₹ ${datas[x]['net_total']}</td>
                    </tr>
                            `;
                            siNo += 1;
                        }
                        $('.printDesignTable table tbody').append(template)


                     
                        $('.printDesignTable  table tfoot').append(`
                         <tr style="page-break-inside: avoid; page-break-after: auto;">
                        <td colspan="5"><b>(${datas[0]['amount_words']} rupees only)</b></td>
                        <td colspan="2"><b>Total Tax</b></td>
                        <td><b>₹ </b></td>
                    </tr>
                    <tr style="page-break-inside: avoid; page-break-after: auto;">
                        <td colspan="5" style="border: none; padding: 5px 12px;"></td>
                        <td colspan="2" style="border: none; padding: 5px 12px;"><b>Total Disc</b></td>
                        <td style="border: none; padding: 5px 12px;"><b>₹ ${datas[0]['total_discount']}</b></td>
                    </tr>
                    <tr style="page-break-inside: avoid; page-break-after: auto;">
                        <td colspan="5" style="border: none;"></td>
                        <td colspan="2" style="border: none;"><b>Total Amount</b></td>
                        <td style="border: none;"><b>₹ ${datas[0]['total_amount']}</b></td>
                    </tr>
                        `)


                        
                        $('.printDesignProfile').append(`<div class="printDesignProfileBox">
                        <ul>
                            <li>
                                <span>Invoice ID <b>:</b></span>
                                <p>${datas[0]['invoice_no']}</p>
                            </li>
                            <li>
                                <span>Customer Name <b>:</b></span>
                                <p>${datas[0]['customer_name']}</p>
                            </li>
                            <li>
                                <span>Mobile No <b>:</b></span>
                                <p>${datas[0]['phone']}</p>
                            </li>
                        </ul>
                    </div>
                    <div class="printDesignProfileBox">
                        <ul>
                            <li style="display:none">
                                <span>Order No <b>:</b></span>
                                <p>12345</p>
                            </li>
                            <li>
                                <span>Order Date <b>:</b></span>
                                <p>${datas[0]['date']}</p>
                            </li>
                        </ul>
                    </div>`)
                    
                    }
                }
            });
        }
    })

//apply filter
$('.applyFilter').click(function (e) {
    e.preventDefault()
        $('.filter_staff').each(function () { 
            if ($(this).prop('checked') == true) {
                status_id = $(this).val()
				fetch_bill_count()
            }
        })

})
let recipt_id = 0;
	$('body').delegate('.cancelReceipt','click', function(e){
		recipt_id = $(this).attr('data-id')
		$.ajax({
			url:"action/fetch_invoice_customer_name.php",
			type:"POST",
			data:{recipt_id:recipt_id},
			success:function(recipt_data){
				let recipt_data_json = jQuery.parseJSON(recipt_data);
				$('#customer_name').val(recipt_data_json[0]['customer_name'])
				$('#invoice_num').val(recipt_data_json[0]['invoice_no'])
				$('.cancelReciptPopup').fadeIn();
				$('.shimmer').fadeIn();
			}
		})
		
	});
	$('.cancelReciptBtn').click(function(e){
		$('.cancelReciptPopup').fadeOut();
		$('.shimmer').fadeOut();
	});
	$('.submitReciptBtn').click(function(e){
		e.preventDefault()
		let reson = $('#reson').val()
		if(reson != ''){
			$('#reson_required').text('')
		$.ajax({
				url:"action/delete_invoice.php",
				type:"POST",
				data:{id:recipt_id,
					  reson:reson,
					 },
				success:function(result_data){
					$('.cancelReciptPopup').fadeOut();
					$('.shimmer').fadeOut();
					$('#reson').val('')
					fetch_bill_count()
				}
			})
		}else{
			$('#reson_required').text('required!')
		}
		
	});
