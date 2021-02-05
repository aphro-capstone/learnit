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

	$('#multimedia').on('hidden.bs.modal',function(){
		$(this).find('video')[0].pause();
		$(this).find('video').remove();
	});
	$('.videobox .img-container').on('click',function(){
		let vidpath = SITE_URL + $(this).attr('data-src');
		$('#multimedia').modal( { backdrop : 'static' , keyboard : false  } );

		let video = $('<video preload="auto" controls="controls" autoplay>\
					<source src="'+ vidpath +'" type="video/mp4">\
					<source src="media/why-autologel.webm" type="video/webm">\
				</video>');
		$('#multimedia #multimedia-container').append(video);
		 
	});

	$('#gamesinte').on('hidden.bs.modal',function(){
		$('#gamescript').off().remove();
	});

 
	$('.slick-container	').slick({
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 3,
		autoplay: true,
		autoplaySpeed: 4000,
		responsive: [
			{
			  breakpoint: 1024,
			  settings: {
				slidesToShow: 3,
				slidesToScroll: 3,
				infinite: true,
				dots: true
			  }
			},
			{
			  breakpoint: 600,
			  settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			  }
			}
			// You can unslick at a given breakpoint now by adding:
			// settings: "unslick"
			// instead of a settings object
		  ]
	});


	$('.videobox .buttons span').on('click',function(){
		if( $(this).hasClass('get-url') ){
			$.confirm({
				title : 'Video URL',
				type : 'blue',
				content : SITE_URL + USER_ROLE + '/videoplayurl/' + $(this).closest('.videobox').attr('data-vid-id'),
				button : {
					close :  function(){}
				}
			});
		}
	});

});