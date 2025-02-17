<?php
namespace sv_100;

/**
 * @version         1.00
 * @author			straightvisions GmbH
 * @package			sv_100
 * @copyright		2017 straightvisions GmbH
 * @link			https://straightvisions.com
 * @since			1.0
 * @license			See license.txt or https://straightvisions.com
 */

class sv_post_latest extends init {
	public function __construct() {

	}

	public function init() {
		// Translates the module
		load_theme_textdomain( $this->get_module_name(), $this->get_path( 'languages' ) );

		// Module Info
		$this->set_module_title( 'SV Post Latest' );
		$this->set_module_desc( __( 'This module gives the ability to display the latest posts via the "[sv_post_latest]" shortcode.', $this->get_module_name() ) );

		// Shortcodes
		add_shortcode($this->get_module_name(), array($this, 'shortcode'));

		// Action Hooks
		add_action('widgets_init', array($this, 'sidebars'));

		$this->scripts_queue['frontend']			= static::$scripts->create( $this )
			->set_ID('frontend')
			->set_path( 'lib/css/frontend.css' )
			->set_inline(true);
	}

	public function shortcode( $settings, $content = '' ) {
		$settings								= shortcode_atts(
			array(
				'inline'						=> true,
				'title'							=> '+++ UPDATES +++',
				'id'							=> false,
				'limit'							=> 3,
				'order'							=> 'date',
			),
			$settings,
			$this->get_module_name()
		);

		// Load Styles
		$this->scripts_queue['frontend']
			->set_inline($settings['inline'])
			->set_is_enqueued();

		ob_start();
		include( $this->get_path( 'lib/tpl/frontend.php' ) );
		$output									= ob_get_contents();
		ob_end_clean();

		return $output;
	}

	public function sidebars() {
		register_sidebar(array(
			'name'									=> __('Latest Posts Sidebar', 'sv_100'),
			'id'									=> $this->get_module_name(),
			'description'							=> __( 'Widgets in this area will be shown in with Latest Posts List.', 'sv_100' ),
			'before_widget'							=> '<li id="%1$s" class="widget d-flex align-items-center %2$s">',
			'after_widget'							=> '</li>',
			'before_title'							=> '<h2 class="'.$this->name.'">',
			'after_title'							=> '</h2>',
		));
	}
}