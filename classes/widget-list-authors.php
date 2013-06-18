<?php

/* Register the List Authors widget. */
function ChillThemes_Load_List_Authors_Widget() {
	register_widget( 'ChillThemes_Widget_List_Authors' );
}
add_action( 'widgets_init', 'ChillThemes_Load_List_Authors_Widget' );

/* List Authors widget class. */
class ChillThemes_Widget_List_Authors extends WP_Widget {

	/* Set up the widget's unique name, ID, class, description, and other options. */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'widget-list-authors',
			'description' => esc_html__( 'Display all your site\'s authors.', 'ChillThemes' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'chillthemes-list-authors', /* Widget ID. */
			__( 'ChillThemes List Authors', 'ChillThemes' ), /* Widget name. */
			$widget_options, /* Widget options. */
			$control_options /* Control options. */
		);
	}

	/* Outputs the widget based on the arguments input through the widget controls. */
	function widget( $args, $instance ) {
		extract( $args );

		/* Arguments for the widget. */
		$args['limit'] = $instance['limit'];
		$args['order'] = $instance['order'];
		$args['orderby'] = $instance['orderby'];

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		/* Get all users that are authors. */
		$authors = get_users(
			array(
				'who' => 'authors',
				'number' => intval( $args['limit'] ),
				'order' => $args['order'],
				'orderby' => $args['orderby']
			)
		);

		echo '<ul class="list-authors">';

		/* Loop through each author. */
		foreach ( $authors as $author ) :

			/* Count the amount of posts a user has. */
			$post_count = count_user_posts( $author->ID );

			/* Only display author's that have more than one published post. */
			if ( $post_count >= 1 ) :

				echo '<li>';
					echo '<a href="' . get_author_posts_url( $author->ID ) . '">' .  get_avatar( $author->ID, 60 ) . '</a>';
					echo '<a class="author-name" href="' . get_author_posts_url( $author->ID ) . '">' . get_the_author_meta( 'display_name', $author->ID ) . '</a>';
					if ( get_the_author_meta( 'user_url', $author->ID ) ) : printf( '<a class="author-url" href="%1$s">' . __( 'Visit %2$s\'s Website', 'ChillThemes' ) . '</a>', get_the_author_meta( 'user_url', $author->ID ), get_the_author_meta( 'first_name', $author->ID ) ); endif;
					printf( '<span class="post-count">' . __( 'Published Articles: %s', 'ChillThemes' ), $post_count ) . '</span>';
				echo '</li>';

			endif;

		endforeach;

		echo '</ul><!-- .list-authors -->';

		/* Close the theme's widget wrapper. */
		echo $after_widget;

	}

	/* Updates the widget control options for the particular instance of the widget. */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance = $new_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['limit'] = strip_tags( $new_instance['limit'] );
		$instance['order'] = $new_instance['order'];
		$instance['orderby'] = $new_instance['orderby'];

		return $instance;
	}

	/* Displays the widget control options in the Widgets admin screen. */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => esc_attr__( 'Authors', 'ChillThemes' ),
			'limit' => '4',
			'order' => 'ASC',
			'orderby' => 'display_name'
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

		/* <select> element options. */
		$order = array( 'ASC' => esc_attr__( 'Ascending', 'ChillThemes' ), 'DESC' => esc_attr__( 'Descending', 'ChillThemes' ) );
		$orderby = array( 'id' => esc_attr__( 'ID', 'ChillThemes' ), 'login' => esc_attr__( 'Login', 'ChillThemes' ), 'nicename' => esc_attr__( 'Nice Name', 'ChillThemes' ), 'email' => esc_attr__( 'Email', 'ChillThemes' ), 'url' => esc_attr__( 'URL', 'ChillThemes' ), 'registered' => esc_attr__( 'Registered', 'ChillThemes' ), 'display_name' => esc_attr__( 'Display Name', 'ChillThemes' ), 'post_count' => esc_attr__( 'Post Count', 'ChillThemes' ) );

	?>

		<div class="widget-controls">

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>"name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo esc_attr( $instance['limit'] ); ?>" type="number" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order:', 'ChillThemes' ); ?></label> 
				<select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
					<?php foreach ( $order as $option_value => $option_label ) { ?>
						<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['order'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php } ?>
				</select>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order By:', 'ChillThemes' ); ?></label> 
				<select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
					<?php foreach ( $orderby as $option_value => $option_label ) { ?>
						<option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $instance['orderby'], $option_value ); ?>><?php echo esc_html( $option_label ); ?></option>
					<?php } ?>
				</select>
			</p>

		</div><!-- .widget-controls -->

		<div class="clear">&nbsp;</div><!-- .clear -->

	<?php } } ?>