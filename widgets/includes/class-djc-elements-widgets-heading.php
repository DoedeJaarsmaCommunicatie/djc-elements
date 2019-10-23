<?php
defined('ABSPATH') || exit; // exit if accessed directly

class Djc_Elements_Widgets_Heading extends \Elementor\Widget_Heading {
    public function get_title() {
        return 'DJC ' . __('Heading', 'elementor');
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
