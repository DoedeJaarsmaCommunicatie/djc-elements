<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://doedejaarsma.nl/
 * @since      1.0.0
 *
 * @package    Djc_Elements
 * @subpackage Djc_Elements/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Djc_Elements
 * @subpackage Djc_Elements/includes
 * @author     Mitch Hijlkema <mitch@doedejaarsma.nl>
 */
class Djc_Elements {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Djc_Elements_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'DJC_ELEMENTS_VERSION' ) ) {
			$this->version = DJC_ELEMENTS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'djc-elements';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_controls_hooks();
        $this->define_widgets_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Djc_Elements_Loader. Orchestrates the hooks of the plugin.
	 * - Djc_Elements_i18n. Defines internationalization functionality.
	 * - Djc_Elements_Admin. Defines all hooks for the admin area.
	 * - Djc_Elements_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-djc-elements-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-djc-elements-i18n.php';
        
        /**
         * The class responsible for defining all widgets that are hooked into
         * Elementor.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'widgets/class-djc-elements-widgets.php';
        
        /**
         * The class responsible for defining all controls that are hooked into
         * Elementor.
         */
        require_once plugin_dir_path( __DIR__) . 'controls/class-djc-elements-controls.php';
        
		$this->loader = new Djc_Elements_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Djc_Elements_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Djc_Elements_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}
	
	private function define_widgets_hooks() {
	    $plugin_widget = new Djc_Elements_Widgets($this->get_plugin_name(), $this->get_version());
	    
	    $this->get_loader()->add_action('elementor/widgets/widgets_registered', $plugin_widget, 'init_widgets');
    }

    private function define_controls_hooks() {
	    $plugin_controls = new Djc_Elements_Controls($this->get_plugin_name(), $this->get_version());
	    
	    $this->get_loader()->add_action( 'elementor/controls/controls_registered', $plugin_controls, 'init_controls');
    }
    
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Djc_Elements_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
