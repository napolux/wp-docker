<?php
/**
 * Template Name: Stories page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() ) : ?>
  <?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>


<div class="wrapper" id="full-width-page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">
				<div class="filter-button-group button-group js-radio-button-group">
    <button class="button is-checked" data-filter="*">All Stories</button>
    <button class="button" data-filter=".flatiron">flatiron stories</button>
    <button class="button" data-filter=".happenings">Happenings</button>
    <button class="button" data-filter=".press">Press</button>
  </div>






                         <div class="grid">
					<?php
					$post_id = 0;
					$catquery = new WP_Query( 'posts_per_page=25' );
					while($catquery->have_posts()) : $catquery->the_post();
					$cats = array();
foreach (get_the_category($post_id) as $c) {
$cat = get_category($c);
array_push($cats, $cat->slug);
}

if (sizeOf($cats) > 0) {
$post_categories = implode(' ', $cats);
} else {
$post_categories = 'Not Assigned';
}


            if ( has_post_thumbnail() ) {
				echo '<div class="element-item '. $post_categories .'">';
				echo get_the_post_thumbnail($post_id, array( 300, 150) ) ;
				echo '<a href="' . get_the_permalink() .'" rel="bookmark">';
				echo get_the_title() ;
				echo '</a></div>';
            } else {
				echo '<div class="element-item '. $post_categories .'"><img src="https://www.fillmurray.com/300/150" />';
				echo '<a href="' . get_the_permalink() .'" rel="bookmark">';
				echo get_the_title() ;
				echo '</a></div>';			}


endwhile;
					?>

					</div>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- #content -->

</div><!-- #full-width-page-wrapper -->

<?php get_footer();
