<?php
defined('ABSPATH') || exit; // Exit if accessed directly.

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
    
    protected function render(): void {
        $current = get_queried_object_id();
        $services = Djc_Elements_Service::all(-1, 0, $current);
        
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
     * @param Djc_Elements_Service $post
     */
    private function render_card($post): void {
        $title = $post->title;
        $excerpt = $post->excerpt;
        $link = $post->link; ?>
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
    }
}
