
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

