// fetch('action/fetch-category.php')
//     .then(Response => Response.json())
//     .then(data => {
//         console.log(data)
//         for (x = 0; x < data.length; x++) {
//             $('#category').append(`<option value=${data[x]['id']} selected="true">${data[x]['category']}</option>`);
   
//         }
//     })
   
 let urlval=window.location.href
 let urlvalp=urlval.split("=")
 let urlv=urlvalp[1];
 $.when(fetchproduct(urlv)).then(function(productresult){
   let data=jQuery.parseJSON(productresult)
    $('#p_name').val(data[0]['product_name'])
   $('#category').val(data[0]['category'])
    let cat_id=data[0]['category_id'];
    $.when(selectparentcat()).then(function(Allcat){
        if(Allcat==0){
        }
        else{
            let Allcategory=jQuery.parseJSON(Allcat)
            for(let x=0;x<Allcategory.length;x++){
                if(Allcategory[x]['id']==cat_id){
                    $('#category').append(`<option value="${Allcategory[x]['id']}" selected="true">${Allcategory[x]['category']}</option>`)
                }
                else{
                    $('#category').append(`<option value="${Allcategory[x]['id']}">${Allcategory[x]['category']}</option>`)     
                }
            }
        }
    })
    .then(()=>{
        create_custom_dropdowns()
    })
	.then(() => {
		$.when(fetch_medicine_all_details(urlv)).then(function(){
			
		})
	})
})

function fetch_medicine_all_details(urlv){
	$.ajax({
		url:"action/fetch_all_medicine_details.php",
		type:"POST",
		data:{urlv:urlv},
		success:function(medicine_details){
			let medicine_details_json = jQuery.parseJSON(medicine_details)
			var formParentTemplateDiv = $('.formParentTemplateDiv');
			if(medicine_details_json.length !=0){
				for(let x=0;x<medicine_details_json.length;x++){
					var formTemplateDiv = `<div class="formTemplateDiv">
							<div class="formGroup">
								<label for="">No.of Pills</label>
								<input type="number" class="pills_number" value="${medicine_details_json[x]['no_of_pills']}" required>
								<input type="hidden" class="medicine_details_id" value="${medicine_details_json[x]['id']}">
							</div>
							<div class="formGroup">
								<label for="">Price</label>
								<input type="number" class="price" value="${medicine_details_json[x]['price']}">
							</div>
							<div class="formGroup">
								<label for="">HSN/SAC</label>
								<input type="number" class="hsn_num" value="${medicine_details_json[x]['hsn_sac']}">
							</div>
							<div class="formGroup">
								<label for="">Batch</label>
								<input type="text" class="batch_name" value="${medicine_details_json[x]['batch']}">
							</div>
							<div class="formGroup">
								<label for="">Expiry Date</label>
								<input type="date" class="exp_date" value="${medicine_details_json[x]['expiry_date']}">
							</div>
							<div class="formGroup">
								<label for="">Discount</label>
								<input type="number" class="discount" value="${medicine_details_json[x]['discount']}">
							</div>
							<div class="formGroup">
								<label for="">Quantity</label>
								<input type="number" class="quantity" value="${medicine_details_json[x]['quantity']}">
							</div>
							<div class="formGroup">
								<label for="">Tax In %</label>
								<input type="number" class="tax_in" value="${medicine_details_json[x]['tax_data']}" required>
							</div>
							<div class="formGroup">
								<label for="">Purchased Price</label>
								<input type="number" class="purchased_price"  value="${medicine_details_json[x]['purchased_price']}" required>
							</div>
							<div class="formGroup">
								<label for="">Purchased Date</label>
								<input type="date" class="purchase_date"  value="${medicine_details_json[x]['purchased_date']}" required>
							</div>
							<div class="formGroup">
								<label for="">Invoice Number</label>
								<input type="text" class="invoice_num"  value="${medicine_details_json[x]['invoice_num']}" required>
							</div>
							<!-- dont remove the div, put it down -->
							<div class="dummyDiv"></div>
							<div class="dummyDiv"></div>
							<!-- dont remove the div, put it down -->

							<div class="removeTemplate">
								<div class="removeTemplateBtn removeTemplateBtn1" data_id=${medicine_details_json[x]['id']}>Remove</div>
							</div>
						</div>`;
					formParentTemplateDiv.append(formTemplateDiv);
				}
			}else{
				
			}
		}
	})
}

    //edit products
	$('#form_details').submit(function(e){
		e.preventDefault()
		let medicine_name = $('#p_name').val()
		let category_name = $('#category').val()
		if(category_name != null){
			$('#submit_btn').text('Loading...')
		$.when(edit_producd_details(medicine_name,category_name,urlv)).then(function(product_details){
			
			let product_details_json = jQuery.parseJSON(product_details)
			if(product_details_json[0]['status'] == 1){
				let product_id = product_details_json[0]['product_id'];
				let main_div_count = $('.formTemplateDiv').length
				let each_count = 0;
				$('.formTemplateDiv').each(function(){
					let no_of_pills = $(this).find('.pills_number').val()
					let price = $(this).find('.price').val()
					let hsn_num = $(this).find('.hsn_num').val()
					let batch_name = $(this).find('.batch_name').val()
					let exp_date = $(this).find('.exp_date').val()
					let discount = $(this).find('.discount').val()
					let quantity = $(this).find('.quantity').val()
					let medicine_details_id = $(this).find('.medicine_details_id').val()
					let tax_data = $(this).find('.tax_in').val()
					let purchased_price=$(this).find('.purchased_price').val()
					let purchase_date=$(this).find('.purchase_date').val()
					let invoice_num=$(this).find('.invoice_num').val()					
					if(medicine_details_id == 0){
					$.ajax({
						url:"action/add_medicine_details.php",
						type:"POST",
						data:{product_id:urlv,
							 no_of_pills:no_of_pills,
							  price:price,
							  hsn_num:hsn_num,
							  batch_name:batch_name,
							  exp_date:exp_date,
							  discount:discount,
							  quantity:quantity,
							  tax_data:tax_data,
							  purchased_price:purchased_price,
							  purchase_date:purchase_date,
							  invoice_num:invoice_num							  
							 },
						success:function(result){
							each_count++;
							if(each_count == main_div_count){
								setTimeout(function () {
                					$('#submit_btn').text('success');
                 					$('#submit_btn').css('background-color', 'green');
             					}, 1500);
								setTimeout(function () {
                					window.location.href="products.php";
             					}, 2000);
							}
						
						}
					})
					}else{
						$.ajax({
						url:"action/edit_medicine_details.php",
						type:"POST",
						data:{product_id:product_id,
							 no_of_pills:no_of_pills,
							  price:price,
							  hsn_num:hsn_num,
							  batch_name:batch_name,
							  exp_date:exp_date,
							  discount:discount,
							  quantity:quantity,
							  medicine_details_id:medicine_details_id,
							  tax_data:tax_data,
							  purchased_price:purchased_price,
							  purchase_date:purchase_date,
							  invoice_num:invoice_num							  
							 },
						success:function(result){
							each_count++;
							if(each_count == main_div_count){
								setTimeout(function () {
                					$('.submitBtn').text('success');
                 					$('.submitBtn').css('background-color', 'green');
             					}, 1500);
								setTimeout(function () {
                					window.location.href="products.php";
             					}, 2000);
							}
						
						}
					})
					}
				})
			}else{
				//window.location.href="login.php"
			}
		})
		}else{
			$('#Cat_error').text('*Category Required!')
		}
	})

/**$('#form_details').submit(function(e){
  e.preventDefault()
  $('#submit_btn').text('loading..')
  let p_name = $('#p_name').val()
  let category = $('#category').val()
  let discount = $('#discount').val()
  let quantity = $('#quantity').val()
  let price = $('#price').val()
  let hsn = $('#hsn_nums').val()
  let batch_names = $('#batch_names').val()
  let exp_dates = $('#exp_dates').val()
  let fb = new FormData();
  fb.append('p_name',p_name)
  fb.append('category',category)
  fb.append('discount',discount)
  fb.append('quantity',quantity)
  fb.append('price',price)
  fb.append('hsn_number',hsn)
  fb.append('batch',batch_names)
  fb.append('expiry',exp_dates)
  let urlval1 = location.href.split('=')[1];            
  fetch("action/edit-product.php?id="+ urlval1,{
      method:'POST',
      body:fb,
  })
  .then(Response=>Response.text())
  .then(data=>{
      console.log(data)
      if(data==1){
           setTimeout(function () {
                   $('#submit_btn').text('success');
                    $('#submit_btn').css('background-color', 'green');
                }, 1500);
            setTimeout(function () {
                   window.location.href="products.php";
                }, 2000);
      }
      else{
         
      }
  })      
})**/

function selectparentcat(){
    return $.ajax({
        url:"action/fetch-category.php",
    })
}

function fetchproduct(urlv){
    return $.ajax({
        url:"action/product.php",
        type:"POST",
        data:{urlv:urlv},
    })
}

function edit_producd_details(medicine_name,category_name,urlv){
		return $.ajax({
			url:"action/edit_product_main_details.php",
			type:"POST",
			data:{medicine_name:medicine_name,
				 category_name:category_name,
				  urlv:urlv
				 }
		})
}
