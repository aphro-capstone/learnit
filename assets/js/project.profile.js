



jQuery( function($){



	$('.editprofileBtn,.saveProfileBtn').on('click',(e) =>{
		$(e.target).closest(".panel-content").toggleClass("editing");
		setAllInputEditable(  $(e.target).closest(".panel-content").hasClass('editing')  );
	});
});	



var setAllInputEditable =  ( isReverse = false ) => {
	$('#about form input').each( function(a,b){
		$(b).prop('readonly', !isReverse);
	});
};


