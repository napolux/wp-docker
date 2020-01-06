<?php
/**
 * Add an option page
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_admin() ){ // admin actions
	add_action( 'admin_menu', 'duplicate_post_menu' );
	add_action( 'admin_init', 'duplicate_post_register_settings' );
}

function duplicate_post_register_settings() { // whitelist options
	register_setting( 'duplicate_post_group', 'duplicate_post_copytitle');
	register_setting( 'duplicate_post_group', 'duplicate_post_copydate');
	register_setting( 'duplicate_post_group', 'duplicate_post_copystatus');
	register_setting( 'duplicate_post_group', 'duplicate_post_copyslug');
	register_setting( 'duplicate_post_group', 'duplicate_post_copyexcerpt');
	register_setting( 'duplicate_post_group', 'duplicate_post_copycontent');
	register_setting( 'duplicate_post_group', 'duplicate_post_copythumbnail');
	register_setting( 'duplicate_post_group', 'duplicate_post_copytemplate');
	register_setting( 'duplicate_post_group', 'duplicate_post_copyformat');
	register_setting( 'duplicate_post_group', 'duplicate_post_copyauthor');
	register_setting( 'duplicate_post_group', 'duplicate_post_copypassword');
	register_setting( 'duplicate_post_group', 'duplicate_post_copyattachments');
	register_setting( 'duplicate_post_group', 'duplicate_post_copychildren');
	register_setting( 'duplicate_post_group', 'duplicate_post_copycomments');
	register_setting( 'duplicate_post_group', 'duplicate_post_copymenuorder');
	register_setting( 'duplicate_post_group', 'duplicate_post_blacklist');
	register_setting( 'duplicate_post_group', 'duplicate_post_taxonomies_blacklist');
	register_setting( 'duplicate_post_group', 'duplicate_post_title_prefix');
	register_setting( 'duplicate_post_group', 'duplicate_post_title_suffix');
	register_setting( 'duplicate_post_group', 'duplicate_post_increase_menu_order_by');
	register_setting( 'duplicate_post_group', 'duplicate_post_roles');
	register_setting( 'duplicate_post_group', 'duplicate_post_types_enabled');
	register_setting( 'duplicate_post_group', 'duplicate_post_show_row');
	register_setting( 'duplicate_post_group', 'duplicate_post_show_adminbar');
	register_setting( 'duplicate_post_group', 'duplicate_post_show_submitbox');
	register_setting( 'duplicate_post_group', 'duplicate_post_show_bulkactions');
	register_setting( 'duplicate_post_group', 'duplicate_post_show_original_column');
	register_setting( 'duplicate_post_group', 'duplicate_post_show_original_in_post_states');
	register_setting( 'duplicate_post_group', 'duplicate_post_show_original_meta_box');
	register_setting( 'duplicate_post_group', 'duplicate_post_show_notice');
}


function duplicate_post_menu() {
	add_options_page(__("Duplicate Post Options", 'duplicate-post'), __("Duplicate Post", 'duplicate-post'), 'manage_options', 'duplicatepost', 'duplicate_post_options');
}

function duplicate_post_options() {

	if ( current_user_can( 'promote_users' ) && (isset($_GET['settings-updated'])  && $_GET['settings-updated'] == true)){
		global $wp_roles;
		$roles = $wp_roles->get_names();

		$dp_roles = get_option('duplicate_post_roles');
		if ( $dp_roles == "" ) $dp_roles = array();

		foreach ($roles as $name => $display_name){
			$role = get_role($name);

			/* If the role doesn't have the capability and it was selected, add it. */
			if ( !$role->has_cap( 'copy_posts' )  && in_array($name, $dp_roles) )
				$role->add_cap( 'copy_posts' );

			/* If the role has the capability and it wasn't selected, remove it. */
			elseif ( $role->has_cap( 'copy_posts' ) && !in_array($name, $dp_roles) )
			$role->remove_cap( 'copy_posts' );
		}
	}
	?>
<div class="wrap">
	<div id="icon-options-general" class="icon32">
		<br>
	</div>
	<h1>
		<?php esc_html_e("Duplicate Post Options", 'duplicate-post'); ?>
	</h1>
	
	<div
		style="display: flex; align-items: center; margin: 9px 15px 4px 0; padding: 5px 30px; float: left; clear:left; border: solid 3px #cccccc; width: 600px;">
		<svg xmlns="http://www.w3.org/2000/svg" style="padding: 0; margin: 10px 20px 10px 0;"	width="80" height="80" viewBox="0 0 20 20">
			<path d="M18.9 4.3c0.6 0 1.1 0.5 1.1 1.1v13.6c0 0.6-0.5 1.1-1.1 1.1h-10.7c-0.6 0-1.1-0.5-1.1-1.1v-3.2h-6.1c-0.6 0-1.1-0.5-1.1-1.1v-7.5c0-0.6 0.3-1.4 0.8-1.8l4.6-4.6c0.4-0.4 1.2-0.8 1.8-0.8h4.6c0.6 0 1.1 0.5 1.1 1.1v3.7c0.4-0.3 1-0.4 1.4-0.4h4.6zM12.9 6.7l-3.3 3.3h3.3v-3.3zM5.7 2.4l-3.3 3.3h3.3v-3.3zM7.9 9.6l3.5-3.5v-4.6h-4.3v4.6c0 0.6-0.5 1.1-1.1 1.1h-4.6v7.1h5.7v-2.9c0-0.6 0.3-1.4 0.8-1.8zM18.6 18.6v-12.9h-4.3v4.6c0 0.6-0.5 1.1-1.1 1.1h-4.6v7.1h10z"
				  fill="rgba(140,140,140,1)"/>
		</svg>
		<div>
		<p>
			<?php esc_html_e('Serving the WordPress community since November 2007.', 'duplicate-post'); ?>
			<br/>
			<strong><a href="https://duplicate-post.lopo.it/donate/"><?php esc_html_e('Support the plugin by making a donation or becoming a patron!', 'duplicate-post'); ?></a></strong>
		</p>
		<p>
			<a href="https://duplicate-post.lopo.it/" aria-label="<?php esc_attr_e('Documentation for Duplicate Post', 'duplicate-post'); ?>"><?php esc_html_e('Documentation', 'duplicate-post'); ?></a>
			 - <a href="https://translate.wordpress.org/projects/wp-plugins/duplicate-post" aria-label="<?php esc_attr_e('Translate Duplicate Post', 'duplicate-post'); ?>"><?php esc_html_e('Translate', 'duplicate-post'); ?></a>
			 - <a href="https://wordpress.org/support/plugin/duplicate-post" aria-label="<?php esc_attr_e('Support forum for Duplicate Post', 'duplicate-post'); ?>"><?php esc_html_e('Support Forum', 'duplicate-post'); ?></a>
		</p>
		</div>
	</div>
		

	<script>
		var tablist;
		var tabs;
		var panels;

		// For easy reference
		var keys = {
			end: 35,
			home: 36,
			left: 37,
			up: 38,
			right: 39,
			down: 40,
			delete: 46
		};

		// Add or substract depending on key pressed
		var direction = {
			37: -1,
			38: -1,
			39: 1,
			40: 1
		};


		function generateArrays () {
			tabs = document.querySelectorAll('#duplicate_post_settings_form [role="tab"]');
			panels = document.querySelectorAll('#duplicate_post_settings_form [role="tabpanel"]');
		};

		function addListeners (index) {
			tabs[index].addEventListener('click', function(event){
				var tab = event.target;
				activateTab(tab, false);
			});
			tabs[index].addEventListener('keydown', function(event) {
				var key = event.keyCode;

				switch (key) {
					case keys.end:
						event.preventDefault();
						// Activate last tab
						activateTab(tabs[tabs.length - 1]);
						break;
					case keys.home:
						event.preventDefault();
						// Activate first tab
						activateTab(tabs[0]);
						break;
				};
			});
			tabs[index].addEventListener('keyup', function(event) {
				var key = event.keyCode;

				switch (key) {
					case keys.left:
					case keys.right:
						switchTabOnArrowPress(event);
						break;
				};
			});

			// Build an array with all tabs (<button>s) in it
			tabs[index].index = index;
		};


		// Either focus the next, previous, first, or last tab
		// depening on key pressed
		function switchTabOnArrowPress (event) {
			var pressed = event.keyCode;

			for (x = 0; x < tabs.length; x++) {
				tabs[x].addEventListener('focus', focusEventHandler);
			};

			if (direction[pressed]) {
				var target = event.target;
				if (target.index !== undefined) {
					if (tabs[target.index + direction[pressed]]) {
						tabs[target.index + direction[pressed]].focus();
					}
					else if (pressed === keys.left || pressed === keys.up) {
						focusLastTab();
					}
					else if (pressed === keys.right || pressed == keys.down) {
						focusFirstTab();
					};
				};
			};
		};

		// Activates any given tab panel
		function activateTab (tab, setFocus) {
			setFocus = setFocus || true;
			// Deactivate all other tabs
			deactivateTabs();

			// Remove tabindex attribute
			tab.removeAttribute('tabindex');

			// Set the tab as selected
			tab.setAttribute('aria-selected', 'true');

			tab.classList.add('nav-tab-active');

			// Get the value of aria-controls (which is an ID)
			var controls = tab.getAttribute('aria-controls');

			// Remove hidden attribute from tab panel to make it visible
			document.getElementById(controls).removeAttribute('hidden');

			// Set focus when required
			if (setFocus) {
				tab.focus();
			};
		};

		// Deactivate all tabs and tab panels
		function deactivateTabs () {
			for (t = 0; t < tabs.length; t++) {
				tabs[t].setAttribute('tabindex', '-1');
				tabs[t].setAttribute('aria-selected', 'false');
				tabs[t].classList.remove('nav-tab-active');
				tabs[t].removeEventListener('focus', focusEventHandler);
			};

			for (p = 0; p < panels.length; p++) {
				panels[p].setAttribute('hidden', 'hidden');
			};
		};

		// Make a guess
		function focusFirstTab () {
			tabs[0].focus();
		};

		// Make a guess
		function focusLastTab () {
			tabs[tabs.length - 1].focus();
		};

		//
		function focusEventHandler (event) {
			var target = event.target;

			checkTabFocus(target);
		};

		// Only activate tab on focus if it still has focus after the delay
		function checkTabFocus (target) {
			focused = document.activeElement;

			if (target === focused) {
				activateTab(target, false);
			};
		};

		document.addEventListener("DOMContentLoaded", function () {
			tablist = document.querySelectorAll('#duplicate_post_settings_form [role="tablist"]')[0];

			generateArrays();

			// Bind listeners
			for (i = 0; i < tabs.length; ++i) {
				addListeners(i);
			};


		});

	function toggle_private_taxonomies(){
		jQuery('.taxonomy_private').toggle(300);
	}

	
	jQuery(function(){
		jQuery('.taxonomy_private').hide(300);
	});
	
	</script>

	<style>
header.nav-tab-wrapper {
	margin: 22px 0 0 0;
}

header .nav-tab:focus {
	color: #555;
	box-shadow: none;
}

#sections {
	padding: 22px;
	background: #fff;
	border: 1px solid #ccc;
	border-top: 0px;
}
/*
section {
	display: none;
}

section:first-of-type {
	display: block;
}*/

.no-js header.nav-tab-wrapper {
	display: none;
}

.no-js #sections {
	border-top: 1px solid #ccc;
	margin-top: 22px;
}

.no-js section {
	border-top: 1px dashed #aaa;
	margin-top: 22px;
	padding-top: 22px;
}

.no-js section:first-child {
	margin: 0px;
	padding: 0px;
	border: 0px;
}

label {
	display: block;
}

label.taxonomy_private {
	font-style: italic;
}

a.toggle_link {
	font-size: small;
}
img#donate-button{
	vertical-align: middle;
}
</style>


	<form method="post" action="options.php" style="clear: both" id="duplicate_post_settings_form">
		<?php settings_fields('duplicate_post_group'); ?>

		<header role="tablist" aria-label="<?php esc_attr_e('Settings sections', 'duplicate-post'); ?>" class="nav-tab-wrapper">
			<button
					type="button"
					role="tab"
					class="nav-tab nav-tab-active"
					aria-selected="true"
					aria-controls="what-tab"
					id="what"><?php esc_html_e('What to copy', 'duplicate-post'); ?>
			</button>
			<button
					type="button"
					role="tab"
					class="nav-tab"
					aria-selected="false"
					aria-controls="who-tab"
					id="who"
					tabindex="-1"><?php esc_html_e('Permissions', 'duplicate-post'); ?>
			</button>
			<button
					type="button"
					role="tab"
					class="nav-tab"
					aria-selected="false"
					aria-controls="where-tab"
					id="where"
					tabindex="-1"><?php esc_html_e('Display', 'duplicate-post'); ?>
			</button>
		</header>

		<section
				tabindex="0"
				role="tabpanel"
				id="what-tab"
				aria-labelledby="what">

			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Post/page elements to copy', 'duplicate-post'); ?>
					</th>
					<td colspan="2"><label> <input type="checkbox"
							name="duplicate_post_copytitle" value="1" <?php  if(get_option('duplicate_post_copytitle') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Title", 'default'); ?>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copydate" value="1" <?php  if(get_option('duplicate_post_copydate') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Date", 'default'); ?>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copystatus" value="1" <?php  if(get_option('duplicate_post_copystatus') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Status", 'default'); ?>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copyslug" value="1" <?php  if(get_option('duplicate_post_copyslug') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Slug", 'default'); ?>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copyexcerpt" value="1" <?php  if(get_option('duplicate_post_copyexcerpt') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Excerpt", 'default'); ?>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copycontent" value="1" <?php  if(get_option('duplicate_post_copycontent') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Content", 'default'); ?>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copythumbnail" value="1" <?php  if(get_option('duplicate_post_copythumbnail') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Featured Image", 'default'); ?>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copytemplate" value="1" <?php  if(get_option('duplicate_post_copytemplate') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Template", 'default'); ?>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copyformat" value="1" <?php  if(get_option('duplicate_post_copyformat') == 1) echo 'checked="checked"'; ?>/>
							<?php echo esc_html_x("Format", 'post format', 'default'); ?>																					
					</label> <label> <input type="checkbox"
							name="duplicate_post_copyauthor" value="1" <?php  if(get_option('duplicate_post_copyauthor') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Author", 'default'); ?>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copypassword" value="1" <?php  if(get_option('duplicate_post_copypassword') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Password", 'default'); ?>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copyattachments" value="1" <?php  if(get_option('duplicate_post_copyattachments') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Attachments", 'duplicate-post');  ?> <span class="description">(<?php esc_html_e("you probably want this unchecked, unless you have very special requirements", 'duplicate-post');  ?>)</span>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copychildren" value="1" <?php  if(get_option('duplicate_post_copychildren') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Children", 'duplicate-post');  ?>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copycomments" value="1" <?php  if(get_option('duplicate_post_copycomments') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Comments", 'default');  ?> <span class="description">(<?php esc_html_e("except pingbacks and trackbacks", 'duplicate-post');  ?>)</span>
					</label> <label> <input type="checkbox"
							name="duplicate_post_copymenuorder" value="1" <?php  if(get_option('duplicate_post_copymenuorder') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Menu order", 'default');  ?>
					</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="duplicate_post_title_prefix">
							<?php esc_html_e("Title prefix", 'duplicate-post'); ?>
						</label>
					</th>
					<td><input type="text" name="duplicate_post_title_prefix" id="duplicate_post_title_prefix"
						value="<?php form_option('duplicate_post_title_prefix'); ?>" />
					</td>
					<td><span class="description"><?php esc_html_e("Prefix to be added before the title, e.g. \"Copy of\" (blank for no prefix)", 'duplicate-post'); ?>
					</span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="duplicate_post_title_suffix">
							<?php esc_html_e("Title suffix", 'duplicate-post'); ?>
						</label>
					</th>
					<td><input type="text" name="duplicate_post_title_suffix" id="duplicate_post_title_suffix"
						value="<?php form_option('duplicate_post_title_suffix'); ?>" />
					</td>
					<td><span class="description"><?php esc_html_e("Suffix to be added after the title, e.g. \"(dup)\" (blank for no suffix)", 'duplicate-post'); ?>
					</span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="duplicate_post_increase_menu_order_by">
							<?php esc_html_e("Increase menu order by", 'duplicate-post'); ?>
						</label>
					</th>
					<td><input type="text" name="duplicate_post_increase_menu_order_by" id="duplicate_post_increase_menu_order_by"
						value="<?php form_option('duplicate_post_increase_menu_order_by'); ?>" />
					</td>
					<td><span class="description"><?php esc_html_e("Add this number to the original menu order (blank or zero to retain the value)", 'duplicate-post'); ?>
					</span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="duplicate_post_blacklist">
							<?php esc_html_e("Do not copy these fields", 'duplicate-post'); ?>
						</label>
					</th>
					<td id="textfield"><input type="text"
						name="duplicate_post_blacklist"
					  	id="duplicate_post_blacklist"
						value="<?php form_option('duplicate_post_blacklist'); ?>" /></td>
					<td><span class="description"><?php esc_html_e("Comma-separated list of meta fields that must not be copied", 'duplicate-post'); ?><br />
							<small><?php esc_html_e("You can use * to match zero or more alphanumeric characters or underscores: e.g. field*", 'duplicate-post'); ?>
						</small> </span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e("Do not copy these taxonomies", 'duplicate-post'); ?><br />
						<a class="toggle_link" href="#"
						onclick="toggle_private_taxonomies();return false;"><?php esc_html_e('Show/hide private taxonomies', 'duplicate-post');?>
					</a>
					</th>
					<td colspan="2"><?php $taxonomies=get_taxonomies(array(),'objects'); usort($taxonomies, 'duplicate_post_tax_obj_cmp');
					$taxonomies_blacklist = get_option('duplicate_post_taxonomies_blacklist');
					if ($taxonomies_blacklist == "") $taxonomies_blacklist = array();
					foreach ($taxonomies as $taxonomy ) : 
						if($taxonomy->name == 'post_format'){
							continue;
						}
						?> <label
						class="taxonomy_<?php echo ($taxonomy->public)?'public':'private';?>">
							<input type="checkbox"
							name="duplicate_post_taxonomies_blacklist[]"
							value="<?php echo $taxonomy->name?>"
							<?php if(in_array($taxonomy->name, $taxonomies_blacklist)) echo 'checked="checked"'?> />
							<?php echo $taxonomy->labels->name.' ['.$taxonomy->name.']'; ?>
					</label> <?php endforeach; ?> <span class="description"><?php esc_html_e("Select the taxonomies you don't want to be copied", 'duplicate-post'); ?>
					</span>
					</td>
				</tr>
			</table>
		</section>
		<section
				tabindex="0"
				role="tabpanel"
				id="who-tab"
				aria-labelledby="who"
				hidden="hidden">
			<table class="form-table">
				<?php if ( current_user_can( 'promote_users' ) ){ ?>
				<tr valign="top">
					<th scope="row"><?php esc_html_e("Roles allowed to copy", 'duplicate-post'); ?>
					</th>
					<td><?php	global $wp_roles;
					$roles = $wp_roles->get_names();
					$post_types = get_post_types( array( 'show_ui' => true ), 'objects' );
					$edit_capabilities = array('edit_posts' => true);
					foreach( $post_types as $post_type ) {
						$edit_capabilities[$post_type->cap->edit_posts] = true;
					}
					foreach ( $roles as $name => $display_name ):
						$role = get_role( $name );
						if( count ( array_intersect_key( $role->capabilities, $edit_capabilities ) ) > 0 ): ?>
					<label> <input
							type="checkbox" name="duplicate_post_roles[]"
							value="<?php echo $name ?>"
							<?php if($role->has_cap('copy_posts')) echo 'checked="checked"'?> />
							<?php echo translate_user_role($display_name); ?>
					</label> <?php endif; endforeach; ?> <span class="description"><?php esc_html_e("Warning: users will be able to copy all posts, even those of other users", 'duplicate-post'); ?><br />
							<?php esc_html_e("Passwords and contents of password-protected posts may become visible to undesired users and visitors", 'duplicate-post'); ?>
					</span>
					</td>
				</tr>
				<?php } ?>
				<tr valign="top">
					<th scope="row"><?php esc_html_e("Enable for these post types", 'duplicate-post'); ?>
					</th>
					<td><?php $post_types = get_post_types(array('show_ui' => true),'objects');
					foreach ($post_types as $post_type_object ) :
					if ($post_type_object->name == 'attachment') continue; ?> <label> <input
							type="checkbox" name="duplicate_post_types_enabled[]"
							value="<?php echo $post_type_object->name?>"
							<?php if(duplicate_post_is_post_type_enabled($post_type_object->name)) echo 'checked="checked"'?> />
							<?php echo $post_type_object->labels->name?>
					</label> <?php endforeach; ?> <span class="description"><?php esc_html_e("Select the post types you want the plugin to be enabled", 'duplicate-post'); ?>
							<br /> <?php esc_html_e("Whether the links are displayed for custom post types registered by themes or plugins depends on their use of standard WordPress UI elements", 'duplicate-post'); ?>
					</span>
					</td>
				</tr>
			</table>
		</section>
		<section
				tabindex="0"
				role="tabpanel"
				id="where-tab"
				aria-labelledby="where"
				hidden="hidden">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e("Show links in", 'duplicate-post'); ?>
					</th>
					<td><label><input type="checkbox" name="duplicate_post_show_row"
							value="1" <?php  if(get_option('duplicate_post_show_row') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Post list", 'duplicate-post'); ?> </label>
							<label><input type="checkbox" name="duplicate_post_show_submitbox" value="1" <?php  if(get_option('duplicate_post_show_submitbox') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Edit screen", 'duplicate-post'); ?> </label>
							<label><input type="checkbox" name="duplicate_post_show_adminbar" value="1" <?php  if(get_option('duplicate_post_show_adminbar') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Admin bar", 'duplicate-post'); ?> <span class="description">(<?php esc_html_e("now works on Edit screen too - check this option to use with Gutenberg enabled", 'duplicate-post');  ?>)</span></label>
							<?php global $wp_version;
							if( version_compare($wp_version, '4.7') >= 0 ){ ?>
							<label><input type="checkbox" name="duplicate_post_show_bulkactions" value="1" <?php  if(get_option('duplicate_post_show_bulkactions') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("Bulk Actions", 'default'); ?> </label>
							<?php } ?>												
					</td>
				</tr>
				<tr valign="top">
					<td colspan="2"><span class="description"><?php esc_html_e("Whether the links are displayed for custom post types registered by themes or plugins depends on their use of standard WordPress UI elements", 'duplicate-post'); ?>
							<br /> <?php printf(__('You can also use the template tag duplicate_post_clone_post_link( $link, $before, $after, $id ). You can find more info about this on the <a href="%s">developer&apos;s guide for Duplicate Post</a>', 'duplicate-post'), 'https://duplicate-post.lopo.it/docs/developers-guide/functions-template-tags/duplicate_post_clone_post_link/'); ?>
					</span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e("Show original item:", 'duplicate-post'); ?></th>
					<td>
						<label>
							<input type="checkbox" name="duplicate_post_show_original_meta_box"
							   value="1" <?php  if(get_option('duplicate_post_show_original_meta_box') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("In a metabox in the Edit screen [Classic editor]", 'duplicate-post'); ?>
							<span class="description">(<?php esc_html_e("you'll also be able to delete the reference to the original item with a checkbox", 'duplicate-post');  ?>)</span>
						</label>
						<label>
							<input type="checkbox" name="duplicate_post_show_original_column"
							   value="1" <?php  if(get_option('duplicate_post_show_original_column') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("In a column in the Post list", 'duplicate-post'); ?>
							<span class="description">(<?php esc_html_e("you'll also be able to delete the reference to the original item with a checkbox in Quick Edit", 'duplicate-post');  ?>)</span>
						</label>
						<label>
							<input type="checkbox" name="duplicate_post_show_original_in_post_states"
								   value="1" <?php  if(get_option('duplicate_post_show_original_in_post_states') == 1) echo 'checked="checked"'; ?>/>
							<?php esc_html_e("After the title in the Post list", 'duplicate-post'); ?>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="duplicate_post_show_notice">
							<?php esc_html_e("Show update notice", 'duplicate-post'); ?>
						</label>
					</th>
					<td><input type="checkbox" name="duplicate_post_show_notice" id="duplicate_post_show_notice"
							value="1" <?php  if(get_option('duplicate_post_show_notice') == 1) echo 'checked="checked"'; ?>/>
					</td>
				</tr>				
			</table>
		</section>
		<p class="submit">
			<input type="submit" class="button-primary"
				value="<?php esc_html_e('Save Changes', 'duplicate-post') ?>" />
		</p>

	</form>
</div>
<?php
}
?>