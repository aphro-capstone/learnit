
jQuery(function($){
    iniNewProgress();
});
 




const iniNewProgress = function(){
    
    this.displayMultiple = (e) => {
        let str = $('<div class="progress-item itemized-view mini-panel-item pull-left clickable-content" >\
                        <div class="class-name mp-head">\
                            '+ e.class_name +' ( <span class="current-sy"></span> , '+ e.class_sy_to +' )\
                        </div>\
                        <div class="mp-body">\
                            <span class="d-block">Grade : </span>\
                            <span class="d-block grade"></span>\
                        </div>\
                    </div>');

        str.on('click',function(){
            window.location.href=  SITE_URL + 'student/progress/details:' + e.class_id;
        });

        str.find('.current-sy').text( 'Period : ' + e.periods[0].cg_period_name );

        let totalScore = 0;
        let totalOver = 0;

        e.periods[0].normal_col_grades.forEach( ee => {
            totalScore += ee.grades.length > 0  && ee.grades[0].cgsg_score != '' ? parseInt( ee.grades[0].cgsg_score ) : 0;
            totalOver  += ee.grades.length > 0 ? parseInt( ee.grades[0].cgsg_over ) : parseInt( ee.default_over )
        });
        
        e.periods[0].task_grades.forEach(ee => {
            totalScore += ee.submissions.length > 0 ? parseInt( ee.submissions[0].score ): 0;

            if(ee.tsk_type == 1){
                totalOver += ee.submissions.length > 0 ? parseInt( ee.submissions[0].ass_over ): parseInt( ee.ass_default );
            }else{
                totalOver += parseInt( ee.quiz_total );
            }
            
        });      

        str.find('.grade').html( ((totalScore / totalOver) * 100).toFixed(2) + '%'  )

        $('#class-progress-list').append(str);
    }

    this.displayDetails = () => {
        
        
        showPeriodGrades = function(ee,isNormal = false){
            let str ='<tr class="clickable-content">\
                    <td>\
                        <span class="d-block font-bold name">Midterm Exam part 1 </span>\
                        <span class="d-block small-text assigned">Assigned Date : May 1, 2020 </span>\
                        <span class="d-block small-text due">Due on May 1, 2020 </span>\
                        </td>\
                    <td class="type"> </td>\
                    <td class="status"> <i class="fa fa-check text-primary"></i>  Taken </td>\
                    <td class="font-bold">  <span class="score">10</span> <span class="small-text">out of</span> <span class="over"> 60 </span> </td>\
                </tr>';
            
                ee.forEach(eee => {
                    let str1 = $(str);
                    if( isNormal ){
                        str1.find( '.name' ).text(eee.cgg_name);
                        str1.find('.assigned').html('Assigned Date : ' + moment(eee.timestamp_created).format('MMM D, YYYY hh:mm a'))
                        str1.find('.due').remove();
                        str1.find('.type').remove();
                        str1.removeClass('clickable-content');
                        str1.find('.status').attr('colspan',2).html('Manually Added');
                        str1.find('.score').text( eee.grades.length > 0 && eee.grades[0].cgsg_score != '' ? eee.grades[0].cgsg_score : 0 );
                        str1.find('.over').text( eee.grades.length > 0 && eee.grades[0].cgsg_over != '' ? eee.grades[0].cgsg_over : eee.default_over );
                    }else{
                        str1.find( '.name' ).text(eee.tsk_title);
                        str1.find( '.assigned' ).text('Assigned Date : ' + moment(eee.assigned_date).format('MMM D, YYYY hh:mm a'));
                        str1.find( '.due' ).text('Due on : ' + moment(eee.tsk_duedate).format('MMM D, YYYY hh:mm a'));
        
                        str1.find('.status').html( eee.submissions.length > 0 ? '<i class="fa fa-check text-primary"></i>  Taken ' : ( eee.tsk_status == 0 ? '<i class="fa fa-times text-danger"></i>  Closed ' : '<span class="text-info">Available</span>' )   );
                        if( eee.tsk_type == 1 ){
                            str1.find( '.type' ).text('Assignment');
                            str1.find('.score').text( eee.submissions.length > 0 ? eee.submissions[0].score : 0 );
                            str1.find('.over').text( eee.submissions.length > 0 ? eee.submissions[0].ass_over : eee.ass_default );
                        }else{
                            str1.find( '.type' ).text('Quiz');
                            str1.find('.score').text( eee.submissions.length > 0 ? eee.submissions[0].score : 0 );
                            str1.find('.over').text(  eee.quiz_total  );
                        }


                        str1.on('click',function(){
                            if( eee.tsk_type == 0 ){
                                window.location.href = SITE_URL + "/student/quiz/quiz:" + eee.quiz_id;
                            }else{
                                window.location.href = SITE_URL + '/student/assignment/assignment:' + eee.ass_id;
                            }
                        });
                    }



                   
                    

                    

                    $('table tbody').append(str1);
                });
        }

        showPeriods = function(ee,i){
            let str = $('<button class="btn btn-xs btn-outline-primary mr-1"> '+ ee.cg_period_name +'</button>');
            
            str.on('click',function(){
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
                $('table tbody').html('');
                showPeriodGrades( ee.normal_col_grades,true );
                showPeriodGrades( ee.task_grades );
            });

            
            $('.grading-periods').append(str);
            if( i == grades.periods.length - 1 ) str.trigger('click'); 
        }

        $('.grading-periods').html('');
        grades.periods.forEach( (ee,i) => {
            showPeriods( ee,i );
        });
    };


   

    if( !isSingleView ){
        $('#class-progress-list .progress-item').remove();
        grades.forEach(e => { displayMultiple(e); });
    }else{
        this.displayDetails();
    }
}