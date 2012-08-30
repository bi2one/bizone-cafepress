<?php
/**
 * Board Posts Message
 */

$message_id = $_GET['message'];
$message = null;
switch( $message_id ) {
	case 1:
		$message = '등록 성공';
		break;
	case 2:
		$message = '제거 성공';
		break;
	default:
}
?>

<div id="bzc-message">
	<?php echo $message ?>
</div>
