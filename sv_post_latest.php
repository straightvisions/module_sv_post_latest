<?php
	namespace sv_100;
	
	/**
	 * @author			Matthias Reuter
	 * @package			sv_100
	 * @copyright		2017 Matthias Reuter
	 * @link			https://straightvisions.com
	 * @since			1.0
	 * @license			See license.txt or https://straightvisions.com
	 */
	class sv_post_latest extends init{
		static $scripts_loaded						= false;

		public function __construct($path,$url){
			$this->path								= $path;
			$this->url								= $url;
			$this->name								= get_class($this);
			
			add_shortcode($this->get_module_name(), array($this, 'shortcode'));
			add_action('widgets_init', array($this, 'sidebars'));
		}
		public function shortcode($settings, $content=''){
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
			$this->module_enqueue_scripts($settings['inline']);
			ob_start();
			include($this->get_path('lib/tpl/frontend.php'));
			$output									= ob_get_contents();
			ob_end_clean();
			
			return $output;
		}
		public function sidebars(){
			register_sidebar(array(
			'name'									=> __('Latest Posts Sidebar', 'sv_100'),
			'id'									=> $this->name,
			'description'							=> __( 'Widgets in this area will be shown in with Latest Posts List.', 'sv_100' ),
			'before_widget'							=> '<li id="%1$s" class="widget d-flex align-items-center %2$s">',
			'after_widget'							=> '</li>',
			'before_title'							=> '<h2 class="'.$this->name.'">',
			'after_title'							=> '</h2>',
			));
		}
	}
?>