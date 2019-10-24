<?php
defined('ABSPATH') || exit; // Exit if accessed directly.

class Djc_Elements_widgets_Portfolio extends \Elementor\Widget_Base {
    protected static $current_page_cache = null;
    protected static $current_page_id = null;
    
    public function get_name() {
        return 'projects-portfolio';
    }
    
    public function get_title() {
        return __('Project portfolio', 'djc-elements');
    }
    
    protected function render(): void {
        $projects = $this->get_projects();
        
        $this->filter_render();
        
        $this->projects_render($projects);
        
        $this->pagination_render();
    }
    
    protected function get_projects() {
        return get_posts(static::get_query_args_projects());
    }
    
    protected function pagination_render(): void {
        $projects = static::count_projects();
        $pages = (int) ceil($projects / 5);
        ?>
        <aside class="pagination-wrapper">
        <?php
            for ($i = 1; $i <= $pages; $i++) {
                $is_active = ( self::get_current_pageId() > 0) ?
                    $i === self::get_current_pageId() :
                    $i === ( self::get_current_pageId() + 1);
                $this->pagination_button_render($i, $i, $is_active);
            } ?>
        </aside>
        <?php
    }
    
    protected function filter_render(): void {
        $services = get_posts([
            'post_type'     => 'dienst',
            'numberposts'   => -1,
            'post_parent'   => 0
        ]);
        ?>
        <aside class="filter-wrapper">
        <?php
        foreach ($services as $service) {
            $this->filter_button_render($service);
        } ?>
        </aside>
        <?php
    }
    
    protected function filter_button_render($service): void {
        $url = get_the_permalink(static::get_current_object_id());
        ?>
        <a href="<?=$url?>?service=<?=$service->ID?>" class="project-filter" target="_self" data-slug="<?=sanitize_title($service->post_title)?>" data-id="<?=$service->ID?>">
            <?=$service->post_title?>
        </a>
        <?php
    }
    
    protected function pagination_button_render($page_to, $content, $is_active = false): void {
        $url = get_the_permalink(static::get_current_object_id());
        
        $url .= "?page=$page_to";
        if (isset($_GET['service'])) {
            $url .= '&service=' . $_GET['service'];
        }
        ?>
        <a href="<?=$url?>" class="pagination <?=$is_active ? 'active': ''?>">
            <?=$content?>
        </a>
        <?php
    }
    
    protected function projects_render($projects = []): void {
        if (count($projects) === 0) {
            return;
        }
    
        $loop = 1;
        foreach ($projects as $id) {
            $reverse = $loop % 2 !== 0;
            $this->single_render($id, $reverse);
            $loop++;
        }
    }
    
    protected function single_render($id, $reverse = false): void {
        $project = Djc_Elements_Project_Banner::find($id);
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
    
    protected static function get_current_pageId() {
        if (static::$current_page_cache) {
            return static::$current_page_cache;
        }
        return static::$current_page_cache = get_query_var('page', 1);
    }
    
    protected static function get_current_object_id() {
        if (null !== static::$current_page_id) {
            return static::$current_page_id;
        }
        
        return static::$current_page_id = get_queried_object_id();
    }
    
    protected static function count_projects(): int {
        $args = static::get_query_args_projects();
        
        unset($args['offset']);
        $args['numberposts'] = -1;
        
        return count(get_posts($args));
    }
    
    protected static function get_query_args_projects(): array {
        $page = self::get_current_pageId();
        $page = $page === 0 ? 1 : $page;
        $num_posts = 5;
    
        $args = [
            'post_type'     => 'project',
            'numberposts'   => $num_posts,
            'offset'        => $num_posts * ($page - 1),
            'fields'        => 'ids'
        ];
    
        if (isset($_GET['service'])) {
            $args['meta_query']   = [
                [
                    'key'       => 'dienst',
                    'value'     => '"' . $_GET['service'] . '"',
                    'compare'   => 'LIKE'
                ]
            ];
        }
        
        return $args;
    }
}
