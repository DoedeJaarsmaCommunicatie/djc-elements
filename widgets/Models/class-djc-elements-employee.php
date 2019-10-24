<?php
defined('ABSPATH') || exit; // Exit if accessed directly.

class Djc_Elements_Employee {
    protected static $employee_cache = [];
    
    public $id;
    public $link;
    public $title;
    public $email;
    public $phone;
    public $excerpt;
    public $thumbnail;
    
    /**
     * @var \WP_Post
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
        $this->phone = get_field('phone', $this->id);
        $this->email = get_field('email', $this->id);
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
        $this->phone = get_field('phone', $this->id);
        $this->email = get_field('email', $this->id);
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
    
    public function getThumbnail($size = 'medium') {
        return wp_get_attachment_image_url(
            get_field('thumbnail', $this->id),
            $size
        );
    }
    
    public function getFirstName() {
        return explode(' ', $this->title)[0];
    }
    
    /**
     * @param int $id
     *
     * @return Djc_Elements_Employee
     */
    public static function find($id) {
        if (isset(static::$employee_cache[$id])) {
            return static::$employee_cache[$id];
        }
        
        return static::$employee_cache[$id] = new static($id);
    }
    
    /**
     * @param \WP_Post $post
     *
     * @return Djc_Elements_Employee
     */
    public static function create($post) {
        if (isset(static::$employee_cache[$post->ID])) {
            return static::$employee_cache[$post->ID];
        }
        
        return static::$employee_cache[$post->ID] = new static($post->ID);
    }
}
