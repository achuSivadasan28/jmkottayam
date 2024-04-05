let urlval = location.href.split('=')[1];
fetch('action/fetchcustomerbyid.php?id=' + urlval)
    .then(Response => Response.json())
    .then(data => {
        console.log(data)
	$('#cust_name').val(data[0]['customer_name'])
	$('#phn_num').val(data[0]['phone'])
	$('#place').val(data[0]['place'])
	})

//updating details
$('#form_details').submit(function (e) {
    e.preventDefault();
       $('#submit_btn').text('Saving..');
	$('#submit_btn').attr("disabled", true);
        const customer_name =$('#cust_name').val();
       const customer_phn=$('#phn_num').val();
	 const customer_place=$('#place').val();
       const formData = {
            customer_name :customer_name,
            customer_phn:customer_phn,
		   customer_place:customer_place,
		   
        }



        let urlval = location.href.split('=')[1];
        fetch('action/updatecustomer_details.php?id=' + urlval, {
            method: "POST",
            header: {
                'Content-type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
            .then(Response => Response.text())
            .then(data => {
                console.log(data)
			if(data==1){
				 $('#submit_btn').text('Success');
				setTimeout(function () {
                                       window.location.href = "customer-details.php";
                                    }, 1000);
			}else{
				 $('#submit_btn').removeAttr('disabled');
				$('#submit_btn').text('Failed');
			}
		})
})