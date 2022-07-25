// JavaScript Document
jQuery(document).ready(function(){

	// ============ password show hide letter ===============

	$("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });


// =========   OPT input box ========================
	$('.digit-group').find('input').each(function() {
		$(this).attr('maxlength', 1);
		$(this).on('keyup', function(e) {
			var parent = $($(this).parent());
			
			if(e.keyCode === 8 || e.keyCode === 37) {
				var prev = parent.find('input#' + $(this).data('previous'));
				
				if(prev.length) {
					$(prev).select();
				}
			} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
				var next = parent.find('input#' + $(this).data('next'));
				
				if(next.length) {
					$(next).select();
				} else {
					if(parent.data('autosubmit')) {
						parent.submit();
					}
				}
			}
		});
	});

// =============== multi step dashboard ==================

	var current_fs, next_fs, previous_fs; //fieldsets
	var opacity;

	$(".next").click(function(){

		current_fs = $(this).parent();
		next_fs = $(this).parent().next();
		
		//Add Class Active
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		
		//show the next fieldset
		next_fs.show();
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now) {
				// for making fielset appear animation
				opacity = 1 - now;
				
				current_fs.css({
				'display': 'none',
				'position': 'relative'
				});
				next_fs.css({'opacity': opacity});
			},
			duration: 600
		});
	});

	$(".previous").click(function(){

		current_fs = $(this).parent();
		previous_fs = $(this).parent().prev();

		//Remove class active
		$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

		//show the previous fieldset
		previous_fs.show();

		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now) {
			// for making fielset appear animation
			opacity = 1 - now;
			current_fs.css({
				'display': 'none',
				'position': 'relative'
			});
				previous_fs.css({'opacity': opacity});
			},
			duration: 600
		});
	});

	// $('.radio-group .radio').click(function(){
	// 	$(this).parent().find('.radio').removeClass('selected');
	// 	$(this).addClass('selected');
	// });

	$(".submit").click(function(){
		return false;
	})
	

	// ===================== custom attach icon ===============
	$('#custom-input-file').simpleFileInput({
		placeholder : 'Upload Pan Number',
		buttonText : 'Select',
		allowedExts : ['png', 'gif', 'jpg', 'jpeg']
	});
	$('#custom-input-file-2').simpleFileInput({
		placeholder : 'Upload GST certificate',
		buttonText : 'Select',
		allowedExts : ['png', 'gif', 'jpg', 'jpeg']
	});
	$('#custom-input-file-3').simpleFileInput({
		placeholder : 'Upload File',
		buttonText : 'Select',
		allowedExts : ['png', 'gif', 'jpg', 'jpeg']
	});
	$('#custom-input-file-4').simpleFileInput({
		placeholder : 'Upload Cancelled Cheque',
		buttonText : 'Select',
		allowedExts : ['png', 'gif', 'jpg', 'jpeg']
	});



//===============Owl-carocel=====================	

jQuery('.owl-carousel').owlCarousel({
    rtl:true,
    loop:true,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
		768:{
            items:2
        },
        1000:{
            items:3
        }
    }
})
	
//===============tooltip=====================
	//jQuery('[data-toggle="tooltip"]').tooltip();
		
//=============== Sticky =====================	
	//jQuery('.sticky').positionSticky();
//===============Scroll To Top=====================	
	
	//Check to see if the window is top if not then display button
	jQuery(window).scroll(function(){
			if (jQuery(this).scrollTop() > 100) {
				$('.scrollToTop').fadeIn();
			} else {
				jQuery('.scrollToTop').fadeOut();
			}
		});
		
		//Click event to scroll to top
		jQuery('.scrollToTop').click(function(){
			jQuery('html, body').animate({scrollTop : 0},800);
			return false;
		});
		
		
		




//=======end============
});




	
