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
    
        $this->add_group_control(
            \ElementorPro\Modules\QueryControl\Controls\Group_Control_Query::get_type(),
            [
                'name' => $this->get_name(),
                'presets' => [ 'include', 'exclude' ],
                'exclude' => [
                    'posts_per_page',
                ],
            ]
        );
        
        $this->add_control(
            'reverse',
            [
                'label'     => __('Reverse', 'djc-elements'),
                'type'      => \Elementor\Controls_Manager::SWITCHER
            ]
        );
    
        $this->end_controls_section();
    }
    
    protected function _register_controls(): void {
        $this->register_content_controls();
    }
    
    protected function render(): void {
        $settings = $this->get_settings();
        if (count($settings['project-cta_posts_ids']) === 0) {
            return;
        }
        
        if (count($settings['project-cta_posts_ids']) > 1) {
            $loop = 1;
            foreach ($settings['project-cta_posts_ids'] as $id) {
                // Makes the loop go reverse -> not reverse or vice versa.
                $reverse = ((bool) $settings['reverse'])?
                    $loop % 2 !== 0 :
                    $loop % 2 === 0;
                
                $this->single_render($id, $reverse);
                $loop++;
            }
            return;
        }
        
        $id = $settings['project-cta_posts_ids'][0];
        $reverse = (bool) $settings['reverse'];
        
        $this->single_render($id, $reverse);
    }
    
    protected function single_render($id, $reverse = false): void {
        $project = new Djc_Elements_Project_Banner($id);
        ?>
        <article class="related-project-banner" data-reversed="<?=$reverse?>" data-id="<?=$id?>">
            <?php if ($reverse): ?>
                <?php $project->renderImage(); ?>
                <?php $project->renderContent(); ?>
            <?php else: ?>
                <?php $project->renderContent(); ?>
                <?php $project->renderImage(); ?>
            <?php endif; ?>
        </article>
        <?php
    }
}
