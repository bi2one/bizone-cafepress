<?php
/**
 * Template Name: cafePress - guestbook
 *
 * @package cafePress
 * @subpackage Theme
 */
get_header(); ?>

<div id="guestbook" style="margin-bottom:20px;">
	<?php bzc_get_template_part( 'loop', 'bzc-page' ); ?>
	<?php do_action( 'bzc_template_notices' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>
	<div>
	<?php the_content(); ?>
	</div>
	<?php endwhile; ?>

</div>
<?php get_footer(); ?>
