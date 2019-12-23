<?php
/**
 * Template Name: Front page
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

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'loop-templates/content', 'page' ); ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>

                    <?php endwhile; // end of the loop. ?>
                    <div class="col-lg-12 mx-auto text-center bg-light-grey py-2">
	<?php

$args = array( 'posts_per_page' => 3, 'post__not_in' => array( $post->ID ) );

$the_query = new WP_Query( $args );

if ( $the_query->have_posts() ) :
	echo '<h1> Stories </h1><div class="stories-block">';
	while ( $the_query->have_posts() ) : $the_query->the_post();
	echo '<div><a href="' . get_permalink() . '">';
	echo get_the_post_thumbnail( $post->ID, 'thumbnail' );
	$category = get_the_category();
	echo '<div><h2 class="golden-text">' . $category[0]->cat_name . '</h2>';
		the_title();
		echo '</div></a></div>';
	endwhile;
	echo '</div><a class="wp-block-button__link wp-block-button__link__onwhite my-5" href="./stories/">Read all stories </a>';
else:
    _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
endif;

wp_reset_postdata();

		?>
</div>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- #content -->

</div><!-- #full-width-page-wrapper -->

<?php get_footer();
