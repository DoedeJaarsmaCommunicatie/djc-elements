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
    
    private function includes() {
        
        require_once __DIR__ . '/includes/class-djc-elements-widgets-cta.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-solutions.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-content.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-heading.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-button.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-services.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-portfolio.php';
        
        require_once __DIR__ . '/Models/class-djc-elements-pill.php';
        require_once __DIR__ . '/Models/Djc_Elements_Project_Banner.php';
    }
    
    public function init_widgets() {
        
        $this->includes();
        
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_CTA());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Content());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Heading());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Button());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_widgets_Portfolio());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Solutions());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Services());
        
    }
}
