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
        <article class="related-project-banner" data-reversed="<?=$reverse?>" data-id="<?=$id?>">
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
        add_filter('excerpt_length', static function () { return 35; });
        $title = get_the_title($id);
        $excerpt = get_the_excerpt($id);
        $link = get_the_permalink($id);
        ?>
        <main class="related-project-content">
            <h2 class="related-project-title">
                <a href="<?=$link?>" title="<?= sprintf(__('Bekijk %s', 'djc-elements'), $title) ?>">
                    <?=$title?>
                </a>
            </h2>
            <section class="related-project-pills">
                <?php $this->services_render($id); ?>
            </section>
            <p class="related-project-excerpt"><?=$excerpt?></p>
            <?php $this->button_render($id); ?>
        </main>
        <?php
    }
    
    protected function image_render($id) {
        $title = get_the_title($id);
        $thumbnail = get_the_post_thumbnail_url($id);
        $link = get_the_permalink($id);
        ?>
        <figure class="related-project-figure">
            <a href="<?= $link?>" title="<?= sprintf(__('Bekijk %s', 'djc-elements'), $title) ?>">
                <img src="<?=$thumbnail?>" alt="<?=$title?>" class="related-project-image" />
            </a>
        </figure>
        <?php
    }
    
    protected function button_render($id) {
        $title = get_the_title($id);
        $permalink = get_the_permalink($id);
        ?>
            <a href="<?=$permalink?>" title="<?= sprintf(__('Bekijk %s', 'djc-elements'), $title)?>" target="_self" class="related-project-button">
                <?= sprintf(__('Bekijk project', 'djc-elements'))?>
            </a>
        <?php
    }
    
    protected function services_render($id) {
        if (!function_exists('get_field')) {
            return;
        }
        
        $services = get_field( 'dienst', $id);
        foreach ($services as $service) {
            $this->pill_generator($service);
        }
    }
    
    /**
     * @param WP_Post $post
     */
    protected function pill_generator($post) {
        $id = $post->ID;
        $type = $post->post_type;
        $title = $post->post_title;
        $link = get_the_permalink($id);
        ?>
            <a href="<?=$link?>" class="related-pill" data-title="<?=$title?>" data-id="<?=$id?>" data-type="<?=$type?>">
                <?=$title?>
            </a>
        <?php
    }
}
