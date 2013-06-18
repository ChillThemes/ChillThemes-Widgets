<?php

/* Register the Recent Posts widget. */
function ChillThemes_Load_Recent_Posts_Widget() {
	register_widget( 'ChillThemes_Widget_Recent_Posts' );
}
add_action( 'widgets_init', 'ChillThemes_Load_Recent_Posts_Widget' );

/* Recent Posts widget class. */
class ChillThemes_Widget_Recent_Posts extends WP_Widget {

	/* Set up the widget's unique name, ID, class, description, and other options. */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'widget-recent-posts',
			'description' => esc_html__( 'Display your site\'s recent posts.', 'ChillThemes' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350
		);

		/* Create the widget. */
		$this->WP_Widget(
			'chillthemes-recent-posts', /* Widget ID. */
			__( 'ChillThemes Recent Posts', 'ChillThemes' ), /* Widget name. */
			$widget_options, /* Widget options. */
			$control_options /* Control options. */
		);
	}

	/* Outputs the widget based on the arguments input through the widget controls. */
	function widget( $args, $instance ) {
		extract( $args );

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		/* Arguments for the widget. */
		$args['category'] = strip_tags( $instance['category'] );
		$args['limit'] = strip_tags( $instance['limit'] );
		$args['offset'] = strip_tags( $instance['offset'] );
		$args['order'] = $instance['order'];
		$args['orderby'] = $instance['orderby'];
		$args['show_post_meta'] = $instance['show_post_meta'];
		$args['show_post_content'] = $instance['show_post_content'];

	?>

	<?php
		$posts = new WP_Query(
			apply_filters( 'widget_posts_args',
				array(
					'category_name' => $args['category'],
					'offset' => $args['offset'],
					'order' => $args['order'],
					'orderby' => $args['orderby'],
					'post__not_in' => get_option( 'sticky_posts' ),
					'posts_per_page' => intval( $args['limit'] )
				)
			)
		);
	?>

	<?php if ( $posts->have_posts() ) : ?>

		<ul class="xoxo posts">

			<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

			<li>

				<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

				<?php if ( $args['show_post_meta'] ) : ?>
				<span class="post-date">
					<?php echo esc_html( get_the_date( 'm/d/Y' ) ); ?>
				</span><!-- .post-date -->
				<?php endif; ?>

				<?php if ( $args['show_post_content'] ) : ?>
				<div class="post-content">
					<?php echo get_the_excerpt(); ?>
				</div><!-- .post-content -->
				<?php endif; ?>

			</li>

			<?php endwhile; wp_reset_query(); ?>

		</ul><!-- .xoxo .posts -->

	<?php endif; ?>

	<?php

		/* Close the theme's widget wrapper. */
		echo $after_widget;

	}

	/* Updates the widget control options for the particular instance of the widget. */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance = $new_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['limit'] = strip_tags( $new_instance['limit'] );
		$instance['offset'] = strip_tags( $new_instance['offset'] );
		$instance['order'] = $new_instance['order'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['show_post_meta'] = ( isset( $new_instance['show_post_meta'] ) ? 1 : 0 );
		$instance['show_post_content'] = ( isset( $new_instance['show_post_content'] ) ? 1 : 0 );

		return $instance;
	}

	/* Displays the widget control options in the Widgets admin screen. */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => 'Recent Posts',
			'category' => '',
			'limit' => '5',
			'offset' => '',
			'order' => 'DESC',
			'orderby' => 'date',
			'show_post_meta' => true,
			'show_post_content' => false
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

		/* Select element options. */
		$order = array( 'ASC' => esc_attr__( 'Ascending', 'ChillThemes' ), 'DESC' => esc_attr__( 'Descending', 'ChillThemes' ) );
		$orderby = array( 'author' => esc_attr__( 'Author', 'ChillThemes' ), 'comment_count' => esc_attr__( 'Comment Count', 'ChillThemes' ), 'date' => esc_attr__( 'Date', 'ChillThemes' ), 'ID' => esc_attr__( 'ID', 'ChillThemes' ), 'name' => esc_attr__( 'Name', 'ChillThemes' ), 'rand' => esc_attr__( 'Random', 'ChillThemes' ), 'title' => esc_attr__( 'Title', 'ChillThemes' ) );

	?>

		<div class="widget-controls columns-1">

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category Name:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>"name="<?php echo $this->get_field_name( 'category' ); ?>" value="<?php echo esc_attr( $instance['category'] ); ?>" type="text" />
				<small><strong>Example:</strong> category-one, category-two</small>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Limit:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" value="<?php echo esc_attr( $instance['limit'] ); ?>" type="text" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Offset:', 'ChillThemes' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" value="<?php echo esc_attr( $instance['offset'] ); ?>" type="number" />
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

			<p>
				<label for="<?php echo $this->get_field_id( 'show_post_meta' ); ?>">
				<input class="checkbox" id="<?php echo $this->get_field_id( 'show_post_meta' ); ?>" name="<?php echo $this->get_field_name( 'show_post_meta' ); ?>" type="checkbox" <?php checked( $instance['show_post_meta'], true ); ?> /> <?php _e( 'Show post meta?', 'ChillThemes' ); ?></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'show_post_content' ); ?>">
				<input class="checkbox" id="<?php echo $this->get_field_id( 'show_post_content' ); ?>" name="<?php echo $this->get_field_name( 'show_post_content' ); ?>" type="checkbox" <?php checked( $instance['show_post_content'], true ); ?> /> <?php _e( 'Show post content?', 'ChillThemes' ); ?></label>
			</p>

		</div><!-- .widget-controls -->

		<div style="clear: both;">&nbsp;</div>

	<?php } } ?>