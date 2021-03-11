var classFocus;
var statusFocus = 1;


jQuery( function(){

    $('.status-dd li').on('click',function(){
        let str = $(this).text();
        $(this).closest('.dropdown').find('[data-toggle="dropdown"] span').text(str);
        statusFocus = $(this).find('a').attr('value');
        displayTasks();
    }); 
    listClass(); 
   
});


var displayTasks = function(){
    const str = '<div class="task-item" data-toggle="modal" data-target="#quizInstruction">\
                <div class="task-icon"	>\
                    <div class="ribbon left-ribbon ribbon-primary ribbon1">\
                        <div class="content big-text">\
                            <i class="fa fa-tasks"></i>\
                        </div>\
                    </div>\
                </div>\
                <div class="task-details">\
                    <p class="big-text task-name"> <a href="#"> Example Quiz task  </a></p>\
                    <p class="text-danger mb-0"> <i class="fa fa-clock-o"></i> Due on <span class="due-time"> May 01,2020 </span> </p>\
                    <p class="quiz-info"> <span class="questions"></span> Questions | <span class="duration">60</span> Minutes</p>\
                    <hr>\
                    <span class="d-block font-bold"> Instruction </span>\
                    <p class="instruction">\
                        1) This is by individual, pair or trio exercise.<br>\
                        2) This is an alternative exercise if you cannot do Final Module Exercise 3A.<br>\
                        3) You are task to do a Correlational Analysis on two continuous CODID-19 data.<br>\
                    </p>\
                </div>\
            </div>';

    $('.tasks-container').html('');
    


    

    tasks.forEach(t => {
        if( (t.tsk_status != statusFocus || t.class_id != classFocus) && statusFocus != 2 ) return true;

        if( statusFocus == 2 && t.subcount == 0 ) return true;
        
        let a = $(str);
            a.find('.task-name a').text(t.tsk_title);
            a.find('.instruction').html(t.tsk_instruction);
            a.attr({ 'data-task-id' : t.tsk_id, 'data-class-id' : t.class_id });
            a.find('.due-time').html( moment( t.tsk_duedate).format('MMMM D, YYYY'));
            

            if(t.tsk_type == 1){
                a.find('.quiz-info').remove();
                a.find('.task-name a').attr('href',SITE_URL + USER_ROLE + '/assignment/assignment:' + t.assID)
            }else{

                a.find('.task-name a').attr('href',SITE_URL + USER_ROLE + '/quiz/'+ ( t.subcount != 0 ? 'view' : 'quiz' )   +':' + t.quiz.id);
                a.find('.questions').text(t.quiz.count);
                a.find('.duration').text(t.quiz.duration);
            }
            $('.tasks-container').append(a);
    }) 

}

const listClass = () => {
    const str1 = '<li class="class-item"> <a href="#">  DNSC - QM (2nd, 2020)  </a> </li>'; 
    $('.class-item').remove();
    let listedClassID = [];
    let listedClass = [];

    tasks.forEach(t => { 

        if( listedClassID.indexOf(t.class_id) == -1 ){
            listedClass.push({ 'id' : t.class_id, 'name' : t.class_name });
            listedClassID.push( t.class_id );
        } 
    }) 


    listedClass.forEach( (c,d) => {
        let a = $(str1);
            a.attr('data-value',c.id);
            a.find('a').text(c.name);
            a.on('click',function(){
                classFocus = c.id;
                $('.class-item .class-item').toggleClass('active');
            });

            if(d == 0){
                a.addClass('active');
                classFocus = c.id;
                displayTasks();
            }
        $('.class-item-container').append( a );
    });
}