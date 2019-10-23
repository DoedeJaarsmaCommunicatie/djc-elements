<?php


class Djc_Elements_Pill {
    public $id;
    public $type;
    public $title;
    public $link;
    
    /**
     * Pill constructor.
     * @var \WP_Post|int $post The post to chip.
     */
    public function __construct($post) {
        if ($post instanceof \WP_Post) {
            $this->instantiateWpPost($post);
        } else {
            $this->instantiate($post);
        }
    }
    
    /**
     * Renders the pill HTML
     */
    public function render(): void {
        ?>
        <a href="<?=$this->link?>" class="related-pill" data-title="<?=$this->title?>" data-id="<?=$this->id?>" data-type="<?=$this->type?>">
            <?=$this->title?>
        </a>
        <?php
    }
    
    /**
     * @param \WP_Post $post
     */
    protected function instantiateWpPost($post) {
        $this->id = $post->ID;
        $this->type = $post->post_type;
        $this->title = $post->post_title;
        $this->setLink();
    }
    
    /**
     * @param int $post
     */
    protected function instantiate($post) {
        $this->id = $post;
        $this->type = get_post_type($post);
        $this->title = get_the_title($post);
        $this->setLink();
    }
    
    public function setLink() {
        $this->link = get_permalink($this->id);
    }
}
