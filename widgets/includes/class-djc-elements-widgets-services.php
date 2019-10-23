<?php
defined('ABSPATH') || exit;

class Djc_Elements_Widgets_Services extends \Elementor\Widget_Base {
    public function get_name() {
        return 'services';
    }
    
    public function get_title() {
        return __('Diensten', 'djc-elements');
    }
    
    public function get_icon() {
        return 'eicon-slider-push';
    }
    
    protected function render() {
        $current = get_queried_object_id();
        $services = get_posts([
            'post_type'     => 'dienst',
            'exclude'       => [ $current ],
            'numberposts'   => -1,
            'post_parent'   => 0
        ]);
        
        if (count($services) === 0) {
            return;
        }
        ?>
        <section class="service-wrapper diensten">
            <?php
                foreach ($services as $service) {
                    $this->render_card($service);
                }
            ?>
        </section>
        <?php
        }
    
    /**
     * @param \WP_Post $post
     */
    private function render_card($post) {
        add_filter('excerpt_length', static function () { return 15; });
        
        $id = $post->ID;
        $title = get_the_title($id);
        $excerpt = str_replace('[&hellip;]', '', get_the_excerpt($id));
        $link = get_the_permalink($id); ?>
        <article class="service dienst">
            <h3 class="service-title">
                <a href="<?=$link?>" target="_self" title="Bekijk <?=$title?>">
                    <?=$title?>
                </a>
            </h3>
            <p class="service-content"><?=$excerpt?></p>
            <a href="<?=$link?>" target="_self" title="Bekijk <?=$title?>" class="service-fab subservice-fab">
                <i class="fas fa-chevron-right"></i>
            </a>
        </article>
        <?php
        
        add_filter('excerpt_length', static function () { return 55; });
    }
}
