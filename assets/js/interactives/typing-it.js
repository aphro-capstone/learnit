
let lollll;
function Type_it (){
    this.score = 0; 
    this.difficulty = 1;
    this.allowInput = false;
    this.interval;
    this.json;
    this.wordindexs = [];
    this.words ;

    this.textinputbind = (e) => {
        if( !this.allowInput ) return;
        let el = $('.wordsWrap .words span.correct').last();
        let key = e.originalEvent.key.toUpperCase();

        if( el.length == 0 ){
            el = $( '.wordsWrap .words span').first();
        }else{
            el = el.next();
        }
        
        if( key == el.text().trim() ){
            el.addClass('correct');
        }

        if( $('.wordsWrap span.correct').length == $('.wordsWrap span').length ){
            this.score  = this.score+ this.words.points;
            $('.scoreWrap .score').html(this.score);
            this.getNewWord();
        }

    };
    this.start = (difficulty) =>{
        this.allowInput = true;
        this.difficulty = difficulty;
       
        let this_ = this;

        this.words = this.json.find( a => {  return  a.difficulty ==  difficulty } );
        console.log(this.words);
        let countdown_s  = this.words.duration;

        this.interval = setInterval( function(){
            countdown_s--;
            $('.timeWrap .time').html(countdown_s); 
            if( countdown_s == 0 ){
                this.allowInput = false;
                this_.stop();
            }
        },1000);

       
        $(document).bind('keyup',this_.textinputbind);
      
        
        this.getNewWord();

    };

    this.stop = () =>{
        clearInterval( this.interval );
        $(document).unbind('keyup',this_.textinputbind);
        $('.wordsWrap .words').html('<span class="game-over-text">Game Over. Score is '  + this.score + '</span>');
    }

    this.getNewWord = () => { 
       
        let randomIndex = Math.floor(Math.random() * Math.floor(this.words.words.length));
        if( this.wordindexs.includes(randomIndex)) this.getNewWord();
        else{
            $('.wordsWrap .words').html('');
            this.wordindexs.push( randomIndex ); 
            let word = this.words.words[ randomIndex ];
            let html = '';
            for(let x = 0; x < word.length; x++){
                html += '<span>' + word[x].toUpperCase() + '</span>';
            }
            $('.wordsWrap .words').html( html );
            
        }
    };

    this.getJSONObject = () => {
        this_ = this;
        $.ajax({
            url: SITE_URL + '/assets/json-objects/type-it.json',
            type: 'get',
            success: function(Response) {
                this_.json = Response;
           },error:function(e){
               console.log(e.responseText);
           }
       });
    };

    this.getJSONObject();

} 

const typeit = new Type_it();


jQuery(function($){
    $(document).on('click','button.start', () => {
        if( $('#typing-it-wrapper select[name="difficulty"]').val() == '' ){
            notify('error','Please Select a difficulty first',undefined,false);
            return;
        }
        $("#typing-it-wrapper").addClass("gamestart");
        console.log( $('#typing-it-wrapper select[name="difficulty"]').val() );
        typeit.start( $('#typing-it-wrapper select[name="difficulty"]').val() );
    });
});



// function startbtn(){
//     var x = document.getElementById("custom-select");
//     if (x.style.display === "none"){
//         x.style.display = "block";
//     }else{
//         x.style.display = "none";
//     }

// }