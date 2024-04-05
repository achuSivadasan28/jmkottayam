fetch('action/fetch-category.php')
    .then(Response => Response.json())
    .then(data => {
        console.log(data)
        for (x = 0; x < data.length; x++) {
            $('#category').append(`<option value=${data[x]['id']}>${data[x]['category']}</option>`);
   
        }

    })
    .then(()=>{
        create_custom_dropdowns()
    })

    //add products
	$('#form_act').submit(function(e){
		e.preventDefault()
		let medicine_name = $('#p_name').val()
		let category_name = $('#category').val()
		if(category_name != null){
			$('.submitBtn').text('Loading...')
		$.when(add_producd_details(medicine_name,category_name)).then(function(product_details){
			
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
					let tax_data = $(this).find('.tax_in').val()
					$.ajax({
						url:"action/add_medicine_details.php",
						type:"POST",
						data:{product_id:product_id,
							 no_of_pills:no_of_pills,
							  price:price,
							  hsn_num:hsn_num,
							  batch_name:batch_name,
							  exp_date:exp_date,
							  discount:discount,
							  quantity:quantity,
							  tax_data:tax_data
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
				})
			}else{
				//window.location.href="login.php"
			}
		})
		}else{
			$('#Cat_error').text('*Category Required!')
		}
	})
	$('#category').change(function(){
		$('#Cat_error').text(' ')
	})
    function add_producd_details(medicine_name,category_name){
		return $.ajax({
			url:"action/add_product_main_details.php",
			type:"POST",
			data:{medicine_name:medicine_name,
				 category_name:category_name
				 }
		})
	}
   /* $('#form_act').submit(function(e){
        e.preventDefault()
         $('.submitBtn').text('Loading...')
    let p_name = $('#p_name').val()
    let price = $('#price').val()
    let discount = $('#discount').val()
    let quantity = $('#quantity').val()
	let hsn_num = $('#hsn_num').val()
	let batch_name = $('#batch_name').val()
	let exp_date = $('#exp_date').val()
    let select=$('#category').val()  
    let fb = new FormData();
    fb.append('p_name', p_name)
    fb.append('select', select)
    fb.append('price', price)
    fb.append('discount', discount)
    fb.append('quantity', quantity)
	fb.append('hsn_num', hsn_num)
	fb.append('batch_name', batch_name)
	fb.append('exp_date', exp_date)
    fetch('action/add-products.php',{
        method:'POST',
        body:fb,
    })
    .then(Response=>Response.text())
    .then(data=>{
        console.log(data)
        if(data==1){
            $('.submitBtn').removeAttr('disabled');
            $('.submitBtn').text('data not inserted');

        }
        else {
           
            setTimeout(function () {
                $('.submitBtn').text('success');
                 $('.submitBtn').css('background-color', 'green');
             }, 1500);
         setTimeout(function () {
                window.location.href="products.php";
             }, 2000);
        //window.location.href="index.html";
        }
    })

})*/