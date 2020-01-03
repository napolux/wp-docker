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
    <a class="button is-checked" data-filter="*">All Stories</a>
    <a class="button" data-filter=".flatiron">flatiron stories</a>
    <a class="button" data-filter=".happenings">Happenings</a>
    <a class="button" data-filter=".press">Press</a>
  </div>






                         <div class="grid col-lg-10 mx-auto">
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
				echo '<a href="' . get_the_permalink() .'" rel="bookmark"><div class="element-item '. $post_categories .'">';
				echo get_the_post_thumbnail($post_id, "story-size") ;
				echo '<h3>';
				echo get_the_title() ;
				echo '</h3></div></a>';
            } else {
				echo '<a href="' . get_the_permalink() .'" rel="bookmark"><div class="element-item '. $post_categories .'"><img src="https://www.fillmurray.com/300/150" />';
				echo '';
				echo get_the_title() ;
				echo '</div></a>';			}


endwhile;
					?>

					</div>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- #content -->

</div><!-- #full-width-page-wrapper -->

<?php get_footer();
