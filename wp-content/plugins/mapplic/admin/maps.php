<?php

// Legacy support
function mapplic_restore_old_maps() {
	global $wpdb;

	$old_table = $wpdb->prefix . 'custommaps';
	$query = "SELECT * FROM $old_table WHERE status > 0";

	$old_maps = $wpdb->get_results($query, 'ARRAY_A');

	foreach ($old_maps as &$old_map) {
		$new_map = array(
			'post_type' 	=> 'mapplic_map',
			'post_title' 	=> $old_map['title'],
			'post_status' 	=> 'publish',
			'filter' 		=> true
		);
		$post_id = wp_insert_post($new_map);
		$table = $wpdb->prefix . 'posts';
		$wpdb->update($table, array('post_content' => $old_map['data']), array('ID' => $post_id));
	}
}

// Preinstalled example maps
function mapplic_add_example_maps() {
	$exampledir = plugins_url() . '/mapplic/images/examples';
	$mapdir = plugins_url() . '/mapplic/maps';

	$maps = array(
		'[Example] US States'  => '{"mapwidth":"959","mapheight":"593","minimap":true,"sidebar":false,"search":false,"hovertip":true,"zoomlimit":"4","categories":[],"levels":[{"id":"states","title":"States","map":"' . $mapdir . '/usa.svg","minimap":"' . $mapdir . '/usa-mini.jpg","locations":[{"id":"ca","title":"California","description":"<p>California state.</p>","link":"http://en.wikipedia.org/wiki/California","pin":"hidden no-fill","x":"0.0718","y":"0.4546","category":"false","action":"tooltip"},{"id":"wa","title":"Washington","description":"<p>The Evergreen State</p>","link":"http://en.wikipedia.org/wiki/Washington_(state)","pin":"hidden","x":"0.1331","y":"0.0971"},{"id":"nv","title":"Nevada","description":"Nevada is officially known as the \"Silver State\" due to the importance of silver to its history and economy","link":"http://en.wikipedia.org/wiki/Nevada","pin":"hidden","x":"0.1484","y":"0.3973"},{"id":"il","title":"Illinois","description":"<p>Three U.S. presidents have been elected while living in Illinois</p>","link":"http://en.wikipedia.org/wiki/Illinois","pin":"hidden","x":"0.6209","y":"0.4316","category":null},{"id":"ny","title":"New York","description":"New York is a state in the Northeastern and Mid-Atlantic regions of the United States.","link":"http://en.wikipedia.org/wiki/NewYork","pin":"hidden","x":"0.8472","y":"0.2680"},{"id":"ma","title":"Massachusetts","description":"Officially the Commonwealth of Massachusetts, is a state in the New England region of the northeastern United States.","link":"http://en.wikipedia.org/wiki/Massachusetts","pin":"hidden","x":"0.9049","y":"0.2625"},{"id":"ga","title":"Georgia","description":"Georgia is known as the Peach State and the Empire State of the South.","link":"http://en.wikipedia.org/wiki/Georgia_(U.S._state)","pin":"hidden","x":"0.7517","y":"0.6885"},{"id":"fl","title":"Florida","description":"The state capital is Tallahassee, the largest city is Jacksonville, and the largest metropolitan area is the Miami metropolitan area.","link":"http://en.wikipedia.org/wiki/Florida","pin":"hidden","x":"0.8001","y":"0.8486"},{"id":"tx","title":"Texas","description":"<p>The Lone Star State <a href=\"http://www.codecanyon.net\">Canyon</a></p>","link":"http://en.wikipedia.org/wiki/Texas","pin":"hidden","x":"0.4512","y":"0.7694","zoom":"2","category":null},{"id":"losangeles","title":"Los Angeles","description":"<p>The city of Angels</p>","x":"0.0892","y":"0.5742","zoom":"2","category":"false","action":"tooltip","pin":"circular pin-md pin-label","label":"LA"},{"id":"houston","title":"Houston","description":"<p>Space City</p>","x":"0.4962","y":"0.8127","zoom":"2","pin":"circular","category":"false","action":"tooltip"},{"id":"chicago","title":"Chicago","description":"<p>The windy city</p>","x":"0.6418","y":"0.3489","zoom":"2","pin":"circular","category":"false","action":"tooltip"},{"id":"newyork","title":"New York","description":"<p>The big apple</p>","x":"0.8827","y":"0.3322","zoom":"2","pin":"circular pin-md pin-label","label":"NY","category":"false","action":"tooltip"}]}],"maxscale":4,"zoombuttons":true,"fullscreen":false,"mapfill":false,"zoom":true,"alphabetic":false,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'[Example] Mall' => '{"mapwidth":"1000","mapheight":"600","categories":[{"id":"food","title":"Fast-foods & Restaurants","color":"#b7a6bd","show":"false"},{"id":"dep","title":"Department Stores","color":"#b7a6bd"},{"id":"clothing","title":"Clothing & Accessories","color":"#b7a6bd"},{"id":"health","title":"Health & Cosmetics","color":"#b7a6bd"},{"id":"misc","title":"Miscellaneous","color":"#b7a6bd"}],"levels":[{"id":"basement","title":"Basement","map":"' . $exampledir . '/mall/mall-underground.svg","minimap":"' . $exampledir . '/mall/mall-underground-mini.jpg","locations":[{"id":"gap","title":"GAP","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.3750","y":"0.4343","pin":"hidden","action":"tooltip"},{"id":"petco","title":"Petco","description":"<p>Lorem ipsum</p>","category":"misc","x":"0.5194","y":"0.3091","pin":"hidden","action":"tooltip"}]},{"id":"ground","title":"Ground Floor","map":"' . $exampledir . '/mall/mall-ground.svg","minimap":"' . $exampledir . '/mall/mall-ground-mini.jpg","show":"true","locations":[{"id":"sears","title":"Sears","description":"<p>Sears depártment store</p>","category":"dep","x":"0.7929","y":"0.2727","zoom":"3","pin":"hidden","action":"tooltip"},{"id":"macys","title":"Macy\'s","description":"<p>Macy\'s <i>department</i> store</p>","category":"dep","x":"0.2022","y":"0.5843","zoom":"3","pin":"hidden","actionx":"open-link-new-tab","action":"tooltip"},{"id":"jcpenney","title":"JCPenney","description":"<p>JCPenney department store</p>","category":"dep","x":"0.6713","y":"0.6553","zoom":"3","pin":"hidden","action":"default"},{"id":"walgreens","title":"Walgreens","description":"<p>At the corner of Happy & Healthy</p>","category":"health","x":"0.4600","y":"0.5396","pin":"hidden","action":"none"},{"id":"sephora","title":"Sephora","description":"<p>Makeup, fragrance, skincare</p>","category":"health","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.7506","y":"0.5203","pin":"hidden","action":"default"},{"id":"belk","title":"Belk","description":"<p>Lorem ipsumy</p>","category":"clothing","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.3956","y":"0.5556","pin":"hidden","action":"tooltip"},{"id":"hnm","title":"H&M","description":"<p>Lorem ipsum xy</p>","category":"clothing","x":"0.5407","y":"0.5135","link":"http://codecanyon.net/user/sekler?ref=sekler","action":"default","pin":"hidden"},{"id":"oldnavy","title":"Old Navy","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.3668","y":"0.3948","pin":"hidden","action":"default"},{"id":"sportchek","title":"Sport Chek","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.6239","y":"0.3049","pin":"hidden","action":"tooltip"},{"id":"starbucks","title":"Starbucks","description":"<p>The coffee company</p>","category":"food","x":"0.6445","y":"0.4477","pin":"hidden","link":"http://codecanyon.net/user/sekler?ref=sekler","action":"open-link-new-tab"},{"id":"zara","title":"Zara","description":"<p>Lorem ipsum</p>","category":"clothing","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.4779","y":"0.3112","pin":"hidden","action":"tooltip"}]},{"id":"first","title":"First Floor","map":"' . $exampledir . '/mall/mall-level1.svg","minimap":"' . $exampledir . '/mall/mall-level1-mini.jpg","locations":[{"id":"applebees","title":"Applebee\'s","description":"<p>See you tomorrow</p>","category":"food","x":"0.7539","y":"0.2767","pin":"hidden","action":"tooltip"},{"id":"kfc","title":"KFC","description":"<p>Kentucky Fried Chicken</p>","category":"food","x":"0.7491","y":"0.4996","pin":"hidden","action":"tooltip"},{"id":"mcdonalds","title":"McDonald\'s","description":"<p>Additional information</p>","category":"food","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.7386","y":"0.3991","pin":"hidden","action":"tooltip"},{"id":"pizzahut","title":"Pizza Hut","description":"<p>Make it great</p>","category":"food","x":"0.6265","y":"0.3150","pin":"hidden","action":"tooltip"},{"id":"subway","title":"Subway","description":"<p>Eat fresh.</p>","category":"food","x":"0.7110","y":"0.5294","pin":"hidden","action":"tooltip"},{"id":"cvs","title":"CVS Pharmacy","description":"<p>Lorem ipsum <a href=\"http://www.codecanyon.net\">dolor sit</a> amet, consectetur.</p>","category":"health","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.5188","y":"0.2731","pin":"hidden","action":"tooltip"},{"id":"pullnbear","title":"Pull & Bear","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.4854","y":"0.3293","pin":"hidden","action":"tooltip"},{"id":"amc","title":"AMC Theatres","description":"<p>Additional information</p>","category":"misc","x":"0.6630","y":"0.6452","pin":"hidden","action":"tooltip"},{"id":"atnt","title":"AT&T","description":"<p>Additional information</p>","category":"misc","actionx":"open-link-new-tab","x":"0.3749","y":"0.5386","pin":"hidden","action":"tooltip"}]}],"maxscale":4,"minimap":true,"zoombuttons":true,"sidebar":true,"search":true,"hovertip":true,"fullscreen":true,"zoomlimit":"4","mapfill":false,"zoom":true,"alphabetic":true,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"","action":"tooltip"}',

		'[Example] Apartment' => '{"mapwidth":"2000","mapheight":"2000","minimap":true,"sidebar":true,"search":true,"hovertip":true,"zoomlimit":"1","categories":[{"id":"furniture","title":"Furniture","color":"#4cd3b8","show":"false"},{"id":"rooms","title":"Rooms","color":"#63aa9c"}],"levels":[{"id":"lower","title":"Lower","map":"' . $exampledir . '/apartment/lower.jpg","minimap":"' . $exampledir . '/apartment/lower-small.jpg","locations":[{"id":"coffeetable","title":"Coffee Table","description":"<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>","category":"furniture","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.2067","y":"0.4660","zoom":"3","pin":"no-fill","action":"tooltip"},{"id":"stairstop","title":"Stairs","description":"<p>Let\'s go upstairs!</p>","category":"furniture","x":"0.5057","y":"0.6173","zoom":"3","pin":"no-fill","action":"tooltip"},{"id":"diningtable","title":"Dining Table","description":"<p>An eight-person dining table with an image.</p>","category":"rooms","x":"0.4746","y":"0.2883","zoom":"3","pin":"no-fill","action":"tooltip"},{"id":"coffeemachine","title":"Coffee Machine","description":"<p>Coffee Machine</p>","category":"furniture","x":"0.6792","y":"0.3459","zoom":"3","pin":"no-fill","action":"tooltip"},{"id":"workingtable","title":"Working Table","description":"It\'s the perfect home workspace you\'ve always dreamed about.","category":"furniture","x":"0.6285","y":"0.1480","zoom":"3"},{"id":"kitchen","title":"Kitchen","description":"<p>Welcome to the kitchen.</p>","category":"rooms","link":"http://codecanyon.net/user/sekler?ref=sekler","pin":"hidden","x":"0.6650","y":"0.4600","zoom":"3","action":"tooltip"},{"id":"dining","title":"Dining room","description":"<p>The main living room</p><!--<iframe width=\"320\" height=\"180\" src=\"//www.youtube.com/embed/HGy9i8vvCxk\" frameborder=\"0\" allowfullscreen></iframe>-->","category":"rooms","pin":"hidden","x":"0.2966","y":"0.3795","zoom":"3","action":"tooltip"}]},{"id":"upper","title":"Upper","map":"' . $exampledir . '/apartment/upper.jpg","minimap":"' . $exampledir . '/apartment/upper-small.jpg","locations":[{"id":"livingup","title":"Living room","description":"<p>I could spend the whole day here!</p>","category":"rooms","x":"0.4900","y":"0.3600","zoom":"2","pin":"no-fill","action":"tooltip"},{"id":"kingbed","title":"King bed","description":"<p>A king size bed situated in the main bedroom on the first floor.</p>","category":"furniture","x":"0.6564","y":"0.2782","zoom":"3","pin":"no-fill","action":"tooltip"},{"id":"bathroom","title":"Bathroom","description":"<p>Take a bath!</p>","category":"rooms","pin":"hidden","x":"0.7843","y":"0.4035","mapfill":"true","zoom":"3","action":"tooltip"}]}],"maxscale":1,"zoombuttons":true,"fullscreen":false,"mapfill":true,"zoom":true,"alphabetic":false,"clearbutton":true,"mousewheel":true,"deeplinking":false,"fillcolor":"","action":"tooltip"}'
	);

	global $wpdb;
	$table = $wpdb->prefix . 'posts';
	
	foreach ($maps as $title => $map) {
		$new_map = array(
			'post_type' 	=> 'mapplic_map',
			'post_title' 	=> $title,
			'post_status' 	=> 'publish',
			'filter' 		=> true
		);
		$post_id = wp_insert_post($new_map);
		$wpdb->update($table, array('post_content' => $map), array('ID' => $post_id));
	}
}

// New map type select
function mapplic_new_map_type() {
	// Built-in maps
	$maps = array(
		'world' 		=> __('World', 'mapplic'),
		'continents' 	=> __('Continents', 'mapplic'),
		'europe' 		=> __('Europe', 'mapplic'),
		'usa' 			=> __('USA', 'mapplic'),
		'canada' 		=> __('Canada', 'mapplic'),
		'australia' 	=> __('Australia', 'mapplic'),
		'france' 		=> __('France', 'mapplic'),
		'germany' 		=> __('Germany', 'mapplic'),
		'uk' 			=> __('United Kingdom', 'mapplic'),
		'italy' 		=> __('Italy', 'mapplic'),
		'netherlands' 	=> __('Netherlands', 'mapplic'),
		'switzerland' 	=> __('Switzerland', 'mapplic'),
		'russia' 		=> __('Russia', 'mapplic'),
		'china' 		=> __('China', 'mapplic'),
		'brazil' 		=> __('Brazil', 'mapplic')
	);
	?>
	<h3><?php _e('Select Map Type', 'mapplic'); ?></h3>
	<p><?php _e('Create a custom map using your own file(s) or select one of the built-in maps.', 'mapplic'); ?></p>
	<select id="mapplic-new-type" name="new-map-type">
		<option value="custom"><?php _e('Custom', 'mapplic'); ?></option>
	<?php foreach ($maps as $key => $map) : ?>
		<option value="<?php echo $key; ?>"><?php echo $map; ?></option>
	<?php endforeach; ?>
	</select>
	<br><br>

	<div id="mapplic-mapfile">
		<h3><?php _e('Define Map File', 'mapplic'); ?></h3>
		<p><?php _e('Upload or select map file from library. SVG, JPG and PNG formats supported.', 'mapplic'); ?></p>
		<label class="field-small">
			<b><?php _e('Name', 'mapplic'); ?></b><br>
			<input type="text" name="new-map-name" class="input-text title-input" value="My Map">
		</label>
		<label class="field-small">
			<b><?php _e('ID (required)', 'mapplic'); ?></b><br>
			<input type="text" name="new-map-id" class="input-text id-input" value="my-map">
		</label>

		<div class="field-medium">
			<label><b><?php _e('Map File (required)', 'mapplic'); ?></b><br>
				<input type="text" name="new-map" class="input-text map-input buttoned" value="">
				<button class="button media-button"><span class="dashicons dashicons-upload"></span></button>
			</label>
		</div>

		<label class="field-small">
			<b><?php _e('Width (reqiured)', 'mapplic'); ?></b><br>
			<input type="text" name="new-mapwidth" class="input-text" value="">
		</label>
		<label class="field-small">
			<b><?php _e('Height (reqiured)', 'mapplic'); ?></b><br>
			<input type="text" name="new-mapheight" class="input-text" value="">
		</label>
	</div>
	<?php
}

// Built-in Maps
function mapplic_map_type($map) {
	$mapdir = plugins_url() . '/mapplic/maps';
	$maps = array(
		'custom' => '{"mapwidth":"' . $_POST['new-mapwidth'] . '","mapheight":"' . $_POST['new-mapheight'] . '","minimap":false,"clearbutton":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"mousewheel":true,"fullscreen":false,"deeplinking":true,"mapfill":false,"zoom":true,"alphabetic":false,"zoomlimit":"3","action":"tooltip","categories":[],"levels":[{"id":"' . $_POST['new-map-id'] . '","title":"' . $_POST['new-map-name'] . '","map":"' . $_POST['new-map'] . '","minimap":"' . $_POST['new-minimap'] .'","locations":[]}]}',

		'world' => '{"mapwidth":"1200","mapheight":"760","minimap":false,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"4","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"world","title":"World","map":"' . $mapdir . '/world.svg","minimap":"","locations":[{"id":"us","title":"USA","description":"<p>United States</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.2287","y":"0.5149"}]}],"maxscale":4,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'continents' => '{"mapwidth":"400","mapheight":"220","minimap":false,"zoombuttons":false,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"4","mapfill":false,"zoom":false,"alphabetic":false,"categories":[],"levels":[{"id":"continents","title":"Continents","map":"' . $mapdir . '/world-continents.svg","minimap":"","show":"true","locations":[{"id":"europe","title":"Europe","description":"<p>Example landmark.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.5494","y":"0.2492"}]}],"maxscale":4,"clearbutton":true,"mousewheel":false,"deeplinking":false,"fillcolor":"#343f4b","action":"tooltip"}',

		'europe' => '{"mapwidth":"1200","mapheight":"1200","minimap":true,"zoombuttons":true,"sidebar":true,"search":true,"hovertip":true,"fullscreen":false,"zoomlimit":"2","mapfill":true,"zoom":true,"alphabetic":true,"categories":[],"levels":[{"id":"europe","title":"Europe","map":"' . $mapdir . '/europe.svg","minimap":"' . $mapdir . '/europe-mini.jpg","locations":[{"id":"ch","title":"Switzerland","description":"<p>Example country</p>","fill":"#343f4b","category":"false","action":"tooltip","pin":"hidden","x":"0.4085","y":"0.6328"}]}],"maxscale":2,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'usa' => '{"mapwidth":"960","mapheight":"600","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"usa","title":"USA","map":"' . $mapdir . '/usa.svg","minimap":"' . $mapdir . '/usa-mini.jpg","locations":[{"id":"il","title":"Illinois","description":"<p>Example state.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.6226","y":"0.4248"},{"id":"los-angeles","title":"Los Angeles","description":"<p>Welcome to LA!</p>","pin":"circular pin-md pin-label","label":"LA","category":"false","action":"default","x":"0.0898","y":"0.5749","fill":"#937ed7"},{"id":"new-york","title":"New York","description":"<p>Welcome to NY!</p>","pin":"circular pin-md pin-label","label":"NY","category":"false","action":"default","x":"0.8810","y":"0.3339","fill":"#937ed7"},{"id":"ca","title":"California","description":"<p>California state.</p>","pin":"hidden","category":"false","action":"default","x":"0.0806","y":"0.4705"}]}],"maxscale":3,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'canada' => '{"mapwidth":"640","mapheight":"600","minimap":false,"zoombuttons":false,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":false,"alphabetic":false,"categories":[],"levels":[{"id":"canada","title":"Canada","map":"' . $mapdir . '/canada.svg","minimap":"","locations":[{"id":"ca-ab","title":"Alberta","description":"<p>Example province</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.2528","y":"0.6790"}]}],"maxscale":4,"clearbutton":true,"mousewheel":false,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'australia' => '{"mapwidth":"600","mapheight":"540","minimap":false,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"australia","title":"Australia","map":"' . $mapdir . '/australia.svg","minimap":"","locations":[{"id":"qld","title":"Queensland","description":"<p>Example territory.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.7544","y":"0.3667"},{"id":"melbourne","title":"Melbourne","description":"<p>City of Melbourne.</p>","pin":"circular","category":"false","action":"default","x":"0.7586","y":"0.7752"}]}],"maxscale":3,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'france' => '{"mapwidth":"1000","mapheight":"1000","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"2","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"france","title":"France","map":"' . $mapdir . '/france.svg","minimap":"' . $mapdir . '/france-mini.jpg","locations":[{"id":"fr-d18","title":"Department 18","description":"<p>Example department.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.5606","y":"0.4639"}]}],"maxscale":2,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'germany' => '{"mapwidth":"600","mapheight":"800","minimap":false,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"2","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"germany","title":"Germany","map":"' . $mapdir . '/germany.svg","minimap":"","locations":[{"id":"de-ni","title":"Niedersachsen","description":"<p>Example land.</p>","category":"false","action":"tooltip","x":"0.3980","y":"0.2674","pin":"hidden"},{"id":"de-by","title":"Bayern","pin":"hidden","category":"false","action":"tooltip","x":"0.6381","y":"0.7738","description":"<p>Bavaria.</p>"}]}],"maxscale":2,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'uk' => '{"mapwidth":"690","mapheight":"982","minimap":false,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":true,"zoomlimit":"2","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"uk","title":"United Kingdom","map":"' . $mapdir . '/uk.svg","minimap":"","locations":[{"id":"north-west","title":"North West","description":"<p>Example region.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.5437","y":"0.5530"},{"id":"london","title":"London","description":"<p>City of London.</p>","pin":"hidden","category":"false","action":"default","x":"0.7921","y":"0.8223"}]}],"maxscale":2,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'italy' => '{"mapwidth":"800","mapheight":"1000","minimap":false,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"italy","title":"Italy","map":"' . $mapdir . '/italy.svg","minimap":"","locations":[{"id":"tuscany","title":"Tuscany","description":"<p>Example.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.3897","y":"0.3401"},{"id":"milan","title":"Milan","pin":"circular","category":"false","action":"tooltip","x":"0.2379","y":"0.1703"}]}],"maxscale":4,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'switzerland' => '{"mapwidth":"640","mapheight":"420","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"switzerland","title":"Switzerland","map":"' . $mapdir . '/switzerland.svg","minimap":"' . $mapdir . '/switzerland-mini.jpg","locations":[{"id":"BE","title":"Bern","description":"<p>Canton of Bern.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.3680","y":"0.4808"},{"id":"zurich","title":"Zürich","description":"<p>City of Zürich.</p>","pin":"circular pin-md pin-label","category":"false","action":"default","x":"0.5562","y":"0.2341","label":"ZH"}]}],"maxscale":3,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'netherlands' => '{"mapwidth":"598","mapheight":"598","bottomLat":"50.67500192979909","leftLng":"2.8680356443589807","topLat":"53.62609096857893","rightLng":"7.679884929662812","categories":[],"levels":[{"id":"netherlands","title":"Netherlands","map":"' . $mapdir . '/netherlands.svg","minimap":"","locations":[{"id":"nl-ut","title":"Utrecht","about":"Province","description":"<p>Utrecht province description.</p>","pin":"hidden","x":"0.4819","y":"0.5238","category":"false","action":"default"},{"id":"amsterdam","title":"Amsterdam","about":"Capital city","description":"<p>Amsterdam, the capital city.</p>","pin":"transparent pin-md pin-label","link":"http://www.codecanyon.net/user/sekler","lng":"4.896911","lat":"52.373412","x":0.4216415010830731,"y":0.4326147922230017,"label":"AM","fill":"#8224e3","category":"false","action":"lightbox"}]}],"maxscale":3,"minimap":false,"zoombuttons":true,"sidebar":true,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'russia' => '{"mapwidth":"1100","mapheight":"640","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"4","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"russia","title":"Russia","map":"' . $mapdir . '/russia.svg","minimap":"' . $mapdir . '/russia-mini.jpg","locations":[{"id":"YAN","title":"Yamalia","description":"<p>Example</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.4019","y":"0.5905"},{"id":"MOW","title":"Moscow","description":"<p>The capital city.</p>","pin":"circular","category":"false","action":"default","x":"0.1267","y":"0.5924"}]}],"maxscale":4,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'china' => '{"mapwidth":"860","mapheight":"700","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"3","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"china","title":"China","map":"' . $mapdir . '/china.svg","minimap":"' . $mapdir . '/china-mini.jpg","locations":[{"id":"SD","title":"Shandong","description":"<p>Example.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.7626","y":"0.4833"}]}],"maxscale":4,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}',

		'brazil' => '{"mapwidth":"800","mapheight":"800","minimap":true,"zoombuttons":true,"sidebar":false,"search":false,"hovertip":true,"fullscreen":false,"zoomlimit":"2","mapfill":false,"zoom":true,"alphabetic":false,"categories":[],"levels":[{"id":"brazil","title":"Brazil","map":"' . $mapdir . '/brazil.svg","minimap":"' . $mapdir . '/brazil-mini.jpg","locations":[{"id":"br-ba","title":"Bahia","description":"<p>Bahia state.</p>","category":"false","action":"tooltip","pin":"hidden","x":"0.7964","y":"0.4429"}]}],"maxscale":2,"clearbutton":true,"mousewheel":true,"deeplinking":true,"fillcolor":"#343f4b","action":"tooltip"}'
	);
	
	return $maps[$map];
}