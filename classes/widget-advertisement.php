<?php

/* Register the Advertisement widget. */
function ChillThemes_Load_Advertisement_Widget() {
	register_widget( 'ChillThemes_Widget_Advertisement' );
}
add_action( 'widgets_init', 'ChillThemes_Load_Advertisement_Widget' );

/* Advertisement widget class. */
class ChillThemes_Widget_Advertisement extends WP_Widget {

	/* Set up the widget's unique name, ID, class, description, and other options. */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'widget-advertisement',
			'description' => esc_html__( 'Display any type of advertisement on your site.', 'ChillThemes' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'chillthemes-advertisement', /* Widget ID. */
			__( 'ChillThemes Advertisement', 'ChillThemes' ), /* Widget name. */
			$widget_options, /* Widget options. */
			$control_options /* Control options. */
		);
	}

	/* Outputs the widget based on the arguments input through the widget controls. */
	function widget( $args, $instance ) {
		extract( $args );

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If no HTML was input. */
		$html = '';

		/* First Advertisement */
		if ( $instance['ad_code_one'] != '' ) {

			$html .= '<span>' . $instance['ad_code_one'] . '</span>';

		} else {

			if ( $instance['ad_url_one'] != '' ) {

				/* Open the hyperlink. */
				$html .= '<span><a href="' . $instance['ad_url_one'] . '">';

				if ( $instance['ad_image_one'] != '' ) {

					$html .= '<img src="' . $instance['ad_image_one'] . '" alt="' . $instance['alt_text_one'] . '" />';

				} else {

					if ( $instance['alt_text_one'] != '' ) {
						$html .= $instance['alt_text_one'];
					}

				}

				/* Close the hyperlink. */
				$html .= '</a></span>';

			}

		}

		/* Second Advertisement */
		if ( $instance['ad_code_two'] != '' ) {

			$html .= '<span>' . $instance['ad_code_two'] . '</span>';

		} else {

			if ( $instance['ad_url_two'] != '' ) {

				/* Open the hyperlink. */
				$html .= '<span><a href="' . $instance['ad_url_two'] . '">';

				if ( $instance['ad_image_two'] != '' ) {

					$html .= '<img src="' . $instance['ad_image_two'] . '" alt="' . $instance['alt_text_two'] . '" />';

				} else {

					if ( $instance['alt_text_two'] != '' ) {
						$html .= $instance['alt_text_two'];
					}

				}

				/* Close the hyperlink. */
				$html .= '</a></span>';

			}

		}

		/* Third Advertisement */
		if ( $instance['ad_code_three'] != '' ) {

			$html .= '<span>' . $instance['ad_code_three'] . '</span>';

		} else {

			if ( $instance['ad_url_three'] != '' ) {

				/* Open the hyperlink. */
				$html .= '<span><a href="' . $instance['ad_url_three'] . '">';

				if ( $instance['ad_image_three'] != '' ) {

					$html .= '<img src="' . $instance['ad_image_three'] . '" alt="' . $instance['alt_text_three'] . '" />';

				} else {

					if ( $instance['alt_text_three'] != '' ) {
						$html .= $instance['alt_text_three'];
					}

				}

				/* Close the hyperlink. */
				$html .= '</a></span>';

			}

		}

		/* Fourth Advertisement */
		if ( $instance['ad_code_four'] != '' ) {

			$html .= '<span>' . $instance['ad_code_four'] . '</span>';

		} else {

			if ( $instance['ad_url_four'] != '' ) {

				/* Open the hyperlink. */
				$html .= '<span><a href="' . $instance['ad_url_four'] . '">';

				if ( $instance['ad_image_four'] != '' ) {

					$html .= '<img src="' . $instance['ad_image_four'] . '" alt="' . $instance['alt_text_four'] . '" />';

				} else {

					if ( $instance['alt_text_four'] != '' ) {
						$html .= $instance['alt_text_four'];
					}

				}

				/* Close the hyperlink. */
				$html .= '</a></span>';

			}

		}

		/* Output the HTML to build the advertisement. */
		echo $html;

		/* Close the theme's widget wrapper. */
		echo $after_widget;

	}

	/* Updates the widget control options for the particular instance of the widget. */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance = $new_instance;

		/* First Advertisement */
		if ( !current_user_can( 'unfiltered_html' ) ) { $instance['ad_code_one'] = $new_instance['ad_code_one']; }
		$instance['ad_image_one'] = esc_url( $new_instance['ad_image_one'] );
		$instance['ad_url_one'] = esc_url( $new_instance['ad_url_one'] );
		$instance['alt_text_one'] = esc_attr( $new_instance['alt_text_one'] );

		/* Second Advertisement */
		if ( !current_user_can( 'unfiltered_html' ) ) { $instance['ad_code_two'] = $new_instance['ad_code_two']; }
		$instance['ad_image_two'] = esc_url( $new_instance['ad_image_two'] );
		$instance['ad_url_two'] = esc_url( $new_instance['ad_url_two'] );
		$instance['alt_text_two'] = esc_attr( $new_instance['alt_text_two'] );

		/* Third Advertisement */
		if ( !current_user_can( 'unfiltered_html' ) ) { $instance['ad_code_three'] = $new_instance['ad_code_three']; }
		$instance['ad_image_three'] = esc_url( $new_instance['ad_image_three'] );
		$instance['ad_url_three'] = esc_url( $new_instance['ad_url_three'] );
		$instance['alt_text_three'] = esc_attr( $new_instance['alt_text_three'] );

		/* Fourth Advertisement */
		if ( !current_user_can( 'unfiltered_html' ) ) { $instance['ad_code_four'] = $new_instance['ad_code_four']; }
		$instance['ad_image_four'] = esc_url( $new_instance['ad_image_four'] );
		$instance['ad_url_four'] = esc_url( $new_instance['ad_url_four'] );
		$instance['alt_text_four'] = esc_attr( $new_instance['alt_text_four'] );

		return $instance;
	}

	/* Displays the widget control options in the Widgets admin screen. */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(

			/* First Advertisement */
			'ad_code_one' => '',
			'ad_image_one' => '',
			'ad_url_one' => '',
			'alt_text_one' => '',

			/* Second Advertisement */
			'ad_code_two' => '',
			'ad_image_two' => '',
			'ad_url_two' => '',
			'alt_text_two' => '',

			/* Third Advertisement */
			'ad_code_three' => '',
			'ad_image_three' => '',
			'ad_url_three' => '',
			'alt_text_three' => '',

			/* Fourth Advertisement */
			'ad_code_four' => '',
			'ad_image_four' => '',
			'ad_url_four' => '',
			'alt_text_four' => ''

		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

	?>

		<div class="widget-controls columns-1">

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_code_one' ); ?>"><?php _e( 'Ad Code One:', 'ChillThemes' ); ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'ad_code_one' ); ?>" name="<?php echo $this->get_field_name( 'ad_code_one' ); ?>" rows="4" <?php if ( !current_user_can( 'unfiltered_html' ) ) { echo 'readonly="readonly"'; } else { echo ''; } ?>><?php echo $instance['ad_code_one']; ?></textarea>
			</p>

			<hr style="background: #DDD; border: none; height: 1px; margin: 0 0 1em;" />

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_image_one' ); ?>"><?php _e( 'Ad Image One:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_image_one' ); ?>" name="<?php echo $this->get_field_name( 'ad_image_one' ); ?>" value="<?php echo esc_attr( $instance['ad_image_one'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_url_one' ); ?>"><?php _e( 'Ad URL One:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_url_one' ); ?>" name="<?php echo $this->get_field_name( 'ad_url_one' ); ?>" value="<?php echo esc_attr( $instance['ad_url_one'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'alt_text_one' ); ?>"><?php _e( 'Alt Text One:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'alt_text_one' ); ?>" name="<?php echo $this->get_field_name( 'alt_text_one' ); ?>" value="<?php echo esc_attr( $instance['alt_text_one'] ); ?>" type="text" />
			</p>

			<hr style="background: #DDD; border: none; height: 1px; margin: 0 0 1em;" />

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_code_two' ); ?>"><?php _e( 'Ad Code Two:', 'ChillThemes' ); ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'ad_code_two' ); ?>" name="<?php echo $this->get_field_name( 'ad_code_two' ); ?>" rows="4" <?php if ( !current_user_can( 'unfiltered_html' ) ) { echo 'readonly="readonly"'; } else { echo ''; } ?>><?php echo $instance['ad_code_two']; ?></textarea>
			</p>

			<hr style="background: #DDD; border: none; height: 1px; margin: 0 0 1em;" />

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_image_two' ); ?>"><?php _e( 'Ad Image Two:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_image_two' ); ?>" name="<?php echo $this->get_field_name( 'ad_image_two' ); ?>" value="<?php echo esc_attr( $instance['ad_image_two'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_url_two' ); ?>"><?php _e( 'Ad URL Two:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_url_two' ); ?>" name="<?php echo $this->get_field_name( 'ad_url_two' ); ?>" value="<?php echo esc_attr( $instance['ad_url_two'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'alt_text_two' ); ?>"><?php _e( 'Alt Text Two:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'alt_text_two' ); ?>" name="<?php echo $this->get_field_name( 'alt_text_two' ); ?>" value="<?php echo esc_attr( $instance['alt_text_two'] ); ?>" type="text" />
			</p>

			<hr style="background: #DDD; border: none; height: 1px; margin: 0 0 1em;" />

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_code_three' ); ?>"><?php _e( 'Ad Code Three:', 'ChillThemes' ); ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'ad_code_three' ); ?>" name="<?php echo $this->get_field_name( 'ad_code_three' ); ?>" rows="4" <?php if ( !current_user_can( 'unfiltered_html' ) ) { echo 'readonly="readonly"'; } else { echo ''; } ?>><?php echo $instance['ad_code_three']; ?></textarea>
			</p>

			<hr style="background: #DDD; border: none; height: 1px; margin: 0 0 1em;" />

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_image_three' ); ?>"><?php _e( 'Ad Image Three:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_image_three' ); ?>" name="<?php echo $this->get_field_name( 'ad_image_three' ); ?>" value="<?php echo esc_attr( $instance['ad_image_three'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_url_three' ); ?>"><?php _e( 'Ad URL Three:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_url_three' ); ?>" name="<?php echo $this->get_field_name( 'ad_url_three' ); ?>" value="<?php echo esc_attr( $instance['ad_url_three'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'alt_text_three' ); ?>"><?php _e( 'Alt Text Three:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'alt_text_three' ); ?>" name="<?php echo $this->get_field_name( 'alt_text_three' ); ?>" value="<?php echo esc_attr( $instance['alt_text_three'] ); ?>" type="text" />
			</p>

			<hr style="background: #DDD; border: none; height: 1px; margin: 0 0 1em;" />

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_code_four' ); ?>"><?php _e( 'Ad Code Four:', 'ChillThemes' ); ?></label>
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'ad_code_four' ); ?>" name="<?php echo $this->get_field_name( 'ad_code_four' ); ?>" rows="4" <?php if ( !current_user_can( 'unfiltered_html' ) ) { echo 'readonly="readonly"'; } else { echo ''; } ?>><?php echo $instance['ad_code_four']; ?></textarea>
			</p>

			<hr style="background: #DDD; border: none; height: 1px; margin: 0 0 1em;" />

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_image_four' ); ?>"><?php _e( 'Ad Image Four:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_image_four' ); ?>" name="<?php echo $this->get_field_name( 'ad_image_four' ); ?>" value="<?php echo esc_attr( $instance['ad_image_four'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'ad_url_four' ); ?>"><?php _e( 'Ad URL Four:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'ad_url_four' ); ?>" name="<?php echo $this->get_field_name( 'ad_url_four' ); ?>" value="<?php echo esc_attr( $instance['ad_url_four'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'alt_text_four' ); ?>"><?php _e( 'Alt Text Four:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'alt_text_four' ); ?>" name="<?php echo $this->get_field_name( 'alt_text_four' ); ?>" value="<?php echo esc_attr( $instance['alt_text_four'] ); ?>" type="text" />
			</p>

		</div><!-- .widget-controls -->

		<div style="clear: both;">&nbsp;</div>

	<?php } } ?>