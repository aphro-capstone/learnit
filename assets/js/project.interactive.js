jQuery(function($){

	$(".modal-games-trgr").on("click", function(e){

		let triggerType = 'typing-it';

		if( $(this).attr('data-type') ) triggerType = $(this).attr('data-type'); 

		console.log(SITE_URL + USER_ROLE  +  '/games/' + triggerType);

		$("#gamesinte").modal({ backdrop : 'static', keyboard : false });
		$('#game-container').load( SITE_URL + USER_ROLE  +  '/games/' + triggerType);



		$('#gamescript').off().remove();


		let script = document.createElement('script');
			script.setAttribute('id','gamescript');
			script.setAttribute('type','text/javascript');
			script.setAttribute('src', SITE_URL +'assets/js/interactives/'+ triggerType +'.js' )


		document.getElementsByTagName('body')[0].appendChild(script);

	});

	$('.videobox').on('click',function(){
		$('#multimedia').modal( { backdrop : 'static' , keyboard : false  } );
		$('#multimedia video').play();	
	});

	$('#gamesinte').on('hidden.bs.modal',function(){
		$('#gamescript').off().remove();
	});

});