<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/jetpack.php',                         // Load Jetpack compatibility file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker.
	'/woocommerce.php',                     // Load WooCommerce functions.
	'/editor.php',                          // Load Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
);

foreach ( $understrap_includes as $file ) {
	$filepath = locate_template( 'inc' . $file );
	if ( ! $filepath ) {
		trigger_error( sprintf( 'Error locating /inc%s for inclusion', $file ), E_USER_ERROR );
	}
	require_once $filepath;
}

function custom_post_type() {

    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'Apartments', 'Post Type General Name', 'flat-iron-house' ),
            'singular_name'       => _x( 'Apartment', 'Post Type Singular Name', 'flat-iron-house' ),
            'menu_name'           => __( 'Apartments', 'flat-iron-house' ),
            'parent_item_colon'   => __( 'Parent Apartment', 'flat-iron-house' ),
            'all_items'           => __( 'All Apartments', 'flat-iron-house' ),
            'view_item'           => __( 'View Apartment', 'flat-iron-house' ),
            'add_new_item'        => __( 'Add New Apartment', 'flat-iron-house' ),
            'add_new'             => __( 'Add New', 'flat-iron-house' ),
            'edit_item'           => __( 'Edit Apartment', 'flat-iron-house' ),
            'update_item'         => __( 'Update Apartment', 'flat-iron-house' ),
            'search_items'        => __( 'Search Apartment', 'flat-iron-house' ),
            'not_found'           => __( 'Not Found', 'flat-iron-house' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'flat-iron-house' ),
        );

    // Set other options for Custom Post Type

        $args = array(
            'label'               => __( 'apartments', 'flat-iron-house' ),
            'description'         => __( 'Apartment', 'flat-iron-house' ),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
         //   'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            // You can associate this CPT with a taxonomy or custom taxonomy.
            'taxonomies'          => array( 'apartment' ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
            'show_in_rest' => true,
            'supports' => array('editor','title', 'thumbnail')
        );

        // Registering your Custom Post Type
        register_post_type( 'apartments', $args );

    }

    /* Hook into the 'init' action so that the function
    * Containing our post type registration is not
    * unnecessarily executed.
    */

    add_action( 'init', 'custom_post_type', 0 );

    function my_custom_scripts() {
        wp_enqueue_style('twentysixteen-style', get_stylesheet_directory_uri() . '/src/js/dataTables/datatables.min.css');
        wp_enqueue_script( 'datatables', get_stylesheet_directory_uri() . '/src/js/dataTables/datatables.min.js', array( 'jquery' ),'',true );

        wp_enqueue_style('slickcss', get_stylesheet_directory_uri() . '/src/js/slick/slick.css');
        wp_enqueue_script( 'slickjs', get_stylesheet_directory_uri() . '/src/js/slick/slick.min.js', array( 'jquery' ),'',true );

wp_enqueue_script( 'isotope', get_stylesheet_directory_uri() . '/src/js/isotope-docs.min.js', array( 'jquery' ) );
wp_enqueue_script( 'stories', get_stylesheet_directory_uri() . '/src/js/stories.js', array( 'jquery' ) );



     //   wp_enqueue_script( 'isotope', get_stylesheet_directory_uri() . '/src/js/isotope-docs.min.js', array( 'jquery' ),'',true );

    }
    add_action( 'wp_enqueue_scripts', 'my_custom_scripts' );

    function register_my_menus() {
        register_nav_menus(
        array(
         'additional-menu' => __( 'Right Menu' ),
         )
         );
        }
        add_action( 'init', 'register_my_menus' );

        add_image_size( 'story-size', 356, 230, true );


