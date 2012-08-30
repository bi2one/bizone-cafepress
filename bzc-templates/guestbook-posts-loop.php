<?php

/**
 * cafePress - Guestbook Posts Loop
 *
 * @package cafePress
 */
?>

<?php if ( bzc_has_guestbook_posts() ) : ?>
<ul id="posts-list" class="item-list" role="main">
	<?php while ( bzc_guestbook_posts() ) : bzc_the_guestbook_post(); ?>
	<li>
		<div class="item-content">
			Contents: <?php bzc_guestbook_post_content(); ?>
		</div>
		<div class="item-user">
			Author: <?php bzc_guestbook_post_user_nicename(); ?>
		</div>
		<div class="item-date">
			Published: <?php bzc_guestbook_post_pub_date(); ?>
		</div>
		<div class="item-delete">
			<a href="<?php bzc_guestbook_post_remove_url() ?>">삭제</a>
		</div>
		<div class="clear"></div>
	</li>
	<?php endwhile; ?>
</ul>
<?php endif; ?>
