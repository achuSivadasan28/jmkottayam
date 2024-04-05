let url = window.location.href;
let url_val = url.split("=")
let appointment_id = url_val[1]
let valid = 0;
$('#changePwd_btn').click(function(e){
	     
			$(this).text('Loading...')
			let temp_count = $('.templateDiv').length;
			let temp_data = 0;
			e.preventDefault()
				let fd = new FormData();
				let file_name = $('.uploadInputFile').val().replace("C:\\fakepath\\", "");
				let file = $('#file_name').val()
				fd.append("file_name",file);
				fd.append("appointment_id",appointment_id);
	            for(let x = 0; x < $('.uploadInputFile')[0].files.length; x++){
					checkValidation(file,$('.uploadInputFile')[0].files[x])
					fd.append("files[]", $('.uploadInputFile')[0].files[x]);
				
				}
				
				fd.append("file_data", file);
	            
	          if(valid === 1){
				 // console.log('hi')
				  $.ajax({
				  url:"action/upload_data/Upload_file_new.php",
                  type:"POST",
                  data:fd,
                  contentType:false,
                  processData:false,
				  success:function(result_data){
					  console.log(result_data)
					  //if(result_data == 1){
						  history.back()
					 // }
					  		
				  }
				})
			  }
				

		})
function checkValidation(file_name,file){
	if(file_name.trim().length >0){
		$('#file_error').text('')
		if(file != '' && file != undefined){
			valid = 1;
			$('#file_error').text('')
		}else{
			valid = 0;
			$('#file_error').text('*please select a file')
			$('#changePwd_btn').text('Save');
		}
	}else{
		$('#file_error').text('*please enter test name')
		$('#changePwd_btn').text('Save')
		valid = 0;
	}
	
}