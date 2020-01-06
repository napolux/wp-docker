(function(jQuery) {
	// we create a copy of the WP inline edit post function
	var $wp_inline_edit = inlineEditPost.edit;
	// and then we overwrite the function with our own code
	inlineEditPost.edit = function( id ) {
		// "call" the original WP edit function
		// we don't want to leave WordPress hanging
		$wp_inline_edit.apply( this, arguments );
		// now we take care of our business
		// get the post ID
		var $post_id = 0;
		if ( typeof( id ) == 'object' ) {
			$post_id = parseInt( this.getId( id ) );
		}
		if ( $post_id > 0 ) {
			// define the edit row.
			var $edit_row = jQuery( '#edit-' + $post_id );
			var $post_row = jQuery( '#post-' + $post_id );

			// get the data.
			var has_original = ( jQuery( '.duplicate_post_original_item span[data-no_original]', $post_row ).length === 0 );
			var original = jQuery( '.duplicate_post_original_item', $post_row ).html();

			// populate the data.
			if ( has_original ) {
				jQuery( '.duplicate_post_original_item_title_span', $edit_row ).html( original );
				jQuery( '#duplicate_post_quick_edit_fieldset', $edit_row ).show();
			} else {
				jQuery( '#duplicate_post_quick_edit_fieldset', $edit_row ).hide();
				jQuery( '.duplicate_post_original_item_title_span', $edit_row ).html( '' );
			}
		}
	};

})(jQuery);