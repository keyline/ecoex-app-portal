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
	jQuery('[data-toggle="tooltip"]').tooltip();
		
//=============== Sticky =====================	
	jQuery('.sticky').positionSticky();
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







