<?php

use Elementor\Widget_Text_Editor;

defined('ABSPATH') || die;

class Djc_Elements_Widgets_Content extends Widget_Text_Editor {
    public function get_title(): string {
        return 'DJC Content';
    }
    
    protected function render(): void {
        $this->add_render_attribute('editor', 'class', ['content']);
        
        parent::render();
    }
    
    protected function _content_template(): void {
        ?>
        <#
        view.addRenderAttribute( 'editor', 'class', [ 'content' ] );
        #>
        <?php
        parent::_content_template();
    }
}
