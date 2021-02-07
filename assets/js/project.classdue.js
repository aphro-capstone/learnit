let tasktypeshow = 0;
let taskclassshow;
let taskreviewshow = 'unreviewed';

let classActive = '';
let tabActive = 'all-stud';

jQuery( ($) => {
    $('.backbtn').on('click',function(){
        window.location.href= SITE_URL + "/teacher/classes/whats-due";
    });

    $('.section .search input').on('focus',function(){
        $(this).parent().addClass('focus');
    }).on('blur',function(){
        $(this).parent().removeClass('focus');
    });

    $('.toppart .search input').on('input',function(){
        let search = $(this).val();

        if( search == ''){
            $(this).closest('.dropdown-w-search').find('.search-results .item').show();
        }else{
            $(this).closest('.dropdown-w-search').find('.search-results .item').each(function(){
                if( $(this).text().trim().toLowerCase().startsWith( search.toLowerCase() ) ){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
        }
    });

    $('.toppart .dropdown-w-search .search-results .class-item a').on('click',function(){
        $(this).closest('.dropdown').find(' > .data-toggle .text').text( $(this).text().trim() );
        $(this).parent().siblings().removeClass('active');
        $(this).parent().addClass('active');
        taskclassshow = $(this).parent().attr('cid');
        showTasks();

    });

    $('.all-work-dd li a').on('click',function(){

        tasktypeshow = $(this).attr('data-val');
        $(this).closest('.dropdown').find('span[data-toggle="dropdown"] span.text').text( $(this).text().trim()  );
        showTasks();
    });

    $('.mark-review,.mark-unreview').on('click',function(){
        markasReviewed($(this), $(this).closest('.due-item').attr('data-tid'), $(this).hasClass('mark-review') ? 1 : 0 );
    }); 

    $('.toggle-tasks').on('click',function(){
        if( !$(this).hasClass('active') ){
            taskreviewshow = $(this).hasClass('forreview') ? 'unreviewed' : 'reviewed';
            showTasks();
        }
    });

    $('.unlock-quiz').on('click',function(e){
        e.preventDefault(); 
        lockunlockQuiz(1);
    });

    $('.lock-quiz').on('click',function(e){
        e.preventDefault(); 
        lockunlockQuiz(0);
    });

    $('.lock-quiz-due').on('click',function(e){
        e.preventDefault(); 
        lockunlockQuiz(1,'lockondue');
    });
    $('.remove-lock-quiz-due').on('click',function(e){
        e.preventDefault(); 
        lockunlockQuiz(0,'lockondue');
    });
    

    $('.lockassondue').on('click',function(){
            let temp = $(this).parent().hasClass('checked') ? 1 : 0;
            lockunlockQuiz( temp, 'lockondue');
    }); 

    $('.edit-assignment').on('click',function(){
        setUpdateAssignment(  );
        $('#assignmentModal').modal('show');
    });



    showTasks();
    iniClassDue();
});



const showTasks = function(){ 
    $('#div1 table tbody .no-show').remove();
    if( taskclassshow == undefined ){ 
        if( tasktypeshow == 0 ){ 
            $('#div1 tr.due-item.' + taskreviewshow).show();
        }
        else if( tasktypeshow == 1 ){ 
            $('#div1 tr.due-item.ass-item').show();
            $('#div1 tr.due-item.quiz-item').hide();
        }else if( tasktypeshow == 2 ){
            $('#div1 tr.due-item.quiz-item').show();
            $('#div1 tr.due-item.ass-item').hide();
        }
        $('#div1 tr.due-item:not(.' + taskreviewshow +')').hide();

        if( !$('#div1 tr.due-item').is(':visible') ){
            $('#div1 table tbody').append('<tr class="no-show"> <td colspan="4" class="text-center"> No task to show</td></tr>');
        }
    }else{
        hasShow = false;
        $('#div1 tr.due-item').each(function(){
            classids = $(this).attr('data-cid');
            classids = JSON.parse( classids );

            typeshowclass = tasktypeshow == 1 ? 'ass-item' : (tasktypeshow == 2 ? 'quiz-item' : '');
            if( classids.indexOf( parseInt(taskclassshow) ) > - 1 && (  typeshowclass == '' || $(this).hasClass(typeshowclass) ) ){
                    $(this).show(300);
                    hasShow = true;
            }else{
                $(this).hide();
            }
        });
       
        $('#div1 tr.due-item:not(.' + taskreviewshow +')').hide();

        if( !$('#div1 tr.due-item').is(':visible') ){
            $('#div1 table tbody').append('<tr class="no-show"> <td colspan="4" class="text-center"> No task to show</td></tr>');
        }

        if(!hasShow){
            $('#div1 table tbody').append('<tr class="no-show"> <td colspan="4" class="text-center"> No task to show</td></tr>');
        } 
    }
}
 
const iniClassDue = () => {

    if( !isOntaskindividualpages ) return;

    this.showClassSubmissions = (searchstudname = '') =>{
        
        const table = $('.details-table tbody');
            table.html('');
        
 
        let element = $('<tr class="task-grade-item">\
                        <td>\
                            <div class="student-info">\
                                <div class="student-image img-container ">\
                                <img src="'+ SITE_URL +'/assets/images/avatars/user2.png">\
                                </div>\
                                <div class="student-name"> </div>\
                            </div>\
                        </td>\
                        <td class="text-center v-mid date-submitted"> June 10, 2020 @ 11:00 PM </td>\
                        <td class="text-center v-mid grades"> <span class="score"></span>    of <span class="over"></span> </td>\
                        <td class="action v-mid text-center"> </td>\
                    </tr>');

        let buttonsAssignment = ' <a href="#" class="btn btn-primary btn-xs mr-1" data-toggle="tooltip" data-placement="top" title="View">  <i class="fa fa-eye"></i> View Submission</a>';

        
        let buttonsQuiz = '<a href="#" class="btn btn-primary btn-xs mr-1" >  <i class="fa fa-eye"></i> View Quiz </a>';

        element.find( 'td.action' ).append( viewType == 'assignment' ? buttonsAssignment : buttonsQuiz  );

    
        let arr = submissions; 
        arr = $.grep(arr, function( n, i ) {
            let allow = true;
            if( searchstudname != '' ){
                allow = n.studname.toLowerCase().indexOf( searchstudname.toLowerCase() ) > -1;
            }
            if( tabActive == 'graded'){
                allow = n.ass_over != undefined
            }else if ( tabActive == 'not-graded'){
                allow = n.ass_over == undefined;
            }

            if( classActive != undefined && classActive != '' ){ 
                let found = false;
                n.studclasses.forEach(el => {
                    if(el.class_id ==  classActive ){
                        found = true; 
                    }
                });
                allow = found;
            }
            return  allow  ;
        });


        
        let total = { score : 0, over : 0 };


        if( arr.length > 0 ){
            $.each( arr,function(a,b){
                let el = element.clone();
                    el.find('.student-name').text(b.studname);
                    el.find('.date-submitted').text( moment( b.datetime_submitted ).format('MMMM DD, YYYY @ hh:mm A') );
                    if( viewType == 'assignment' ){
                        total['score'] = total.score + parseFloat( b.ass_grade );
                        total['over'] = total.over + parseFloat( b.ass_over );
                        el.find('.score').text(b.ass_grade);
                        el.find('.over').text(b.ass_over); 
                        el.find('td.action a').attr('href', SITE_URL + USER_ROLE + '/classes/assignment/submission:' + b.ts_id )
                    }else{
                        total['score'] = total.score + parseFloat(b.quiz_score);
                        total['over'] = total.over + b.parseFloat( total_points );
                        el.find('.score').text(b.quiz_score);
                        el.find('.over').text(b.total_points); 
                        el.find('td.action a').attr('href', SITE_URL + USER_ROLE + '/classes/quiz/submission:' + b.ts_id );
                    }


                    table.append(el);
            } );
            console.log(total);
            $('.average-percentage').html( ((total.score/ total.over) * 100).toFixed(0) + '%' );

        }else{
            table.append('<tr><td colspan="4" class="text-center"> No records to show </td></tr>' );
        }
    }
    
    this.showAssignees= (searchClass = '') => {

        const dropdown = $('.classes-dropdown');
        const element = $('<div class="item class-item"> <a href="#">  <span class="left-bg" style="background-color:#3583e5"></span> <span class="class-name">Class 1</span> </a> </div>')
        dropdown.find(' > div:not(.default)').remove();
        
        let arr = assignees;
    
        if( searchClass != '' ){
            arr = $.grep(arr, function( n, i ) {
                return  n.class_name.toLowerCase().startsWith( searchClass.toLowerCase() )  ;
            });
        }
        
    
    
        $.each( arr,function(a,b){
            let el = element.clone();
                el.find('.class-name').text(b.class_name);
                el.find('.left-bg').css({ 'background-color' : b.sc_color  });
    
                el.attr('data-item-id',b.class_id);
    
                el.find('a').on('click',function(e){
                    e.preventDefault();
                    $('.viewing-class').html(  $(this).text()); 
                });
    
                dropdown.append(el);
        } );
    }

    $('.section .search input').on('input',function(){
        showClassSubmissions( $(this).val() );
    }); 
    
    if( isOntaskindividualpages && viewType == 'assignment'  ){
        $('.dropdown-w-search .search input').on('input',function(){
            
            showAssignees( $(this).val() );
        }); 

        $(document).on('click','.classes-dropdown .class-item a',function(){
            classActive = $(this).parent().attr('data-item-id');
            showClassSubmissions();
        });

        $('.panel-top-content .nav-tabs li a').on('click',function(){
            $('.panel-top-content .nav-tabs li a.active').removeClass('active');
            $(this).addClass('active');

            tabActive = $(this).attr('data-sort');
            showClassSubmissions();
        });
    

        

        showAssignees();
    }else{

    }

    showClassSubmissions();
}
 

const markasReviewed = (el,tid,val) => {

    let ajaxFunc = () => {
        $.ajax({
                url: SITE_URL + 'teacher/task', 
                type: 'post',
                dataType : 'json',
                data : { tid : tid, action : 'review',val : val },
                success: function(Response) { 
                    if( Response.Error == null ){ 
                        notify('success', Response.msg);
                        if( val == 1 ){
                            el.removeClass('btn-outline-primary')
                              .removeClass('mark-review')
                              .addClass('btn-outline-danger mark-unreview')
                              .text('Marked as unreviewed');
                            el.closest('tr')
                              .removeClass('unreviewed')
                              .addClass('reviewed')
                              .find('td.status-td')
                              .html('<div class="status-closed"> <span>Closed</span>  </div>');
                              showTasks();
                        }else{
                            el.closest('tr')
                              .removeClass('reviewed')
                              .addClass('unreviewed');
                            el.removeClass('btn-outline-danger')
                              .removeClass('mark-unreview')
                              .addClass('btn-outline-primary mark-review')
                              .text('Marked as reviewed'); 
                        }
                    }else{
                        notify('error',Response.Error);
                    }
                },error:function(e){
                    console.log(e.responseText);
                }
        });
    }

    if( val == 1){
        jConfirm( 'red', 'Please confirm,  marking the task as reviewed will also set it automatically as closed.', ajaxFunc );
    }else{
        ajaxFunc();
    }
    

    
}

const lockunlockQuiz = (val,action) => {
    
    let ajxFunc = () => {
        $.ajax({
                url: SITE_URL + 'teacher/task', 
                type: 'post',
                dataType : 'json',
                data : { tid : tid,val : val,action : action },
                success: function(Response) {
                    console.log(Response);
                    if( Response.Error == null ){ 
                        notify('success', Response.msg, ()=>{
                            window.location.reload();
                        });
                    }else{
                        notify('error',Response.Error);
                    }
                },error:function(e){
                    console.log(e.responseText);
                }
        });
    }
    jConfirm( 'red', 'Are you sure ?' , ajxFunc );
}


const setUpdateAssignment = () => {
    let modal = $('#assignmentModal');
    modal.find('[name="title"]').val(TI.tsk_title);
    modal.find('[name="instruction"]').val(TI.tsk_instruction);
    modal.find('[name="title"]').val(TI.tsk_title);

    let duedate = moment( TI.tsk_duedate );

    modal.find('input.datepicker').datepicker('setDate', duedate.toDate());
    modal.find('[name="time_h"]').val( duedate.format('h'));
    modal.find('[name="time_m"]').val( duedate.format('m'));
    modal.find('[name="time_a"]').val( duedate.format('a'));

    if( TI.tsk_lock_on_due == 1 ){
        modal.find('[name="islockondue"]').parent().addClass('checked');
        modal.find('[name="islockondue"]').parent().find('input').prop('checked',true);

    }else{
        modal.find('[name="islockondue"]').parent().removeClass('checked');
        modal.find('[name="islockondue"]').parent().find('input').prop('checked',false);
    }

    let options = JSON.parse( TI.tsk_options );
    if( TI.tsk_lock_on_due == 1 ){
        modal.find('[name="islockondue"]').parent().addClass('checked');
        modal.find('[name="islockondue"]').prop('checked',true);

    }else{
        modal.find('[name="islockondue"]').parent().removeClass('checked');
        modal.find('[name="islockondue"]').prop('checked',false);
    }

    if( options.isaddtogradebook == 'true' ){
        modal.find('[name="isaddtogradebook"]').parent().addClass('checked');
        modal.find('[name="isaddtogradebook"]').prop('checked',true);

    }else{
        modal.find('[name="isaddtogradebook"]').parent().removeClass('checked');
        modal.find('[name="isaddtogradebook"]').prop('checked',false);
    }

}

 