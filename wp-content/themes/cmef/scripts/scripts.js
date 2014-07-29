jQuery(function ($) {
	/* You can safely use $ in this code block to reference jQuery */

	//Style the first word of the menu item in the header.
	$('#menu-main-navigation-header li a').each(function() {
		var h = $(this).html();
		var index = h.indexOf(' ');
		if(index == -1) {
			index = h.length;
		}
		$(this).html('<span class="menu-first-word">' + h.substring(0, index) + '</span><br />' + h.substring(index, h.length));
		//$('.menu-main-navigation-header-container').toggle();
	});

	// This is for the menu item conditions
	$( 'body' ).on( 'change', '.menu-item-if-menu-enable', function() {
		$( this ).closest( '.if-menu-enable' ).next().toggle( $( this ).prop( 'checked' ) );
	} );

	//We Hid the menu so that we could change the style a bit and now we are showing it
	//The reason is because you get a flash of unstyled text which is ugly.
	$('.menu-main-navigation-header-container').toggle();

});