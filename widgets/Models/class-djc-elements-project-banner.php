<?php


class Djc_Elements_Project_Banner {
    public $id;
    public $link;
    public $title;
    public $excerpt;
    public $thumbnail;
    
    /**
     * @var \WP_Post $post
     */
    public $post;
    
    /**
     * Djc_Elements_Project_Banner constructor.
     *
     * @param \WP_Post|int $post
     */
    public function __construct($post) {
        if ($post instanceof \WP_Post) {
            $this->constructWpPost($post);
        } else {
            $this->construct($post);
        }
    }
    
    /**
     * @param \WP_Post $post
     */
    public function constructWpPost($post): void {
        $this->id = $post->ID;
        $this->title = $post->post_title;
        $this->post = $post;
        $this->setThumbnail();
        $this->setExcerpt();
        $this->setLink();
    }
    
    /**
     * @param int $id
     */
    public function construct($id): void {
        $this->id = $id;
        $this->title = get_the_title($this->id);
        $this->post = get_post($id);
        $this->setThumbnail();
        $this->setExcerpt();
        $this->setLink();
    }
    
    public function setLink(): void {
        $this->link = get_permalink($this->id);
    }
    
    public function setExcerpt(): void {
        $excerpt = $this->post->post_excerpt !== '' ?
            $this->post->post_excerpt :
            $this->post->post_content;
        
        $this->excerpt = wp_trim_words($excerpt, 35);
    }
    
    public function setThumbnail(): void {
        $url = get_the_post_thumbnail_url($this->id);
        $this->thumbnail = $url !== false ?
            $url :
            '//via.placeholder.com/1200x600';
    }
    
    public function renderContent(): void {
        ?>
        <main class="related-project-content">
            <h2 class="related-project-title">
                <a href="<?=$this->link?>" title="<?= sprintf(__('Bekijk %s', 'djc-elements'), $this->title) ?>">
                    <?=$this->title?>
                </a>
            </h2>
            <section class="related-project-pills">
                <?php $this->renderServices(); ?>
            </section>
            <p class="related-project-excerpt"><?=$this->excerpt?></p>
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
    
    protected function renderServices(): void {
        if (!function_exists('get_field')) {
            return;
        }
        $services = get_field( 'dienst', $this->id);
        
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
