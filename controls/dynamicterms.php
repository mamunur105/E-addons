<?php
/**
 * Elementor emoji one area control.
 *
 * A control for displaying a textarea with the ability to add emojis.
 *
 * @since 1.0.0
 */
class Dnamicterms_Controller extends \Elementor\Base_Control {

	/**
	 * Get emoji one area control type.
	 *
	 * Retrieve the control type, in this case `emojicontrol`.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return 'dynamicterms';
	}
	/**
	 * Enqueue emoji one area control scripts and styles.
	 *
	 * Used to register and enqueue custom scripts and styles used by the emoji one
	 * area control.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue() {

		wp_register_script( 'dynamicterms-control', plugin_dir_url( __DIR__ ).'assets/js/dynamicterms.js', [ 'jquery' ], '1.0.0' );
		wp_enqueue_script( 'dynamicterms-control' );
	}

	
	/**
	 * Get emoji one area control default settings.
	 *
	 * Retrieve the default settings of the emoji one area control. Used to return
	 * the default settings while initializing the emoji one area control.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	// protected function get_default_settings() {
	// 	return [
	// 		'label_block' => true,
	// 		'selectControl_options' => [],
	// 	];
	// }

	/**
	 * Render emoji one area control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() { 
		?>
		<div>
			<label class="elementor-control-title"> {{{ data.label }}} </label>
			<select class="terms-select" name="" id="" sortable="{{{ data.sortable }}}" multiple="{{{ data.multiple }}}" >
				<option value="{{ data.name }}" selected="selected"> </option>
			</select>
			<!-- <input type="hidden" class="terms-select-save-value" data-setting="{{ data.name }}"> -->
		</div>
		<?php
	}

}
