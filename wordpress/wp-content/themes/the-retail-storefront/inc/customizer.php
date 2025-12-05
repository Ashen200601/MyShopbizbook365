<?php
/**
 * The Retail Storefront Theme Customizer.
 *
 * @package The Retail Storefront
 */

 if ( ! class_exists( 'The_Retail_Storefront_Customizer' ) ) {

	/**
	 * Customizer Loader
	 *
	 * @since 1.0.0
	 */
	class The_Retail_Storefront_Customizer {

		/**
		 * Instance
		 *
		 * @access private
		 * @var object
		 */
		private static $the_retail_storefront_instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$the_retail_storefront_instance ) ) {
				self::$the_retail_storefront_instance = new self;
			}
			return self::$the_retail_storefront_instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			/**
			 * Customizer
			 */
			add_action( 'customize_preview_init',                  array( $this, 'The_Retail_Storefront_Customize_preview_js' ) );
			add_action( 'customize_controls_enqueue_scripts', 	   array( $this, 'The_Retail_Storefront_Customizer_script' ) );
			add_action( 'customize_register',                      array( $this, 'The_Retail_Storefront_Customizer_register' ) );
			add_action( 'after_setup_theme',                       array( $this, 'The_Retail_Storefront_Customizer_settings' ) );
		}
		
		/**
		 * Add postMessage support for site title and description for the Theme Customizer.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		function The_Retail_Storefront_Customizer_register( $wp_customize ) {
			
			$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
			$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
			$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
			$wp_customize->get_setting('custom_logo')->transport = 'refresh';			
			
			/**
			 * Helper files
			 */
			require THE_RETAIL_STOREFRONT_PARENT_INC_DIR . '/customizer/sanitization.php';
		}
		
		/**
		 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
		 */
		function The_Retail_Storefront_Customize_preview_js() {
			wp_enqueue_script( 'the-retail-storefront-customizer', THE_RETAIL_STOREFRONT_PARENT_INC_URI . '/customizer/assets/js/customizer-preview.js', array( 'customize-preview' ), '20151215', true );
		}		
		
		function The_Retail_Storefront_Customizer_script() {
			 wp_enqueue_script( 'the-retail-storefront-customizer-section', THE_RETAIL_STOREFRONT_PARENT_INC_URI .'/customizer/assets/js/customizer-section.js', array("jquery"),'', true  );	
		}

		// Include customizer customizer settings.
			
		function The_Retail_Storefront_Customizer_settings() {
			require THE_RETAIL_STOREFRONT_PARENT_INC_DIR . '/customizer/customizer-options/header.php';
			require THE_RETAIL_STOREFRONT_PARENT_INC_DIR . '/customizer/customizer-options/frontpage.php';
			require THE_RETAIL_STOREFRONT_PARENT_INC_DIR . '/customizer/customizer-options/footer.php';
			require THE_RETAIL_STOREFRONT_PARENT_INC_DIR . '/customizer/customizer-options/post.php';
			require THE_RETAIL_STOREFRONT_PARENT_INC_DIR . '/customizer/customizer-options/sidebar-option.php';
			require THE_RETAIL_STOREFRONT_PARENT_INC_DIR . '/customizer/customizer-options/typography.php';
			require THE_RETAIL_STOREFRONT_PARENT_INC_DIR . '/customizer/customizer-options/general.php';
			require THE_RETAIL_STOREFRONT_PARENT_INC_DIR . '/customizer/customizer-pro/customizer-upgrade-class.php';
			require THE_RETAIL_STOREFRONT_PARENT_INC_DIR . '/customizer/customizer-pro/class-customize.php';
		}

	}
}// End if().

/**
 *  Kicking this off by calling 'get_instance()' method
 */
The_Retail_Storefront_Customizer::get_instance();