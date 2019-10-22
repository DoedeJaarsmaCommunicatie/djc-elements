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
                'presets' => [ 'full' ],
                'exclude' => [
                    'posts_per_page', //use the one from Layout section
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
    
    protected function render() {
        $settings = $this->get_settings();
        $id = $settings['project-cta_posts_ids'][0];
        $reverse = (bool) $settings['reverse'];
        ?>
        <article class="related-project-banner">
            <?php if ($reverse): ?>
                <?php $this->image_render($id); ?>
                <?php $this->content_render($id); ?>
            <?php else: ?>
                <?php $this->content_render($id); ?>
                <?php $this->image_render($id); ?>
            <?php endif; ?>
        </article>
        <?php
    }
    
    /**
     * @param int $id
     */
    protected function content_render($id) {
        add_filter('excerpt_more','__return_false');
    
        $title = get_the_title($id);
        $excerpt = get_the_excerpt($id);
        ?>
        <main class="related-project-content">
            <h2 class="related-project-title"><?=$title?></h2>
            <p class="related-project-excerpt">
                <?=$excerpt?>
            </p>
        </main>
        <?php
    }
    
    protected function image_render($id) {
        $title = get_the_title($id);
        $thumbnail = get_the_post_thumbnail_url($id);
        ?>
        <figure class="related-project-figure">
            <img src="<?=$thumbnail?>" alt="<?=$title?>" class="related-project-image" />
        </figure>
        <?php
    }
}
