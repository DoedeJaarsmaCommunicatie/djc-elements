<?php

use Elementor\Base_Data_Control;

class Djc_Elements_Controls_Projects extends Base_Data_Control {
    public static $type = 'project-loader';
    
    public function get_type(): string {
        return static::$type;
    }
    
    public function content_template() {
        $control_uid = $this->get_control_uid();
        $projects = $this->get_projects();
        ?>
        <div class="elementor-control-field">
            <label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <?php var_dump($projects); ?>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }
    
    protected function get_projects() {
        return get_posts(['post_type' => 'projecten']);
    }
}
