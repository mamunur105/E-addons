<?php // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
/**
 * Settings Page functionality of the plugin.
 *
 * @link       http://codexin.com
 * @since      1.0.0
 *
 * @package    Cdxn_Plugin
 * @subpackage Cdxn_Plugin/admin
 */

namespace Codexin\PluginBoilerplate\Admin;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Gallery notice
 */
class Notice {
	/**
	 * Gallery Notice
	 *
	 * @return mixed
	 */
	public function notice() {
		$my_current_screen = get_current_screen();
		if ( 'attachment' !== $my_current_screen->post_type ) {
			return;
		}
		ob_start();
		$activation_time  = get_option( CDXN_PLUGIN_PREFIX . '_plugin_activation_time' );
		$notice_available = strtotime( '+7 day', $activation_time );

		if ( true || $activation_time && $notice_available < time() ) {
			$using               = human_time_diff( $activation_time, time() );
			$display_rate_notice = $this->display_notice( 'rate-the-plugin' );
			if ( true || $display_rate_notice ) {
				$plugin_data = get_plugin_data( CDXN_PLUGIN_FILE );
				?>
				<div class="cdxn-mlh-notice notice notice-success is-dismissible" data-notice="rate-the-plugin">
					<p>
					<?php
						/* translators: %1$s: For using time */
						printf( esc_html__( 'Hi there! Stoked to see you\'re using %1$s for %2$s now - hope you like it! And if you do, please consider rating it. It would mean the world to us. keep on rocking!', 'PluginBoilerplate' ), esc_html( $plugin_data['Name'] ), esc_html( $using ) );
					?>
					</p>
					<p>
						<?php
							$review_url = 'https://wordpress.org/support/plugin/' . basename( CDXN_PLUGIN_DIR ) . '/reviews/#new-post';
						?>
						<a class="rate-link button-primary" href="<?php echo esc_url( $review_url ); ?>" target="_blank"><?php esc_html_e( 'Rate the plugin', 'PluginBoilerplate' ); ?> </a>
						<button type="button"  data-dismiss="remind-me-later" class="cdxn-mlh-notice-action"><?php esc_html_e( 'Remind me later', 'PluginBoilerplate' ); ?> </button>
						<button type="button" data-dismiss="dont-show-again" class="cdxn-mlh-notice-action"><?php esc_html_e( 'Don\'t show again', 'PluginBoilerplate' ); ?> </button>
						<button type="button" data-dismiss="i-already-did" class="cdxn-mlh-notice-action"><?php esc_html_e( 'I already did', 'PluginBoilerplate' ); ?> </button>
					</p>
				</div>
				<?php
			}
		}// activation time
		$default = \ob_get_clean();
		echo wp_kses_post( apply_filters( 'cdxn_mlh_notice', $default ) );
	}


	/**
	 * Notice show or hide.
	 *
	 * @param  string $notice_type Notice meta field.
	 * @return boolean
	 */
	private function display_notice( $notice_type ) {
		$user_id      = get_current_user_id();
		$admin_notice = get_user_meta( $user_id, CDXN_PLUGIN_PREFIX . '_rate_the_plugin', true );
		$admin_notice = maybe_unserialize( $admin_notice );
		if ( isset( $admin_notice['notice_type'] ) && $notice_type === $admin_notice['notice_type'] ) {
			$notice_expire = isset( $admin_notice['show_again_time'] ) ? $admin_notice['show_again_time'] : 0;
			if ( ! $notice_expire || time() <= $notice_expire ) {
				return false;
			} else {
				return true;
			}
		}
		return true;
	}

	/**
	 * Plugin rated notification
	 *
	 * @return mixed
	 */
	public function rate_the_plugin_action() {

		if ( isset( $_POST['cx_nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cx_nonce'] ) ), 'ajax-nonce' ) ) {
			wp_send_json( boolval( 0 ) );
		}
		$user_id       = get_current_user_id();
		$dismiss_type  = isset( $_POST['dismiss_type'] ) ? sanitize_text_field( wp_unslash( $_POST['dismiss_type'] ) ) : '';
		$notice_type   = isset( $_POST['notice_type'] ) ? sanitize_text_field( wp_unslash( $_POST['notice_type'] ) ) : '';
		$notice_action = isset( $_POST['action'] ) ? sanitize_text_field( wp_unslash( $_POST['action'] ) ) : '';

		if ( 'i-already-did' === $dismiss_type ) {
			$show_again = 0;
		} elseif ( 'dont-show-again' === $dismiss_type ) {
			$show_again = strtotime( '+2 months', time() );
		} else {
			$show_again = strtotime( '+2 week', time() );
		}

		$rate_cdxn_mlh = maybe_serialize(
			array(
				'dismiss_type'    => $dismiss_type,
				'notice_type'     => $notice_type,
				'show_again_time' => $show_again ? $show_again : 0,
				'action'          => $notice_action,
			)
		);
		$update        = update_user_meta( $user_id, CDXN_MLH_PREFIX . '_rate_the_plugin', $rate_cdxn_mlh );
		wp_send_json( boolval( $update ) );

	}





}

