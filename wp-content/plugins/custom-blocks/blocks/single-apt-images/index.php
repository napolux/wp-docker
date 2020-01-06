<?php

namespace DavidYeiser\Detailer\Blocks\BookDetails;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block_sai');

function register_dynamic_block_sai() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('davidyeiser-detailer/single-apt-images', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block_sai'
  ));
}

function render_dynamic_block_sai($attributes) {
  // Parse attributes
  $imageUrlFloorplan = $attributes['imageUrlFloorplan'];
  $imageIdFloorplan = $attributes['imageIdFloorplan'];
  $imageUrlAspect = $attributes['imageUrlAspect'];
  $imageIdAspect = $attributes['imageIdAspect'];
  $imageUrlViews = $attributes['imageUrlViews'];
  $imageIdViews = $attributes['imageIdViews'];

  ob_start(); // Turn on output buffering

  /* BEGIN HTML OUTPUT */
?>
  <div class="block-single-imaage" data-toggle="modal" data-target="#gallery-modal-floorplan" data-img-num="1">
    <?php echo wp_get_attachment_image( $imageIdFloorplan, array('700', '600'), "", array( "class" => "img-responsive" ) );  ?>
  </div>
  <div class="block-single-imaage" data-toggle="modal" data-target="#gallery-modal-aspect" data-img-num="2">
    <?php echo wp_get_attachment_image( $imageIdAspect, array('700', '600'), "", array( "class" => "img-responsive" ) );  ?>
  </div>
  <div class="block-single-imaage" data-toggle="modal" data-target="#gallery-modal-views" data-img-num="3">
    <?php echo wp_get_attachment_image( $imageIdViews, array('700', '600'), "", array( "class" => "img-responsive" ) );  ?>
  </div>

      <!-- Modal -->
      <div class="modal fade" id="gallery-modal-floorplan" tabindex="-1" role="dialog" aria-labelledby="gallery-modalTitle"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="spinner-border-wrapper">
                    <div class="spinner-border" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>

                  <div class="modal-body">
                    <img class="d-block w-100 my-img-modal" src="<?php echo $imageUrlFloorplan ?>">
                  </div>
                </div>
              </div>
       </div>
       <div class="modal fade" id="gallery-modal-aspect" tabindex="-1" role="dialog" aria-labelledby="gallery-modalTitle"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="spinner-border-wrapper">
                    <div class="spinner-border" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>

                  <div class="modal-body">
                    <img class="d-block w-100 my-img-modal" src="<?php echo $imageUrlAspect ?>">
                  </div>
                </div>
              </div>
       </div>
       <div class="modal fade" id="gallery-modal-views" tabindex="-1" role="dialog" aria-labelledby="gallery-modalTitle"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="spinner-border-wrapper">
                    <div class="spinner-border" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>

                  <div class="modal-body">
                    <img class="d-block w-100 my-img-modal" src="<?php echo $imageUrlViews ?>">
                  </div>
                </div>
              </div>
       </div>
<?php
  /* END HTML OUTPUT */

  $output = ob_get_contents(); // collect output
  ob_end_clean(); // Turn off ouput buffer

  return $output; // Print output
}
