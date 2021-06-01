<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/mamunur105/E-addons
 * @since      1.0.0
 *
 * @package    PluginBoilerplate
 * @subpackage PluginBoilerplate/includes
 */

namespace EM\Eaddons;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    PluginBoilerplate
 * @subpackage PluginBoilerplate/includes
 * @author     Your Name <rmamunur105@gmail.com>
 */
class Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option( 'Eaddons_mlh_plugin_activation_time', time() );
	}

}
