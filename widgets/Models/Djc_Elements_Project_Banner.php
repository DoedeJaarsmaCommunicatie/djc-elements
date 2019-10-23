<?php


class Djc_Elements_Project_Banner {
    public $id;
    public $link;
    public $title;
    public $excerpt;
    public $thumbnail;
    
    /**
     * Djc_Elements_Project_Banner constructor.
     *
     * @param \WP_Post|int $post
     */
    public function __construct($post) {
        add_filter('excerpt_length', static function () { return 35; });
        if ($post instanceof \WP_Post) {
            $this->constructWpPost($post);
        } else {
            $this->construct($post);
        }
        add_filter('excerpt_length', static function () { return 55; });
    }
    
    /**
     * @param \WP_Post $post
     */
    public function constructWpPost($post) {
        $this->id = $post->ID;
        $this->title = $post->post_title;
        $this->setThumbnail();
        $this->setExcerpt();
        $this->setLink();
    }
    
    /**
     * @param int $id
     */
    public function construct($id) {
        $this->id = $id;
        $this->title = get_the_title($this->id);
        $this->setThumbnail();
        $this->setExcerpt();
        $this->setLink();
    }
    
    public function setLink(): void {
        $this->link = get_permalink($this->id);
    }
    
    public function setExcerpt(): void {
        $this->excerpt = get_the_excerpt($this->id);
    }
    
    public function setThumbnail() {
        $this->thumbnail = get_the_post_thumbnail_url($this->id);
    }
    
    public function getExcerpt() {
      return str_replace('[&hellip;]', '', $this->excerpt);
    }
    
    public function renderContent() {
        ?>
        <main class="related-project-content">
            <h2 class="related-project-title">
                <a href="<?=$this->link?>" title="<?= sprintf(__('Bekijk %s', 'djc-elements'), $this->title) ?>">
                    <?=$this->title?>
                </a>
            </h2>
            <section class="related-project-pills">
                <?php $this->renderServices($this->id); ?>
            </section>
            <p class="related-project-excerpt"><?=$this->getExcerpt()?></p>
            <?php $this->renderButton(); ?>
        </main>
        <?php
    }
    
    protected function renderButton(): void {
        ?>
        <a href="<?=$this->link?>" title="<?= sprintf(__('Bekijk %s', 'djc-elements'), $this->title)?>" target="_self" class="related-project-button">
            <?= sprintf(__('Bekijk project', 'djc-elements'))?>
        </a>
        <?php
    }
    
    protected function renderServices($id): void {
        if (!function_exists('get_field')) {
            return;
        }
        $services = get_field( 'dienst', $id);
        
        foreach ($services as $service) {
            $pill = new Djc_Elements_Pill($service);
            $pill->render();
        }
    }
    
    public function renderImage(): void {
        ?>
        <figure class="related-project-figure">
            <a href="<?=$this->link?>" title="<?= sprintf(__('Bekijk %s', 'djc-elements'), $this->title) ?>">
                <img src="<?=$this->thumbnail?>" alt="<?=$this->title?>" class="related-project-image" />
            </a>
        </figure>
        <?php
    }
}
