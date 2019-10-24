<?php
defined('ABSPATH') || exit; // Exit if accessed directly.

use Elementor\Controls_Manager;

class Djc_Elements_Widgets_Button extends \Elementor\Widget_Button {
    public function get_title(): string {
        return 'DJC ' . parent::get_title();
    }
    
    protected static function get_button_types(): array {
        return [
            'black'             => __('Zwart', 'djc-elements'),
            'black-outlined'    => __('Zwart omlijnd', 'djc-elements'),
            'primary'           => __('Primair', 'djc-elements'),
            'primary-outlined'  => __('Primair omlijnd', 'djc-elements'),
            'secondary'         => __('Secondair', 'djc-elements'),
            'secondary-outlined'=> __('Secondair omlijnd', 'djc-elements'),
        ];
    }
    
    protected function _register_controls(): void {
        parent::_register_controls();
        
        $this->start_controls_section(
            'section_style_overrides',
            [
                'label' => __('Button', 'elementor') . ' Type',
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_control(
            'button_type_style',
            [
                'label' => __( 'Type', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'black',
                'options' => self::get_button_types(),
                'style_transfer' => true,
            ]
        );
    
        $this->end_controls_section();
    }
    
    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('button', 'class', ['btn', 'djc-button', $settings['button_type_style']]);
        
        parent::render();
    }
}
