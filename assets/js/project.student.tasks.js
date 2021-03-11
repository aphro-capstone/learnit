var classFocus;
var statusFocus = 1;
let listedClassID = [];
let listedClass = [];

jQuery( function(){

    $('.status-dd li').on('click',function(){
        let str = $(this).text();
        $(this).closest('.dropdown').find('[data-toggle="dropdown"] span').text(str);
        statusFocus = str == 'Ongoing' ? 1 : 0;
        displayTasks();
    }); 

    displayTasks();
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
                    <p class="big-text task-name">Example Quiz task </p>\
                    <p class="text-danger mb-0"> <i class="fa fa-clock-o"></i> Due on <span class="due-time"> May 01,2020 </span> </p>\
                    <p class=""> 60 Questions | 2 Hours</p>\
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

        // if( t.tsk_status != statusFocus && t.class_id != classFocus ) return true;

        let a = $(str);
            a.find('.task-name').text(t.tsk_title);
            a.find('.instruction').html(t.tsk_instruction);
            a.attr({ 'data-task-id' : t.tsk_id, 'data-class-id' : t.class_id });

            if( listedClassID.indexOf(t.class_id) == -1 ){
                listedClass.push({ 'id' : t.class_id, 'name' : t.class_name });
                listedClassID.push( t.class_id );
            }
            
            $('.tasks-container').append(a);
    }) 

}

const listClass = () => {
    const str1 = '<li class="class-item"> <a href="#">  DNSC - QM (2nd, 2020)  </a> </li>'; 
    $('.class-item').remove();
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