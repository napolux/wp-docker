<?php
/**
 * Mapplic Plugin
 *
 * New map page.
 */

// SUBMIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	global $wpdb;
	$table = $wpdb->prefix . 'custommaps';

	$type = $_REQUEST['map-type'];
	$data = '';
	$mapdir = plugins_url() . '/mapplic/maps';

	switch ($type) {
		case 'world':
			$data = '{"mapwidth":"1200","mapheight":"760","minimap":false,"zoombuttons":false,"sidebar":false,"search":false,"hovertip":false,"fullscreen":false,"zoomlimit":"4","mapfill":false,"zoom":"true","alphabetic":false,"categories":[],"levels":[{"id":"world","title":"World","map":"' . $mapdir . '/world.svg","minimap":"","locations":[{"id":"us","title":"USA","description":"<p>sdkdfjnsdkjfsd</p>","link":"","category":"false","action":"tooltip","pin":"hidden","zoom":"","x":"0.2287","y":"0.5149","fill":""}]}],"maxscale":4}';
			break;
		case 'europe':
			$data = '{"mapwidth":"1200","mapheight":"1200","minimap":"true","zoombuttons":false,"sidebar":"true","search":false,"hovertip":"true","fullscreen":false,"zoomlimit":"4","mapfill":"true","zoom":"true","alphabetic":"true","categories":[],"levels":[{"id":"europe","title":"Europe","map":"' . $mapdir . '/europe.svg","minimap":"' . $mapdir . '/europe-mini.jpg","locations":[{"id":"ch","title":"Switzerland","description":"<p>Example country</p>","fill":"#343f4b","link":"","category":"false","action":"tooltip","pin":"hidden","zoom":"","x":"0.4085","y":"0.6328"}]}],"maxscale":3}';
			break;
		case 'usa':
			$data = '{"mapwidth":"960","mapheight":"600","minimap":"true","zoombuttons":"true","sidebar":false,"search":false,"hovertip":"true","fullscreen":false,"zoomlimit":"2","mapfill":false,"zoom":"true","alphabetic":false,"categories":[],"levels":[{"id":"usa","title":"USA","map":"' . $mapdir . '/usa.svg","minimap":"' . $mapdir . '/usa-mini.jpg","locations":[{"id":"il","title":"Illinois","description":"<p>Example state.</p>","fill":"","link":"","category":"false","action":"tooltip","pin":"hidden","zoom":"","x":"0.6232","y":"0.4130"}]}],"maxscale":3}';
			break;
		case 'canada':
			$data = '{"mapwidth":"640","mapheight":"600","minimap":false,"zoombuttons":false,"sidebar":false,"search":false,"hovertip":false,"fullscreen":false,"zoomlimit":"4","mapfill":false,"zoom":false,"alphabetic":false,"categories":[],"levels":[{"id":"canada","title":"Canada","map":"' . $mapdir . '/canada.svg","minimap":"","locations":[{"id":"ca-ab","title":"Alberta","description":"<p>Example province.</p>","fill":"","link":"","category":"false","action":"tooltip","pin":"hidden","zoom":"","x":"0.2528","y":"0.6790"}]}],"maxscale":3}';
			break;
		case 'france':
			$data = '{"mapwidth":"1000","mapheight":"1000","minimap":"true","zoombuttons":"true","sidebar":false,"search":false,"hovertip":"true","fullscreen":false,"zoomlimit":"2","mapfill":false,"zoom":"true","alphabetic":false,"categories":[],"levels":[{"id":"france","title":"France","map":"' . $mapdir . '/france.svg","minimap":"' . $mapdir . '/france-mini.jpg","locations":[{"id":"fr-d18","title":"Department 18","description":"<p>Example department.</p>","fill":"","link":"","category":"false","action":"tooltip","pin":"hidden","zoom":"","x":"0.5606","y":"0.4639"}]}],"maxscale":2}';
			break;
		case 'germany':
			$data = '{"mapwidth":"600","mapheight":"800","minimap":false,"zoombuttons":"true","sidebar":false,"search":false,"hovertip":"true","fullscreen":false,"zoomlimit":"2","mapfill":false,"zoom":"true","alphabetic":false,"categories":[],"levels":[{"id":"germany","title":"Germany","map":"' . $mapdir . '/germany.svg","minimap":"","locations":[{"id":"de-ni","title":"Niedersachsen","description":"<p>Example land.</p>","fill":"","link":"","category":"false","action":"tooltip","pin":"hidden","zoom":"","x":"0.3980","y":"0.2674"}]}],"maxscale":2}';
			break;
		case 'uk':
			$data = '{"mapwidth":"690","mapheight":"982","minimap":false,"zoombuttons":"true","sidebar":false,"search":false,"hovertip":"true","fullscreen":"true","zoomlimit":"2","mapfill":false,"zoom":"true","alphabetic":false,"categories":[],"levels":[{"id":"uk","title":"United Kingdom","map":"' . $mapdir . '/uk.svg","minimap":"","locations":[{"id":"north-west","title":"North West","description":"<p>Example region.</p>","fill":"","link":"","category":"false","action":"tooltip","pin":"hidden","zoom":"","x":"0.5443","y":"0.5525"}]}],"maxscale":2}';
			break;
		default:
			$data = '{"categories": [],"levels": []}';
	}

	// Inserting new record into database
	$wpdb->insert(
		$table, 
		array(
			'title' => $_REQUEST['map-title'],
			'data' => $data
		)
	);

	$id = $wpdb->insert_id;

	// Redirect to the edit page of the newly created map
	$editPage = remove_query_arg('noheader', add_query_arg(
		array(
			'action' => 'edit',
			'map' => $id
		)
	));

	wp_redirect($editPage);
	exit;
}

$maps = array(
	'world' => 'World',
	'europe' => 'Europe',
	'usa' => 'USA',
	'canada' => 'Canada',
	'france' => 'France',
	'germany' => 'Germany',
	'uk' => 'United Kingdom'
);
?>

<div class="wrap">

	<h2><?php _e('Add New Custom Map', 'mapplic'); ?></h2>
	
	<form id="mapplic-form" method="post" action="<?php echo add_query_arg('noheader', 'true'); ?>">

		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
		<input type="hidden" name="action" value="new">
		<input type="hidden" name="map" value="<?php echo $id; ?>">
		<input type="hidden" name="noheader" value="true">

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">
					<div id="titlediv">
						<input type="text" name="map-title" id="title" autocomplete="off">
					</div>

					<p><?php _e('To create a new map, first add a floor. Once your map has at least one floor, save it and you can start placing the landmarks.', 'mapplic'); ?></p>

					<select name="map-type">
						<option value="custom">Custom</option>
					<?php foreach ($maps as $key => $map) : ?>
						<option value="<?php echo $key; ?>"><?php echo $map; ?></option>
					<?php endforeach; ?>
					</select>

					<input type="submit" name="submit" class="button button-primary form-submit" value="<?php _e('Create Map', 'mapplic'); ?>">
				</div>
			</div>
		</div>
	</form>
</div>