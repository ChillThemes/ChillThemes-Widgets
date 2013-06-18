<?php

/* Register the MailChimp widget. */
function ChillThemes_Load_MailChimp_Widget() {
	register_widget( 'ChillThemes_Widget_MailChimp' );
}
add_action( 'widgets_init', 'ChillThemes_Load_MailChimp_Widget' );

/* MailChimp widget class. */
class ChillThemes_Widget_MailChimp extends WP_Widget {

	/* Set up the widget's unique name, ID, class, description, and other options. */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'widget-mailchimp',
			'description' => esc_html__( 'Display a subscription form for your MailChimp account.', 'ChillThemes' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'chillthemes-mailchimp', /* Widget ID. */
			__( 'ChillThemes MailChimp', 'ChillThemes' ), /* Widget name. */
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

			<form action="<?php echo esc_url( $instance['url'] ); ?>" class="validate" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" method="post" target="_blank" novalidate>
				<input class="email newsletter-text" id="mce-EMAIL" name="EMAIL" placeholder="<?php echo esc_attr( $instance['placeholder'] ); ?>" type="email" value="" required>
				<button class="newsletter-submit"  id="mc-embedded-subscribe" name="subscribe" type="submit"><?php echo esc_attr( $instance['input_text'] ); ?></button>
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
		$instance['url'] = strip_tags( $new_instance['url'] );
		$instance['placeholder'] = strip_tags( $new_instance['placeholder'] );
		$instance['input_text'] = strip_tags( $new_instance['input_text'] );

		return $instance;
	}

	/* Displays the widget control options in the Widgets admin screen. */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => 'MailChimp',
			'description' => 'Subscribe to our newsletter to stay up to date. Your email address will never be shared, nor spammed, we promise!',
			'url' => '',
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
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'ad_code_six' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" rows="4" <?php if( !current_user_can( 'unfiltered_html' ) ) { echo 'readonly="readonly"'; } else { echo ''; } ?>><?php echo $instance['description']; ?></textarea>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'List URL:', 'ChillThemes' ); ?> <em style="float: right;"><?php printf( __( '<a href="%s" target="_blank">Get the Signup Form Link</a>', 'ChillThemes' ), 'http://kb.mailchimp.com/article/where-do-i-find-the-link-for-my-sign-up-form' ) ?></em></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo esc_attr( $instance['url'] ); ?>" type="text" />
				<em style="display: block; padding-top: 5px;"><strong>Note:</strong> You must use the long URL, not the short URL.</em>
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