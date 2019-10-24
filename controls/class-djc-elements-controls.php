<?php
defined('ABSPATH') || exit; // Exit if accessed directly.

class Djc_Elements_Controls {
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;
    
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;
    
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        
    }
    
    public function init_controls() {
        require_once __DIR__ . '/includes/class-djc-elements-controls-projects.php';
        
        Elementor\Plugin::instance()->controls_manager->register_control( Djc_Elements_Controls_Projects::$type, new Djc_Elements_Controls_Projects());
    }
}
