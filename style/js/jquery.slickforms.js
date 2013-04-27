/*
 * DC jQuery Slick Forms - jQuery Slick Forms
 * Copyright (c) 2011 Design Chemical
 * http://www.designchemical.com
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 */

(function($){

	//define the plugin
	$.fn.dcSlickForms = function(options) {

		//set default options
		var defaults = {
			classError: 'error',
			classForm: 'slick-form',
			align: 'left',
			animateError: true,
			animateD: 10,
			ajaxSubmit: true,
			errorH: 24,
			successH: 40
		};

		//call in the default otions
		var options = $.extend(defaults, options);
		
		//act upon the element that is passed into the design    
		return this.each(function(options){
			
			// Declare the function variables:
			var formAction = $(this).attr('action');
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			var textError = $('.v-error', this).val();
			var textEmail = $('.v-email', this).val();
			var $error = $('<span class="error"></span>');
			var $form = this;
			var $loading = $('<div class="loading"><span></span></div>');
			var errorText = '* Required Fields';
			var check = 0;
			
			$('input',$form).focus(function(){
				$(this).addClass('focus');
			});
			$('input',$form).blur(function(){
				$(this).removeClass('focus');
				masonryHeight();
			});
			$('.nocomment').hide();
			$('.defaultText',this).dcDefaultText();
			$('.'+defaults.classForm+' label').hide();
			
			// Form submit & Validation
			$(this).submit(function(){

				if(check == 0){
					horig = $('#bottom-container .boxes').height();
				}
				check = 1;
				formReset($form);
				$('.defaultText',$form).dcDefaultText({action: 'remove'});

				// Validate all inputs with the class "required"
				$('.required',$form).each(function(){
					var label = $(this).attr('title');
					var inputVal = $(this).val();
					var $parentTag = $(this).parent();
					if(inputVal == ''){
						$parentTag.addClass('error').append($error.clone().text(textError));
					}
			
					// Run the email validation using the regex for those input items also having class "email"
					if($(this).hasClass('email') == true){
						if(!emailReg.test(inputVal)){
							$parentTag.addClass('error').append($error.clone().text(textEmail));
						}
					}
				});

				// All validation complete - Check if any errors exist
				// If has errors
				if ($('.error',$form).length) {
					masonryHeight();
					$('.btn-submit',this).before($error.clone().text(textError));
				} else {
					if(defaults.ajaxSubmit == true){
						
						$(this).addClass('submit').after($loading.clone());
						$('.defaultText',$form).dcDefaultText({action: 'remove'});
						$.post(formAction, $(this).serialize(),function(data){
							$('.loading').fadeOut().remove();
							$('.response').html(data).fadeIn();
							var x = horig + defaults.successH;
							$('.boxes.masoned').animate({height: x+'px'},400);
							$('fieldset',this).slideUp();
						});
					} else {
						$form.submit();
					}
				}
				// Prevent form submission
				return false;
			});
	
		// Fade out error message when input field gains focus
			$('input, textarea').focus(function(){
				var $parent = $(this).parent();
				$parent.addClass('focus');
				$parent.removeClass('error');
				
			});
			$('input, textarea').blur(function(){
				var $parent = $(this).parent();
				var checkVal = $(this).attr('title');
				if (!$(this).val() == checkVal){
					$(this).removeClass('defaulttextActive');
				}
				$parent.removeClass('error focus');
				$('span.error',$parent).hide();
			});
			
			function formReset(obj){
				$('li',obj).removeClass('error');
				$('span.error',obj).remove();
				masonryHeight();
			}
			
			function masonryHeight(){
				var q = $('li.error',$form).length;
				if( q > 0 ){
					var x = horig + (q * defaults.errorH);
					$('.boxes.masoned').animate({height: x+'px'},400);
				}
			}
		});
	};
})(jQuery);
/*
 * DC jQuery Default Text - jQuery Default Text
 * Copyright (c) 2011 Design Chemical
 * http://www.designchemical.com
 */

(function($){

	//define the plugin
	$.fn.dcDefaultText = function(options) {
	
		//set default options
		var defaults = {
			action: 'add', // alternative 'remove'
			classActive: 'defaultTextActive'
		};

		//call in the default otions
		var options = $.extend(defaults, options);
  
		return this.each(function(options){
			
			if(defaults.action == 'add'){
			
				$(this).focus(function(srcc) {
					if ($(this).val() == $(this)[0].title) {
						$(this).removeClass(defaults.classActive);
						$(this).val('');
					}
				});
				
				$(this).blur(function() {
					if ($(this).val() == "") {
						$(this).addClass(defaults.classActive);
						$(this).val($(this)[0].title);
					}
				});
				$(this).addClass(defaults.classActive).blur();
			}
			
			if(defaults.action == 'remove'){
			
				var checkVal = $(this).attr('title');
				if ($(this).val() == checkVal){
					$(this).val('');
				}
					
			}
		});
	};
})(jQuery);