$(document).ready(function() {
	const today = new Date();
	let currentMonth = today.getMonth();
	let currentYear = today.getFullYear();

	const selectedDatesByMonth = {};

	function updateCalendar() {
		const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
		const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
		const calendarGrid = $(".calendar-grid");
		const currentMonthName = new Date(currentYear, currentMonth, 1).toLocaleString('default', { month: 'long' });

		$("#currentMonth").text(`${currentMonthName} ${currentYear}`);
		calendarGrid.empty();

		for (let i = 0; i < firstDayOfMonth; i++) {
			calendarGrid.append("<div class='calendar-day empty'></div>");
		}

		for (let day = 1; day <= daysInMonth; day++) {
			const date = new Date(currentYear, currentMonth, day);
			const options = { weekday: 'long', day: 'numeric' };
			const thisDay = date.getDate().toString().padStart(2,'0');
			const thisMonth = (date.getMonth() + 1).toString().padStart(2,'0');
			const thisYear = date.getFullYear().toString();
			const fullDate = `${thisMonth}/${thisDay}/${thisYear}`;//date.toLocaleDateString('default',{year:'numeric',month :'numeric',day :'numeric'});

			const formattedDate = date.toLocaleDateString(undefined, options);
			const isSelected = selectedDatesByMonth[currentMonth] && selectedDatesByMonth[currentMonth].includes(date.toDateString());
			const dayClass = isSelected ? "calendar-day selected" : "calendar-day";
			calendarGrid.append(`<div class='${dayClass}' data-date='${formattedDate}' full-date = '${fullDate}'>${day}</div>`);
		}


	}
	$(".calendar-day").click(function() {



	});

	function updateSelectedDatesList() {
		const selectedDatesList = $("#selectedDates");
		selectedDatesList.empty();

		//for (const month in selectedDatesByMonth) {}
		const selectedDatesOfMonth = selectedDatesByMonth[currentMonth];
		const monthName = new Date(currentYear, currentMonth, 1).toLocaleString('default', { month: 'long' });

		if (selectedDatesOfMonth && selectedDatesOfMonth.length > 0) {
			selectedDatesList.append(`<h4>${monthName} ${currentYear}</h4>`);
			const ul = $("<ul></ul>");
			selectedDatesOfMonth.forEach(date => {
				let dateSplit = date.split(" ")
				let thisDate = '';
				let thisWeek = '';
				for(let i = 0;i < dateSplit.length ; i++){
					let longDate = dateSplit[i].split('');
					let l = longDate.length;
					if(longDate[l-1]=='y'){
						thisWeek = dateSplit[i];
					}else{
						thisDate = dateSplit[i] 
					}

				}

				ul.append(`<li><h5>${thisDate}</h5><p>${thisWeek}</p></li>`);
			});
			selectedDatesList.append(ul);
		}

	}

	updateCalendar();
	$('body').delegate('.calendar-day','click',function(){
		const date = $(this).data("date");
		let date1 = $(this).attr('full-date')
		console.log($(this).data('no'))
		if($(this).data('no')>0){
			$('.deleteAlert').find('p').text('Patients Already Booked On This Date')
			$('.deleteAlert').find('.confirmdeleteAlert').css('display','none')
			$('.deleteAlert').find('.closedeleteAlert').text('Close').css('flex','100%')
			$('.deleteAlert').fadeIn();
			$('.shimmer').fadeIn();

		}else{
			if (!selectedDatesByMonth[currentMonth]) {
				selectedDatesByMonth[currentMonth] = [date];
				$(this).addClass("selected");
			} else {
				if (!selectedDatesByMonth[currentMonth].includes(date)) {
					selectedDatesByMonth[currentMonth].push(date);
					$(this).addClass("selected");
				} else {
					selectedDatesByMonth[currentMonth] = selectedDatesByMonth[currentMonth].filter(d => d !== date);
					$(this).removeClass("selected");
				}
			}
			update_dates(date1)
			updateSelectedDatesList();


		}



	})
	function update_dates(date){
		$.ajax({
			type:'post',
			url:'action/appointment/add-choose-date.php',
			data:{date:date},
			success:function(result){
				console.log(result)
				//fetch_added_dates()
			}
		})
	}
	fetch_added_dates()
	function fetch_added_dates(){
		$.ajax({
			type:'post',
			url:'action/appointment/fetch_added_dates.php',
			data:{month:currentMonth,year:currentYear},
			success:function(result){
				let result_data = JSON.parse(result);
				console.log(result_data)
				selectedDatesByMonth[currentMonth] = '';
				for(let x = 0; x<result_data.length; x++){

					$('.calendar-day').each(function(){
						let date = new Date(result_data[x]['dates'])
						const thisDay = date.getDate().toString().padStart(2,'0');
						const thisMonth = (date.getMonth() + 1).toString().padStart(2,'0');
						const thisYear = date.getFullYear().toString();
						const fullDate = `${thisMonth}/${thisDay}/${thisYear}`;
                        console.log(fullDate)
						if($(this).attr('full-date') == fullDate){
                          
							if(!selectedDatesByMonth[currentMonth]) {
								selectedDatesByMonth[currentMonth] = [$(this).data('date')];
								$(this).addClass("selected");
								$(this).attr('data-no',result_data[x]['noofapp'])
								//$(this).css('pointer-events','none').css('cursor','pointer')
							}else{
								selectedDatesByMonth[currentMonth].push($(this).data('date'));
								$(this).addClass("selected");
								$(this).attr('data-no',result_data[x]['noofapp'])
								// $(this).css('pointer-events','none')
							}

						}
					})

				}
				console.log(selectedDatesByMonth[currentMonth])
				$('.selectedDatesList').find('ul').empty();
				updateSelectedDatesList();

			}
		})
	}
	$("#prevMonth").click(function() {
		if (currentMonth > 0) {
			currentMonth--;
		} else {
			currentYear--;
			currentMonth = 11;
		}
		updateCalendar();
		fetch_added_dates();
	});

	$("#nextMonth").click(function() {
		if (currentMonth < 11) {
			currentMonth++;
		} else {
			currentYear++;
			currentMonth = 0;
		}
		updateCalendar();
		fetch_added_dates();
	});
	$('.closedeleteAlert').click(()=>{
		$('.deleteAlert').fadeOut();
		$('.shimmer').fadeOut();
	})

});




