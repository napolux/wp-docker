<?php

/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<table id="apartments" class="display apartments-table">
    <thead>
        <tr>
            <th class="hide_on_table">Thumbnail</th>
            <th class="align_left">Residence</th>
            <th><span>floor</span></th>
            <th><span>Bed</span></th>
            <th><span>Bath</span></th>
            <th><span>sq ft/sq m</span></th>
            <th><span>ext sq ft</span></th>
            <th><span>com char</span></th>
            <th><span>exp</span></th>
            <th class="hide_on_table">Price</th>
            <th><span>Favourites</span></th>
        </tr>
    </thead>
    <tbody>

<?php

the_content();

?>

</tbody>
</table>


