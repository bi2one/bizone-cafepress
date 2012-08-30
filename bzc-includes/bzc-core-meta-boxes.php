<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function bzc_submit_meta_box() {
	$can_publish = current_user_can( 'activate_plugins' );
	if ( ! $can_publish ) {
		return ;
	}
	?>
	<div class="submitbox" id="submitboard">
		<div id="minor-publishing">
			<div style="display:none;">
				<?php submit_button( 'Save', 'button', 'save' ); ?>
			</div>
		</div>
		<div id="major-publishing-actions">
			<div id="delete-action">
				<a class="submitdelete deletion" href="<?php echo bzc_get_delete_board_link( $_REQUEST['board'] ) ?>">Delete</a>
			</div>
			<div id="publishing-action">
				<img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ); ?>" class="ajax-loading" id="ajax-loading" alt="" />
				<input name="original_publish" type="hidden" id="original_publish" value="<?php esc_attr_e('Publish') ?>" />
				<?php submit_button( 'Publish', 'primary', 'publish', false, array( 'tabindex' => '5', 'accesskey' => 'p' ) ); ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<?php
}
?>
