<?php
/**
 * Plugin Name: Mapplic
 * Plugin URI: http://www.mapplic.com/
 * Description: Mapplic is the #1 custom map WordPress plugin on the web. Turn simple images and vector graphics into high quality, responsive and fully interactive maps.
 * Version: 4.1
 * Author: sekler
 * Author URI: http://www.codecanyon.net/user/sekler?ref=sekler
 */

if (!class_exists('Mapplic')) :

class Mapplic {
	public static $version = '4.1';
	public $admin;

	public function __construct() {
		// Actions
		add_action('init', array($this, 'localize'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));

		// Create shortcode
		add_shortcode('mapplic', array($this, 'shortcode'));

		// Admin
		if (is_admin()) {
			include('admin/admin.php');
			$this->admin = new MapplicAdmin();
			register_activation_hook(__FILE__, array('MapplicAdmin', 'activation')); // activation
		}
	}

	public function enqueue_scripts_styles() {
		// Styles
		wp_register_style('mapplic-style', plugins_url('css/mapplic.css', __FILE__), false, Mapplic::$version);
		wp_register_style('magnific-popup', plugins_url('css/magnific-popup.css', __FILE__), false, null);
		wp_register_style('mapplic-map-style', plugins_url('css/map.css', __FILE__), array('mapplic-style', 'magnific-popup'), null);

		// Scripts
		wp_register_script('hammer', plugins_url('js/hammer.min.js', __FILE__), false, null);
		wp_register_script('mousewheel', plugins_url('js/jquery.mousewheel.js', __FILE__), false, null);
		wp_register_script('magnific-popup', plugins_url('js/magnific-popup.js', __FILE__), false, null);
		wp_register_script('mapplic-script', plugins_url('js/mapplic.js', __FILE__), array('jquery', 'hammer', 'mousewheel', 'magnific-popup'), Mapplic::$version);
		$mapplic_localization = array(
			'more' => __('More', 'mapplic'),
			'search' => __('Search', 'mapplic'),
			'not_found' => __('Nothing found. Please try a different search.', 'mapplic')
		);
		wp_localize_script('mapplic-script', 'mapplic_localization', $mapplic_localization);
	}

	public function localize() {
		load_plugin_textdomain('mapplic', false, dirname(plugin_basename(__FILE__)) . '/languages');
	}

	public function shortcode($atts) {
		extract(shortcode_atts(array(
			'id' => false,
			'h' => false,
			'class' => false, 
			'landmark' => false,
			'shortcode' => false
		), $atts, 'mapplic'));

		$post = get_post($id);
		if (!$post || !$id) return __('Error: map with the specified ID doesn\'t exist!', 'mapplic');

		$data = $post->post_content;

		// Shortcode support
		if ($shortcode) {
			$data = json_decode($post->post_content);
			foreach ($data->levels as $level) {
				foreach($level->locations as $location) {
					if (isset($location->description)) $location->description = do_shortcode($location->description);
				}
			}
			$data = apply_filters('mapplic_data', $data, $id);
			$data = json_encode($data);
		}
		// Shortcode support ends
		
		$output = '<div id="mapplic-id' . $id . '" data-mapdata="' . htmlentities($data, ENT_QUOTES, 'UTF-8') . '"';
		if ($class) $output .= ' class="' . $class . '"';
		if ($landmark) $output .= ' data-landmark="' . $landmark . '"';
		if ($h) $output .= ' data-height="' . $h . '"';
		$output .= '></div>';

		wp_enqueue_style('mapplic-map-style');
		wp_enqueue_script('mapplic-script');
		do_action('mapplic_enqueue');

		return $output;
	}
}

endif;

function mapplic() {
	global $mapplic;
	if (!isset($mapplic)) $mapplic = new Mapplic();
	return $mapplic;
}
mapplic();