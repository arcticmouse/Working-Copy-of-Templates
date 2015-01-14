function initialize() {
	jQuery( 'div.phys_filter_name div' ).css( 'display', 'none' );
	jQuery( 'div.phys_filter_language div' ).css( 'display', 'none' );
	jQuery( 'div.phys_filter_specialty div' ).css( 'display', 'none' );

	jQuery('ul#namesDir li').on('click', function() {
		jQuery('div.phys_filter_name div').css('display', 'none');
		jQuery('ul#namesDir li').css( 'background-color', '#cccccc' );

		var n = jQuery( this ).clone().html();
		jQuery( 'div.phys_filter_name' ).find( '.' + n ).css('display', 'inline');
		jQuery( this ).css( 'background-color', '#c0392b' );
		});

	jQuery('ul#langDir li').on('click', function() {
		jQuery('div.phys_filter_language div').css('display', 'none');
		jQuery('ul#langDir li').css( 'background-color', '#cccccc' );

		var l = jQuery( this ).attr( 'class' );
		jQuery( 'div.phys_filter_language' ).find( '.' + l ).css('display', 'inline');
		jQuery( this ).css( 'background-color', '#c0392b' );
		});

	jQuery('ul#specDir li').on('click', function() {
		jQuery('div.phys_filter_specialty div').css('display', 'none');
		jQuery('ul#specDir li').css( 'background-color', '#cccccc' );

		var s = jQuery( this ).attr( 'class' );
		jQuery( 'div.phys_filter_specialty' ).find( '.' + s ).css('display', 'inline');
		jQuery( this ).css( 'background-color', '#c0392b' );
		});

}

window.onload = initialize;