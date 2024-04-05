let url=location.href;
let url_val=url.split('/');
let branch_name=url_val[2].split('.')[0]
let admin_type=url_val[3];
var lastSlashIndex = url.lastIndexOf("/");
var baseUrl = url.substring(0, lastSlashIndex + 1);
console.log(branch_name,admin_type)
fetch('action/errorLog/fetch_priority.php')
.then(Response=>Response.json())
.then(data=>{
	console.log(data)
for(let x=0;x<data.length;x++){
$('#priority_data').append(`<option value="${data[x]['priority_data']}">${data[x]['priority_data']}</option>`)
	}
})
$('#add_error_form').submit(function(e){
	e.preventDefault();
	let imgArray_len=imgArray.length;
	
	if(imgArray_len==0){
		$('#img_error').text('Please upload file*')
		$('#img_error').css('color','red')
	}
	else{
		var fileSize = $('#upload_img_vals').prop('files')[0].size;
		var convert_to_mb=fileSize / (1024 * 1024);
		var actual_size=convert_to_mb.toFixed(2)
		if(actual_size <5)	{
			$('#img_error').text('')
			$('.add_error').text('Loading...')
			$('.add_error').attr('disabled',true)
			let issue_info=$('#issue_info').val();
			let priority_data=$('#priority_data').val();
			let images = $('#upload_img_vals')[0].files
			let length = images.length;	
			let fb=new FormData();	
			fb.append('issue_info',issue_info)
			fb.append('priority_data',priority_data)
			fb.append('branch_name',branch_name)
			fb.append('admin_type',admin_type)
			fb.append('baseUrl',baseUrl)	
			for (let x = 0; x < length; x++) {
				fb.append('image', images[x]);
			}
			fetch('action/errorLog/add_error_log.php',{
				method:'POST',
				body:fb	
			})	
				.then(Response=>Response.json())
				.then(data=>{
				console.log(data)
				if(data==1){
					setTimeout(function () {
						$('.add_error').text('success');
						$('.add_error').css('background-color', 'blue');
					}, 1500);
					setTimeout(function () {
						window.location.href = "error-log.php";
					}, 2000);
				}		
			})
		}
		else{
			$('#img_error').text('Your uploaded file size exceeds 5 mb*')
			$('#img_error').css('color','red')		
		}
	}	
})