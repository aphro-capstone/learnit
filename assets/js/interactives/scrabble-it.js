




jQuery(function($){

	init_();

});
function init_(){

	let scrps = [
					'submodal.js',
					'../lang/en_wordlist.js',
					'../lang/en_defs.js',
					'../lang/en_letters.js',
					'../lang/en_translate.js',
					'sizzle.js',
					'redipsdrag.js',
					'bonuses.js',
					'ui.js',
					'engine.js'
				];

    scrps.forEach( function(a,b){
    	console.log(a,b);
		 let script = document.createElement('script');
			script.setAttribute('id','scrabble-game-script-' +  b);
			script.setAttribute('type','text/javascript');
			script.setAttribute('src', SITE_URL +'assets/gameplugins/scrabble-it/src/'+ a )


		document.getElementsByTagName('body')[0].appendChild(script);	
    });


    setTimeout(function(){
    	if ( ! document.querySelectorAll ) document.querySelectorAll = Sizzle;
    	init( "idBoard" );
    },2000);
	

}