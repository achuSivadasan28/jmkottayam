const today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
console.log(currentYear)
function fetch_available_dates(){
	$.ajax({
    type:'post',
	url :'action/appointment/fetch-available-dates.php',
	data:{month:currentMonth,
		  year:currentYear},
	success:function(result){
		let result_data = JSON.parse(result)
		console.log(result_data)
		let template = ''
		const monthNames = [
    		"January", "February", "March", "April",
    		"May", "June", "July", "August",
    		"September", "October", "November", "December"
  			];
		for(let i = 0;i < result_data.length; i++){
			let result_data_month = result_data[i]['years'];
			console.log(result_data_month)
			
			if(result_data_month != undefined){
			for(let x = 0; x<result_data_month.length; x++){
				let month = result_data_month[x]['month'];
				let monthName = monthNames[month - 1];
				
				template = `
					<div class="availableDatesListBox">
						<div class="availableDatesListBoxHead">
							<h2>${monthName} - ${result_data[i]['year']}</h2>
						</div>
					<div class="availableDatesListBoxBody">`
				let result_data_date = result_data_month[x]['months'];
				for(let y = 0; y<result_data_date.length; y++){
					let date = new Date(result_data_date[y]['date'])
					let fullDate = date.toLocaleDateString('default',{weekday:'long',day:'numeric'})
					let datesplit = fullDate.split(" ")
					
				    let active = '';
					if(today>date){
						active = 'inActivDate';
					}
					template +=`<div class="availableDatesBox ${active}">
									<div class="removeAvailableDatesBox" data-napp=${result_data_date[y]['noofapp']} data-id = ${result_data_date[y]['id']}>
										<i class="uil uil-trash"></i>
									</div>
									<h3>${datesplit[0]}</h3>
									<p>${datesplit[1]}</p>
							  </div>`
				}
				template += `
					</div>
						<div class="availableDatesListBoxFooter">
							<div class="resetDeleteDate"><i class="uil uil-redo"></i></div>
							<div class="submitDeleteDate">Submit</div>
						</div>
					</div>`
				$('.availableDatesList').append(template);
			    
			
			}
			}
			
			
		}
	}
	
})



}
fetch_available_dates();

		// removeAvailableDatesBox
let date_id = 0;
		$('body').delegate('.removeAvailableDatesBox','click',function(){
			//console.log($(this).data('napp'))
			if($(this).data('napp') <= 0){
				$('.dateDelete').fadeIn();
				$('.shimmer').fadeIn();
				$('.dateDelete').find('.confirmdeleteAlert').attr('data-id',$(this).data('id'))
				date_id = $(this).data('id');
			}else{
				$('.dateWarn').fadeIn();
				$('.shimmer').fadeIn();
				
			}
		})
		
		$('body').delegate('.resetDeleteDate','click',function(){
			$(this).parent().css({
				display: 'none',
			})
		})
$('.closedeleteAlert').click(()=>{
		$('.deleteAlert').fadeOut();
		$('.shimmer').fadeOut();
		$('.custumDiv').remove();
})

$('body').delegate('.confirmdeleteAlert','click',function(){
	//let id = $(this).data('id');
	console.log(date_id)
	$(this).text('loading...');
	let that = $(this)
	$.ajax({
		type:'post',
		url:"action/appointment/remove_reffered_dates.php",
		data:{id:date_id},
		success:function(result){
			let result_data = JSON.parse(result)
			console.log(result_data[0]['status'])
			if(result_data[0]['status']==1){
				$(that).text('Delete');
				$('.deleteAlert').fadeOut();
				$('.shimmer').fadeOut();
				$('.availableDatesList').empty();
				fetch_available_dates();
				
			
			}
		}
	})
})