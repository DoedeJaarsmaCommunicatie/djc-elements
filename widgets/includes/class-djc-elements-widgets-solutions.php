<?php

use Elementor\Widget_Base;

class Djc_Elements_Widgets_Solutions extends Widget_Base {
    public function get_name() {
        return 'sub-services';
    }
    
    public function get_title() {
        return 'Subdiensten';
    }
    
    public function get_icon() {
        return 'eicon-slider-push';
    }
    
    protected function render() {
        $parent = get_queried_object_id();
        $children = get_children([
            'post_parent' => $parent,
            'numberposts' => -1,
            'post_status' => 'publish'
        ]);
        ?>
        <section class="subservice-wrapper diensten">
            <?php
            foreach ($children as $child)
                $this->render_card($child); ?>
        </section>
        <?php
    }
    
    /**
     * @param WP_Post $post the post to render.
     */
    private function render_card($post) {
        add_filter('excerpt_more','__return_false');
        add_filter('excerpt_length', static function () { return 15; });
        $id = $post->ID;
        $title = get_the_title($id);
        $excerpt = get_the_excerpt($id);
        $link = get_the_permalink($id);
        ?>
            <article class="subservice dienst">
                <h3 class="subservice-title">
                    <a href="<?=$link?>" target="_self" title="Bekijk <?=$title?>" class="subservice-fab">
                        <?=$title?>
                    </a>
                </h3>
                <p class="subservice-content"><?=$excerpt?></p>
                <a href="<?=$link?>" target="_self" title="Bekijk <?=$title?>" class="subservice-fab">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </article>
        <?php
        add_filter('excerpt_more', static function () { return '[&hellip;]'; });
        add_filter('excerpt_length', static function () { return 55; });
    }
}
