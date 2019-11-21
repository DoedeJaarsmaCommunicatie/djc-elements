<?php
defined('ABSPATH') || exit; // exit if accessed directly.

class Djc_Elements_Project {
    protected static $project_cache = [];

    public $id;
    public $link;
    public $title;
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
        $this->thumbnail = $this->getThumbnail('large');
    }

    public function getThumbnail($size = 'large'): string {
        $url = get_the_post_thumbnail_url($this->id, $size);

        if (!$url) {
            return '//via.placeholder.com/1200x600';
        }

        return $url;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public static function find($id) {
        if (isset(static::$project_cache[$id])) {
            return static::$project_cache[$id];
        }

        return static::$project_cache[$id] = new static($id);
    }

    /**
     * @param \WP_Post $post
     *
     * @return Djc_Elements_Project|mixed
     */
    public static function create($post) {
        if (isset(static::$project_cache[$post->ID])) {
            return static::$project_cache[$post->ID];
        }

        return static::$project_cache[$post->ID] = new static($post);
    }
}
