<?php
/**
 * Plugin Name: Google Destination URL
 * Plugin URI:  https://github.com/aubreypwd/google-destination-url/
 * Description: Search Google when you want to add a link.
 * Version:     2.0.0
 * Author:      Aubrey Portwood
 * Author URI:  http://aubreypwd.com
 * Donate link: https://github.com/aubreypwd/google-destination-url/
 * License:     GPLv2
 * Text Domain: google-destination-url
 * Domain Path: /languages
 *
 * @link https://github.com/aubreypwd/google-destination-url/
 *
 * @package Google Destination URL
 * @version 2.0.0
 */

/**
 * Copyright (c) 2017 Aubrey Portwood (email : aubreypwd.git@icloud.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using generator-plugin-wp.
 */

/**
 * Autoloads files with classes when needed
 *
 * @since  2.0.0
 * @param  string $class_name Name of the class being requested.
 * @return void
 */
function google_destination_url_autoload_classes( $class_name ) {
	if ( 0 !== strpos( $class_name, 'GDURL_' ) ) {
		return;
	}

	$filename = strtolower( str_replace(
		'_', '-',
		substr( $class_name, strlen( 'GDURL_' ) )
	) );

	Google_Destination_URL::include_file( 'includes/class-' . $filename );
}
spl_autoload_register( 'google_destination_url_autoload_classes' );

/**
 * Main initiation class.
 *
 * @since  2.0.0
 */
final class Google_Destination_URL {

	/**
	 * Current version.
	 *
	 * @var    string
	 * @since  2.0.0
	 */
	protected $version = '';

	/**
	 * URL of plugin directory.
	 *
	 * @var string
	 * @since  2.0.0
	 */
	protected $url = '';

	/**
	 * Path of plugin directory.
	 *
	 * @var string
	 * @since  2.0.0
	 */
	protected $path = '';

	/**
	 * Plugin basename.
	 *
	 * @var string
	 * @since  2.0.0
	 */
	protected $basename = '';

	/**
	 * Detailed activation error messages.
	 *
	 * @var array
	 * @since  2.0.0
	 */
	protected $activation_errors = array();

	/**
	 * Singleton instance of plugin.
	 *
	 * @var Google_Destination_URL
	 * @since  2.0.0
	 */
	protected static $single_instance = null;

	/**
	 * Plugin headers.
	 *
	 * @author Aubrey Portwood
	 * @since  2.0.0
	 *
	 * @var array
	 */
	protected $plugin_headers = array();

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since  2.0.0
	 * @return Google_Destination_URL A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Sets up our plugin.
	 *
	 * @since  2.0.0
	 */
	protected function __construct() {
		$this->basename = plugin_basename( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->path     = plugin_dir_path( __FILE__ );
		$this->version  = $this->plugin_headers( 'Version' );
	}

	/**
	 * Set the plugin headers.
	 *
	 * @author Aubrey Portwood
	 * @since  2.0.0
	 *
	 * @param string $key The specific header value you want.
	 */
	protected function plugin_headers( $key = '' ) {
		if ( empty( $this->plugin_headers ) ) {

			// Set the plugin headers if they aren't set.
			$this->plugin_headers = get_file_data( __FILE__, array(
				'Plugin Name' => 'Plugin Name',
				'Plugin URI'  => 'Plugin URI',
				'Version'     => 'Version',
				'Description' => 'Description',
				'Author'      => 'Author',
				'Author URI'  => 'Author URI',
				'Text Domain' => 'Text Domain',
				'Domain Path' => 'Domain Path',
			), 'plugin' );
		}

		if ( ! empty( $key ) && isset( $this->plugin_headers[ $key ] ) ) {
			return $this->plugin_headers[ $key ];
		}

		return $this->plugin_headers;
	}

	/**
	 * Attach other plugin classes to the base plugin class.
	 *
	 * @since  2.0.0
	 */
	public function plugin_classes() {
		// Attach other plugin classes to the base plugin class.
		// $this->plugin_class = new GDURL_Plugin_Class( $this );
	} // END OF PLUGIN CLASSES FUNCTION

	/**
	 * Add hooks and filters
	 *
	 * @since  2.0.0
	 */
	public function hooks() {
		// Priority needs to be:
		// < 10 for CPT_Core,
		// < 5 for Taxonomy_Core,
		// 0 Widgets because widgets_init runs at init priority 1.
		add_action( 'init', array( $this, 'init' ), 0 );
	}

	/**
	 * Activate the plugin
	 *
	 * @since  2.0.0
	 */
	public function _activate() {
		// Make sure any rewrite functionality has been loaded.
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin
	 * Uninstall routines should be in uninstall.php
	 *
	 * @since  2.0.0
	 */
	public function _deactivate() {
	}

	/**
	 * Init hooks
	 *
	 * @since  2.0.0
	 */
	public function init() {

		// Bail early if requirements aren't met
		if ( ! $this->check_requirements() ) {
			return;
		}

		// load translated strings for plugin
		load_plugin_textdomain( 'google-destination-url', false, dirname( $this->basename ) . '/languages/' );

		// initialize plugin classes
		$this->plugin_classes();
	}

	/**
	 * Check if the plugin meets requirements and
	 * disable it if they are not present.
	 *
	 * @since  2.0.0
	 * @return boolean result of meets_requirements
	 */
	public function check_requirements() {

		// Bail early if plugin meets requirements.
		if ( $this->meets_requirements() ) {
			return true;
		}

		// Add a dashboard notice.
		add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

		// Deactivate our plugin.
		add_action( 'admin_init', array( $this, 'deactivate_me' ) );

		return false;
	}

	/**
	 * Deactivates this plugin, hook this function on admin_init.
	 *
	 * @since  2.0.0
	 */
	public function deactivate_me() {

		/*
		 * We do a check for deactivate_plugins before calling it, to protect
		 * any developers from accidentally calling it too early and breaking things.
		 */
		if ( function_exists( 'deactivate_plugins' ) ) {
			deactivate_plugins( $this->basename );
		}
	}

	/**
	 * Check that all plugin requirements are met
	 *
	 * @since  2.0.0
	 * @return boolean True if requirements are met.
	 */
	public function meets_requirements() {
		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met
	 *
	 * @since  2.0.0
	 * @return void
	 */
	public function requirements_not_met_notice() {

		// Translators: %$1s is the url to plugins.php.
		$default_message = sprintf( __( 'Google Destination URL is missing requirements and has been <a href="%1$s">deactivated</a>. Please make sure all requirements are available.', 'google-destination-url' ), admin_url( 'plugins.php' ) );

		// Default details to null.
		$details = null;

		// Add details if any exist.
		if ( ! empty( $this->activation_errors ) && is_array( $this->activation_errors ) ) {
			$details = '<small>' . implode( '</small><br /><small>', $this->activation_errors ) . '</small>';
		}

		// Output errors. ?>
		<div id="message" class="error">
			<p><?php echo $default_message; ?></p>
			<?php echo $details; ?>
		</div>
		<?php
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since  2.0.0
	 * @param string $field Field to get.
	 * @throws Exception Throws an exception if the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'version':
				return $this->version;
			case 'basename':
			case 'url':
			case 'path':
				return $this->$field;
			default:
				throw new Exception( 'Invalid ' . __CLASS__ . ' property: ' . $field );
		}
	}

	/**
	 * Include a file from the includes directory.
	 *
	 * @since  2.0.0
	 * @param  string $filename Name of the file to be included.
	 * @return bool   Result of include call.
	 */
	public static function include_file( $filename ) {
		$file = self::dir( $filename . '.php' );
		if ( file_exists( $file ) ) {
			return include_once( $file );
		}
		return false;
	}

	/**
	 * This plugin's directory.
	 *
	 * @since  2.0.0
	 * @param  string $path (optional) appended path.
	 * @return string       Directory and path
	 */
	public static function dir( $path = '' ) {
		static $dir;
		$dir = $dir ? $dir : trailingslashit( dirname( __FILE__ ) );
		return $dir . $path;
	}

	/**
	 * This plugin's url.
	 *
	 * @since  2.0.0
	 * @param  string $path (optional) appended path.
	 * @return string       URL and path
	 */
	public static function url( $path = '' ) {
		static $url;
		$url = $url ? $url : trailingslashit( plugin_dir_url( __FILE__ ) );
		return $url . $path;
	}
}

/**
 * Grab the Google_Destination_URL object and return it.
 *
 * Wrapper for Google_Destination_URL::get_instance().
 *
 * @since  2.0.0
 * @return Google_Destination_URL  Singleton instance of plugin class.
 */
function google_destination_url() {
	return Google_Destination_URL::get_instance();
}

// Kick it off.
add_action( 'plugins_loaded', array( google_destination_url(), 'hooks' ) );

register_activation_hook( __FILE__, array( google_destination_url(), '_activate' ) );
register_deactivation_hook( __FILE__, array( google_destination_url(), '_deactivate' ) );
