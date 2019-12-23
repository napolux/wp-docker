<?php
/**
 * Mapplic Plugin
 *
 * Creating a new database table called [pre]-custommaps.
 *
 */

global $custommap_db_version;
$custommap_db_version = '1.2';

// Creating database
function custommap_install() {
	global $wpdb;
	global $custommap_db_version;

	$table = $wpdb->prefix . 'custommaps';

	$sql = "CREATE TABLE $table (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		title text COLLATE utf8_unicode_ci NOT NULL,		
		data mediumtext COLLATE utf8_unicode_ci NOT NULL,
		width smallint DEFAULT '0',
		height smallint DEFAULT '0',
		status tinyint DEFAULT '1' NOT NULL,
		UNIQUE KEY id (id)
	);";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

	update_option('custommap_db_version', $custommap_db_version);

	if (get_option('custommap_activatted') == false) {
		custommap_install_data();
	}

	update_option('custommap_activatted', time());
}

// Adding initial data
function custommap_install_data() {
	global $wpdb;
	$table = $wpdb->prefix . 'custommaps';

	$exampledir = plugins_url() . '/mapplic/images/examples';
	$mapdir = plugins_url() . '/mapplic/maps';

	// US Example 
	$wpdb->insert(
		$table,
		array(
			'title' => '[Example] US States',
			'data' => '{"mapwidth":"959","mapheight":"593","minimap":"true","sidebar":false,"search":false,"hovertip":"true","zoomlimit":"4","categories":[],"levels":[{"id":"states","title":"States","map":"' . $mapdir . '/usa.svg","minimap":"' . $mapdir . '/usa-mini.jpg","locations":[{"id":"ca","title":"California","description":"<p><iframe src=\"http://www.youtube.com/embed/ebXbLfLACGM?list=FLlobg636ZD_FWo-rtCf17Fw\" width=\"240\" height=\"135\" frameborder=\"0\" allowfullscreen=\"allowfullscreen\"></iframe></p>","link":"http://en.wikipedia.org/wiki/California","pin":"hidden","x":"0.0718","y":"0.4546","category":null,"zoom":""},{"id":"wa","title":"Washington","description":"<p>The Evergreen State</p>","link":"http://en.wikipedia.org/wiki/Washington_(state)","pin":"hidden","x":"0.1331","y":"0.0971"},{"id":"nv","title":"Nevada","description":"Nevada is officially known as the \"Silver State\" due to the importance of silver to its history and economy","link":"http://en.wikipedia.org/wiki/Nevada","pin":"hidden","x":"0.1484","y":"0.3973"},{"id":"il","title":"Illinois","description":"<p>Three U.S. presidents have been elected while living in Illinois</p>","link":"http://en.wikipedia.org/wiki/Illinois","pin":"hidden","x":"0.6207","y":"0.4316","category":null,"zoom":""},{"id":"ny","title":"New York","description":"New York is a state in the Northeastern and Mid-Atlantic regions of the United States.","link":"http://en.wikipedia.org/wiki/NewYork","pin":"hidden","x":"0.8469","y":"0.2680"},{"id":"ma","title":"Massachusetts","description":"Officially the Commonwealth of Massachusetts, is a state in the New England region of the northeastern United States.","link":"http://en.wikipedia.org/wiki/Massachusetts","pin":"hidden","x":"0.9046","y":"0.2625"},{"id":"ga","title":"Georgia","description":"Georgia is known as the Peach State and the Empire State of the South.","link":"http://en.wikipedia.org/wiki/Georgia_(U.S._state)","pin":"hidden","x":"0.7515","y":"0.6885"},{"id":"fl","title":"Florida","description":"The state capital is Tallahassee, the largest city is Jacksonville, and the largest metropolitan area is the Miami metropolitan area.","link":"http://en.wikipedia.org/wiki/Florida","pin":"hidden","x":"0.7998","y":"0.8486"},{"id":"tx","title":"Texas","description":"<p>The Lone Star State <a href=\"http://www.codecanyon.net\">Canyon</a></p>","link":"http://en.wikipedia.org/wiki/Texas","pin":"hidden","x":"0.4511","y":"0.7694","zoom":"2","category":null},{"id":"la","title":"Los Angeles","description":"<p>The city of Angels</p>","x":"0.0892","y":"0.5742","zoom":"2"},{"id":"houston","title":"Houston","description":"<p>Space City</p>","x":"0.4959","y":"0.8127","zoom":"2"},{"id":"chicago","title":"Chicago","description":"<p>The windy city</p>","x":"0.6410","y":"0.3489","zoom":"2"},{"id":"newyork","title":"New York","description":"<p>The big apple</p>","x":"0.8821","y":"0.3322","zoom":"2"}]}]}'
		)
	);

	// Mall Example
	$wpdb->insert(
		$table,
		array(
			'title' => '[Example] Mall',
			'data' => '{"mapwidth":"1000","mapheight":"600","categories":[{"id":"food","title":"Fast-foods & Restaurants","color":"#b7a6bd","show":"false"},{"id":"dep","title":"Department Stores","color":"#b7a6bd"},{"id":"clothing","title":"Clothing & Accessories","color":"#b7a6bd"},{"id":"health","title":"Health & Cosmetics","color":"#b7a6bd"},{"id":"misc","title":"Miscellaneous","color":"#b7a6bd"}],"levels":[{"id":"basement","title":"Basement","map":"' . $exampledir . '/mall/mall-underground.svg","minimap":"' . $exampledir . '/mall/mall-underground-mini.jpg","locations":[{"id":"gap","title":"GAP","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.3781","y":"0.4296","pin":"hidden","link":"","zoom":""},{"id":"petco","title":"Petco","description":"<p>Lorem ipsum</p>","category":"misc","x":"0.5163","y":"0.3050","pin":"hidden","link":"","zoom":""}]},{"id":"ground","title":"Ground Floor","map":"' . $exampledir . '/mall/mall-ground.svg","minimap":"' . $exampledir . '/mall/mall-ground-mini.jpg","show":"true","locations":[{"id":"sears","title":"Sears","description":"<p>Sears depártment store</p>","category":"dep","x":"0.7929","y":"0.2731","zoom":"3","pin":"hidden","link":""},{"id":"macys","title":"Macy\'s","description":"<p>Macy\'s <i>department</i> store</p>","category":"dep","x":"0.2021","y":"0.5844","zoom":"3","pin":"hidden","link":"","actionx":"open-link-new-tab"},{"id":"jcpenney","title":"JCPenney","description":"<p>JCPenney department store</p>","category":"dep","x":"0.6713","y":"0.6561","zoom":"3","pin":"hidden","link":""},{"id":"walgreens","title":"Walgreens","description":"<p>At the corner of Happy &amp; Healthy</p>","category":"health","x":"0.4585","y":"0.5309","pin":"hidden","link":"","zoom":"","action":"none"},{"id":"sephora","title":"Sephora","description":"<p>Makeup, fragrance, skincare</p>","category":"health","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.7506","y":"0.5212","pin":"hidden","zoom":""},{"id":"belk","title":"Belk","description":"<p>Lorem ipsum</p>","category":"clothing","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.3946","y":"0.5438","pin":"hidden","zoom":""},{"id":"hnm","title":"H&M","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.5407","y":"0.5153","pin":"hidden","link":"http://codecanyon.net/user/sekler?ref=sekler","zoom":"","action":"open-link","fill":""},{"id":"oldnavy","title":"Old Navy","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.3686","y":"0.3896","pin":"hidden","link":"","zoom":"","action":"open-link-new-tab","fill":""},{"id":"sportchek","title":"Sport Chek","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.6239","y":"0.3055","pin":"hidden","link":"","zoom":""},{"id":"starbucks","title":"Starbucks","description":"<p>The coffee company</p>","category":"food","x":"0.6445","y":"0.4483","pin":"hidden","link":"http://codecanyon.net/user/sekler?ref=sekler","zoom":"","action":"open-link-new-tab","fill":""},{"id":"zara","title":"Zara","description":"<p>Lorem ipsum</p>","category":"clothing","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.4779","y":"0.3122","pin":"hidden","zoom":"","fill":"","action":"tooltip"}]},{"id":"first","title":"First Floor","map":"' . $exampledir . '/mall/mall-level1.svg","minimap":"' . $exampledir . '/mall/mall-level1-mini.jpg","locations":[{"id":"applebees","title":"Applebee\'s","description":"<p>See you tomorrow</p>","category":"food","x":"0.7465","y":"0.2769","pin":"hidden","link":"","zoom":""},{"id":"kfc","title":"KFC","description":"<p>Kentucky Fried Chicken</p>","category":"food","x":"0.7488","y":"0.4997","pin":"hidden","link":"","zoom":""},{"id":"mcdonalds","title":"McDonald\'s","description":"<p>Additional information</p>","category":"food","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.7374","y":"0.3918","pin":"hidden","zoom":""},{"id":"pizzahut","title":"Pizza Hut","description":"<p>Make it great</p>","category":"food","x":"0.6267","y":"0.3151","pin":"hidden","link":"","zoom":""},{"id":"subway","title":"Subway","description":"<p>Eat fresh.</p>","category":"food","x":"0.7092","y":"0.5232","pin":"hidden","link":"","zoom":""},{"id":"cvs","title":"CVS Pharmacy","description":"<p>Lorem ipsum <a href=\"http://www.codecanyon.net\">dolor sit</a> amet, consectetur.</p>","category":"health","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.5104","y":"0.2771","pin":"hidden","zoom":""},{"id":"pullnbear","title":"Pull & Bear","description":"<p>Lorem ipsum</p>","category":"clothing","x":"0.4846","y":"0.3246","pin":"hidden","link":"","zoom":""},{"id":"amc","title":"AMC Theatres","description":"<p>Additional information</p>","category":"misc","x":"0.6640","y":"0.6426","pin":"hidden","link":"","zoom":""},{"id":"atnt","title":"AT&T","description":"<p>Additional information</p>","category":"misc","actionx":"open-link-new-tab","x":"0.3750","y":"0.5391","pin":"hidden","link":"","zoom":""}]}],"maxscale":4,"minimap":"true","zoombuttons":"true","sidebar":"true","search":"true","hovertip":"true","fullscreen":"true","zoomlimit":"4","mapfill":false,"zoom":"true","alphabetic":"true"}'
		)
	);

	// Apartment Example
	$wpdb->insert(
		$table,
		array(
			'title' => '[Example] Apartment',
			'data' => '{"mapwidth":"2000","mapheight":"2000","minimap":"true","sidebar":"true","search":"true","hovertip":"true","zoomlimit":"1","categories":[{"id":"furniture","title":"Furniture","color":"#4cd3b8","show":"false"},{"id":"rooms","title":"Rooms","color":"#63aa9c"}],"levels":[{"id":"lower","title":"Lower","map":"' . $exampledir . '/apartment/lower.jpg","minimap":"' . $exampledir . '/apartment/lower-small.jpg","locations":[{"id":"coffeetable","title":"Coffee Table","description":"<p>This is an awesome coffee table.</p><p><!--more--></p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean viverra laoreet imperdiet. Praesent viverra, enim at malesuada dignissim, ante purus vestibulum turpis, nec molestie ipsum mauris non risus. In hac habitasse platea dictumst. Integer porta dignissim magna, at sollicitudin neque aliquam eget. Pellentesque dapibus, augue eu ornare mattis, est mauris volutpat ligula.</p>","category":"furniture","link":"http://codecanyon.net/user/sekler?ref=sekler","x":"0.2067","y":"0.4660","zoom":"3","pin":""},{"id":"stairstop","title":"Stairs","description":"Let\'s go upstairs!","category":"furniture","x":"0.5137","y":"0.6136","zoom":"3"},{"id":"diningtable","title":"Dining Table","description":"<p>An eight-person dining table with an image.</p>","category":"rooms","x":"0.4746","y":"0.2883","zoom":"3","link":"","pin":""},{"id":"coffeemachine","title":"Coffee Machine","description":"Coffee Machine","category":"furniture","x":"0.6792","y":"0.3459","zoom":"3"},{"id":"workingtable","title":"Working Table","description":"It\'s the perfect home workspace you\'ve always dreamed about.","category":"furniture","x":"0.6285","y":"0.1480","zoom":"3"},{"id":"kitchen","title":"Kitchen","description":"<p>Welcome to the kitchen.</p>","category":"rooms","link":"http://codecanyon.net/user/sekler?ref=sekler","pin":"hidden","x":"0.665","y":"0.46","zoom":"3"},{"id":"dining","title":"Dining room","description":"The main living room <!--<iframe width=\"320\" height=\"180\" src=\"//www.youtube.com/embed/HGy9i8vvCxk\" frameborder=\"0\" allowfullscreen></iframe>-->","category":"rooms","pin":"hidden","x":"0.3","y":"0.4","zoom":"3"}]},{"id":"upper","title":"Upper","map":"' . $exampledir . '/apartment/upper.jpg","minimap":"' . $exampledir . '/apartment/upper-small.jpg","locations":[{"id":"livingup","title":"Living room","description":"<p>I could spend the whole day here!</p>","category":"rooms","x":"0.4900","y":"0.3600","zoom":"2","link":"","pin":""},{"id":"kingbed","title":"King bed","description":"A king size bed situated in the main bedroom on the first floor.","category":"furniture","x":"0.6564","y":"0.2782","zoom":"3"},{"id":"bathroom","title":"Bathroom","description":"Take a bath","category":"rooms","pin":"hidden","x":"0.7843","y":"0.4035","mapfill":"true","zoom":"3"}]}]}'
		)
	);
}
register_activation_hook(__FILE__, 'custommap_install');

function custommap_update_db_check() {
	global $custommap_db_version;
	if (get_option('custommap_db_version') != $custommap_db_version) {
		custommap_install();
	}
}
add_action('plugins_loaded', 'custommap_update_db_check');