
jQuery(function(){
	$('.clickableFolder').on('click',function(e){
		$('#folder-panel1').hide();
		$('#folder-panel2').show();
	});
	$('.returnFolder').on('click',function(e){
		$('#folder-panel1').show();
		$('#folder-panel2').hide();
	});

	$('.folder-panel .search input').on('focus',function(){
        $(this).parent().addClass('focus');
    }).on('blur',function(){
        $(this).parent().removeClass('focus');
    });


    $('.folder-details').on('click',function(){
    	$(this).toggleClass('selected');
    });
});