<?php

/* Register the Social Profiles widget. */
function ChillThemes_Load_Social_Profiles_Widget() {
	register_widget( 'ChillThemes_Widget_Social_Profiles' );
}
add_action( 'widgets_init', 'ChillThemes_Load_Social_Profiles_Widget' );

/* Social Profiles widget class. */
class ChillThemes_Widget_Social_Profiles extends WP_Widget {

	/* Set up the widget's unique name, ID, class, description, and other options. */
	function __construct() {

		/* Default services. */
		$default_services = array( 
			'delicious' => 'Delicious',
			'dribbble' => 'Dribbble',
			'dropbox' => 'Dropbox',
			'facebook' => 'Facebook',
			'flickr' => 'Flickr',
			'forrst' => 'Forrst',
			'foursquare' => 'Foursquare',
			'github' => 'Github',
			'google-plus' => 'Google Plus',
			'instagram' => 'Instagram',
			'lastfm' => 'LastFM',
			'linkedin' => 'LinkedIn',
			'pinterest' => 'Pinterest',
			'reddit' => 'Reddit',
			'skype' => 'Skype',
			'soundcloud' => 'Soundcloud',
			'spotify' => 'Spotify',
			'twitter' => 'Twitter',
			'vimeo' => 'Vimeo',
			'yelp' => 'Yelp',
			'youtube' => 'YouTube',
			'rss' => 'RSS'
		);

		/* Apply filters. */
		$this->services = apply_filters( 'social-profiles-services', $default_services );

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'widget-social-profiles',
			'description' => esc_html__( 'Display links to your social profiles.', 'ChillThemes' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'chillthemes-social-profiles', /* Widget ID. */
			__( 'ChillThemes Social Profiles', 'ChillThemes' ), /* Widget name. */
			$widget_options, /* Widget options. */
			$control_options /* Control options. */
		);
	}
	
	/* Outputs the widget based on the arguments input through the widget controls. */
	function widget( $args, $instance ) {
		extract( $args );

		/* Arguments for the widget. */
		$args['icon_color'] = strip_tags( $instance['icon_color'] );
		$args['icon_size'] = strip_tags( $instance['icon_size'] );

		$links 	= array();
		foreach( $this->services as $service => $name ) {
			$links[$service] = esc_url( $instance[$service] );
		}
		$links = array_filter( $links );

		if ( empty( $links ) )
			return false;

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		foreach ( $links as $service => $link ) {

			echo '<div class="' . esc_attr( $service ) . '">';

				echo '<a href="' . $link . '" title="' . $this->services[$service] . '" style="color: ' . esc_attr( $args['icon_color'] ) . '; font-size: ' . esc_attr( $args['icon_size'] ) . 'px;"><i class="icon-' . strtolower( str_replace( ' ', '-', $this->services[$service] ) ) . '"></i></a>';

			echo '</div>';

		}

		/* Close the theme's widget wrapper. */
		echo $after_widget;
	}

	/* Updates the widget control options for the particular instance of the widget. */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Set the instance to the new instance. */
		$instance = $new_instance;

		foreach( $this->services as $service => $name ) {
			$instance[$service] = !empty( $new_instance[$service] ) ? esc_url( $new_instance[$service] ) : '';
		}

		return $instance;
	}

	/* Displays the widget control options in the Widgets admin screen. */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => 'Social Profiles',
			'icon_color' => 'inherit',
			'icon_size' => '26',
			'delicious' => 'http://delicious.com',
			'dribbble' => 'http://dribbble.com',
			'dropbox' => 'https://www.dropbox.com',
			'facebook' => 'http://facebook.com',
			'flickr' => 'http://flickr.com',
			'forrst' => 'http://forrst.com',
			'foursquare' => 'https://foursquare.com',
			'github' => 'https://github.com',
			'google-plus' => 'https://plus.google.com',
			'instagram' => 'http://instagram.com',
			'lastfm' => 'http://lastfm.com',
			'linkedin' => 'http://linkedin.com',
			'pinterest' => 'http://pinterest.com',
			'reddit' => 'http://www.reddit.com',
			'rss' => get_bloginfo( 'rss2_url' ),
			'skype' => 'http://skype.com',
			'soundcloud' => 'http://soundcloud.com',
			'spotify' => 'http://spotify.com',
			'twitter' => 'http://twitter.com',
			'vimeo' => 'http://vimeo.com',
			'yelp' => 'http://www.yelp.com',
			'youtube' => 'http://youtube.com'
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

	?>

		<div class="widget-controls columns-1">

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'icon_color' ); ?>"><?php _e( 'Icon Color:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'icon_color' ); ?>"name="<?php echo $this->get_field_name( 'icon_color' ); ?>" value="<?php echo esc_attr( $instance['icon_color'] ); ?>" type="text" />
				<span class="description">Example: #333</span>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'icon_size' ); ?>"><?php _e( 'Icon Size:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'icon_size' ); ?>"name="<?php echo $this->get_field_name( 'icon_size' ); ?>" value="<?php echo esc_attr( $instance['icon_size'] ); ?>" type="number" />
			</p>

			<?php foreach( $this->services as $service => $name ) { ?>
			<p>
				<label for="<?php echo $this->get_field_id( $service ); ?>"><?php echo $name; ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( $service ); ?>"name="<?php echo $this->get_field_name( $service ); ?>" value="<?php echo esc_attr( $instance[$service] ); ?>" type="text" />
			</p>
			<?php } ?>

		</div><!-- .widget-controls -->

		<div class="clear">&nbsp;</div><!-- .clear -->

	<?php } } ?>