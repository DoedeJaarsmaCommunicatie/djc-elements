<?php

class Djc_Elements_Widgets {
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
    
    public function init_widgets() {
        
        require_once __DIR__ . '/includes/class-djc-elements-widgets-cta.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-solutions.php';
        
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_CTA());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Solutions());
        
    }
}
