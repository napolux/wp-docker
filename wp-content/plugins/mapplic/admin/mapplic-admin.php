<?php

// Metaboxes
$screen = get_current_screen();

add_action('admin_footer-' . $screen->id, 'mapplic_footer_scripts');

function mapplic_footer_scripts() {
	?>
	<script>
		postboxes.add_postbox_toggles(pagenow);
	</script>
	<?php
}

// Floors metabox callback
function mapplic_floors_metabox($post, $param) {
	$floors = array_reverse($param['args']['levels']);
	?>

	<ul id="floor-list" class="sortable-list">
		<li class="list-item new-item">
			<div class="list-item-handle">
				<span class="menu-item-title"><?php _e('New floor', 'mapplic'); ?></span>
				<a href="#" class="menu-item-toggle"></a>
			</div>
			<div class="list-item-settings">

				<label><?php _e('Name', 'mapplic'); ?><br><input type="text" class="input-text title-input" value="New floor"></label>
				<label><?php _e('ID (unique)', 'mapplic'); ?><br><input type="text" class="input-text id-input" value=""></label>
				<div>
					<label><?php _e('Map', 'mapplic'); ?><br>
						<input type="text" class="input-text map-input" value="">
					</label>
					<input type="button" class="button media-button" value="<?php _e('Add Map', 'mapplic'); ?>">
					<br><br>
				</div>
				<div>
					<label><?php _e('Minimap', 'mapplic'); ?><br>
						<input type="text" class="input-text minimap-input" value="">
					</label>
					<input type="button" class="button media-button" value="<?php _e('Add Minimap', 'mapplic'); ?>">
					<br><br>
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
				<?php $shown = ($floor['show'] == 'true') ? 'checked' : ''; ?>
				<label><input type="radio" name="shown-floor" class="show-input" <?php echo $shown; ?> value="<?php echo $floor['id']; ?>"> <?php _e('Show by default', 'mapplic'); ?></label>
				<div>
					<label><?php _e('Map', 'mapplic'); ?><br>
						<input type="text" class="input-text map-input" value="<?php echo $floor['map']; ?>">
					</label>
					<input type="button" class="button media-button" value="<?php _e('Add Map', 'mapplic'); ?>">
					<br><br>
				</div>
				<div>
					<label>Minimap<br>
						<input type="text" class="input-text minimap-input" value="<?php echo $floor['minimap']; ?>">
					</label>
					<input type="button" class="button media-button" value="<?php _e('Add Minimap', 'mapplic'); ?>">
					<br><br>
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

// Categories metabox callback
function mapplic_categories_metabox($post, $param) {
	$categories = $param['args']['categories'];
	?>
	<ul id="category-list" class="sortable-list">

		<li class="list-item new-item">
			<div class="list-item-handle">
				<span class="menu-item-title"><?php _e('New category', 'mapplic'); ?></span>
				<a href="#" class="menu-item-toggle"></a>
			</div>
			<div class="list-item-settings">

				<label><?php _e('Name', 'mapplic'); ?><br><input type="text" class="input-text title-input" value="New category"></label>
				<label><?php _e('ID (unique)', 'mapplic'); ?><br><input type="text" class="input-text id-input" value=""></label>
				<label><input type="checkbox" class="expand-input" checked> <?php _e('Expand by default', 'mapplic'); ?></label>
				<input type="text" value="#666666" class="color-picker color-input" data-default-color="#666666">

				<div>
					<a href="#" class="item-delete"><?php _e('Delete'); ?></a>
					<span class="meta-sep"> | </span>
					<a href="#" class="item-cancel"><?php _e('Cancel'); ?></a>
				</div>
			</div>
		</li>

	<?php foreach ($categories as &$category) : ?>
		<li class="list-item">
			<div class="list-item-handle">
				<span class="menu-item-title"><?php echo $category['title']; ?></span>
				<a href="#" class="menu-item-toggle"></a>
			</div>
			<div class="list-item-settings">

				<label><?php _e('Name', 'mapplic'); ?><br><input type="text" class="input-text title-input" value="<?php echo $category['title']; ?>"></label>
				<label><?php _e('ID (unique)', 'mapplic'); ?><br><input type="text" class="input-text id-input" value="<?php echo $category['id']; ?>"></label>
				<?php $shown = ($category['show'] == 'false') ? '' : 'checked'; ?>
				<label><input type="checkbox" class="expand-input" <?php echo $shown; ?>> <?php _e('Expand by default', 'mapplic'); ?></label>
				<input type="text" value="<?php echo $category['color']; ?>" class="color-picker color-input" data-default-color="#666666">

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

// Settings metabox callback
function mapplic_settings_metabox($post, $param) {
?>
	<h4><?php _e('Map file dimensions (REQUIRED)', 'mapplic'); ?></h4>
	<label class="in-line">
		<?php _e('Map Width', 'mapplic'); ?><br>
		<input type="text" id="setting-mapwidth" value="<?php echo $param['args']['mapwidth']; ?>" placeholder="REQUIRED">
	</label>
	<label class="in-line">
		<?php _e('Map Height', 'mapplic'); ?><br>
		<input type="text" id="setting-mapheight" value="<?php echo $param['args']['mapheight']; ?>" placeholder="REQUIRED">
	</label>

	<!-- Components -->
	<h4><?php _e('Components', 'mapplic'); ?></h4>
	<label>
		<input type="checkbox" id="setting-minimap"<?php echo ($param['args']['minimap'] == 'true') ? ' checked' : ''; ?>> <?php _e('Minimap', 'mapplic'); ?>
	</label><br>
	<label>
		<input type="checkbox" id="setting-zoombuttons"<?php echo ($param['args']['zoombuttons'] == 'true') ? ' checked' : ''; ?>> <?php _e('Zoom Buttons', 'mapplic'); ?>
	</label><br>
	<label>
		<input type="checkbox" id="setting-sidebar"<?php echo ($param['args']['sidebar'] == 'true') ? ' checked' : ''; ?>> <?php _e('Sidebar', 'mapplic'); ?>
	</label><br>
	<label>
		<input type="checkbox" id="setting-search"<?php echo ($param['args']['search'] == 'true') ? ' checked' : ''; ?>> <?php _e('Search', 'mapplic'); ?>
	</label><br>
	<label>
		<input type="checkbox" id="setting-hovertip"<?php echo ($param['args']['hovertip'] == 'true') ? ' checked' : ''; ?>> <?php _e('Hover Tooltip', 'mapplic'); ?>
	</label><br>
	<label>
		<input type="checkbox" id="setting-fullscreen"<?php echo ($param['args']['fullscreen'] == 'true') ? ' checked' : ''; ?>> <?php _e('Fullscreen', 'mapplic'); ?>
	</label>

	<!-- General -->
	<h4><?php _e('General settings', 'mapplic'); ?></h4>
	<label>
		<?php _e('Zoom Limit', 'mapplic'); ?><br>
		<input type="text" id="setting-zoomlimit" value="<?php echo $param['args']['zoomlimit']; ?>">
	</label><br>
	<label>
		<input type="checkbox" id="setting-mapfill"<?php echo ($param['args']['mapfill'] == 'true') ? ' checked' : ''; ?>> <?php _e('Map fills the container', 'mapplic'); ?>
	</label><br>
	<label>
		<input type="checkbox" id="setting-zoom"<?php echo ($param['args']['zoom'] == false) ? '' : ' checked'; ?>> <?php _e('Enable zooming', 'mapplic'); ?>
	</label><br>
	<label>
		<input type="checkbox" id="setting-alphabetic"<?php echo ($param['args']['alphabetic'] == 'true') ? ' checked' : ''; ?>> <?php _e('Alphabetically ordered', 'mapplic'); ?>
	</label>
<?php
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'edit') {
	include('mapplic-edit.php');
}
else if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'new') {
	include('mapplic-new.php');
}
else {

// Load WP_List_Table class
if (!class_exists('WP_List_Table')) {
	require_once('class-wp-list-table.php');
}

class Map_List_Table extends WP_List_Table {

	function __construct() {
		parent::__construct(array(
			'singular'=> 'map',
			'plural' => 'maps',
			'ajax'	=> false
		));
	}

	function column_default($item, $column_name){
		switch($column_name){
			case 'title':
			case 'id':
				return $item[$column_name];
			case 'shortcode':
				$width = ($item['width'] != 0 ? sprintf(' w="%s"', $item['width']) : '');
				$height = ($item['height'] != 0 ? sprintf(' h="%s"', $item['height']) : '');

				return '[mapplic id="' . $item['id'] . '"' . $width . $height . ']';
			default:
				return print_r($item, true);
		}
	}

	function column_title($item){
		
		$actions = array(
			'edit'      => sprintf('<a href="?page=%s&action=%s&map=%s">%s</a>', $_REQUEST['page'], 'edit', $item['id'], __('Edit')),
			'delete'    => sprintf('<a href="?page=%s&action=%s&map=%s">%s</a>', $_REQUEST['page'], 'delete', $item['id'], __('Delete')),
		);
		
		//Return the title contents
		return sprintf('<a href="?page=%1$s&action=edit&map=%2$s" class="row-title">%3$s</a> %4$s',
			/*$1%s*/ $_REQUEST['page'],
			/*$2%s*/ $item['id'],
			/*$3%s*/ $item['title'],
			/*$4%s*/ $this->row_actions($actions)
		);
	}

	function column_cb($item) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s">',
			/*$1%s*/ $this->_args['singular'],
			/*$2%s*/ $item['id']
		);
	}

	function get_columns() {
		$columns = array(
			'cb'        => '<input type="checkbox">',
			'title'     => __('Title'),
			'id'        => __('Id'),
			'shortcode' => __('Shortcode')
		);
		return $columns;
	}

	// Bulk actions
	function process_bulk_action() {
		if (isset($_REQUEST['map'])) $target = $_REQUEST['map'];

		if ('delete' === $this->current_action()) {
			global $wpdb;

			if (is_array($target)) { }

			$table = $wpdb->prefix . 'custommaps';
			$wpdb->query("UPDATE $table 
				SET status = 0
				WHERE id = $target"
			);


			$count = sprintf(_n('1 map', '%s maps', count($target)), count($target));
			echo sprintf('<div class="updated"><p>%1$s deleted! <a href="?page=%2$s&action=%3$s&map=%4$s">%5$s</a></p></div>',
				/*$1%s*/ $count,
				/*$2%s*/ $_REQUEST['page'],
				/*$3%s*/ 'undo',
				/*$4%s*/ $target,
				/*$5%s*/ __('Undo')
			);
		}

		if ('undo' === $this->current_action()) {
			global $wpdb;

			$table = $wpdb->prefix . 'custommaps';
			$wpdb->query("UPDATE $table 
				SET status = 1
				WHERE ID = $target"
			);

			$count = sprintf(_n('1 map', '%s maps', count($target)), count($target));
			echo sprintf('<div class="updated"><p>%1$s restored.</p></div>', $count);
		}
	}

	function prepare_items() {
		global $wpdb;

		$per_page = 6;
		
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		
		$this->_column_headers = array($columns, $hidden, $sortable);
		
		/**
		 * Optional. You can handle your bulk actions however you see fit. In this
		 * case, we'll handle them within our package just to keep things clean.
		 */
		$this->process_bulk_action();
		
		// Database Query
		$table_name = $wpdb->prefix . 'custommaps';

		$query = "SELECT * FROM $table_name WHERE status > 0";

		//Parameters that are going to be used to order the result
		$orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';
		$order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
		if (!empty($orderby) & !empty($order)) { $query .= ' ORDER BY ' . $orderby . ' ' . $order; }

		// Number of elements
		$total_items = $wpdb->query($query);

		// Page number
		$paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';

		//Page Number
		if (empty($paged) || !is_numeric($paged) || $paged <= 0) { $paged = 1; }

		//adjust the query to take pagination into account
		if (!empty($paged) && !empty($per_page)) {
			$offset = ($paged - 1) * $per_page;
			$query .= ' LIMIT ' . (int)$offset . ', ' . (int)$per_page;
		}
		
		// Register pagination
		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ceil($total_items/$per_page)
		));

		// Add items
		$this->items = $wpdb->get_results($query, 'ARRAY_A');
	}
}

$map_list_table = new Map_List_Table();
$map_list_table->prepare_items();

?>
<div class="wrap">

	<h2><?php _e('Custom Interactive Maps', 'mapplic'); ?> <a href="?page=<?php echo $_REQUEST['page']; ?>&amp;action=new" class="add-new-h2"><?php _e('Add New'); ?></a></h2>
	
	<form id="maps-filter" method="get">

		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
	
		<?php $map_list_table->display() ?>
	
	</form>
	
</div>

<?php 
}
?>