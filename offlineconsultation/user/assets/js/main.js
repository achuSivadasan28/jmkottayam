
// sidemenu 
$('.navBarBox').click(function(){
	$('.sidemenu').addClass('sidemenuActive');
	$('.shimmer').fadeIn();
})
$('.closeSidemenu').click(function(){
	$('.sidemenu').removeClass('sidemenuActive');
	$('.shimmer').fadeOut();
});


//sckelly
$(window).load(function() {
	$('.sckelly').css({
		display: 'none',
	});
});