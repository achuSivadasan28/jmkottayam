var inserted=0;

let search_val='';

$('.invoice_search').click(function(){
    search_val = $('#invoice_num').val();
	
	
	invoice_data()
	})


//fetch invoices
//invoice_data()
 function invoice_data(){
        $.ajax({
       url:"action/fetch_invoice_details_individually.php",
       type:"POST",
       data:{
        search_val:search_val,
      },
       success:function(data1){
 let invoice_result_json = jQuery.parseJSON(data1);
      console.log(invoice_result_json)
		   
		   $('#invoice_no').val(invoice_result_json[0]['invoice_id'])
		   $(".dynamicEditProductDetails").empty()
		   for(let x = 0;x<invoice_result_json[0]['product_details'].length;x++){
			if(x == 0){
                let template_data = `<div class="customeInputArea all_product_data"> 
<div class="formGroup"> 
<label>Product Name</label> 
<div class="customDropDown product_name_drop">
<input type="search"  class="customDropInput ProductName" value="${invoice_result_json[0]['product_details'][x]['product_name']}" disabled>
<input type="hidden"  class="ProductName_id" value="${invoice_result_json[0]['product_details'][x]['product_id']}">
									
								</div>
</div> 
<div class="formGroup">
                                <label>No.of Pills</label>
								<div class="customDropDown product_no_pill">
									<input type="text" class="customDropInput Productnopill" id="searchbox" value="${invoice_result_json[0]['product_details'][x]['no_pills']} (exp : ${invoice_result_json[0]['product_details'][x]['expiry_date']})" disabled>
									<input type="hidden" class="Productnopill_id" id="searchbox" value="${invoice_result_json[0]['product_details'][x]['pills_id']}">
									<ul class="Productnopill1ul">`
										if(invoice_result_json[0]['product_details'][x]['product_price_details'] != undefined){
											let invoice_len_data = invoice_result_json[0]['product_details'][x]['product_price_details'].length
											for(let y1 = 0;y1<invoice_len_data;y1++){
												let medicine_d_id = invoice_result_json[0]['product_details'][x]['product_price_details'][y1]['id'];
												let medicine_d_no_pill = invoice_result_json[0]['product_details'][x]['product_price_details'][y1]['no_of_pills'];
												template_data += `<li data-id=${medicine_d_id}>${medicine_d_no_pill} (exp : ${invoice_result_json[0]['product_details'][x]['product_price_details'][y1]['expiry_date']})</li>`
											}
										}
									template_data +=`</ul>
								</div>
                        </div>
<input type="hidden" disabled class="product_id" id="product_id" value="${invoice_result_json[0]['product_details'][x]['product_id']}"> 
<input type="hidden" disabled class="product_id_details" id="product_id_details" value="${invoice_result_json[0]['product_details'][x]['p_d_id']}"> 
<div class="formGroup">  
<label>Rate</label>
<input type="number" disabled class="Price" value="${invoice_result_json[0]['product_details'][x]['price']}" disabled> </div> 

<div class="formGroup" style="display:none"> 
<label>Discount Per Piece</label> 
<input type="text" class="discount" value="${invoice_result_json[0]['product_details'][x]['discount']}" disabled> 
<span style="color:red" id="discount_error"></span>  
</div>  

<div class="formGroup">  
<label>Quantity</label>
<input type="text" class="Quantity" id="quant" value="${invoice_result_json[0]['product_details'][x]['no_quantity']}" disabled> <span id="quantity_err" style="color:red"></span> </div> 
<input type="hidden" disabled class="gross" id="gross">
<div class="formGroup">
                        <label>Tax in %</label>        
                                <input type="number" disabled class="tax_in_per" id="tax_in_per" value="${invoice_result_json[0]['product_details'][x]['tax_in_per']}" disabled>                                    
                            </div>
						<div class="formGroup">
                                <label>Total Tax</label>
                                <input type="number" disabled class="tax_data" id="tax_data" value="${invoice_result_json[0]['product_details'][x]['tax_data']}" disabled>                                    
                            </div>
<div class="formGroup"> 
 <label>Total Price</label>
<input type="number" disabled class="Rate" value="${invoice_result_json[0]['product_details'][x]['total_price']}" disabled> </div>
<div class="formGroup" >
                                <label>Returned Quantity</label>
                                <input type="text" class="remainingqty"> 
<span style="color:red" class="qty_error"></span>  
                                                                 
                            </div>
						 <div class="formGroup" >
                                <label>Amount to Return</label>
                                <input type="text" class="total_amnt" disabled> 
                                                               
                            </div>

<div class="dummyDiv"></div></div>`;
					$(".dynamicEditProductDetails").append(template_data);
		}else{
						             let template_data = `<div class="customeInputArea all_product_data"> 
<div class="formGroup"> <label>Product Name</label><div class="customDropDown product_name_drop">
									<input type="search"  class="customDropInput ProductName" value="${invoice_result_json[0]['product_details'][x]['product_name']}" disabled>
<input type="hidden"  class="ProductName_id" value="${invoice_result_json[0]['product_details'][x]['product_id']}">
									<ul >
										
									</ul>
								</div>
<!--<input type="text" placeholder="Product Name"  list="ProductName" class="ProductName"> 
<input type="hidden" placeholder="Product Name"> 
                <span id="product_error" style="color:red"></span> 
<datalist class="ProductName1" id="ProductName">  
		</datalist> --></div> 
<div class="formGroup">
                              <label>No.of Pills</label>
								<div class="customDropDown product_no_pill">
									<input type="text" placeholder="Select" class="customDropInput Productnopill" id="searchbox" value="${invoice_result_json[0]['product_details'][x]['no_pills']}  (exp : ${invoice_result_json[0]['product_details'][x]['expiry_date']})" disabled>
									<input type="hidden" class="Productnopill_id" id="searchbox" value="${invoice_result_json[0]['product_details'][x]['pills_id']}" disabled>
									<ul class="Productnopill1ul">`
										
									template_data += `</ul>
								</div>
                        </div>
<input type="hidden" disabled class="product_id" id="product_id" value="${invoice_result_json[0]['product_details'][x]['product_id']}"> 
<input type="hidden" disabled class="product_id_details" id="product_id_details" value="${invoice_result_json[0]['product_details'][x]['p_d_id']}"> 
<div class="formGroup">  <label>Rate</label>
<input type="number" disabled class="Price" value="${invoice_result_json[0]['product_details'][x]['price']}" disabled> </div> 

<div class="formGroup" style="display:none"> 
<label>Discount Per Piece</label> 
<input type="text" class="discount" value="${invoice_result_json[0]['product_details'][x]['discount']}" disabled> 
<span style="color:red" id="discount_error"></span>  
</div>  

<div class="formGroup">  
<label>Quantity</label>
<input type="text" class="Quantity" id="quant" value="${invoice_result_json[0]['product_details'][x]['no_quantity']}" disabled> <span id="quantity_err" style="color:red"></span> </div> 
<input type="hidden" disabled class="gross" id="gross">
<div class="formGroup">
<label>Tax in %</label>
<input type="number" disabled class="tax_in_per" id="tax_in_per" value="${invoice_result_json[0]['product_details'][x]['tax_in_per']}" disabled>                                    
</div>
<div class="formGroup">
<label>Total Tax</label>
  <input type="number" disabled class="tax_data" id="tax_data" value="${invoice_result_json[0]['product_details'][x]['tax_data']}" disabled>                                    
</div>
<div class="formGroup">
<label>Total Price</label>
<input type="number" disabled class="Rate" value="${invoice_result_json[0]['product_details'][x]['total_price']}" disabled> </div>
<div class="formGroup" >
                                <label>Returned Quantity</label>
                                <input type="text" class="remainingqty">
<span style="color:red" class="qty_error"></span>  
                                                                 
                            </div>
						 <div class="formGroup" >
                                <label>Amount to Return</label>
                                <input type="text" class="total_amnt"  disabled>  
                                                               
                            </div>
 
<div class="dummyDiv"></div></div>`;
					$(".dynamicEditProductDetails").append(template_data);
		}
		}
	   }
		})
 }

//returning qty key up
$('body').delegate('.remainingqty', 'keyup', function (e) {
        e.preventDefault();
    
        let parsent_div = $(this).parent().parent();
	let remaining_qty = parsent_div.find('.remainingqty').val();
	let actual_rate =  parsent_div.find('.Price').val();
let actual_qty = parseInt(parsent_div.find('.Quantity').val());
	let actual_price_data = parsent_div.find('.Rate').val();
 let total_price = remaining_qty*actual_rate;
	let amount_to_return=actual_price_data - total_price;
	let amount_given=0;
	if(amount_to_return == 0){
	amount_given=actual_price_data;
	}else{
	amount_given=total_price;
	}

if(remaining_qty<=actual_qty){
	
let data_append=parsent_div.find('.total_amnt').val(amount_given);
	parsent_div.find('.qty_error').text('')
}else{
	parsent_div.find('.total_amnt').val('');
parsent_div.find('.qty_error').text('*Returning quantity must be less than the actual quantity')

}
})

//on submitting form 
$('.aBtn1').click(function(e){
	e.preventDefault();
	
	$('.aBtn1').text('Loading...')
		$('.aBtn1').prop('disabled',true)
	$('#common_error_data').text('')
		$.when(stock_validation()).then(function(stock_valid){
			console.log(stock_valid)
							if(stock_valid != 0){
								
	$.when(add_user_details()).then(function(customer_id_data){
			  let customer_id_json = jQuery.parseJSON(customer_id_data)
			  let customer_id = customer_id_json[0]['cid']
$.when(save_product_details(customer_id)).then(function(inserted){
	//console.log(inserted)
	
	setTimeout(function(){	
						$('.aBtn1').text('Success')
		},1000)
							    
setTimeout(function(){
	$.when(printbill(customer_id)).then(function(){
					
							window.print();
							setTimeout(function(){
								
								window.location.reload();
								
						})	
					});
	
	
	},2000)
})
	})
							}else{
							$('#common_error_data').text('*please fill atleast one remaining qty')
								$('.aBtn1').prop('disabled',false)
            window.scrollTo({top: 0, behavior: 'smooth'});
            $('.aBtn1').text('Save')
							
							}
		})
		


})


 function add_user_details(){
      let invoice_number = $('#invoice_num').val()
      let invoice_id = $('#invoice_no').val()      
     
	  
	   return $.ajax({
          url:"action/add-creditinvoice.php",
          type:"POST",
          data:{invoice_number:invoice_number,
                invoice_id:invoice_id,
              }
            })
	  
	  
	  }

function save_product_details(customer_id){
$('.all_product_data').each(function(){
           let product_id=$(this).find('.ProductName_id').val()
		   let Productnopill_id = $(this).find('.Productnopill_id').val()
           let ProductName = $(this).find('.ProductName').val()
           let CategoryName = $(this).find('.CategoryName').val()
           let Price = $(this).find('.Price').val()
           let discount = $(this).find('.discount').val()
           let Quantity = parseInt($(this).find('.Quantity').val())
           let gross = $(this).find('.gross').val()
           let Rate = $(this).find('.Rate').val()
		   let remaining_qty = parseInt($(this).find('.remainingqty').val())
		    let returned_amount = $(this).find('.total_amnt').val()
		   if(remaining_qty<=Quantity && remaining_qty!=''){
           $.ajax({
               url:"action/update_product_stock.php",
               type:"POST",
               data:{ProductName:ProductName,
                    CategoryName:CategoryName,
                    Price:Price,
                    discount:discount,
                    Quantity:Quantity,
                    amount_paid:Rate,
                  gross:gross,
                    product_id:product_id,
					 Productnopill_id:Productnopill_id,
					 remaining_qty:remaining_qty,
					 credit_invoice_id:customer_id,
					  returned_amount:returned_amount,
                    },
			   success:function(result){
			   	console.log(result)
			   }
           })
			   inserted+=1; 
		   }
	
			  	
      })
		
     }



function stock_validation(){
		let validate = 0; 
		$('.all_product_data').each(function(){
			let remaining_qty = parseInt($(this).find('.remainingqty').val())
			 let Quantity = parseInt($(this).find('.Quantity').val())
			 
			 if (remaining_qty !== ""  &&remaining_qty <=Quantity ) { // If input box has a value
      validate += 1;
      //return false; // Exit the loop
    }	
		})
	
	 
		return validate;
	}

function printbill(customer_id){
  return $.ajax({
                        url: "action/fetchcreditnotebill.php",
                        type:"POST",
                        data:{tbl_id:customer_id},
                        success: function (result) {
							let data = jQuery.parseJSON(result);
							console.log(data)
							
							 let product_details = data[0]['product'];
							 
            $('#unique_id_text').text(data[0]['credit_note_invoice_number'])
								
								$('#order_date_text').text(data[0]['date'])
        
        let SINO = 0;
								for(let x=0;x<product_details.length;x++){
									SINO++;
									$('.printDesignTable2').append(`

					<ul>
						<li>
							<p style="font-size: 20px;">${SINO} - ${product_details[x]['product_name']}</p>
						</li>
						
						<li>
							<span>Returning QTY</span>
							<p>${product_details[x]['returned_qty']}</p>
						</li>
						<li>
							<span>Returned Amount</span>
							<p>₹ ${product_details[x]['returned_amount']}</p>
						</li>
						
					</ul>
					
`)
									
									
									
								}
							
						$('#total_amnts').append(` <tr style="border-top: none; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="1"></td>
                            <td class="tax_val_dis"><b>Total Amount</b></td>
                            <td style="text-align: left;"><b id="total_amt_1">₹ ${data[0]['total_price_1']}</b></td>
                        </tr>`)
							
							
						}
  })

}



