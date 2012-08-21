<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * bizone-cafepress Info Widget
 *
 * Adds cafepress description.
 *
 * @since bizone-cafepress (v0.1)
 *
 * @uses WP_Widget
 */
class BZC_Info_Widget extends WP_Widget {
	public function __construct() {
		$widget_ops = apply_filters( 'bzc_info_widget_options', array(
			'classname'   => 'bzc_widget_info',
			'description' => 'Bizone Cafepress description.'
		) );
		
		parent::__construct( false, '(BizoneCafepress) Info Widget', $widget_ops );
	}
}

/**
 * bizone-cafepress Counter Widget
 *
 * Counter widget
 *
 * @since bizone-cafepress (v0.1)
 * 
 * @uses WP_Widget
 */
class BZC_Counter_Widget extends WP_Widget {
	public function __construct() {
	    $widget_ops = apply_filters( 'bzc_counter_widget_options', array(
			'classname'   => 'bzc_widget_counter',
			'description' => 'Bizone Cafepress counter.'
		) );
		
		parent::__construct( false, '(BizoneCafepress) Counter Widget', $widget_ops );
	}

	public function register_widget() {
		register_widget( 'BZC_Counter_Widget' );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters( 'bzc_counter_widget_title', $instance['title'] );
		$count = apply_filters( 'bzc_counter_widget_count', $instance['count'] );

		?>
		<h3 class="widget-title"><?php echo $title; ?></h3>
		<h3 class="widget-title"><?php echo $count; ?></h3>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = is_numeric( $new_instance['count'] ) ? $new_instance['count'] : '0';
		
		return $instance;
	}

	public function form( $instance ) {
		$title = !empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$count = !empty( $instance['count'] ) ? $instance['count'] : '0'; ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>">Count:
				<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo $count; ?>" />
			</label>
		</p>
		<?php
	}
}
?>
