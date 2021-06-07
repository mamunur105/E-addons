<?php


class Dnamicterms_Controller extends \Elementor\Control_Select2 {

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
	protected function get_default_settings() {
		return [
			'options'        => [],
			'multiple'       => false,
			'sortable'       => false,
			'dynamic_params' => [],
			'select2options' => [],
		];
	}

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

	
}
