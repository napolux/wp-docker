<?php
/**
 * Plugin name: AJAX Thumbnail Rebuild
 * Plugin URI: https://wordpress.org/plugins/ajax-thumbnail-rebuild/
 * Author: junkcoder, ristoniinemets
 * Version: 1.13
 * Description: AJAX Thumbnail Rebuild allows you to rebuild all thumbnails on your site.
 * Tested up to: 4.9.8
 * Text Domain: ajax-thumbnail-rebuild
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /languages
 */

class AjaxThumbnailRebuild {

	function __construct() {
		add_action( 'admin_menu',                array( $this, 'addAdminMenu' ) );
		add_filter( 'attachment_fields_to_edit', array( $this, 'addRebuildSingle' ), 10, 2 );
	}

	function addAdminMenu() {
		add_management_page( __( 'Rebuild all Thumbnails', 'ajax-thumbnail-rebuild' ), __( 'Rebuild Thumbnails', 'ajax-thumbnail-rebuild' ), 'manage_options', 'ajax-thumbnail-rebuild', array( $this, 'ManagementPage' ) );
	}

	/**
	 * Add rebuild thumbnails button to the media page
	 *
	 * @param array $fields
	 * @param object $post
	 * @return array
	 */
	function addRebuildSingle( $fields, $post ) {
		$thumbnails = array();

		foreach ( ajax_thumbnail_rebuild_get_sizes() as $s ) {
			$thumbnails[] = 'thumbnails[]=' . $s['name'];
		}

		$thumbnails = '&' . implode( '&', $thumbnails );

		ob_start();
		?>
		<script>
			function setMessage(msg) {
				jQuery("#atr-message").html(msg);
				jQuery("#atr-message").show();
			}

			function regenerate() {
				jQuery("#ajax_thumbnail_rebuild").prop("disabled", true);
				setMessage("<?php _e('Reading attachments...', 'ajax-thumbnail-rebuild') ?>");
				thumbnails = '<?php echo $thumbnails ?>';
				jQuery.ajax({
					url: "<?php echo admin_url('admin-ajax.php'); ?>",
					type: "POST",
					data: "action=ajax_thumbnail_rebuild&do=regen&id=<?php echo $post->ID ?>" + thumbnails,
					success: function(result) {
						if (result != '-1') {
							setMessage("<?php _e('Done.', 'ajax-thumbnail-rebuild') ?>");
						}
					},
					error: function(request, status, error) {
						setMessage("<?php _e('Error', 'ajax-thumbnail-rebuild') ?>" + request.status);
					},
					complete: function() {
						jQuery("#ajax_thumbnail_rebuild").prop("disabled", false);
					}
				});
			}
		</script>
		<input type='button' onclick='javascript:regenerate();' class='button' name='ajax_thumbnail_rebuild' id='ajax_thumbnail_rebuild' value='Rebuild Thumbnails'>
		<span id="atr-message" class="updated fade" style="clear:both;display:none;line-height:28px;padding-left:10px;"></span>
		<?php
		$html = ob_get_clean();

		$fields['ajax-thumbnail-rebuild'] = array(
			'label' => __( 'Ajax Thumbnail Rebuild', 'ajax-thumbnail-rebuild' ),
			'input' => 'html',
			'html'  => $html
		);

		return $fields;
	}

	function ManagementPage() {
		?>
		<div id="message" class="updated fade" style="display:none"></div>
		<script type="text/javascript">
		// <![CDATA[
		function setMessage(msg) {
			jQuery("#message").html(msg);
			jQuery("#message").show();
		}

		function regenerate() {
			jQuery("#ajax_thumbnail_rebuild").prop("disabled", true);
			setMessage("<p><?php _e('Reading attachments...', 'ajax-thumbnail-rebuild') ?></p>");

			inputs = jQuery( 'input:checked' );
			var thumbnails= '';
			if( inputs.length != jQuery( 'input[type=checkbox]' ).length ){
				inputs.each( function(){
					thumbnails += '&thumbnails[]='+jQuery(this).val();
				} );
			}

			var onlyfeatured = jQuery("#onlyfeatured").prop('checked') ? 1 : 0;

			jQuery.ajax({
				url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
				type: "POST",
				data: "action=ajax_thumbnail_rebuild&do=getlist&onlyfeatured=" + onlyfeatured,
				success: function(result) {
					var list = eval(result);
					var curr = 0;

					if (!list) {
						setMessage("<?php _e( 'No attachments found.', 'ajax-thumbnail-rebuild' ) ?>");
						jQuery("#ajax_thumbnail_rebuild").prop("disabled", false);
						return;
					}

					function regenItem(throttling) {

						if (curr >= list.length) {
							jQuery("#ajax_thumbnail_rebuild").prop("disabled", false);
							setMessage("<?php _e('Done.', 'ajax-thumbnail-rebuild') ?>");
							return;
						}

						setMessage( '<?php printf( __( 'Rebuilding %s of %s (%s)...', 'ajax-thumbnail-rebuild' ), "' + (curr + 1) + '", "' + list.length + '", "' + list[curr].title + '" ); ?>' );

						jQuery.ajax({
							url: "<?php echo admin_url('admin-ajax.php'); ?>",
							type: "POST",
							data: "action=ajax_thumbnail_rebuild&do=regen&id=" + list[curr].id + thumbnails,
							success: function(result) {
								curr = curr + 1;
								if (result != '-1') {
									jQuery("#thumb").show();
									jQuery("#thumb-img").attr("src",result);
								}
								setTimeout(function() {
									regenItem(throttling);
								}, throttling * 1000);
							},
							error: function(request, status, error) {
								if ((request.status == 503 && 60 <= throttling) || (20 <= throttling)) {
									console.log('ajax-thumbnail-rebuild gave up on "' + curr + '" after too many errors!');
									// skip this image (most likely malformed or oom_reaper)
									curr = curr + 1;
									throttling = Math.round(throttling / 2);
								} else {
									throttling = throttling + 1;
								}
								setTimeout(function() {
									regenItem(throttling);
								}, throttling * 1000);
							}
						});
					}

					regenItem(0);
				},
				error: function(request, status, error) {
					setMessage("<?php _e( 'Error', 'ajax-thumbnail-rebuild' ) ?>" + request.status);
				}
			});
		}

		jQuery(document).ready(function() {
			jQuery('#size-toggle').click(function() {
				jQuery("#sizeselect").find("input[type=checkbox]").each(function() {
					jQuery(this).prop("checked", !jQuery(this).prop("checked"));
				});
			});
		});

		// ]]>
		</script>

		<form method="post" action="" style="display:inline; float:left; padding-right:30px;">
			<h4><?php _e( 'Select which thumbnails you want to rebuild', 'ajax-thumbnail-rebuild' ); ?>:</h4>
			<a href="javascript:void(0);" id="size-toggle"><?php _e( 'Toggle all', 'ajax-thumbnail-rebuild' ); ?></a>

			<ul id="sizeselect">

				<?php foreach ( ajax_thumbnail_rebuild_get_sizes() as $image_size ) : ?>

				<li>

					<label>
						<input type="checkbox" name="thumbnails[]" id="sizeselect" checked="checked" value="<?php echo $image_size['name'] ?>" />
						<?php
						$crop_setting = '';

						if( $image_size['crop'] ) {
							if( is_array( $image_size['crop'] ) ) {
								$crop_setting = sprintf( '%s, %s', $image_size['crop'][0], $image_size['crop']['1'] );
							}
							else {
								$crop_setting = ' ' . __( 'cropped', 'ajax-thumbnail-rebuild' );
							}
						}

						printf( '<em>%s</em> (%sx%s%s)', $image_size['name'], $image_size['width'], $image_size['height'], $crop_setting );
						?>
					</label>

				</li>

				<?php endforeach; ?>

			</ul>

			<p>
				<label>
					<input type="checkbox" id="onlyfeatured" name="onlyfeatured" />
					<?php _e( 'Only rebuild featured images', 'ajax-thumbnail-rebuild' ); ?>
				</label>
			</p>

			<p><?php _e( 'Note: If you\'ve changed the dimensions of your thumbnails, existing thumbnail images will not be deleted.',
			'ajax-thumbnail-rebuild' ); ?></p>

			<input type="button" onClick="javascript:regenerate();" class="button" name="ajax_thumbnail_rebuild" id="ajax_thumbnail_rebuild" value="<?php _e( 'Rebuild All Thumbnails', 'ajax-thumbnail-rebuild' ) ?>" />
			<br />
		</form>

		<div id="thumb" style="display:none;"><h4><?php _e( 'Last image', 'ajax-thumbnail-rebuild' ); ?>:</h4><img id="thumb-img" /></div>

		<p style="clear:both; padding-top:2em;">
			<?php printf( __( 'If you find this plugin useful, I\'d be happy to read your comments on the %splugin homepage%s. If you experience any problems, feel free to leave a comment too.', 'ajax-thumbnail-rebuild' ), '<a href="https://wordpress.org/plugins/ajax-thumbnail-rebuild/" target="_blank">', '</a>'); ?>
		</p>
		<?php
	}

};

function ajax_thumbnail_rebuild_ajax() {
	global $wpdb;

	$action = $_POST["do"];
	$thumbnails = isset( $_POST['thumbnails'] )? $_POST['thumbnails'] : NULL;
	$onlyfeatured = isset( $_POST['onlyfeatured'] ) ? $_POST['onlyfeatured'] : 0;

	if ($action == "getlist") {
		$res = array();

		if ( $onlyfeatured ) {
			/* Get all featured images */
			$featured_images = $wpdb->get_results( "SELECT meta_value, {$wpdb->posts}.post_title AS title FROM {$wpdb->postmeta}, {$wpdb->posts} WHERE meta_key = '_thumbnail_id' AND {$wpdb->postmeta}.post_id={$wpdb->posts}.ID ORDER BY post_date DESC");

			foreach( $featured_images as $image ) {
				$res[] = array(
					'id'    => $image->meta_value,
					'title' => $image->title
				);
			}
		}
		else {
			$attachments = get_children( array(
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'numberposts'    => -1,
				'post_status'    => null,
				'post_parent'    => null, // any parent
				'output'         => 'object',
				'orderby'        => 'post_date',
				'order'          => 'desc'
			) );

			foreach ( $attachments as $attachment ) {
				$res[] = array(
					'id'    => $attachment->ID,
					'title' => $attachment->post_title
				);
			}
		}

		die( json_encode( $res ) );
	}
	else if ($action == "regen") {
		$id = $_POST["id"];

		$fullsizepath = get_attached_file( $id );

		if ( FALSE !== $fullsizepath && @file_exists( $fullsizepath ) ) {
			set_time_limit( 30 );
			wp_update_attachment_metadata( $id, wp_generate_attachment_metadata_custom( $id, $fullsizepath, $thumbnails ) );

			die( wp_get_attachment_thumb_url( $id ));
		}

		die( '-1' );
	}
}
add_action( 'wp_ajax_ajax_thumbnail_rebuild', 'ajax_thumbnail_rebuild_ajax' );

add_action( 'plugins_loaded', function() {
	global $ajax_thumbnail_rebuild;

	$ajax_thumbnail_rebuild = new AjaxThumbnailRebuild();
});

function ajax_thumbnail_rebuild_get_sizes() {
	global $_wp_additional_image_sizes;

	foreach ( get_intermediate_image_sizes() as $s ) {
		$sizes[$s] = array(
			'name'   => '',
			'width'  => '',
			'height' => '',
			'crop'   => FALSE
		);

		/* Read theme added sizes or fall back to default sizes set in options... */

		$sizes[$s]['name'] = $s;

		if ( isset( $_wp_additional_image_sizes[$s]['width'] ) ) {
			$sizes[$s]['width'] = intval( $_wp_additional_image_sizes[$s]['width'] );
		}
		else {
			$sizes[$s]['width'] = get_option( "{$s}_size_w" );
		}

		if ( isset( $_wp_additional_image_sizes[$s]['height'] ) ) {
			$sizes[$s]['height'] = intval( $_wp_additional_image_sizes[$s]['height'] );
		}
		else {
			$sizes[$s]['height'] = get_option( "{$s}_size_h" );
		}

		if ( isset( $_wp_additional_image_sizes[$s]['crop'] ) ) {
			if( ! is_array( $sizes[$s]['crop'] ) ) {
				$sizes[$s]['crop'] = intval( $_wp_additional_image_sizes[$s]['crop'] );
			}
			else {
				$sizes[$s]['crop'] = $_wp_additional_image_sizes[$s]['crop'];
			}
		}
		else {
			$sizes[$s]['crop'] = get_option( "{$s}_crop" );
		}
	}

	$sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );

	return $sizes;
}

/**
 * Generate post thumbnail attachment meta data.
 *
 * @since 2.1.0
 *
 * @param int $attachment_id Attachment Id to process.
 * @param string $file Filepath of the Attached image.
 * @return mixed Metadata for attachment.
 */
function wp_generate_attachment_metadata_custom( $attachment_id, $file, $thumbnails = NULL ) {
	$attachment = get_post( $attachment_id );

	$metadata = array();
	if ( preg_match( '!^image/!', get_post_mime_type( $attachment ) ) && file_is_displayable_image( $file ) ) {
		$imagesize = getimagesize( $file );
		$metadata['width'] = $imagesize[0];
		$metadata['height'] = $imagesize[1];
		list($uwidth, $uheight) = wp_constrain_dimensions($metadata['width'], $metadata['height'], 128, 96);
		$metadata['hwstring_small'] = sprintf( "height='%s' width='%s'", $uheight, $uwidth );

		// Make the file path relative to the upload dir
		$metadata['file'] = _wp_relative_upload_path( $file );

		$sizes = ajax_thumbnail_rebuild_get_sizes();

		foreach ( $sizes as $size => $size_data ) {
			if( isset( $thumbnails ) && ! in_array( $size, $thumbnails ) ) {
				$intermediate_size = image_get_intermediate_size( $attachment_id, $size_data['name'] );
			}
			else {
				$intermediate_size = image_make_intermediate_size( $file, $size_data['width'], $size_data['height'], $size_data['crop'] );
			}

			if ( $intermediate_size ) {
				$metadata['sizes'][$size] = $intermediate_size;
			}
		}

		// fetch additional metadata from exif/iptc
		$image_meta = wp_read_image_metadata( $file );

		if ( $image_meta ) {
			$metadata['image_meta'] = $image_meta;
		}
	}

	return apply_filters( 'wp_generate_attachment_metadata', $metadata, $attachment_id );
}

load_plugin_textdomain( 'ajax-thumbnail-rebuild', false, basename( dirname( __FILE__ ) ) . '/languages' );
