<?php

use Elementor\Widget_Base;

class Djc_Elements_Widgets_CTA extends Widget_Base {
    public function get_name(): string {
        return 'project-cta';
    }
    
    public function get_title(): string {
        return 'Project CTA';
    }
    
    public function get_icon(): string {
        return 'eicon-image-rollover';
    }
    
    private function register_content_controls(): void {
        $this->start_controls_section(
            'content',
            [
                'label' => __( 'Content'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control( 'project', [
            'label'     => 'Project',
            'type'      => Djc_Elements_Controls_Projects::$type
        ]);
    
        $this->end_controls_section();
    }
    
    protected function _register_controls(): void {
        $this->register_content_controls();
    }
}
