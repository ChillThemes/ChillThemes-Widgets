<?php

/* Register the Dribbble widget. */
function ChillThemes_Load_Dribbble_Widget() {
	register_widget( 'ChillThemes_Widget_Dribbble_Shots' );
}
add_action( 'widgets_init', 'ChillThemes_Load_Dribbble_Widget' );

/* Dribbble widget class. */
class ChillThemes_Widget_Dribbble_Shots extends WP_Widget {

	/* Set up the widget's unique name, ID, class, description, and other options. */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'widget-dribbble',
			'description' => esc_html__( 'Display your Dribbble shots on your site.', 'ChillThemes' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'chillthemes-dribbble', /* Widget ID. */
			__( 'ChillThemes Dribbble', 'ChillThemes' ), /* Widget name. */
			$widget_options, /* Widget options. */
			$control_options /* Control options. */
		);
	}

	/* Outputs the widget based on the arguments input through the widget controls. */
	function widget( $args, $instance ) {
		extract( $args );

		/* Arguments for the widget. */
		$args['limit'] = strip_tags( $instance['limit'] );
		$args['username'] = strip_tags( $instance['username'] );
		$args['show_shot_title'] = $instance['show_shot_title'];
		$args['show_shot_date'] = $instance['show_shot_date'];

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		get_template_part( ABSPATH . WPINC . '/feed.php' );

		if ( function_exists( 'fetch_feed' ) ) :
			$rss = fetch_feed('http://dribbble.com/players/' . $args['username'] . '/shots.rss');
			add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );
			if ( !is_wp_error( $rss ) ) :
				$items = $rss->get_items( 0, $rss->get_item_quantity( intval( $args['limit'] ) ) );
			endif;
		endif;

		if ( !empty( $items ) ) :

			foreach ( $items as $item ) :

				$title = $item->get_title();
				$link = $item->get_permalink();
				$date = $item->get_date( 'm/d/Y' );
				$description = $item->get_description();
				preg_match( "/src=\"(http.*(jpg|jpeg|gif|png))/", $description, $image_url );
				$image = $image_url[1];

				echo '<div class="dribbble-wrap">';

					echo '<a class="dribbble-link" href="' . esc_url( $link ) . '">';
						echo '<span class="dribbble-image"><img src="' . esc_html( $image ) . '" alt="' . esc_attr( $title ) . '" /></span>';
					echo '</a><!-- .dribbble-link -->';

					if ( $args['show_shot_title'] ) :
						echo '<span class="dribbble-title">' . esc_html( $title ) . '</span>';
					endif;

					if ( $args['show_shot_date'] ) :
						echo '<span class="dribbble-date">' . esc_html( $date ) . '</span>';
					endif;

				echo '</div><!-- .dribbble-wrap -->';

			endforeach;

		endif;

		/* Close the theme's widget wrapper. */
		echo $after_widget;

	}

	/* Updates the widget control options for the particular instance of the widget. */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance = $new_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['limit'] = strip_tags( $new_instance['limit'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['show_shot_title'] = ( isset( $new_instance['show_shot_title'] ) ? 1 : 0 );
		$instance['show_shot_date'] = ( isset( $new_instance['show_shot_date'] ) ? 1 : 0 );

		return $instance;
	}

	/* Displays the widget control options in the Widgets admin screen. */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => 'Dribbble',
			'limit' => '1',
			'username' => 'dribbble',
			'show_shot_title' => true,
			'show_shot_date' => true
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
				<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e( 'Username:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo esc_attr( $instance['username'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo esc_attr( $instance['limit'] ); ?>" type="number" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'show_shot_title' ); ?>">
				<input class="checkbox" id="<?php echo $this->get_field_id( 'show_shot_title' ); ?>" name="<?php echo $this->get_field_name( 'show_shot_title' ); ?>" type="checkbox" <?php checked( $instance['show_shot_title'], true ); ?> /> <?php _e( 'Show shot title?', 'ChillThemes' ); ?></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'show_shot_date' ); ?>">
				<input class="checkbox" id="<?php echo $this->get_field_id( 'show_shot_date' ); ?>" name="<?php echo $this->get_field_name( 'show_shot_date' ); ?>" type="checkbox" <?php checked( $instance['show_shot_date'], true ); ?> /> <?php _e( 'Show shot date?', 'ChillThemes' ); ?></label>
			</p>

		</div><!-- .widget-controls -->

	<?php } } ?>