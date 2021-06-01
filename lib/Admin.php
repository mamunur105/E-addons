<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    PluginBoilerplate
 * @subpackage PluginBoilerplate/admin
 */

namespace Codexin\PluginBoilerplate;

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    PluginBoilerplate
 * @subpackage PluginBoilerplate/admin
 * @author     Your Name <email@codexin.com>
 */
class Admin {

	/**
	 * The plugin's instance.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    Plugin $plugin This plugin's instance.
	 */
	private $plugin;
	/**
	 * The plugin's script.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    Plugin $suffix This plugin's script.
	 */
	private $suffix;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 *
	 * @param Plugin $plugin This plugin's instance.
	 */
	public function __construct( Plugin $plugin ) {
		$this->suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$this->plugin = $plugin;
	}
	/**
	 * Enqueue css and js
	 *
	 * @return void
	 */
	public function enqueue() {

		$my_current_screen = get_current_screen();
		if ( 'upload' === $my_current_screen->base ) {
			$this->enqueue_styles()->enqueue_scripts();
		}
	}
	/**
	 * Register the stylesheets for the Dashboard. dependency
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in PluginBoilerplate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The PluginBoilerplate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		\wp_enqueue_style(
			$this->plugin->get_plugin_name(),
			\plugin_dir_url( dirname( __FILE__ ) ) . 'assets/styles/admin' . $this->suffix . '.css',
			array(),
			$this->plugin->get_version(),
			'all'
		);
		return $this;
	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		\wp_enqueue_script(
			$this->plugin->get_plugin_name(),
			\plugin_dir_url( dirname( __FILE__ ) ) . 'assets/scripts/admin' . $this->suffix . '.js',
			array( 'jquery' ),
			$this->plugin->get_version(),
			false
		);

	}




}
