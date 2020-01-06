<?php

namespace DavidYeiser\Detailer\Blocks\BookDetails;

add_action('plugins_loaded', __NAMESPACE__ . '\register_dynamic_block');

function register_dynamic_block() {
  // Only load if Gutenberg is available.
  if (!function_exists('register_block_type')) {
    return;
  }

  // Hook server side rendering into render callback
  // Make sure name matches registerBlockType in ./index.js
  register_block_type('davidyeiser-detailer/banner', array(
    'render_callback' => __NAMESPACE__ . '\render_dynamic_block'
  ));
}

function render_dynamic_block($attributes) {
  // Parse attributes
  $banner_title = $attributes['title'];
  $banner_copy = $attributes['copy'];
  $banner_cta_copy = $attributes['callToActionCopy'];
  $banner_cta_url = $attributes['ctaUrl'];
  $banner_image_url = $attributes['imageUrl'];
  $banner_image_alt = $attributes['imageAlt'];
  $banner_alignment = $attributes['alignment'];

  ob_start(); // Turn on output buffering

  /* BEGIN HTML OUTPUT */
?>
  <div class="block-banner container <?php echo $banner_alignment ?>" >
      <div>
      <img src="<?php echo $banner_image_url ?>" alt="<?php echo $banner_image_alt ?>">
      <div>
    <h3 class="block-banner-title"><?php echo $banner_title ?></h3>
    <div class="block-banner-copy"><?php echo $banner_copy ?></div>

    <a class="wp-block-button__link wp-block-button__link__onwhite" href="<?php echo $banner_cta_url ?>">  <?php echo $banner_cta_copy ?> </a>
       </div>
    </div>
  </div>
<?php
  /* END HTML OUTPUT */

  $output = ob_get_contents(); // collect output
  ob_end_clean(); // Turn off ouput buffer

  return $output; // Print output
}
