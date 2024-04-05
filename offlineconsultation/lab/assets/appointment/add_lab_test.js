let url = window.location.href;
let url_val = url.split("=")
let url_id_split = url_val[1]
let url_id_split_data = url_id_split.split('-')
let url_id = url_id_split_data[0];
let appointment_id = url_id_split_data[1];
console.log(url_id)
$('#changePwd_btn').click(function(e){
			$(this).text('Loading...')
			let temp_count = $('.templateDiv').length;
			let temp_data = 0;
			e.preventDefault()
				let fd = new FormData();
				let file_name = $('.uploadInputFile').val().replace("C:\\fakepath\\", "");
				fd.append("file_name",file_name);
				fd.append("url_id",url_id);
				fd.append("appointment_id",appointment_id);
	            for(let x = 0; x < $('.uploadInputFile')[0].files.length ; x++){
					fd.append("files[]", $('.uploadInputFile')[0].files[x]);
				}
				
				$.ajax({
				  url:"action/upload_data/Upload_file.php",
                  type:"POST",
                  data:fd,
                  contentType:false,
                  processData:false,
				  success:function(result_data){
					  console.log(result_data)
					  		history.back()
				  }
				})
			
		})