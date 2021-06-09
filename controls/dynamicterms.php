<?php


class Dnamicterms_Controller extends  \Elementor\Base_Control {

	/**
	 * Control identifier
	 */
	
	/**
	 * Set control type.
	 */
	public function get_type() {
		return 'dynamicterms';
	}

	/**
	 * Get select2 control default settings.
	 *
	 * Retrieve the default settings of the select2 control. Used to return the
	 * default settings while initializing the select2 control.
	 *
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	// protected function get_default_settings() {
	// 	return [
	// 		'options'        => [],
	// 		'multiple'       => false,
	// 		'sortable'       => false,
	// 		'dynamic_params' => [],
	// 		'select2options' => [],
	// 	];
	// }

	/**
	 * Enqueue control scripts and styles.
	 */
	public function enqueue() {
		if ( $this->get_settings( 'sortable' ) ) {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}
		wp_register_script( 'dynamicterms-control', plugin_dir_url( __DIR__ ).'assets/js/dynamicterms.js', [ 'jquery' ], '1.0.0' );
		wp_enqueue_script( 'dynamicterms-control' );
	}

	
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
			<select class="terms-select" name="" id="" multiple='true'>
				<# _.each( data.options, function( option_title, option_value ) {
					var value = data.controlValue;
					
					#>
				<option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
				<# } ); #>
			</select>
			<input type="hidden"  class="terms-select-save-value" data-setting="{{ data.name }}">
		</div>
		<?php
	}
}
