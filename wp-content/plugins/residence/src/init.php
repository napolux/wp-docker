<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function residence_cgb_block_assets() { // phpcs:ignore
	// Register block styles for both frontend + backend.
	wp_register_style(
		'residence-cgb-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		array( 'wp-editor' ), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
	);

	// Register block editor script for backend.
	wp_register_script(
		'residence-cgb-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
		null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	// Register block editor styles for backend.
	wp_register_style(
		'residence-cgb-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);

	// WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
	wp_localize_script(
		'residence-cgb-block-js',
		'cgbGlobal', // Array containing dynamic data for a JS Global.
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			// Add more data here that you want to access from `cgbGlobal` object.
		]
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'cgb/block-residence', array(
			// Enqueue blocks.style.build.css on both frontend & backend.
			'style'         => 'residence-cgb-style-css',
			// Enqueue blocks.build.js in the editor only.
			'editor_script' => 'residence-cgb-block-js',
			// Enqueue blocks.editor.build.css in the editor only.
			'editor_style'  => 'residence-cgb-block-editor-css',
			'attributes' => array(
                'floor' => array(
                    'type' => 'string',
                ),
                'class' => array(
                    'type' => 'string',
                ),
            ),
			'render_callback' => 'block_dynamic_render_cb', // The render callback
		)
	);
}

// Hook: Block assets.
add_action( 'init', 'residence_cgb_block_assets' );

function block_dynamic_render_cb ( $att ) {

	if(!empty($att['post_Id'])){
		$postId = $att['post_Id'];
	} else {
		$postId = '0';
	}

	if(!empty($att['post_Id'])){
		$url = get_permalink( $postId );

	} else {
		$url = '0';
	}

	if(!empty($att['post_Id'])){
		$thumb = get_the_post_thumbnail( $postId );
	} else {
		$thumb = wp_get_attachment_image( 11, array('232', '264'), "", array( "class" => "img-responsive" ) );
	}

	if(!empty($att['residence'])){
		$residence = $att['residence'];
	} else {
		$residence = '0';
	}

	if(!empty($att['floor'])){
		$floor = $att['floor'];
	} else {
		$floor = '0';
	}

	if(!empty($att['bedrooms'])){
		$bedrooms = $att['bedrooms'];
	} else {
		$bedrooms = '0';
	}

	if(!empty($att['bathrooms'])){
		$bathrooms = $att['bathrooms'];
	} else {
		$bathrooms = '0';
	}

	if(!empty($att['sizeSF'])){
		$sizeSF = $att['sizeSF'];
	} else {
		$sizeSF = '0';
	}


	if(!empty($att['sizeM'])){
		$sizeM = $att['sizeM'];
	} else {
		$sizeM = '0';
	}

	if(!empty($att['extArea'])){
		$extArea = $att['extArea'];
	} else {
		$extArea = '0';
	}

	if(!empty($att['comCharges'])){
		$comCharges = $att['comCharges'];
	} else {
		$comCharges = '0';
	}

	if(!empty($att['exposure'])){
		$exposure = $att['exposure'];
	} else {
		$exposure = '0';
	}

	if(!empty($att['price'])){
		$price = $att['price'];
	} else {
		$price = '0';
	}
	$html .=	'<tr class="single-residence">';
	$html .=        '<td class="thumbnail"><a href="' . $url . '">' .$thumb .'</a></td>';
	$html .=        '<td class="residence">';
	$html .=		'<span class="card__residence"><a href="' . $url . '">' . $residence .'</a></span>';
	$html .=		'</td>';
	$html .=        '<td>';
	$html .=		' <span class="card__floor">' . $floor. ' </span>';
	$html .=		'</td>';
	$html .=		'<td>';
	$html .=		'<span class="card__bedrooms">' . $bedrooms . ' </span>';
	$html .=		'</td>';
	$html .=		'<td>';
	$html .=		'<span class="card__bathrooms">' . $bathrooms . ' </span>';
	$html .=		'</td>';
	$html .=			'<td>';
	$html .=			'<span class="card__sizeSF">' . $sizeSF . '</span>';
	$html .=			'<span class="card__sizeM">' . $sizeM . ' </span>';
	$html .=		'</td>';
	$html .=		'<td>';
	$html .=			'<span class="card__extArea">' . $extArea . '</span>';
	$html .=		'</td>';
	$html .=		'<td >';
	$html .=			'<span class="card__ComCharges">' . $comCharges . '</span></td>';
	$html .=		'<td>';
	$html .=			'<span class="card__exposure">' . $exposure . '</span>';
	$html .=		'</td>';
	$html .=		'<td class="hide_on_table" >';
	$html .=			'<span>Price: </span>$';
	$html .=			'<span class="card__price">' . $price . '</span></td>';
	$html .= '<td class="fav-cell"><div class="fav-button" data-post-id=' . $postId .'>0</div></td>';
	$html .=		'</tr>';


	return $html;
}