<?php

/*
Plugin Name: ChillThemes Widgets
Plugin URI: http://wordpress.org/plugins/chillthemes-widgets
Description: Enables custom widgets for use in any of our Chill Themes.
Version: 1.8
Author: ChillThemes
Author URI: http://chillthemes.com
Author Email: matt@chillthemes.com
License:

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/* ChillThemes_Widgets class. */
class ChillThemes_Widgets {

	/*--------------------------------------------*
	 * Attributes
	 *--------------------------------------------*/

	/* Refers to a single instance of this class. */
	private static $instance = null;
	
	/* Refers to the slug of the plugin screen. */
	private $plugin_screen_slug = null;

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/
	 
	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return Chillthemes_Authors_Widget A single instance of this class.
	 */
	public function get_instance() {
		return null == self::$instance ? new self : self::$instance;
	} // end get_instance;

	/* Initializes the plugin by setting localization, filters, and administration functions. */
	private function __construct() {

		// Load plugin textdomain.
		add_action( 'init', array( $this, 'chillthemes_widgets_plugin_textdomain' ) );

		// Register plugin scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_chillthemes_widgets_stylesheet' ) );

		// Load plugin widgets.
		add_action( 'widgets_init', array( $this, 'chillthemes_load_widgets' ), 1 );

		// Unregister WP widgets.
		add_action( 'widgets_init', array( $this, 'chillthemes_unregister_widgets' ) );

	} // end constructor

	/* Loads the plugin text domain for translation. */
	public function chillthemes_widgets_plugin_textdomain() {

		// Define plugin domain name.
		$domain = 'chillthemes-widgets';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

        load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
        load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

	} // end plugin_textdomain

	/* Registers and enqueues plugin-specific styles. */
	public function register_chillthemes_widgets_stylesheet() {
		wp_enqueue_style( 'chillthemes-widgets', plugins_url( 'css/display.css', __FILE__ ) );
		wp_enqueue_style( 'chillthemes-widgets-font-icons', plugins_url( 'css/font-awesome.css', __FILE__ ) );
	} // end register_plugin_styles

	/* Registers and loads plugin-specific widgets. */
	public function chillthemes_load_widgets() {

		/* Load the Advertisement widget. */
		require_once( dirname( __FILE__ ) . '/classes/widget-advertisement.php' );

		/* Load the Dribbble widget. */
		require_once( dirname( __FILE__ ) . '/classes/widget-dribbble.php' );

		/* Load the Feedburner widget. */
		require_once( dirname( __FILE__ ) . '/classes/widget-feedburner.php' );

		/* Load the Flickr widget. */
		require_once( dirname( __FILE__ ) . '/classes/widget-flickr.php' );

		/* Load the List Authors widget. */
		require_once( dirname( __FILE__ ) . '/classes/widget-list-authors.php' );

		/* Load the MailChimp widget. */
		require_once( dirname( __FILE__ ) . '/classes/widget-mailchimp.php' );

		/* Load the Portfolio widget. */
		if ( function_exists( 'chillthemes_register_portfolio' ) )
			require_once( dirname( __FILE__ ) . '/classes/widget-portfolio.php' );

		/* Load the Recent Comments widget. */
		require_once( dirname( __FILE__ ) . '/classes/widget-recent-comments.php' );

		/* Load the Recent Images widget. */
		require_once( dirname( __FILE__ ) . '/classes/widget-recent-images.php' );

		/* Load the Recent Posts widget. */
		require_once( dirname( __FILE__ ) . '/classes/widget-recent-posts.php' );

		/* Load the Social Profiles widget. */
		require_once( dirname( __FILE__ ) . '/classes/widget-social-profiles.php' );

	} // end chillthemes_load_widgets

	/* Unregister default WordPress widgets that are replaced by the widgets this plugin provides. */
	public function chillthemes_unregister_widgets() {
		unregister_widget( 'WP_Widget_Recent_Comments' );
		unregister_widget( 'WP_Widget_Recent_Posts' );
	}

} // end class

// Instantiation call of your plugin to the name given at the class definition.
ChillThemes_Widgets::get_instance();

?>