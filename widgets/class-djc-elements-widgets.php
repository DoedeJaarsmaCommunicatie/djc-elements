<?php
defined('ABSPATH') || exit; // Exit if accessed directly.

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
    
    private function includes(): void {
        
        require_once __DIR__ . '/includes/class-djc-elements-widgets-cta.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-solutions.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-content.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-heading.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-button.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-services.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-portfolio.php';
        require_once __DIR__ . '/includes/class-djc-elements-widgets-employee.php';
        
        // Require the models to make sure all widgets can call these.
        require_once __DIR__ . '/Models/class-djc-elements-pill.php';
        require_once __DIR__ . '/Models/class-djc-elements-project.php';
        require_once __DIR__ . '/Models/class-djc-elements-.php';
        require_once __DIR__ . '/Models/class-djc-elements-service.php';
        require_once __DIR__ . '/Models/class-djc-elements-project-banner.php';
    }
    
    /**
     * Is hooked in main class.
     *
     * This function registers all the custom widgets with elementor.
     *
     * @since 1.0.0
     * @return void
     * @throws Exception
     */
    public function init_widgets(): void {
        
        $this->includes();
        
        do_action('djc-elements/widgets/preload');
        
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Button());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_CTA());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Content());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Employee());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Heading());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_widgets_Portfolio());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Solutions());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Djc_Elements_Widgets_Services());
        
        do_action('djc-elements/widgets/loaded');
        
    }
}
