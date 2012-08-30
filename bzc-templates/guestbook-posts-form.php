<?php

/**
 * cafePress - Guestbook Posts Form
 *
 * @package cafePress
 */
?>

<form method="post" name="guestbook-posts-form" id="guestbook-posts-form" action="<?php bzc_guestbook_posts_form_action(); ?>">
	<div id="guestbook-textarea">
		<textarea name="guestbook-content" id="guestbook-content" cols="50" rows="2"></textarea>
	</div>
	<input type="submit" value="작성하기" />
</form>
