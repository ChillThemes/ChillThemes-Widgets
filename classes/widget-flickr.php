<?php

/* Register the Flickr widget. */
function ChillThemes_Load_Flickr_Widget() {
	register_widget( 'ChillThemes_Widget_Flickr' );
}
add_action( 'widgets_init', 'ChillThemes_Load_Flickr_Widget' );

/* Flickr widget class. */
class ChillThemes_Widget_Flickr extends WP_Widget {

	/* Set up the widget's unique name, ID, class, description, and other options. */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'widget-flickr',
			'description' => esc_html__( 'Display your Flickr images on your site.', 'ChillThemes' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'chillthemes-flickr', /* Widget ID. */
			__( 'ChillThemes Flickr', 'ChillThemes' ), /* Widget name. */
			$widget_options, /* Widget options. */
			$control_options /* Control options. */
		);
	}

	/* Outputs the widget based on the arguments input through the widget controls. */
	function widget( $args, $instance ) {
		extract( $args );

		/* Arguments for the widget. */
		$args['limit'] = strip_tags( $instance['limit'] );
		$args['display'] = $instance['display'];
		$args['type'] = $instance['type'];
		$args['id'] = $instance['id'];

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

			echo '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=' . intval( $args['limit'] ) . '&amp;display=' . esc_attr( $args['display'] ) . '&amp;size=s&amp;layout=x&amp;source=' . esc_attr( $args['type'] ) . '&amp;' . esc_attr( $args['type'] ) . '=' . esc_attr( $args['id'] ) . '"></script>';

		/* Close the theme's widget wrapper. */
		echo $after_widget;

	}

	/* Updates the widget control options for the particular instance of the widget. */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance = $new_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['id'] = $new_instance['id'];
		$instance['limit'] = strip_tags( $new_instance['limit'] );
		$instance['type'] = $new_instance['type'];
		$instance['display'] = $new_instance['display'];

		return $instance;
	}

	/* Displays the widget control options in the Widgets admin screen. */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => 'Flickr Images',
			'id' => '59319377@N00',
			'limit' => '4',
			'type' => 'group',
			'display' => 'latest',
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

		/* Select element options. */
		$display = array( 'latest' => esc_attr__( 'Latest', 'ChillThemes' ), 'random' => esc_attr__( 'Random', 'ChillThemes' ) );
		$type = array( 'group' => esc_attr__( 'Group', 'ChillThemes' ), 'user' => esc_attr__( 'User', 'ChillThemes' ) );

	?>

		<div class="widget-controls">

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'ID:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo esc_attr( $instance['id'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo esc_attr( $instance['limit'] ); ?>" type="number" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e( 'Display:', 'ChillThemes' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>">
					<?php foreach ( $display as $option_value => $option_label ) { ?>
						<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['display'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php } ?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type:', 'ChillThemes' ); ?></label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>">
					<?php foreach ( $type as $option_value => $option_label ) { ?>
						<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['type'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php } ?>
				</select>
			</p>

		</div><!-- .widget-controls -->

		<div style="clear: both;">&nbsp;</div>

	<?php } } ?>