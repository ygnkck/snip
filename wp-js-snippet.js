

/*** Jquery to Add sticky header wordpress ***/


<script>
jQuery( document ).on('scroll', function(){
		if ( jQuery( document ).scrollTop() > 0 ){
			jQuery( '.ms__main-header' ).addClass( 'fixed' );			
		} else {
			jQuery( '.ms__main-header' ).removeClass( 'fixed' );			
		}
	});
</script>


/*** jquery for mobile menu toggle ******/

jQuery(document).ready(function($) {
    jQuery("#mobilemenu").hide();
    jQuery(".ms__menu-toggle").click(function() {
        jQuery("#mobilemenu").slideToggle(500);
		jQuery(".ms__mobile-menu").toggleClass('opened');
    });
});	
