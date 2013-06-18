<?php

/* Register the Feedburner widget. */
function ChillThemes_Load_Feedburner_Widget() {
	register_widget( 'ChillThemes_Widget_Feedburner' );
}
add_action( 'widgets_init', 'ChillThemes_Load_Feedburner_Widget' );

/* Feedburner widget class. */
class ChillThemes_Widget_Feedburner extends WP_Widget {

	/* Set up the widget's unique name, ID, class, description, and other options. */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'widget-feedburner',
			'description' => esc_html__( 'Display a subscription form for your Google/Feedburner account.', 'ChillThemes' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'chillthemes-feedburner', /* Widget ID. */
			__( 'ChillThemes Feedburner', 'ChillThemes' ), /* Widget name. */
			$widget_options, /* Widget options. */
			$control_options /* Control options. */
		);
	}

	/* Outputs the widget based on the arguments input through the widget controls. */
	function widget( $sidebar, $instance ) {
		extract( $sidebar );

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		/* If a description was input by the user, display it. */
		if ( !empty( $instance['description'] ) )
			echo '<p class="widget-description">' . apply_filters( 'widget_description',  $instance['description'], $instance, $this->id_base ) . '</p>';

	?>

		<div class="newsletter-wrap">

			<form action="http://feedburner.google.com/fb/a/mailverify" method="post">
				<input class="newsletter-text" name="email" placeholder="<?php echo esc_attr( $instance['placeholder'] ); ?>" type="text" required />
				<button class="newsletter-submit" type="submit"><?php echo esc_attr( $instance['input_text'] ); ?></button>
				<input value="<?php echo esc_attr( $instance['id'] ); ?>" name="uri" type="hidden" />
				<input name="loc" value="en_US" type="hidden" />
			</form>

		</div><!-- .newsletter-wrap -->

	<?php

		/* Close the theme's widget wrapper. */
		echo $after_widget;

	}

	/* Updates the widget control options for the particular instance of the widget. */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance = $new_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		if ( !current_user_can( 'unfiltered_html' ) ) { $instance['description'] = $new_instance['description']; }
		$instance['id'] = strip_tags( $new_instance['id'] );
		$instance['placeholder'] = strip_tags( $new_instance['placeholder'] );

		return $instance;
	}

	/* Displays the widget control options in the Widgets admin screen. */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => 'Feedburner',
			'description' => 'Enter your email address to subscribe to this blog and receive notifications of new posts by email.',
			'id' => '',
			'placeholder' => 'you@email.com',
			'input_text' => 'Subscribe'
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

	?>

		<div class="widget-controls">

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:', 'ChillThemes' ); ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" rows="4" <?php if( !current_user_can( 'unfiltered_html' ) ) { echo 'readonly="readonly"'; } else { echo ''; } ?>><?php echo $instance['description']; ?></textarea>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'id' ); ?>"><?php _e( 'Google/Feedburner ID:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" value="<?php echo esc_attr( $instance['id'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'placeholder' ); ?>"><?php _e( 'Placeholder:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'placeholder' ); ?>" name="<?php echo $this->get_field_name( 'placeholder' ); ?>" value="<?php echo esc_attr( $instance['placeholder'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'input_text' ); ?>"><?php _e( 'Input Text:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'input_text' ); ?>" name="<?php echo $this->get_field_name( 'input_text' ); ?>" value="<?php echo esc_attr( $instance['input_text'] ); ?>" type="text" />
			</p>

		</div><!-- .widget-controls -->

		<div style="clear: both;">&nbsp;</div>

	<?php } } ?>