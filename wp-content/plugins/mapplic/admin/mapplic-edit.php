<?php

$id = $_REQUEST['map'];

global $wpdb;
$table = $wpdb->prefix . 'custommaps';

// SUBMIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$title = $_REQUEST['map-title'];
	$data = $_REQUEST['data'];
	$width = $_REQUEST['map-width'];
	$height = $_REQUEST['map-height'];

	$wpdb->query("UPDATE $table
		SET title = '$title',
			data = '$data',
			width = $width,
			height = $height
		WHERE id = $id"
	);
}

$map = $wpdb->get_row("SELECT * FROM $table WHERE id = $id", 'ARRAY_A');
$data = json_decode($map['data'], true);

if (count($data['levels']) > 0) {
	add_meta_box('landmark', __('Landmark', 'mapplic'), 'mapplic_landmark_metabox','toplevel_page_mapplic_menu', 'side', 'core', $data);
}
add_meta_box('floors', __('Floors', 'mapplic'), 'mapplic_floors_metabox', 'toplevel_page_mapplic_menu', 'side', 'core', $data);
add_meta_box('categories', __('Categories', 'mapplic'), 'mapplic_categories_metabox', 'toplevel_page_mapplic_menu', 'side', 'core', $data);
add_meta_box('settings', __('Settings', 'mapplic'), 'mapplic_settings_metabox', 'toplevel_page_mapplic_menu', 'normal', 'core', $data);

// Landmark metabox callback
function mapplic_landmark_metabox($post, $param) {
	$categories = $param['args']['categories'];
	$pins = array('yellow', 'orange', 'green', 'blue', 'purple', 'circular', 'transparent');
	?>

	<p>
	<input type="button" id="new-landmark" class="button" value="<?php _e('Add New', 'mapplic'); ?>">
	</p>

	<div id="landmark-settings">
		<hr>
		<label><?php _e('Title', 'mapplic'); ?>:<input type="text" class="title-input input-text"></label>

		<label><?php _e('ID (unique)', 'mapplic'); ?>:<input type="text" class="id-input input-text"></label>

		<?php $settings = array('drag_drop_upload' => true); ?>
		<?php wp_editor('', 'descriptioninput', $settings); ?>
		
		<label><?php _e('Pin', 'mapplic'); ?></label>
		<div>
			<div id="pins-input">
				<div class="mapplic-pin hidden" data-pin="hidden"></div>
				<div class="mapplic-pin default selected" data-pin=""></div>
			<?php foreach ($pins as &$pin) : ?>
				<div class="mapplic-pin <?php echo $pin; ?>" data-pin="<?php echo $pin; ?>"></div>
			<?php endforeach; ?>
			</div>
		</div>

		<input type="text" class="color-picker fill-input" data-default-color="#343f4b">

		<label><?php _e('Link', 'mapplic'); ?>:<input type="text" class="link-input input-text"></label>

		<label><?php _e('Category', 'mapplic'); ?>
			<select class="category-select input-select">
				<option value="false" selected>None</option>
			<?php foreach ($categories as &$category) : ?>
				<option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
			<?php endforeach; ?>
			</select>
		</label>

		<label><?php _e('Action', 'mapplic'); ?>
			<select class="action-select input-select">
				<option value="tooltip" selected>Tooltip (Default)</option>
				<option value="none">None</option>
				<option value="open-link">Open link</option>
				<option value="open-link-new-tab">Open link in new tab</option>
			</select>
		</label>

		<label><?php _e('Zoom Level', 'mapplic'); ?><input type="text" class="zoom-input input-text" placeholder="Auto"></label>

		<div>
			<input type="button" id="delete-landmark" class="button" value="<?php _e('Delete', 'mapplic'); ?>">
			<input type="button" id="save-landmark" class="button button-primary right" value="<?php _e('Save', 'mapplic'); ?>">
		</div>
	</div>
	
	<?php
	unset($pins);
	unset($category);
}
?>

<div class="wrap">

	<h2><?php _e('Edit Custom Map', 'mapplic'); ?> <a href="?page=<?php echo $_REQUEST['page']; ?>&amp;action=new" class="add-new-h2"><?php _e('Add New'); ?></a></h2>
	
	<form id="mapplic-form" method="post">

		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
		<input type="hidden" name="action" value="edit">
		<input type="hidden" name="map" value="<?php echo $id; ?>">

		<input type="hidden" name="data" id="input-data">

		<?php
			wp_nonce_field($_REQUEST['page'] . '-nonce');
			wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
			wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
		?>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div id="titlediv">
						<input type="text" value="<?php echo $map['title']; ?>" name="map-title" id="title">
					</div>

					<?php if (count($data['levels']) > 0) : ?>
						<div id="admin-map"></div>
					<?php endif; ?>

					<h4><?php _e('Container dimensions', 'mapplic'); ?></h4>
					<p>Note: The shortcode is updated when these values are changed.</p>
					<label class="in-line">
						<?php _e('Width', 'mapplic'); ?><br>
						<input type="text" name="map-width" value="<?php echo $map['width']; ?>">
					</label>

					<label class="in-line">
						<?php _e('Height', 'mapplic'); ?><br>
						<input type="text" name="map-height" value="<?php echo $map['height']; ?>">
					</label>
				</div>
				
				<div id="postbox-container-1" class="postbox-container">
					<?php do_meta_boxes('','side',null); ?>
				</div>
				
				<div id="postbox-container-2" class="postbox-container">
					<?php do_meta_boxes('','normal',null); ?>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<p class="submit">
			<input type="submit" name="submit" class="button button-primary form-submit" value="<?php _e('Save Changes', 'mapplic') ?>">
		</p>
	</form>
</div>