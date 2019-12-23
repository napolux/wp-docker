<?php

// Field validation
if (!function_exists('mplc_field')) {
	function mplc_field(&$field, $equals = null, $true = null, $false = '') {
		if (isset($field) && (($field == $equals) || is_null($equals))) echo (is_null($true)) ? $field : $true;
		else echo $false;
	}
}

// Landmark metabox
function mapplic_landmark_box($post, $param) {
	$data = json_decode($post->post_content, true);
	if (!is_array($data)) return;

	$categories = $data['categories'];

	// Pin types
	$pins = array(
		'yellow no-fill',
		'orange no-fill',
		'green no-fill',
		'blue no-fill',
		'purple no-fill',
		'circular',
		'pin-classic pin-label',
		'pin-marker pin-label',
		'pin-disk pin-label',
		'pin-ribbon pin-label',
		'pin-dot pin-label',
		'transparent pin-md pin-label',
		'circular pin-md pin-label',
		'circular pin-md pin-pulse pin-label'
	);
	$pins = apply_filters('mapplic_pins', $pins);
	?>

	<div id="landmark-settings">
		<div>
			<input type="button" class="delete-landmark button" value="<?php _e('Delete', 'mapplic'); ?>">
			<input type="button" class="save-landmark button button-primary right" value="<?php _e('Save', 'mapplic'); ?>">
		</div>
		<div class="clear"></div>
		<hr>

		<label><strong><?php _e('Title', 'mapplic'); ?>:</strong><input type="text" class="title-input input-text"></label>
		<label><strong><?php _e('ID (unique)', 'mapplic'); ?>:</strong><input type="text" class="id-input input-text"></label>
		<?php wp_editor('', 'descriptioninput', array('drag_drop_upload' => true)); ?>

		<?php do_action('mapplic_landmark_fields'); // Custom fields ?>

		<div class="landmark-geolocation">
			<p><strong><?php _e('Geolocation', 'mapplic'); ?></strong></p>
			<input type="text" class="landmark-lat input-text geopos-field" placeholder="Latitude">
			<input type="text" class="landmark-lng input-text geopos-field" placeholder="Longitude">
		</div>

		<p><strong><?php _e('Color and Pin Type', 'mapplic'); ?></strong></p>
		<div>
			<ul id="pins-input">
				<li><div class="mapplic-pin hidden" data-pin="hidden">pin</div></li>
				<li class="selected"><div class="mapplic-pin default" data-pin="no-fill">pin</div></li>
			<?php foreach ($pins as &$pin) : ?>
				<li><div class="mapplic-pin <?php echo $pin; ?>" data-pin="<?php echo $pin; ?>">m</div></li>
			<?php endforeach; ?>
			</ul>
		</div>
		<input type="text" class="label-input input-text" placeholder="<?php _e('Label', 'mapplic'); ?>">
		<input type="text" class="mapplic-color-picker fill-input" data-default-color="#343f4b">

		<p><strong><?php _e('Attributes', 'mapplic'); ?></strong></p>
		<label><?php _e('Link', 'mapplic'); ?>:<input type="text" class="link-input input-text"></label>

		<label><?php _e('Category', 'mapplic'); ?>
			<select class="category-select input-select">
				<option value="false" selected>None</option>
			<?php foreach ($categories as &$category) : ?>
				<option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
			<?php endforeach; ?>
			</select>
		</label>

		<div>
			<label><?php _e('Thumbnail', 'mapplic'); ?><br>
				<input type="text" class="input-text thumbnail-input buttoned" value="">
				<button class="button media-button"><span class="dashicons dashicons-upload"></span></button>
			</label>
		</div>

		<label><?php _e('Action', 'mapplic'); ?>

			<select class="action-select input-select">
				<option value="default" selected><?php _e('Default', 'mapplic'); ?></option>
				<?php 
					$landmark_actions = array(
						'tooltip' => __('Tooltip', 'mapplic'),
						'open-link' => __('Open link', 'mapplic'),
						'open-link-new-tab' => __('Open link in new tab', 'mapplic'),
						'lightbox' => __('Lightbox', 'mapplic'),
						'none' => __('None', 'mapplic')
					);
					foreach ($landmark_actions as $value => $action) : 
				?>
				<option value="<?php echo $value; ?>"<?php if ($data['action'] == $value) echo ' selected'; ?>><?php echo $action; ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<label><?php _e('About', 'mapplic'); ?>:<input type="text" class="about-input input-text" placeholder="Visible in sidebar"></label>

		<label><?php _e('Zoom Level', 'mapplic'); ?><input type="text" class="zoom-input input-text" placeholder="Auto"></label>

		<input type="button" class="duplicate-landmark button right" value="<?php _e('Duplicate', 'mapplic'); ?>">
	</div>

	<input type="button" id="new-landmark" class="button" value="<?php _e('Add New', 'mapplic'); ?>">
	
	<?php
	unset($pins);
	unset($category);
}

// Floors Metabox
function mapplic_floors_box($post, $param) {
	$data = json_decode($post->post_content, true);
	if (!is_array($data)) return;

	$floors = array_reverse($data['levels']);
	?>

	<ul id="floor-list" class="sortable-list">
		<li class="list-item new-item">
			<div class="list-item-handle">
				<span class="menu-item-title"><?php _e('New Floor', 'mapplic'); ?></span>
				<a href="#" class="menu-item-toggle"></a>
			</div>
			<div class="list-item-settings">
				<label>
					<?php _e('Name', 'mapplic'); ?><br><input type="text" class="input-text title-input" value="<?php _e('New Floor', 'mapplic'); ?>">
				</label>
				<label><?php _e('ID (unique)', 'mapplic'); ?><br><input type="text" class="input-text id-input" value=""></label>

				<div>
					<label><?php _e('Map', 'mapplic'); ?><br>
						<input type="text" class="input-text map-input buttoned" value="">
						<button class="button media-button"><span class="dashicons dashicons-upload"></span></button>
					</label>
				</div>

				<div>
					<label><?php _e('Minimap', 'mapplic'); ?><br>
						<input type="text" class="input-text minimap-input buttoned" value="">
						<button class="button media-button"><span class="dashicons dashicons-upload"></span></button>
					</label>
				</div>

				<div>
					<a href="#" class="item-delete"><?php _e('Delete'); ?></a>
					<span class="meta-sep"> | </span>
					<a href="#" class="item-cancel"><?php _e('Cancel'); ?></a>
				</div>
			</div>
		</li>
	
	<?php foreach ($floors as &$floor) : ?>

		<li class="list-item">
			<div class="list-item-handle">
				<span class="menu-item-title"><?php echo $floor['title']; ?></span>
				<a href="#" class="menu-item-toggle"></a>
			</div>
			<div class="list-item-settings">
				<label><?php _e('Name', 'mapplic'); ?><br><input type="text" class="input-text title-input" value="<?php echo $floor['title']; ?>"></label>
				<label><?php _e('ID (unique)', 'mapplic'); ?><br><input type="text" class="input-text id-input" value="<?php echo $floor['id']; ?>" disabled></label>

				<?php $shown = (isset($floor['show']) && ($floor['show'] == 'true')) ? 'checked' : ''; ?>
				<label>
					<input type="radio" name="shown-floor" class="show-input" <?php echo $shown; ?> value="<?php echo $floor['id']; ?>"> <?php _e('Show by default', 'mapplic'); ?>
				</label>

				<div>
					<label><?php _e('Map', 'mapplic'); ?><br>
						<input type="text" class="input-text map-input buttoned" value="<?php echo $floor['map']; ?>">
						<button class="button media-button"><span class="dashicons dashicons-upload"></span></button>
					</label>
				</div>

				<div>
					<label>Minimap<br>
						<input type="text" class="input-text minimap-input buttoned" value="<?php echo $floor['minimap']; ?>">
						<button class="button media-button"><span class="dashicons dashicons-upload"></span></button>
					</label>
				</div>

				<div>
					<a href="#" class="item-delete"><?php _e('Delete'); ?></a>
					<span class="meta-sep"> | </span>
					<a href="#" class="item-cancel"><?php _e('Cancel'); ?></a>
				</div>
			</div>
		</li>

	<?php endforeach; ?>
	</ul>
	<input type="button" id="new-floor" class="button" value="<?php _e('New Floor', 'mapplic'); ?>">
	<input type="submit" name="submit" class="button button-primary form-submit right" value="<?php _e('Save', 'mapplic'); ?>">
	<div class="clear"></div>
	<?php
	unset($floor);
}

// Categories metabox
function mapplic_categories_box($post, $param) {
	$data = json_decode($post->post_content, true);
	if (!is_array($data)) return;
	?>
	<ul id="category-list" class="sortable-list">

		<li class="list-item new-item">
			<div class="list-item-handle">
				<span class="menu-item-title"><?php _e('New Category', 'mapplic'); ?></span>
				<a href="#" class="menu-item-toggle"></a>
			</div>
			<div class="list-item-settings">

				<label>
					<?php _e('Name', 'mapplic'); ?><br><input type="text" class="input-text title-input" value="<?php _e('New Category', 'mapplic'); ?>">
				</label>
				<label><?php _e('ID (unique)', 'mapplic'); ?><br><input type="text" class="input-text id-input" value=""></label>
				<label><input type="checkbox" class="expand-input" checked> <?php _e('Expand by default', 'mapplic'); ?></label>

				<div>
					<a href="#" class="item-delete"><?php _e('Delete'); ?></a>
					<span class="meta-sep"> | </span>
					<a href="#" class="item-cancel"><?php _e('Cancel'); ?></a>
				</div>
			</div>
		</li>

	<?php foreach ($data['categories'] as &$category) : ?>
		<li class="list-item">
			<div class="list-item-handle">
				<span class="menu-item-title"><?php echo $category['title']; ?></span>
				<a href="#" class="menu-item-toggle"></a>
			</div>
			<div class="list-item-settings">

				<label><?php _e('Name', 'mapplic'); ?><br><input type="text" class="input-text title-input" value="<?php echo $category['title']; ?>"></label>
				<label><?php _e('ID (unique)', 'mapplic'); ?><br><input type="text" class="input-text id-input" value="<?php echo $category['id']; ?>"></label>
				<?php $shown = (isset($category['show']) && ($category['show'] == 'false')) ? '' : 'checked'; ?>
				<label><input type="checkbox" class="expand-input" <?php echo $shown; ?>> <?php _e('Expand by default', 'mapplic'); ?></label>
				<input type="text" value="<?php echo $category['color']; ?>" class="mapplic-color-picker color-input" data-default-color="#666666">

				<div>
					<a href="#" class="item-delete"><?php _e('Delete'); ?></a>
					<span class="meta-sep"> | </span>
					<a href="#" class="item-cancel"><?php _e('Cancel'); ?></a>
				</div>
			</div>
		</li>
	<?php endforeach; ?>
	</ul>
	<input type="button" id="new-category" class="button" value="<?php _e('New Category', 'mapplic'); ?>">
	<input type="submit" name="submit" class="button button-primary form-submit right" value="<?php _e('Save', 'mapplic'); ?>">
	<div class="clear"></div>	
	<?php
	unset($category);
}

// Geoposition metabox
function mapplic_geoposition_box($post, $param) {
	$data = json_decode($post->post_content, true);
	if (!is_array($data)) return;
	?>
	<div id="geopos">
		<div class="geopos-corner tl"></div>
		<input type="text" class="geopos-field" id="topLat" placeholder="Top Latitude" value="<?php mplc_field($data['topLat']); ?>">
		<div class="geopos-corner tr"></div><br>
		<input type="text" class="geopos-field" id="leftLng" placeholder="Left Longitude" value="<?php mplc_field($data['leftLng']); ?>">
		<input type="text" class="geopos-field" id="rightLng" placeholder="Right Longitude" value="<?php mplc_field($data['rightLng']); ?>">
		<br><div class="geopos-corner bl"></div>
		<input type="text" class="geopos-field" id="bottomLat" placeholder="Bottom Latitude" value="<?php mplc_field($data['bottomLat']); ?>">
		<div class="geopos-corner br"></div>
	</div>
	<?php
}

// Settings metabox
function mapplic_settings_box($post, $param) {
	$data = json_decode($post->post_content, true);
	if (!is_array($data)) return;

	if (!is_numeric($data['mapwidth']) || !is_numeric($data['mapheight'])) :
	?>
		<div class="notice notice-error">
			<p><?php _e('Map file dimensions either not set or invalid!', 'mapplic'); ?></p>
		</div>
	<?php
	endif;

	?>
	<h4><?php _e('Map file Dimensions (REQUIRED)', 'mapplic'); ?></h4>
	<label>
		<?php _e('Map Width', 'mapplic'); ?><br>
		<input type="text" id="setting-mapwidth" value="<?php echo $data['mapwidth']; ?>" placeholder="<?php _e('REQUIRED', 'mapplic'); ?>"><span> px</span>
	</label>
	<label>
		<?php _e('Map Height', 'mapplic'); ?><br>
		<input type="text" id="setting-mapheight" value="<?php echo $data['mapheight']; ?>" placeholder="<?php _e('REQUIRED', 'mapplic'); ?>"><span> px</span>
	</label>

	<!-- Components -->
	<h4><?php _e('Features', 'mapplic'); ?></h4>
	<label>
		<input type="checkbox" id="setting-minimap"<?php mplc_field($data['minimap'], 'true', ' checked', ''); ?>> <?php _e('Minimap', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-clearbutton"<?php mplc_field($data['clearbutton'], 'true', ' checked', ''); ?>> <?php _e('Clear button', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-zoombuttons"<?php mplc_field($data['zoombuttons'], 'true', ' checked', ''); ?>> <?php _e('Zoom buttons', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-hovertip"<?php mplc_field($data['hovertip'], 'true', ' checked', ''); ?>> <?php _e('Hover Tooltip', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-fullscreen"<?php mplc_field($data['fullscreen'], 'true', ' checked', ''); ?>> <?php _e('Fullscreen', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-deeplinking"<?php mplc_field($data['deeplinking'], 'true', ' checked', ''); ?>> <?php _e('Deeplinking', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-zoomoutclose"<?php mplc_field($data['zoomoutclose'], 'true', ' checked', ''); ?>> <?php _e('Zoom out on closing popup', 'mapplic'); ?>
	</label>

	<!-- Sidebar -->
	<h4><?php _e('Sidebar', 'mapplic'); ?></h4>
	<label>
		<input type="checkbox" id="setting-sidebar"<?php mplc_field($data['sidebar'], 'true', ' checked', ''); ?>> <?php _e('Sidebar', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-alphabetic"<?php mplc_field($data['alphabetic'], 'true', ' checked', ''); ?>> <?php _e('Alphabetically ordered', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-search"<?php mplc_field($data['search'], 'true', ' checked', ''); ?>> <?php _e('Search', 'mapplic'); ?>
	</label>

	<!-- General -->
	<h4><?php _e('General Settings', 'mapplic'); ?></h4>
	<label>
		<input type="checkbox" id="setting-zoom"<?php mplc_field($data['zoom'], false, '', ' checked'); ?>> <?php _e('Enable zoom', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-mousewheel"<?php mplc_field($data['mousewheel'], 'true', ' checked', ''); ?>> <?php _e('Mouse wheel', 'mapplic'); ?>
	</label>
	<label>
		<input type="checkbox" id="setting-mapfill"<?php mplc_field($data['mapfill'], 'true', ' checked', ''); ?>> <?php _e('Map fills the container', 'mapplic'); ?>
	</label>
	<label>
		<?php _e('Zoom Limit', 'mapplic'); ?><br>
		<input type="text" id="setting-zoomlimit" value="<?php echo $data['zoomlimit']; ?>" placeholder="<?php _e('No zoom', 'mapplic'); ?>">
	</label>
	<label><?php _e('Default Action', 'mapplic'); ?><br>
		<select id="setting-action">
			<?php
				$landmark_actions = array(
					'tooltip' => __('Tooltip', 'mapplic'),
					'open-link' => __('Open link', 'mapplic'),
					'open-link-new-tab' => __('Open link in new tab', 'mapplic'),
					'lightbox' => __('Lightbox', 'mapplic'),
					'none' => __('None', 'mapplic')
				);
				foreach ($landmark_actions as $value => $action) : 
			?>
			<option value="<?php echo $value; ?>"<?php if ($data['action'] == $value) echo ' selected'; ?>><?php echo $action; ?></option>
			<?php endforeach; ?>
		</select>
	</label>
	<label>
		<?php _e('Default Fill Color', 'mapplic'); ?><br>
		<input type="text" id="setting-fillcolor" class="mapplic-color-picker" data-default-color="#343f4b" value="<?php mplc_field($data['fillcolor']); ?>">
	</label>
	<?php
}