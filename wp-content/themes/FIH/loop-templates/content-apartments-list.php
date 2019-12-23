<?php

/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<table id="apartments" class="display">
    <thead>
        <tr>
            <th>Thumbnail</th>
            <th>Residence</th>
            <th>floor</th>
            <th>Bed</th>
            <th>Bath</th>
            <th>sq ft/sq m</th>
            <th>ext sq ft</th>
            <th>com char</th>
            <th>exp</th>
            <th>Price</th>
            <th>Favourites</th>
        </tr>
    </thead>
    <tbody>

<?php

the_content();

?>

</tbody>
</table>


