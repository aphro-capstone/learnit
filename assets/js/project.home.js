
var scanner;

jQuery(function($){
  $('input[name="password"]').passwordStrengthCheck();

	$('form.login_reg').submit(function(e){
        e.preventDefault();
        var a = $(this); 
        $('.loading').addClass('show');
        $.ajax({
             url: $(this).attr('action'),
             type: 'post',
             dataType : 'json',
             data: a.serialize(),
             success: function(Response) {
             	notify( Response.type, Response.msg, () => {
                    $('.loading').removeClass('show');
             		if( Response.type != 'error' ){
             		// Action for login
             		if(Response.responseType == 1){
             			window.location.href= Response.link ;
             		}
             	}
             	});

            },error:function(e){
                notify( 'error','Error occured,  kindly contact support');
                console.log(e.responseText);
                $('.loading').removeClass('show');
            }
        });

    });

    $('.formReg').on('submit',function(e){
      e.preventDefault();
      
    	let data = $(this).serialize();
        $('.loading').addClass('show');
        let form = $(this);
      
      
        if(form.find('input[name="password"]').val().length < 8){
          notify('error', 'Password not enough! Please set it to 8 characters and above');
          $('.loading').removeClass('show');
          return;
        } 
      
        $.ajax({
        	url: $(this).attr('action'),
        	type: 'post',
         	dataType : 'json',
         	data: data,
         	success: function(Response) {
              notify( Response.type, Response.msg, () => {
                  if(Response.type == 'success'){
                    if( form.attr('id') == 'student-signup' ){
                      form.hide();
                      $('.loading').removeClass('show');
                      $('#student-mobile-verify').show();
                    }else{
                      $('[data-target="#login-form"]').trigger('click');
                      form.trigger('reset'); 
                    }
                        
                  }
              }, Response.time ? Response.time : 3000);
              $('.loading').removeClass('show');
        	},error:function(e){
                console.log(e);
                notify( 'error', 'An error occured,  kindly contact support.');
                $('.loading').removeClass('show');
        	}
    	});
    });

    $('#student-mobile-verify').on('submit',function(e){
        e.preventDefault();
        $('.loading').addClass('show');
        let form = $(this);
        $.ajax({
        	url:  $(this).attr('action'),
        	type: 'post',
         	dataType : 'json',
         	data: { code : $('#student-mobile-verify').find('[name="mobileverify"]').val() },
         	success: function(Response) {
            $('.loading').removeClass('show');
             if(Response.approved ){
               
              notify('success',Response.msg,undefined,3000);
              $('[data-target="#login-form"]').trigger('click');
              form.trigger('reset'); 
             }else{
              notify('error',Response.msg,undefined,3000);
             }
             
        	},error:function(e){
                console.log(e);
                notify( 'error', 'An error occured,  kindly contact support.');
                $('.loading').removeClass('show');
        	}
    	});

    });



    $('[role="Tabs"]').on('click',(e) => {
        e.preventDefault();
        let this_ = $(e.currentTarget);
        let entity_loctor = this_.attr('data-entity-locator');
        let target = this_.attr('data-target');
        $('form').trigger('reset');
        $(entity_loctor + ':visible').fadeOut(300, () => {
            $( target).fadeIn(300);
        });
    });

    $('[data-toggle="scrollto"]').on('click',function(){
       let target = $(this).attr('data-target');

       $([document.documentElement, document.body]).animate({
          scrollTop: $(target).offset().top - 50
      }, 1000);
    });


    $('.navbar-toggler').on('click',function(){
      $('body').toggleClass('navbar-open');
    });

   
});

var notify = (type, msg,callback = function(){},delay = 500 ) => {

    if(type == 'error') type = 'danger';
    if(type == 'success') type = 'info';
    
    $.notify( msg , {
        type: type,
        delay:delay,
        allow_dismiss: true,
        showProgressbar: true,
        onClose : callback
    });
};


 
jQuery.fn.passwordStrengthCheck = function () {
    var this__ = this;
    var this__form = this.closest('form');
  
    this.generatePassword = function () {
      var Password = {
        _pattern: /[a-zA-Z0-9_\!\@\#\$\%\^\*\-\_\+\=]/,
        _getRandomByte: function _getRandomByte() {
          if (window.crypto && window.crypto.getRandomValues) {
            var result = new Uint8Array(1);
            window.crypto.getRandomValues(result);
            return result[0];
          } else if (window.msCrypto && window.msCrypto.getRandomValues) {
            var result = new Uint8Array(1);
            window.msCrypto.getRandomValues(result);
            return result[0];
          } else {
            return Math.floor(Math.random() * 256);
          }
        },
        generate: function generate(length) {
          return Array.apply(null, {
            'length': length
          }).map(function () {
            var result;
  
            while (true) {
              result = String.fromCharCode(this._getRandomByte());
  
              if (this._pattern.test(result)) {
                return result;
              }
            }
          }, this).join('');
        }
      };
      return Password.generate(16);
    };
  
    this.testPassword = function (password) {
      var jsonStrengthData = [{
        'label': 'Too weak'
      }, {
        'label': 'Weak'
      }, {
        'label': 'Moderate'
      }, {
        'label': 'Good'
      }];
      var counter = 0;
      this__form.find('.progress-bar-item').removeClass (function (index, css) {
          return (css.match (/(^|\s)strength-\S+/g) || []).join(' ');
      });

      if (password.length >= 8) {
        
        var patterns = [/[A-Z]/, /[a-z]/, /[0-9]/, /[!@#$%^*\-_+=]/];
        patterns.forEach(function (e) {
          // var p = new RegExp(e);
          if (password.match(e)) {
            // console.log(e);
            counter++;
          }
        });

        this__form.find('.progress-bar-item').addClass( 'strength-' + counter);
        this__form.find('.password-strength span.strength').text(jsonStrengthData[counter == 0 ? 0 : counter - 1].label);
        this__form.find('.password-strength meter').attr('value', counter == 0 ? 0 : counter / jsonStrengthData.length);
      } else {
        this__form.find('.password-strength span.strength').text("-");
        this__form.find('.password-strength meter').attr('value', 0);
      }
  
      if (counter == 0) {
        this__form.find('button[type="submit"]').addClass('password-not-enough');
      } else {
        this__form.find('button[type="submit"]').removeClass('password-not-enough');
      }      
      return counter;
    };
  
    this.closest('div').css({
      transition: 'all ease 0.3s'
    }).after('<div class="password-strength" style="display:none;">\
                                      <div class="d-flex">\
                                        <p class="full-width">Password Strength : <span class="strength"> </span>  <meter value="0" style="display:none;"></meter> </p>\
                                        <div class="progress-bar-container full-width">\
                                          <div class="progress-bar-item" ></div>\
                                        </div>\
                                      </div>\
                                      <p> <span class="gen-pass"> Generate Password </span></p>\
                                      <ul style="margin-top: 15px;margin-bottom:0; padding-left: 20px; ">\
                                          <li>Use 8 to 64 characters</li>\
                                          <li>Use a combination of letters,numbers and special chars(!?)</li>\
                                          <li>For a stronger password, create a long phrase you can easily remember.</li>\
                                      </ul>\
                                  </div>');
    this.on('focus', function () {
      this__form.find('.password-strength').show();
    });
    this.on('blur',function(){
      this__form.find('.password-strength').hide();
    })
    this.on('input change', function (e) {
      var pass = e.currentTarget.value;
      this__.removeClass('generated-password');
        this__.testPassword(pass);
    });
    this__form.find('input').not(this).on('click', function () {
      this__form.find('.password-strength').hide();
    });
    this__form.find('.generate-password').on('click', function () {
        this__form.find('.password-strength').show();
        this__.val(this__.generatePassword());
      
        while (true) {
          if (this__.testPassword(this__.generatePassword()) == 4) {
            break;
          }
        }
    });
  };