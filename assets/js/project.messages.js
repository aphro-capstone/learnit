jQuery( ($) => {

    $('[name="search_messages"]').on('focus',() => {
        $('#left-div .conversations').removeClass('show');
        $('#left-div .contacts').addClass('show');
    }).on('blur',() => {
        $('#left-div .conversations').addClass('show');
        $('#left-div .contacts').removeClass('show');
    });

    $(window).on('resize',function(){
        iniHeights();
    })
    iniHeights();
});



var iniHeights = () => {
    let winheight = window.innerHeight;
    let nav = $('header')[0].offsetHeight;
    let leftheading = $('#left-div .heading')[0].offsetHeight;
    let leftcontenttop = $('#left-div .search-message')[0].offsetHeight;
    let leftcontent = (winheight  - (nav + leftheading + leftcontenttop)) + 'px';
    let rightheading = $('#conversation-div .heading')[0].offsetHeight;
    let rightfooter = $('#conversation-div .footer')[0].offsetHeight;
    let rightcontent = (winheight - ( nav + rightheading + rightfooter)) + 'px';


    $('#left-div .conversations').css('height', leftcontent);
    $('#left-div .contacts').css('height', leftcontent);
    $('#conversation-div .conversation-content').css('height', rightcontent);
    
};