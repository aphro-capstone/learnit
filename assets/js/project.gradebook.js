

jQuery( ($) => {
	$('#gradebook-table').on( 'scroll', function(){
		console.log(1);
	});


	setTableFixedPart();
	
});



var setTableFixedPart = () => {
	$('#gradebook-table .student-header').css('top', $('#gradebook-table')[0].offsetTop );
	
	$('#gradebook-table .fixed-td').each( (a,b) => {
		$(b).css({'top': $(b)[0].offsetTop, height : $(b).next()[0].clientHeight});
	} );

	$('.gradebook-grid').css({ 'height' : (window.innerHeight -  $('.gradebook-grid')[0].offsetTop) - 20 });

}