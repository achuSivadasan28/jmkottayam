

    fetch('action/fetch-product.php')
    .then(Response => Response.json())
    .then(data => {
		$('.product_name_drop ul').empty()
        for (x = 0; x < data.length; x++) {
			//console.log(data[x]['id'])
			
            $('.product_name_drop ul').append(`<li data-id=${data[x]['id']}>${data[x]['product_name']}</li>`);
   
        }
    })
	.then(() => {
		$('input[data-list]').each(function () {
			  var availableTags = $('#' + $(this).attr("data-list")).find('option').map(function () {
				return this.value;
			  }).get();

			  $(this).autocomplete({
				source: availableTags
			  }).on('focus', function () {
				$(this).autocomplete('search', ' ');
			  }).on('search', function () {
				if ($(this).val() === '') {
				  $(this).autocomplete('search', ' ');
				}
			  });
			});
	})

let url = window.location.href
let url_split_up = url.split('=');
var url_val = url_split_up[1];

$.ajax({
	url:"action/fetch_invoice_details.php",
	type:"POST",
	data:{url_val:url_val},
	success:function(invoice_result){
		let invoice_result_json = jQuery.parseJSON(invoice_result)
		console.log(invoice_result_json)
		$('#customer_name').val(invoice_result_json[0]['customer_name'])
		$('#phone').val(invoice_result_json[0]['phone'])
		$('#place').val(invoice_result_json[0]['place'])
		$('#Tprice').val(invoice_result_json[0]['total_amonut'])
		$('#Tdiscount').val(invoice_result_json[0]['total_discount'])
		$('#tamount').val(invoice_result_json[0]['total_amonut'])
		for(let x = 0;x<invoice_result_json[0]['product_details'].length;x++){
			if(x == 0){
                let template_data = `<div class="customeInputArea"> 
<div class="formGroup"> 
<label>Product Name</label> 
<div class="customDropDown product_name_drop">
<input type="search" placeholder="Select" class="customDropInput ProductName" value="${invoice_result_json[0]['product_details'][x]['product_name']}">
<input type="hidden"  class="ProductName_id" value="${invoice_result_json[0]['product_details'][x]['product_id']}">
									<ul >
										
									</ul>
								</div>
</div> 
<div class="formGroup">
                                <label>No.of Pills</label>
								<div class="customDropDown product_no_pill">
									<input type="text" placeholder="Select" class="customDropInput Productnopill" id="searchbox" value="${invoice_result_json[0]['product_details'][x]['no_pills']} (exp : ${invoice_result_json[0]['product_details'][x]['expiry_date']})">
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
<input type="number" disabled class="Price" value="${invoice_result_json[0]['product_details'][x]['price']}"> </div> 

<div class="formGroup" style="display:none"> 
<label>Discount Per Piece</label> 
<input type="text" class="discount" value="${invoice_result_json[0]['product_details'][x]['discount']}"> 
<span style="color:red" id="discount_error"></span>  
</div>  

<div class="formGroup">  
<label>Quantity</label>
<input type="text" class="Quantity" id="quant" value="${invoice_result_json[0]['product_details'][x]['no_quantity']}"> <span id="quantity_err" style="color:red"></span> </div> 
<input type="hidden" disabled class="gross" id="gross">
<div class="formGroup">
                        <label>Tax in %</label>        
                                <input type="number" disabled class="tax_in_per" id="tax_in_per" value="${invoice_result_json[0]['product_details'][x]['tax_in_per']}">                                    
                            </div>
						<div class="formGroup">
                                <label>Total Tax</label>
                                <input type="number" disabled class="tax_data" id="tax_data" value="${invoice_result_json[0]['product_details'][x]['tax_data']}">                                    
                            </div>
<div class="formGroup"> 
 <label>Total Price</label>
<input type="number" disabled class="Rate" value="${invoice_result_json[0]['product_details'][x]['total_price']}"> </div>
<div class="removeBtn">
<button class="inputRemove product_remove_data" data-id="${invoice_result_json[0]['product_details'][x]['p_d_id']}"><i class="uil uil-trash"></i></button>
		</div> 
<div class="dummyDiv"></div></div>`;
					$(".dynamicEditProductDetails").append(template_data);
		}else{
						             let template_data = `<div class="customeInputArea"> 
<div class="formGroup"> <div class="customDropDown product_name_drop">
									<input type="search" placeholder="Select" class="customDropInput ProductName" value="${invoice_result_json[0]['product_details'][x]['product_name']}">
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
                              
								<div class="customDropDown product_no_pill">
									<input type="text" placeholder="Select" class="customDropInput Productnopill" id="searchbox" value="${invoice_result_json[0]['product_details'][x]['no_pills']}  (exp : ${invoice_result_json[0]['product_details'][x]['expiry_date']})">
									<input type="hidden" class="Productnopill_id" id="searchbox" value="${invoice_result_json[0]['product_details'][x]['pills_id']}">
									<ul class="Productnopill1ul">`
										if(invoice_result_json[0]['product_details'][x]['product_price_details'] != undefined){
											let invoice_len_data = invoice_result_json[0]['product_details'][x]['product_price_details'].length
											for(let y1 = 0;y1<invoice_len_data;y1++){
												let medicine_d_id = invoice_result_json[0]['product_details'][x]['product_price_details'][y1]['id'];
												let medicine_d_no_pill = invoice_result_json[0]['product_details'][x]['product_price_details'][y1]['no_of_pills'];
												template_data += `<li data-id=${medicine_d_id}>${medicine_d_no_pill}  (exp : ${invoice_result_json[0]['product_details'][x]['product_price_details'][y1]['expiry_date']})</li>`
											}
										}
									template_data += `</ul>
								</div>
                        </div>
<input type="hidden" disabled class="product_id" id="product_id" value="${invoice_result_json[0]['product_details'][x]['product_id']}"> 
<input type="hidden" disabled class="product_id_details" id="product_id_details" value="${invoice_result_json[0]['product_details'][x]['p_d_id']}"> 
<div class="formGroup">  
<input type="number" disabled class="Price" value="${invoice_result_json[0]['product_details'][x]['price']}"> </div> 

<div class="formGroup" style="display:none"> 
<label>Discount Per Piece</label> 
<input type="text" class="discount" value="${invoice_result_json[0]['product_details'][x]['discount']}"> 
<span style="color:red" id="discount_error"></span>  
</div>  

<div class="formGroup">  
<label>Quantity</label>
<input type="text" class="Quantity" id="quant" value="${invoice_result_json[0]['product_details'][x]['no_quantity']}"> <span id="quantity_err" style="color:red"></span> </div> 
<input type="hidden" disabled class="gross" id="gross">
<div class="formGroup">
<label>Tax in %</label>
<input type="number" disabled class="tax_in_per" id="tax_in_per" value="${invoice_result_json[0]['product_details'][x]['tax_in_per']}">                                    
</div>
<div class="formGroup">
<label>Total Tax</label>
  <input type="number" disabled class="tax_data" id="tax_data" value="${invoice_result_json[0]['product_details'][x]['tax_data']}">                                    
</div>
<div class="formGroup">
<label>Total Price</label>
<input type="number" disabled class="Rate" value="${invoice_result_json[0]['product_details'][x]['total_price']}"> </div>
<div class="removeBtn">
<button class="inputRemove product_remove_data" data-id="${invoice_result_json[0]['product_details'][x]['p_d_id']}"><i class="uil uil-trash"></i></button>
		</div> 
<div class="dummyDiv"></div></div>`;
					$(".dynamicEditProductDetails").append(template_data);
		}
		}
	}
})
let btn_id = '';
let parent_div_data = '';
let p_actual_price = '';
let p_total_price = '';
let total_amt = '';
let g_total_amt = '';
let total_dis = '';
let mainremove = '';
$('body').delegate('.product_remove_data','click',function(e){
	e.preventDefault()
	btn_id = $(this).attr('data-id')
	parent_div_data = $(this).parent().parent()
	p_actual_price = parent_div_data.find('.Price').val()
	p_total_price = parent_div_data.find('.Rate').val()
	mainremove = $(this).parent().parent()
	total_amt = $('#Tprice').val()
	g_total_amt = $('#tamount').val()
	total_dis = $('#Tdiscount').val()
	$('.deleteAlert').fadeIn();
    $('.shimmer').fadeIn();
})

function update_total_Price(){
			let A_total_amt = 0;
			let G_total_amt = 0;
			let G_total_dis = 0;
			let btn_disabled_status = 0;
			$('.customeInputArea').each(function(e){
				if($(this).find('.Price').val() != ''){
						let total_rate = parseInt($(this).find('.Price').val())
						console.log(total_rate)
						let total_dis = parseInt($(this).find('.discount').val())
						let total_Qu = parseInt($(this).find('.Quantity').val())
						if(total_Qu == ''){
							total_Qu = 1;
						}
				
						A_total_amt += total_rate*total_Qu
						G_total_amt += (total_rate-total_dis)*total_Qu
						G_total_dis += total_dis*total_Qu
				
				}
						
			})
			$('.Tprice').val(A_total_amt)
			$('.Tdiscount').val(G_total_dis)
			$('.tamount').val(A_total_amt)
		}

$('.confirmdeleteAlert').click(function(){
      $.ajax({
		url:"action/delete_product_data.php",
		type:"POST",
		data:{btn_id:btn_id,
			  url_val:url_val,
			  total_amt:total_amt,
			  g_total_amt:g_total_amt,
			  total_dis:total_dis,
			  p_actual_price:p_actual_price,
			  p_total_price:p_total_price
			 },
		success:function(result_data){
			console.log(result_data)
			if(result_data == 0){
				window.location.href="invoice-reports.php"
			}else{
			$('.deleteAlert').fadeOut();
            $('.shimmer').fadeOut();
			mainremove.remove()
			$.when(update_total_Price()).then(function(){
					let g_total_price = $('.tamount').val()
					if(g_total_price != ''){
						//tax_calculation_data(g_total_price)
					}
				})
			}
		}
		})
            
        });

    $('body').delegate('.discount,.Quantity','keyup',function(){
        let parsent_div = $(this).parent().parent();
        let discount = parsent_div.find('.discount').val()
        let price = parsent_div.find('.Price').val()
        let Quantity =parsent_div.find('.Quantity').val()    
        let product_price_data = price*Quantity;
         let dis=discount*Quantity;
         let total=product_price_data-dis;
		console.log("total "+total)
        parsent_div.find('.Rate').val(total)
        
    })
//discount alert

$('body').delegate('.discount','keyup',function(){
    let parsent_div = $(this).parent().parent();
    let id =parsent_div.find('.product_id').val()
    let discount =parsent_div.find('.discount').val()
    
  $.ajax({
      url:"action/discount-check.php",
      type:"POST",
      data:{id:id,
        discount:discount},
      success:function(resultData){
        console.log(resultData)
        if(resultData==1){
			parsent_div.find('.dis_error_status').val(1)
			parsent_div.find('#discount_error').text('*maximum discount encountered')
            //$('#discount_error').text('*maximum discount encountered')
			//$('.aBtn').attr('disabled',true)
        }else{
			parsent_div.find('.dis_error_status').val(0)
			parsent_div.find('#discount_error').text('')
			//$('.aBtn').attr('disabled',false)
            //$('#discount_error').text('')
        } 
      }
  })
})


    //gross total
    $('body').delegate('.Quantity','keyup',function(){
        let parsent_div = $(this).parent().parent();
        let price = parsent_div.find('.Price').val()
        let Quantity =parsent_div.find('.Quantity').val()    
        let product_price_data = price*Quantity;
		let Productnopill_id = parsent_div.find('.Productnopill_id').val() 
		console.log(Productnopill_id)
        parsent_div.find('.gross').val(product_price_data)
		$.ajax({
			url:"action/ebs_calculate_tax.php",
			type:"POST",
			data:{price:price,
				 Quantity:Quantity,
				  Productnopill_id:Productnopill_id
				 },
			success:function(ebs_result){
				let ebs_result_json = jQuery.parseJSON(ebs_result)
				parsent_div.find('.tax_data').val(ebs_result_json[0]['ebs_tax'])
				//tax_data
			}
		})
        
    })

    $('body').delegate('.Quantity','keyup',function(){
        let Tprice=0;
        let parsent_div = $(this).parent().parent();
        let price = parsent_div.find('.Price').val();
        let Quantity =parsent_div.find('.Quantity').val()
        let total = price*Quantity;
        let tprice_data = $('#Tprice').val()
    
        let TnewPrice= 0
        let g_total = 0;
		let total_dis_data = 0;
        $('.customeInputArea').each(function(){
            let c_price = $(this).find('.Price').val()
            let c_quantity = $(this).find('.Quantity').val()
			let c_discount = $(this).find('.discount').val()
            let c_total = c_price*c_quantity
            g_total += c_total;
			total_dis_data += c_quantity*c_discount
        })
        Tprice = $('#Tprice').val(g_total)
		Tprice = $('#Tdiscount').val(total_dis_data)
		
    
    })  

    $('body').delegate('.Quantity,.discount','keyup',function(){
        let dis=0;
        let parsent_div = $(this).parent().parent();
        let Quantity =parsent_div.find('.Quantity').val()
        let discount = parsent_div.find('.discount').val()
        let product_price_data = discount*Quantity;
        let g_total = 0;
        $('.customeInputArea').each(function(){
            let c_price = $(this).find('.discount').val()
            let c_quantity = $(this).find('.Quantity').val()
            let c_total = c_price*c_quantity
            g_total += c_total;
        })
        Tprice = $('#Tdiscount').val(g_total)

    })

    $('body').delegate('.Quantity,.discount','keyup',function(){

        let g_total = 0;
        $('.customeInputArea').each(function(){
            let c_price=$(this).find('.Price').val()
            let c_discount = $(this).find('.discount').val()
            let c_quantity = $(this).find('.Quantity').val()
            let c_total = c_price*c_quantity
            let dis=c_discount*c_quantity;
            let amt=c_total-dis
            g_total += amt;
        })
        Tprice = $('#tamount').val(g_total)
		let g_total_price = $('.tamount').val()
		if(g_total_price != ''){
			//tax_calculation_data(g_total_price)
		}
    })

	function tax_calculation_data(g_total_act_price){
		if($('.tax_ch').prop('checked') == true){
		$('#tax_split_amt').css('display','flex')
		$('#tax_split_cgst').css('display','flex')
		$('#tax_split_sgst').css('display','flex')
		$('#tax_split').css('display','flex')
		let tax = 18
		let tax_ratio = tax+100
		let tax_amt_1 = (g_total_act_price/tax_ratio)*100
		let tax_amt = tax_amt_1.toFixed(2)
			  	//let round_tax_val = parseFloat(tax_amt).toFixed(2);
		let total_tax_amt_c_1 = g_total_act_price-tax_amt
		let total_tax_amt_c = total_tax_amt_c_1.toFixed(2)
		$('.aAmt').val(tax_amt)
		$('#total_tax_amt').val(total_tax_amt_c)
		$('#tax_including_data_text').text('Total Amount (Including Tax)')
		
			let cgst_tax = 9;
			let sgst_tax = 9;
			let cgst_tax_data = calculate_tax_split(cgst_tax,tax_amt);
			let sgst_tax_data = calculate_tax_split(sgst_tax,tax_amt);
			$('#total_tax_amt_cgst').val(cgst_tax_data)
			$('#total_tax_amt_sgst').val(sgst_tax_data)
		}else{
		$('#tax_including_data_text').text('Total Amount')
		$('#tax_split_amt').css('display','none')
		$('#tax_split').css('display','none')
		$('#tax_split_cgst').css('display','none')
		$('#tax_split_sgst').css('display','none')
		}
	}

	/*$('body').delegate('.product_name_drop ul li','click',function(){
		let parsent_div_1 = $(this).parent().parent()
		parsent_div_1.find('.ProductName').val($(this).text())
		let product_name = $(this).text().trim();;
		console.log(product_name)
		let parent_data = parsent_div_1.parent().parent()
		$.ajax({
           url:"action/fetch_product_data.php",
          type:"POST",
          data:{product_name:product_name},
          success:function(result_data){
              let result_data_json = jQuery.parseJSON(result_data);
			  console.log(result_data_json)
			  if(result_data_json[0]['quantity'] == 0){
			  	  parent_data.find('#quantity_err').text('*Out of Stock!')
				  parent_data.find('.stock_error_status').val(1)
				  //$('.aBtn').attr('disabled',true)
			  }else{
				  //$('.aBtn').attr('disabled',false)
			  	  parent_data.find('#quantity_err').text(' ')
				  parent_data.find('.stock_error_status').val(0)
			  }
              parent_data.find('.CategoryName').val(result_data_json[0]['category_name'])
              parent_data.find('.product_id').val(result_data_json[0]['id'])
              parent_data.find('.Price').val(result_data_json[0]['price'])
              //parent_data.find('.Rate').val(result_data_json[0]['price'])
              parent_data.find('.Quantity').val('1')
              parent_data.find('.discount').val(result_data_json[0]['discount_data'])
			  
			  let actual_price = result_data_json[0]['price']-result_data_json[0]['discount_data'];
			  parent_data.find('.Rate').val(actual_price)
			  let total_amt = 0
			  let total_dis = 0
			  let total_amt_a = 0
			  let total_val_details = calculate_total_amt();
			  console.log(total_val_details)
			  $('.Tprice').val(total_val_details)
			  $('.tamount').val(total_val_details)
			  $('#bill_amt').val(total_val_details)
			  /*if($('.Tprice').val() != ''){
			   total_amt = parseInt($('.Tprice').val())
			  }
			  if($('.Tdiscount').val() != ''){
			   total_dis = parseInt($('.Tdiscount').val())
			  }
			  if($('.tamount').val() != ''){
			   total_amt_a = parseInt($('.tamount').val())
			  }

			  let g_total_price = parseInt(result_data_json[0]['price'])+total_amt
			  let g_total_dis = parseInt(result_data_json[0]['discount_data'])+total_dis
			  let g_total_act_price = actual_price+total_amt_a
			  let tax_check_box = 0;
			  tax_calculation_data(g_total_act_price)
			  $('.Tprice').val(g_total_price)
			  $('.Tdiscount').val(g_total_dis)
			  $('.tamount').val(g_total_act_price)*/
         /* }
		  
       })
	})*/

    $('body').delegate('.ProductName','keyup',function(){
        let that = $(this);
        let product_name = $(this).val()
		console.log(product_name)
      let parent_div = $(this).parent().parent()
      let append_div = $(this).parent().find('ul')
      $.ajax({
          url:"action/fetch-products.php",
          type:"POST",
          data:{product_name:product_name},
          success:function(resultData){
              
              let resultData_json = jQuery.parseJSON(resultData)
			  append_div.empty()
              if(resultData_json.length !=0){
				  console.log("haii")
                append_div.empty()
                  for(let x=0;x<resultData_json.length;x++){
                      //console.log(resultData_json[x]['product_name'])
                      append_div.append(`<li data-id="${resultData_json[x]['id']}"> ${resultData_json[x]['product_name']}</li>`)
                  }
              }
          }
      })
    })

$('.aBtn1').click(function(e){
	e.preventDefault();
	     $('.aBtn1').text('Loading...')
		$('.aBtn1').prop('disabled',true)
		$('#common_error_data').text('')
	let customer_name = $('#customer_name').val()
	let phone = $('#phone').val()
	let place = $('#place').val()
	let Tprice = $('#Tprice').val()
	let Tdiscount = $('#Tdiscount').val()
	let tamount = $('#tamount').val()
	$.when(validation_details()).then(function(validate_c){
		if(validate_c == 2){
			$.when(validation()).then(function(validate_b){
                    if(validate_b == 2){
						$.when(stock_validation()).then(function(stock_valid){
							if(stock_valid == 0){
								$('.billLoading').css('display','flex')
								$('.shimmer').fadeIn()
	$.when(update_customer_details(customer_name,phone,place,Tprice,Tdiscount,tamount)).then(function(){
		$.when(update_exist_data()).then(function(){
			$.when(save_product_details(url_val)).then(function(loop_count){
				let product_len = $('.customeInputArea').length
			
				setTimeout(function(){
						
            		$.when(printbill(url_val)).then(function(){
						$('.billLoading').css('display','none')
						
							window.print();
							setTimeout(function(){
								window.location.href="invoice-reports.php"
								
						})	
					});
					  },1000)
			})
		})
	})
							}else{
								$('.aBtn1').prop('disabled',false)
								$('.aBtn1').text('Save')
							}
						})
					}else{
						$('.aBtn1').prop('disabled',false)
								$('.aBtn1').text('Save')
					}
			})
		}else{
							$('.aBtn1').prop('disabled',false)
								$('.aBtn1').text('Save')
		}
	})
})

	function stock_validation(){
		let validate_result = 0;
		$('.customeInputArea').each(function(){
			let stock_error_status = $(this).find('.stock_error_status').val()
			let dis_error_status = $(this).find('.dis_error_status').val()
			let quantity = $(this).find('.Quantity').val()
			let product = $(this).find('.ProductName').val()
			if(stock_error_status == 1 || dis_error_status == 1 || quantity == 0){
				validate_result = 1;
				if(stock_error_status == 1){
					$('#common_error_data').text('*Remove Out of stock Product!')
				}
				if(dis_error_status == 1){
					$('#common_error_data').text('*Discount Error!')
				}
				if(quantity == 0){
					$('#common_error_data').text('* '+product+' Quantity Error!')
				}
				
			}
		})
		return validate_result;
	}

$('body').delegate('.product_name_drop ul li','click',function(){
		//$('.aBtn1').attr('disabled',true)
		let parsent_div_1 = $(this).parent().parent()
		parsent_div_1.find('.ProductName').val($(this).text())
		let product_name = $(this).text().trim();
		let product_id = $(this).attr('data-id');
		$(this).parent().parent().find('.ProductName_id').val(product_id)
		let product_quantity_no = $(this).parent().parent().parent().parent().find('.Productnopill1ul')
		$.ajax({
			url:"action/fetch_product_no_pills.php",
			type:"POST",
			data:{product_id:product_id},
			success:function(product_no_pills){
				let product_no_pills_json = jQuery.parseJSON(product_no_pills)
				console.log(product_no_pills_json)
				if(product_no_pills_json[0]['status'] == 1){
					product_quantity_no.empty()
				    for(let x1=0;x1<product_no_pills_json.length;x1++){
							product_quantity_no.append(`<li data-id="${product_no_pills_json[x1]['id']}"> ${product_no_pills_json[x1]['no_of_pills']} (exp : ${product_no_pills_json[x1]['expiry_date']})</li>`)
					}
				}else{
					product_quantity_no.empty()
				}
			}
		})
	})

    function validation_details(){
      let customerName_data = $('#customer_name').val()
      let phone_num = $('#phone').val()
      let valid_c = 0;
      if(customerName_data != ''){
          valid_c+=1;
          $('#customer_name_error').text('')
      }else{
          $('#customer_name_error').text('*Name Is Required!')
      }
        
      if(phone_num != ''){
          valid_c+=1;
          $('#phone_error').text('')
      }else{
          $('#phone_error').text('*Phone Number Is Required!')
      }
       return valid_c; 
    }


function update_exist_data(){
	$('.dynamicEditProductDetails .customeInputArea').each(function(){
		let ProductName = $(this).find('.ProductName').val()
		let product_id = $(this).find('.ProductName_id').val()
		let product_id_details = $(this).find('.product_id_details').val()
		let Productnopill_id = $(this).find('.Productnopill_id').val()
		let Price = $(this).find('.Price').val()
		let Quantity = $(this).find('.Quantity').val()
		let Rate = $(this).find('.Rate').val()
		let tax_in_per = $(this).find('.tax_in_per').val()
		let tax_data = $(this).find('.tax_data').val()
		$.ajax({
			url:"action/update_exist_data.php",
			type:"POST",
			data:{ProductName:ProductName,
				 product_id:product_id,
				  product_id_details:product_id_details,
				  Price:Price,
				  Quantity:Quantity,
				  Rate:Rate,
				  tax_in_per:tax_in_per,
				  tax_data:tax_data,
				  Productnopill_id:Productnopill_id
				 },
			success:function(product_result){
				console.log(product_result)
			}
		})
	})
}

function update_customer_details(customer_name,phone,place,Tprice,Tdiscount,tamount){
	return $.ajax({
		url:"action/update_customet_details.php",
		type:"POST",
		data:{customer_name:customer_name,
			 phone:phone,
			  place:place,
			  Tprice:Tprice,
			  Tdiscount:Tdiscount,
			  tamount:tamount,
			  url_val:url_val
			 }
	})
}

    function save_product_details(customer_id){
		let product_len = $('.customeInputArea').length
		//console.log("product_len "+product_len)
		let live_each_count = 0;
		let promise = new Promise(function(res,rej){
			$('.edit_customer_input_new').each(function(){
           let product_id=$(this).find('.ProductName_id').val()
		   let Productnopill_id = $(this).find('.Productnopill_id').val()
           let ProductName = $(this).find('.ProductName').val()
           let CategoryName = $(this).find('.CategoryName').val()
           let Price = $(this).find('.Price').val()
           let discount = $(this).find('.discount').val()
           let Quantity = $(this).find('.Quantity').val()
           let gross = $(this).find('.gross').val()
           let Rate = $(this).find('.Rate').val()
		   let tax_in_per = $(this).find('.tax_in_per').val()
		   let tax_data = $(this).find('.tax_data').val()
		   if(ProductName != ''){
           $.ajax({
               url:"action/insert_product_details.php",
               type:"POST",
               data:{ProductName:ProductName,
                    CategoryName:CategoryName,
                    Price:Price,
                    discount:discount,
                    Quantity:Quantity,
                    Rate:Rate,
                    customer_id:customer_id,
                    gross:gross,
                    product_id:product_id,
					 Productnopill_id:Productnopill_id,
					 tax_in_per:tax_in_per,
					 tax_data:tax_data
                    },
			   success:function(result){
			   	console.log(result)
			   }
           })
		   }
			  	live_each_count++;
				   //console.log(live_each_count)
				   if(product_len == live_each_count){
				   	return live_each_count
				   }
           
      })
		}).then(()=>{
			return (live_each_count)
		});
     }

     //print bill
               function printbill(customer_id) {              
                     return $.ajax({
                        url: "action/fetchbill.php",
                        type:"POST",
                        data:{customer_id:customer_id},
                        success: function (result) {
							if(result != 0){
								let result_json = jQuery.parseJSON(result)
								console.log(result_json)
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
								$('#total_amt_1').text('₹ '+result_json[0]['total_amount'])
								$('#total_amt_3').text('₹ '+result_json[0]['total_price_q'])
								//$('#tax_total').text('₹ '+result_json[0]['total_tax'])
								let product_details = result_json[0]['product']
								$('.printDesignTable .tableInvoice').empty();
								let SINO = 0;
								for(let x=0;x<product_details.length;x++){
									SINO++;
									let net_total = product_details[x]['price']*product_details[x]['quantity']
									$('.printDesignTable .tableInvoice').append(`
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
                        </tr>`)
								}
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
                        </tr>`)
							}
								
							}
                           
                        } 
                    });
                }

	function stock_validation(){
		let validate_result = 0;
		$('.customeInputArea').each(function(){
			let stock_error_status = $(this).find('.stock_error_status').val()
			let dis_error_status = $(this).find('.dis_error_status').val()
			let quantity = $(this).find('.Quantity').val()
			let product = $(this).find('.ProductName').val()
			if(quantity == 0){
			if(product == ''){
				quantity = 1;
			}
			}
			if(stock_error_status == 1 || dis_error_status == 1 || quantity == 0){
				validate_result = 1;
				if(stock_error_status == 1){
					$('#common_error_data').text('*Remove Out of stock Product!')
				}
				if(dis_error_status == 1){
					$('#common_error_data').text('*Discount Error!')
				}
				if(quantity == 0){
					$('#common_error_data').text('* '+product+' Quantity Error!')
				}
				
			}
		})
		return validate_result;
	}

    function validation(){
        let p_name = $('.ProductName').val()
        let c_name = $('.CategoryName').val()
        let validate_b = 0;
        if(p_name != ''){
            validate_b+=1;
            $('#product_error').text('')
        }else{
            $('#product_error').text('*please choose product!')
        }
          
        if(c_name != ''){
            validate_b+=1;
            $('#category_error').text('')
        }else{
            $('#category_error').text('*please choose category!')
        }
         return validate_b; 
      }

function calculate_total_amt(){
	let total_val_data = 0;
	let total_count = $('.customeInputArea').length
	$('.customeInputArea').each(function(){
		let total_price_val = $(this).find('.Rate').val()
		total_val_data += parseInt(total_price_val)
	})
	return total_val_data
}

$('body').delegate('.Productnopill1ul li','click',function(){
	let id_details = $(this).attr('data-id')
	let red_main_div = $(this).parent().parent().parent().parent()
	let quantity = red_main_div.find('.Quantity').val()
	$.ajax({
		url:"action/fetch_product_price_details.php",
		type:"POST",
		data:{id_details:id_details,
			 quantity:quantity
			 },
		success:function(price_result){
			let price_result_json = jQuery.parseJSON(price_result)
			if(price_result_json.length !=0){
				red_main_div.find('.Price').val(price_result_json[0]['ebs_price'])
				red_main_div.find('.Quantity').val(price_result_json[0]['ebs_quantity'])
				red_main_div.find('.Rate').val(price_result_json[0]['ebs_total_price'])
				red_main_div.find('.tax_in_per').val(price_result_json[0]['ebs_tax_per'])
				red_main_div.find('.tax_data').val(price_result_json[0]['ebs_tax'])
				let Gtotal_val = 0;
				let rate_len = $('.Rate').length
				let loop_len = 0;
				$('.Rate').each(function(){
					loop_len++;
					let total_amt_data = $(this).val()
					if(total_amt_data != ''){
					Gtotal_val += parseInt(total_amt_data);
					if(rate_len == loop_len){
						$('#bill_amt').val(Gtotal_val)
						$('.tamount').val(Gtotal_val)
						$('.Tprice').val(Gtotal_val)
					}
					}
				})
				$('#bill_amt').val(Gtotal_val)
			}
		}
	})

	
})

$('body').delegate('.product_no_pill ul li','click',function(){
	let medicine_details_q = $(this).attr('data-id').trim()
	let medicine_details_text = $(this).text().trim()
	$(this).parent().parent().parent().parent().find('.Productnopill').val(medicine_details_text)
	$(this).parent().parent().parent().parent().find('.Productnopill_id').val(medicine_details_q)
})

//out of stock    
    $('body').delegate('.Quantity','keyup',function(){
        let parsent_div = $(this).parent().parent()
        let id =parsent_div.find('.Productnopill_id').val()
        let Quantity =parsent_div.find('.Quantity').val()
		if(id != ''){
		console.log("id "+id)
        console.log("Quantity "+Quantity)
      $.ajax({
          url:"action/ebs_quantity-checking.php",
          type:"POST",
          data:{id:id,
            Quantity:Quantity},
          success:function(resultData){
            console.log(resultData)
            if(resultData==0){
				//$('.aBtn').attr('disabled',true)
				parsent_div.find('#quantity_err').text('*out of stock')
				parsent_div.find('.stock_error_status').val(1)
				
				//error_status
               // $('#quantity_err').text('*out of stock')
            } 
            else{
				//$('.aBtn').attr('disabled',false)
				parsent_div.find('#quantity_err').text(' ')
				parsent_div.find('.stock_error_status').val(0)
                //$('#quantity_err').text('')
            } 
          }
      })
		}
    })

 $('.closedeleteAlert').click(function(){
            $('.deleteAlert').fadeOut();
            $('.shimmer').fadeOut();
        });