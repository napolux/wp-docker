<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
<a class="nav-icon back" onclick="goBack()">Back</a>

<script>
function goBack() {
  window.history.back();
}
</script>

	<header class="entry-header col-lg-8 mx-auto">


		<?php the_title( '<h1 class="entry-title col-lg-4">', '</h1>' ); ?>

		<div class="entry-meta col-lg-4 mx-auto text-center">

		By	 <?php the_author_meta( 'user_firstname' ) ?> <?php the_author_meta( 'user_lastname' );?>

		</div><!-- .entry-meta -->
	<div class="mx-auto text-center">	<?php echo get_the_post_thumbnail( $post->ID ); ?> </div>

	</header><!-- .entry-header -->



	<div class="entry-content col-lg-6 mx-auto">

		<?php the_content(); ?>



	</div><!-- .entry-content -->
	<div class="col-lg-12 mx-auto text-center">
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



</article><!-- #post-## -->
