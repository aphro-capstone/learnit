jQuery( ($) => {
    $('.backbtn').on('click',function(){
        window.location.href="http://localhost/capstone_project/teacher/classes/whats-due";
    });

    $('.section .search input').on('focus',function(){
        $(this).parent().addClass('focus');
    }).on('blur',function(){
        $(this).parent().removeClass('focus');
    });

    iniClassDue();
});



const iniClassDue = () => {

    if( !isOntaskindividualpages ) return;

    this.showClassSubmissions = (searchstudname = '') =>{
        const table = $('.details-table tbody');
            table.html('');
    
        let element = $('<tr class="task-grade-item">\
                        <td>\
                            <div class="student-info">\
                                <div class="student-image img-container ">\
                                <img src="http://localhost/capstone_project/assets/images/avatars/user2.png">\
                                </div>\
                                <div class="student-name"> Aphrodite Gajo</div>\
                            </div>\
                        </td>\
                        <td class="text-center v-mid date-submitted"> June 10, 2020 @ 11:00 PM </td>\
                        <td class="text-center v-mid grades"> 30 out of 40 </td>\
                        <td class="action v-mid text-center"> </td>\
                    </tr>');

        let buttonsAssignment = '<div><a href="#" class="btn btn-primary btn-xs mr-1" data-toggle="tooltip" data-placement="top" title="View">  <i class="fa fa-eye"></i> </a>\
                                <a href="#" class="btn btn-info btn-xs mr-1" data-toggle="tooltip" data-placement="top" title="Grade">  <i class="fa fa-star"></i> </a>\
                                <a href="#" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete">  <i class="fa fa-trash"></i></a></div>';

        
        let buttonsQuiz = '<a href="#" class="btn btn-primary btn-xs mr-1" >  <i class="fa fa-eye"></i> View Quiz </a>';

        element.find( 'td.action' ).append( viewType == 'assignment' ? buttonsAssignment : buttonsQuiz  );

    
        let arr = submissions;
    
        if( searchstudname != '' ){
            arr = $.grep(arr, function( n, i ) {
                return  n.studname.toLowerCase().startsWith( searchstudname.toLowerCase() )  ;
            });
        }
    
        if( arr.length > 0 ){
            $.each( arr,function(a,b){
                let el = element.clone();
                    el.find('.student-name').text(b.studname);
                    el.find('.date-submitted').text( moment( b.datetime_submitted ).format('MMMM DD, YYYY @ hh:mm A') );
                    el.find('.grades').text( '30 out of 40' );  
                    el.find('td.action a').attr('href', SITE_URL + USER_ROLE + '/classes/quiz/submission:' + b.ts_id );
                    table.append(el);
            } );
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
                el.find('.class-name').text(b.studname);
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
        showAssignees();
    }else{

    }

    showClassSubmissions();
}
