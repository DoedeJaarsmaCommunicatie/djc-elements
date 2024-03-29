<?php
defined('ABSPATH') || exit; // Exit if accessed directly.

class Djc_Elements_Widgets_Heading extends \Elementor\Widget_Heading {
    public function get_title() {
        return 'DJC ' . parent::get_title();
    }
    
    protected function render() {
        $this->add_render_attribute('title', 'class', ['content', 'djc-title']);
        
        return parent::render();
    }
    
    protected function _content_template() {
        ?>
        <#
        view.addRenderAttribute('title', 'class', [ 'content', 'djc-title' ]);
        #>
        <?php
        parent::_content_template();
    }
}
