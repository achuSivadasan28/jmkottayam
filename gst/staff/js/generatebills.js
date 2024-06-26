
let url_data = window.location.href
let url_data_id = url_data.split('=')
let bill_data = url_data_id[1]
console.log(bill_data)
if(bill_data == 0 || bill_data == undefined){
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
}else{
	$('.customeInputArea').empty()
	$.when(fetch_prescription_details()).then(function(prescription_result){
		let prescription_result_json = jQuery.parseJSON(prescription_result)
		console.log(prescription_result_json)
		let loop_count = 0;
		let g_total_amt = 0;
		let product_length = prescription_result_json.length
		$('#customer_name').val(prescription_result_json[0]['name'])
		$('#phone').val(prescription_result_json[0]['phone'])
		$('#place').val(prescription_result_json[0]['place'])
		$('#date').val(prescription_result_json[0]['date'])
		for(let x1=0;x1<prescription_result_json.length;x1++){
			  let medicine_id = prescription_result_json[x1]['medicine_id']
			let quantity = prescription_result_json[x1]['quantity']
			    fetch('action/fetch-product_dynamic.php?pid='+medicine_id+'&quantity='+quantity)
    .then(Response => Response.json())
    .then(data => {
					console.log(data)
					for(let x=0;x<data.length;x++){
						if(data[x]['id'] == medicine_id){
							let stock_error_log = ``;
							let stock_error_input = `<input type="hidden" disabled class="stock_error_status">`;
							if(data[x]['stock_status'] == 0){
							 stock_error_log = `<span id="quantity_err" style="color:red">*out of stock</span>`;
								stock_error_input = `<input type="hidden" disabled class="stock_error_status" value=1>`;
							}
							g_total_amt += data[x]['total_p']
							if(loop_count!=0){
							let template_data = `<div class="customeInputArea"> 
<div class="formGroup"> <div class="customDropDown product_name_drop">
									<input type="text" placeholder="Select" class="customDropInput ProductName" id="searchbox" value="${data[x]['product_name']}">
									<ul >
									</ul>
								</div>
<!--<input type="text" placeholder="Product Name"  list="ProductName" class="ProductName"> 
<input type="hidden" placeholder="Product Name"> 
                <span id="product_error" style="color:red"></span> 
<datalist class="ProductName1" id="ProductName">  
		</datalist> --></div> 
<input type="hidden" disabled class="product_id" id="product_id" value=${data[x]['id']}> 
<div class="formGroup">  
<input type="number" disabled class="Price" value=${data[x]['price']}> </div> 

<div class="formGroup" style="display:none"> 
<label>Discount Per Piece</label> 
<input type="text" class="discount"> 
<span style="color:red" id="discount_error"></span>  
</div>  

<div class="formGroup">  
<input type="text" class="Quantity" id="quant" value=${quantity}> ${stock_error_log} </div> 
<input type="hidden" disabled class="gross" id="gross">
${stock_error_input}
<div class="formGroup"> <input type="number" disabled class="Rate" value=${data[x]['total_p']}> </div>
<div class="removeBtn">
<button class="inputRemove"><i class="uil uil-trash"></i></button>
		</div> 
<div class="dummyDiv"></div></div>`;
								$(".dynamicProductDetails").append(template_data);
							}else{
								let template_data = `<div class="customeInputArea"> 
<div class="formGroup"> <div class="customDropDown product_name_drop">
									<input type="text" placeholder="Select" class="customDropInput ProductName" id="searchbox" value="${data[x]['product_name']}">
									<ul >
									</ul>
								</div>
<!--<input type="text" placeholder="Product Name"  list="ProductName" class="ProductName"> 
<input type="hidden" placeholder="Product Name"> 
                <span id="product_error" style="color:red"></span> 
<datalist class="ProductName1" id="ProductName">  
		</datalist> --></div> 
<input type="hidden" disabled class="product_id" id="product_id" value=${data[x]['id']}> 
<div class="formGroup">  
<input type="number" disabled class="Price" value=${data[x]['price']}> </div> 

<div class="formGroup" style="display:none"> 
<label>Discount Per Piece</label> 
<input type="text" class="discount"> 
<span style="color:red" id="discount_error"></span>  
</div>  

<div class="formGroup">  
<input type="text" class="Quantity" id="quant" value=${quantity}> ${stock_error_log}  </div> 
<input type="hidden" disabled class="gross" id="gross">
${stock_error_input}
<div class="formGroup"> <input type="number" disabled class="Rate" value=${data[x]['total_p']}> </div>
<div class="removeBtn">
<button class="inputRemove"><i class="uil uil-trash"></i></button>
		</div> 
<div class="dummyDiv"></div></div>`;
								$(".dynamicProductDetails").append(template_data);
							//$('.ProductName').attr('data-val',data[x]['medicine_id'])
							//$('.ProductName').val(data[x]['product_name'])
							
							}
						   }
					}
				})
			.then(() => {
					loop_count++
					console.log(loop_count)
					if(product_length == loop_count){
						console.log("product_length "+product_length)
						console.log("loop_count "+loop_count)
						$('.Tprice').val(g_total_amt)
						$('.tamount').val(g_total_amt)
						$('#bill_amt').val(g_total_amt)
					}
				})
			
			
			
		
		}
		
	})

	function fetch_prescription_details(){
		let enc_key = '1efe04280deca02e6e83d619572a3a10'
		return $.ajax({
			url:"../../offlineconsultation/action/fetch_all_prescription_data.php",
			type:"POST",
			data:{bill_data:bill_data,
				 enc_key:enc_key},
			
		})
	}
}

		/*document.getElementsByClassName("ProductName").addEventListener("search", function(event) {
			  let div_val = $(this).parent().parent().parent()
			  div_val.find('.Price').val(' ')
			  div_val.find('.Quantity').val(' ')
			  div_val.find('.Rate').val(' ')
			
			        let Tprice=0;
        let parsent_div = $(this).parent().parent().parent();
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
			$('#tamount').val(g_total)
			  
		});*/

    var actual_price = 0;
    $('body').delegate('.ProductName','keyup',function(){
        let that = $(this);
        let product_name = $(this).val()
		console.log(product_name)
      let parent_div = $(this).parent().parent()
      let append_div = $(this).parent().find('ul')
	  let g_total = $(this).parent().parent().parent().find('.Rate').val()
	  if(product_name != ''){
      $.ajax({
          url:"action/fetch-products.php",
          type:"POST",
          data:{product_name:product_name},
          success:function(resultData){
              
              let resultData_json = jQuery.parseJSON(resultData)
              if(resultData_json.length !=0){
				
                append_div.empty()
                  for(let x=0;x<resultData_json.length;x++){
                      //console.log(resultData_json[x]['product_name'])
                      append_div.append(`<li data-id="${resultData_json[x]['id']}"> ${resultData_json[x]['product_name']}</li>`)
                  }
              }
          }
      })
	  }else{
	  	let g_total_t = $('#tamount').val()
		let new_g_total = g_total_t-g_total
		$('#tamount').val(new_g_total)
		  $('#bill_amt').val(new_g_total)
		  $('#Tprice').val(new_g_total)
	  }
    })

	$('.tax_ch').click(function(){
		let g_total_price = $('.tamount').val()
		if(g_total_price != ''){
			tax_calculation_data(g_total_price)
		}
	})
    
	$('body').delegate('.product_name_drop ul li','click',function(){
		$('.aBtn1').attr('disabled',true)
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
			  console.log("total_val_details "+total_val_details)
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
			  $('.tamount').val(g_total_act_price)
			  $('#bill_amt').val(g_total_act_price)*/
			  $('.aBtn1').attr('disabled',false)
          }
		  
       })
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

	function calculate_tax_split(tax_ration,tax_amt){
		let tax_data_1 = tax_amt*(tax_ration/100);
		let tax_data = tax_data_1.toFixed(2);
    	return tax_data;
	}


    $('body').delegate('.discount,.Quantity','keyup',function(){
        let parsent_div = $(this).parent().parent();
        let discount = parsent_div.find('.discount').val()
        let price = parsent_div.find('.Price').val()
        let Quantity =parsent_div.find('.Quantity').val()    
        let product_price_data = price*Quantity;
         let dis=discount*Quantity;
         let total=product_price_data-dis;
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

//out of stock    
    $('body').delegate('.Quantity','keyup',function(){
        let parsent_div = $(this).parent().parent()
        let id =parsent_div.find('.product_id').val()
        let Quantity =parsent_div.find('.Quantity').val()
		console.log("id "+id)
        console.log("Quantity "+Quantity)
      $.ajax({
          url:"action/quantity-checking.php",
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
    })

    //gross total
    $('body').delegate('.Quantity','keyup',function(){
        let parsent_div = $(this).parent().parent();
        let price = parsent_div.find('.Price').val()
        let Quantity =parsent_div.find('.Quantity').val()    
        let product_price_data = price*Quantity;
        parsent_div.find('.gross').val(product_price_data)
        
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
			if(c_price != undefined || c_quantity != undefined || c_discount != undefined){
            let c_total = c_price*c_quantity
            g_total += c_total;
			total_dis_data += c_quantity*c_discount
			}
        })
        Tprice = $('#Tprice').val(g_total)
		Tprice = $('#tamount').val(g_total)
		Tprice = $('#Tdiscount').val(total_dis_data)
		
		$('#bill_amt').val(g_total)
    
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
			if(c_price != undefined || c_quantity != undefined){
            	let c_total = c_price*c_quantity
            	g_total += c_total;
			}
        })
        Tprice = $('#Tdiscount').val(g_total)
		$('#Tdiscount').val(g_total)
		

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
        //Tprice = $('#tamount').val(g_total)
		let g_total_price = $('.tamount').val()
		if(g_total_price != ''){
			tax_calculation_data(g_total_price)
		}
    })

    

//insertion
    $('.aBtn').click(function(e){
        e.preventDefault()
          $('.aBtn').text('Loading...')
		$('.aBtn').prop('disabled',true)
		$('#common_error_data').text('')
          $.when(validation_details()).then(function(validate_c){
            if(validate_c == 2){
                
                $.when(validation()).then(function(validate_b){
                    if(validate_b == 2){
						$.when(stock_validation()).then(function(stock_valid){
							if(stock_valid == 0){
								$('.billLoading').css('display','flex')
								$('.shimmer').fadeIn()
                        //$('.aBtn').attr('disabled','true')  
          $.when(add_user_details()).then(function(customer_id){
                  $.when(save_product_details(customer_id)).then(function(loop_count){
					  let product_len = $('.customeInputArea').length
					  //$('.shimmer').fadeOut()
					  if(bill_data != undefined){
					  $.when(update_gen_bill_status(bill_data)).then(function(){
					setTimeout(function(){
						
            		$.when(printbill(customer_id)).then(function(){
						$('.billLoading').css('display','none')
						
							window.print();
							setTimeout(function(){
								window.location.href="bills.php"
								
						})	
					});
					  },1000)
				  })
					  }else{
					  	setTimeout(function(){
						
            		$.when(printbill(customer_id)).then(function(){
						$('.billLoading').css('display','none')
						
							window.print();
							setTimeout(function(){
								window.location.href="bills.php"
								
						})	
					});
					  },1000)
					  }
					   
					//$('.aBtn').text('success');
                    //$('.aBtn').css('background-color', 'blue');
                })

          })
							}else{
								$('.aBtn').prop('disabled',false)
								$('.aBtn').text('Save')
							}
					})

        }else{
			$('.aBtn').prop('disabled',false)
			$('.aBtn').text('Save')
		}
     })
        }
        else{
			$('.aBtn').prop('disabled',false)
            window.scrollTo({top: 0, behavior: 'smooth'});
            $('.aBtn').text('Save')
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
			if(stock_error_status == 1 || dis_error_status == 1 || quantity <= 0){
				validate_result = 1;
				if(stock_error_status == 1){
					$('#common_error_data').text('*Remove Out of stock Product!')
				}
				if(dis_error_status == 1){
					$('#common_error_data').text('*Discount Error!')
				}
				if(quantity <= 0){
					$('#common_error_data').text('* '+product+' Quantity Error!')
				}
				
			}
		})
		return validate_result;
	}

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
 

    function validation(){
        let p_name = $('.ProductName').val()
        let c_name = $('.CategoryName').val()
        let validate_b = 0;
		console.log(p_name)
		if(p_name != undefined){
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
		}else{
			$('#common_error_data').text('*please choose product!')
		}
         return validate_b; 
      }
//customer insertion
    function add_user_details(){
      let customer_name = $('#customer_name').val()
      let phone_num = $('#phone').val()       
      let Tprice = $('#Tprice').val()
      let discount = $('#Tdiscount').val()
      let tamount =  $('#tamount').val()
	  let total_tax =  $('#total_tax_amt').val()
	  let total_tax_cgst =  $('#total_tax_amt_cgst').val()
	  let total_tax_sgst =  $('#total_tax_amt_sgst').val()
	  let Actual_amt =  $('.aAmt').val()
	  let place =  $('#place').val()
	  let bill_date = $('#date').val()
	  let payment_option = $('#payment_option').val()
	  let tax_cal = 0;
		if($('.tax_ch').prop('checked') == true){
			tax_cal = 1;
		}

      return $.ajax({
          url:"action/add-customer.php",
          type:"POST",
          data:{customer_name:customer_name,
                phone_num:phone_num,
                Tprice:Tprice,
                discount:discount,
                tamount:tamount,
				total_tax:total_tax,
				tax_cal:tax_cal,
				total_tax_cgst:total_tax_cgst,
				total_tax_sgst:total_tax_sgst,
				Actual_amt:Actual_amt,
				place:place,
				bill_date:bill_date,
				payment_option:payment_option,
               }
            })
        }
// insertion of bill details
    function save_product_details(customer_id){
		let product_len = $('.customeInputArea').length
		//console.log("product_len "+product_len)
		let live_each_count = 0;
          $('.customeInputArea').each(function(){
           let product_id=$(this).find('.product_id').val()
           let ProductName = $(this).find('.ProductName').val()
           let CategoryName = $(this).find('.CategoryName').val()
           let Price = $(this).find('.Price').val()
           let discount = $(this).find('.discount').val()
           let Quantity = $(this).find('.Quantity').val()
           let gross = $(this).find('.gross').val()
           let Rate = $(this).find('.Rate').val()
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
                    }
           })
			  	live_each_count++;
				   //console.log(live_each_count)
				   if(product_len == live_each_count){
				   	return live_each_count
				   }
           
      })
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
								let product_details = result_json[0]['product']
								$('.printDesignTable tbody').empty();
								let SINO = 0;
								for(let x=0;x<product_details.length;x++){
									SINO++;
									let net_total = product_details[x]['price']*product_details[x]['quantity']
									$('.printDesignTable tbody').append(`
					<tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>${SINO}</td>
                            <td>${product_details[x]['product_name']}</td>
                            <td>30</td>
                            <td>${product_details[x]['quantity']}</td>
                            <td>₹ ${product_details[x]['price']}</td>
                            <td>₹ ${net_total}</td>
                         
                            
                            
                        </tr>`)
								}
								
								
							}
                           
                        } 
                    });
                }

$('#Recived_amt').keyup(function(){
	let revived_amt = $(this).val()
	let bill_amt = $('#bill_amt').val()
	let balance_amt = bill_amt-revived_amt;
	if(balance_amt <0){
		balance_amt *= -1;
	}
	$('#balance_amt').val(balance_amt)
	console.log(revived_amt)
})

function calculate_total_amt(){
	let total_val_data = 0;
	let total_count = $('.customeInputArea').length
	$('.customeInputArea').each(function(){
		let total_price_val = $(this).find('.Rate').val()
		if(total_price_val != undefined){
			console.log(total_price_val)
			total_val_data += parseInt(total_price_val)
		}
	})
	return total_val_data
}

$.ajax({
	url:"action/fetch_all_payment_option.php",
	success:function(payment_result){
		
		let payment_result_json = jQuery.parseJSON(payment_result);
		$('#payment_option').empty()
		
		
		if(payment_result_json.length !=0){
			$('#payment_option').append(`<option value="0">Select Payment Option</option>`)
			for(let x=0;x<payment_result_json.length;x++){
				$('#payment_option').append(`<option value="${payment_result_json[x]['id']}">${payment_result_json[x]['payment_option']}</option>`)
			}
		}else{
			$('#payment_option').append(`<option value="0">No Data</option>`)
		}
	}
})

function update_gen_bill_status(bill_data){
	return $.ajax({
		url:"../../offlineconsultation/action/update_bill_status.php",
		type:"POST",
		data:{bill_data:bill_data}
	})
}