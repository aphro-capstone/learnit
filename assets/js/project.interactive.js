jQuery(function($){

	$(".modal-games-trgr").on("click", function(e){

		let triggerType = 'typing-it';

		if( $(this).attr('data-type') ) triggerType = $(this).attr('data-type'); 

		$("#gamesinte").modal("show");
		$('#gamesinte .modal-body').load( SITE_URL + USER_ROLE  +  '/games/' + triggerType);



		$('#gamescript').off().remove();


		let script = document.createElement('script');
			script.setAttribute('id','gamescript');
			script.setAttribute('type','text/javascript');
			script.setAttribute('src', SITE_URL +'assets/js/interactives/'+ triggerType +'.js' )


		document.getElementsByTagName('body')[0].appendChild(script);

	});

});