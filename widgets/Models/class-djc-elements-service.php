<?php

defined('ABSPATH') || exit; // Exit if accessed directly.

class Djc_Elements_Service {
    protected static $service_cache = [];
    protected static $services_cache = [];
    
    public $id;
    public $title;
    public $excerpt;
    public $link;
    
    /**
     * @var \WP_Post $post
     */
    public $post;
    
    /**
     * Djc_Elements_Service constructor.
     *
     * @param int|\WP_Post $post
     */
    public function __construct($post) {
        if ($post instanceof \WP_Post) {
            $this->constructFromPost($post);
        } else {
            $this->constructFromId($post);
        }
    }
    
    /**
     * @param \WP_Post $post
     */
    private function constructFromPost($post): void {
        $this->post = $post;
        $this->id = $this->post->ID;
        $this->title = $this->post->post_title;
        $this->setExcerpt();
        $this->setLink();
    }
    
    /**
     * @param int $id
     */
    private function constructFromId($id): void {
        $this->id = $id;
        $this->post = get_post($this->id);
        $this->title = $this->post->post_title;
        $this->setExcerpt();
        $this->setLink();
    }
    
    public function getExcerpt() {
        return str_replace('[&hellip;]', '..', $this->excerpt);
    }
    
    public function setLink(): void {
        $this->link = get_the_permalink($this->id);
    }
    
    public function setExcerpt(): void {
        $excerpt = $this->post->post_excerpt !== '' ?
            $this->post->post_excerpt :
            $this->post->post_content;
        
        $this->excerpt = wp_trim_words( $excerpt, 15 ) . '..';
    }
    
    /**
     * Returns all services.
     *
     * @param int      $limit
     * @param int      $offset
     * @param bool|int $exclude_self
     *
     * @return self[]|[]
     */
    public static function all($limit = -1, $offset = 0, $exclude_self = false): array {
        $key = "dienst_{$limit}_{$offset}";
        if (isset(static::$services_cache[$key])) {
            return static::$services_cache[$key];
        }
        
        $args = [
            'post_type'     => 'dienst',
            'numberposts'   => $limit,
            'post_parent'   => 0,
            'offset'        => $offset
        ];
        
        if ($exclude_self) {
            $args['exclude'] = [$exclude_self];
        }
        
        $services = get_posts($args);
        
        $self = [];
        
        foreach($services as $service) {
            $self []= new static($service);
        }
        
        return static::$services_cache[$key] = $self;
    }
    
    /**
     * Returns an instance of this class based on the passed integer
     *
     * @param int $id
     *
     * @return Djc_Elements_Service
     */
    public static function find($id): self {
        if (isset(static::$service_cache[$id])) {
            return static::$services_cache[$id];
        }
        
        return static::$service_cache[$id] = new static($id);
    }
    
    /**
     * Returns an instance of this class based on the WP_Post
     *
     * @param \WP_Post $post
     *
     * @return Djc_Elements_Service
     */
    public static function create($post): self {
        if (isset(static::$service_cache[$post->ID])) {
            return static::$services_cache[$post->ID];
        }
    
        return static::$service_cache[$post->ID] = new static($post);
    }
}
