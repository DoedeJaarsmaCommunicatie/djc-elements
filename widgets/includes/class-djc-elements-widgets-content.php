<?php

class Djc_Elements_Widgets_Content extends \Elementor\Widget_Text_Editor {
    public function get_title() {
        return 'DJC Content';
    }
    
    protected function render() {
        $this->add_render_attribute('editor', 'class', ['content']);
        
        parent::render();
    }
    
    protected function _content_template() {
        ?>
        <#
        view.addRenderAttribute( 'editor', 'class', [ 'content' ] );
        #>
        <?php
        parent::_content_template();
    }
}
