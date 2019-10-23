<?php
defined('ABSPATH') || exit;

class Djc_Elements_widgets_Portfolio extends \Elementor\Widget_Base {
    protected static $current_page_cache = null;
    
    public function get_name() {
        return 'projects-portfolio';
    }
    
    public function get_title() {
        return __('Project portfolio', 'djc-elements');
    }
    
    protected function render() {
        $projects = $this->get_projects();
        
        $loop = 1;
        foreach ($projects as $id) {
            $reverse = $loop % 2 !== 0;
            $this->single_render($id, $reverse);
            $loop++;
        }
        
        $this->pagination_render();
    }
    
    protected function get_projects() {
        $page = self::get_current_page();
        $page = $page === 0 ? 1 : $page;
        $num_posts = 5;
        return get_posts([
            'post_type'     => 'project',
            'numberposts'   => $num_posts,
            'offset'        => $num_posts * ($page - 1),
            'fields'        => 'ids'
        ]);
    }
    
    protected function pagination_render() {
        $projects = wp_count_posts('project');
        $pages = (int) ceil($projects->publish / 5);
        
        for ($i = 1; $i <= $pages; $i++) {
            $is_active = (self::get_current_page() > 0) ?
                $i === self::get_current_page() :
                $i === (self::get_current_page() + 1);
            $this->pagination_button_render($i, $i, $is_active);
        }
    }
    
    protected static function get_current_page() {
        if (static::$current_page_cache) {
            return static::$current_page_cache;
        }
        return static::$current_page_cache = get_query_var('page', 1);
    }
    
    protected function pagination_button_render($page_to, $content, $is_active = false) {
        ?>
        <a href="/portfolio/<?=$page_to?>/" class="pagination <?=$is_active ? 'active': ''?>">
            <?=$content?>
        </a>
        <?php
    }
    
    protected function single_render($id, $reverse = false): void {
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
    protected function content_render($id): void {
        add_filter('excerpt_length', static function () { return 35; });
        
        $title = get_the_title($id);
        $excerpt = str_replace('[&hellip;]', '', get_the_excerpt($id));
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
        
        add_filter('excerpt_length', static function () { return 55; });
    }
    
    protected function image_render($id): void {
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
    
    protected function button_render($id): void {
        $title = get_the_title($id);
        $permalink = get_the_permalink($id);
        ?>
        <a href="<?=$permalink?>" title="<?= sprintf(__('Bekijk %s', 'djc-elements'), $title)?>" target="_self" class="related-project-button">
            <?= sprintf(__('Bekijk project', 'djc-elements'))?>
        </a>
        <?php
    }
    
    protected function services_render($id): void {
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
