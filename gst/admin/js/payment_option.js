$('#add-payment-option').submit(function(e){
	e.preventDefault()
	let payment_val = $('#payment_val').val().trim()
	if(payment_val != ''){
		$('#payment_option_error').text('')
	$('#submit_btn').text('Loading...')
	$.ajax({
		url:"action/fetch_all_option.php",
		type:"POST",
		data:{payment_val:payment_val},
		success:function(result_data){
			$('#submit_btn').text('Success')
			setTimeout(function(){
				window.location.href="payment-option.php"
			},1500)
		}
	})
	}else{
		$('#payment_option_error').text('required!')
	}
})