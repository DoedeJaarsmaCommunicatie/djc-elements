<?php
defined('ABSPATH') || exit; // Exit if accessed directly.

class Djc_Elements_Project_Banner extends Djc_Elements_Project {
   
    public function renderContent(): void {
        ?>
        <main class="related-project-content">
            <h2 class="related-project-title">
                <a href="<?=$this->link?>" title="<?= sprintf(__('Bekijk %s', 'djc-elements'), $this->title) ?>">
                    <?=$this->title?>
                </a>
            </h2>
            <section class="related-project-pills">
                <?php $this->renderServices(); ?>
            </section>
            <p class="related-project-excerpt"><?=$this->excerpt?></p>
            <?php $this->renderButton(); ?>
        </main>
        <?php
    }
    
    protected function renderButton(): void {
        ?>
        <a href="<?=$this->link?>" title="<?= sprintf(__('Bekijk %s', 'djc-elements'), $this->title)?>" target="_self" class="related-project-button">
            <?= sprintf(__('Bekijk project', 'djc-elements'))?>
        </a>
        <?php
    }
    
    protected function renderServices(): void {
        if (!function_exists('get_field')) {
            return;
        }
        $services = get_field( 'dienst', $this->id);
        
        if (!$services) {
            return;
        }
        
        foreach ($services as $service) {
            $pill = new Djc_Elements_Pill($service);
            $pill->render();
        }
    }
    
    public function renderImage($use_lazyload = false): void {
        ?>
        <figure class="related-project-figure">
            <a href="<?=$this->link?>" title="<?= sprintf(__('Bekijk %s', 'djc-elements'), $this->title) ?>">
                <img
                     <?php if ($use_lazyload): ?>
                     data-src="<?=$this->thumbnail?>"
                     <?php else: ?>
                     src="<?=$this->thumbnail?>"
                     <?php endif; ?>
                     alt="<?=$this->title?>"
                     class="related-project-image" />
            </a>
        </figure>
        <?php
    }
}
