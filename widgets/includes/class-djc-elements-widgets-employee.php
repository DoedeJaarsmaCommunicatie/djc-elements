<?php
defined('ABSPATH') || exit; // Exit if accessed directly.

class Djc_Elements_Widgets_Employee extends \Elementor\Widget_Base {
    public function get_name() {
        return 'employee-select';
    }
    
    public function get_title() {
        return __('Employee selector', 'djc-elements');
    }
    
    public function get_icon() {
        return 'eicon-person';
    }
    
    protected function _register_controls() {
        $this->start_controls_section(
            'content',
            [
                'label'     => __('Content', 'elementor'),
                'tab'       => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        
        $this->add_control(
                'title',
                [
                    'label'     => __('Title'),
                    'type'      => \Elementor\Controls_Manager::TEXT,
                    'default'   => 'Meer weten over dit project?'
                ]
        );
    
        $this->add_group_control(
            \ElementorPro\Modules\QueryControl\Controls\Group_Control_Query::get_type(),
            [
                'name' => $this->get_name(),
                'presets' => [ 'include', 'exclude' ]
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $ids = $settings['employee-select_posts_ids'];
        
        if (!function_exists('get_field')) {
            return;
        }
        
        if (count($ids) !== 1) {
            return;
        }
        
        foreach ($ids as $id) {
            $this->content_render($id, $settings['title']);
        }
        
    }
    
    private function content_render($id, $title = null) {
        $employee = Djc_Elements_Employee::find($id);
        ?>
        <section class="employee-wrapper">
            <figure class="employee-figure">
                <img src="<?=$employee->getThumbnail()?>" alt="<?=$employee->title?>" class="employee-image" />
            </figure>
            <main class="employee-content">
                <h3 class="employee-name djc-title"><?=$title?? 'Meer weten over dit project?'?></h3>
                <p>Neem contact op met <?=$employee->getFirstName()?></p>
                <aside class="employee-contact">
                    <?php if ($employee->phone): ?>
                    <p class="employee-phone">
                        <span class="employee-letter">
                            T:
                        </span>
                        <a class="employee-contact-method" href="tel:<?=$employee->phone?>">
                            <?=$employee->phone?>
                        </a>
                    </p>
                    <?php endif; ?>
                    <p class="employee-email">
                        <span class="employee-letter">M:</span>
                        <a href="mailto:<?=$employee->email?>" class="employee-contact-method">
                            <?=$employee->email?>
                        </a>
                    </p>
                </aside>
            </main>
        </section>
        <?php
    }
}
