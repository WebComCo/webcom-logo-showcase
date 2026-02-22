<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Webcom_Logo_Widget extends Widget_Base {
    public function get_name() { return 'webcom_logo_showcase'; }
    public function get_title() { return 'لوگوی مشتریان (وبکام)'; }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'general' ]; }

    protected function register_controls() {
        // --- بخش محتوا ---
        $this->start_controls_section('content', ['label' => 'تنظیمات']);

        $this->add_control('animation_style', [
            'label' => 'افکت انیمیشن',
            'type' => Controls_Manager::SELECT,
            'default' => 'wls-fade',
            'options' => [
                'wls-fade' => 'Fade', 'wls-zoom' => 'Zoom', 'wls-slide' => 'Slide', 'wls-rotate' => 'Rotate', 'wls-blur' => 'Blur'
            ],
        ]);

        $this->add_control('swap_count', [
            'label' => 'تعداد لوگوهای در حال تغییر (همزمان)',
            'type' => Controls_Manager::NUMBER,
            'min' => 1, 'max' => 4, 'default' => 2,
        ]);

        $this->add_control('swap_interval', [
            'label' => 'فاصله زمانی (میلی‌ثانیه)',
            'type' => Controls_Manager::NUMBER,
            'default' => 3000,
        ]);

        $this->end_controls_section();

        // --- بخش استایل شبکه ---
        $this->start_controls_section('grid_style', ['label' => 'تنظیمات شبکه و خطوط', 'tab' => Controls_Manager::TAB_STYLE]);

        $this->add_control('item_bg', [
            'label' => 'رنگ پس‌زمینه باکس‌ها',
            'type' => Controls_Manager::COLOR,
            'default' => '#0a192f',
            'selectors' => ['{{WRAPPER}} .wls-logo-grid' => '--wls-item-bg: {{VALUE}};']
        ]);

        $this->add_control('border_color', [
            'label' => 'رنگ خطوط جداکننده',
            'type' => Controls_Manager::COLOR,
            'default' => 'rgba(255,255,255,0.1)',
            'selectors' => ['{{WRAPPER}} .wls-logo-grid' => '--wls-border-color: {{VALUE}};']
        ]);

        $this->add_control('border_width', [
            'label' => 'ضخامت خطوط',
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0.1, 'max' => 5, 'step' => 0.1]],
            'default' => ['size' => 1],
            'selectors' => ['{{WRAPPER}} .wls-logo-grid' => '--wls-border-width: {{SIZE}}px;']
        ]);

        $this->end_controls_section();

        // --- بخش استایل لوگوها ---
        $this->start_controls_section('logo_style', ['label' => 'ابعاد و لوگوها', 'tab' => Controls_Manager::TAB_STYLE]);

        $this->add_responsive_control('cell_height', [
            'label' => 'ارتفاع باکس لوگو',
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 100, 'max' => 250, 'step' => 1]],
            'default' => ['size' => 150],
            'selectors' => ['{{WRAPPER}} .wls-logo-grid' => '--wls-cell-height: {{SIZE}}px;']
        ]);

        $this->add_responsive_control('img_max_height', [
            'label' => 'حداکثر ارتفاع لوگو (تصویر)',
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 50, 'max' => 200, 'step' => 1]],
            'default' => ['size' => 70],
            'selectors' => ['{{WRAPPER}} .wls-logo-grid' => '--wls-img-height: {{SIZE}}px;']
        ]);

        $this->add_control('logo_opacity', [
            'label' => 'شفافیت لوگو (قبل از هاور)',
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0.01, 'max' => 1, 'step' => 0.01]],
            'default' => ['size' => 0.3],
            'selectors' => ['{{WRAPPER}} .wls-logo-grid' => '--wls-opacity: {{SIZE}};']
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $query = new WP_Query(['post_type' => 'webcom_logo', 'posts_per_page' => 50, 'orderby' => 'rand']);
        if ( ! $query->have_posts() ) return;

        $all_logos = [];
        while($query->have_posts()){
            $query->the_post();
            $all_logos[] = [
                'src' => get_the_post_thumbnail_url(null, 'full'),
                'link' => get_post_meta(get_the_ID(), '_logo_url', true) ?: '#',
                'title' => get_the_title()
            ];
        }
        wp_reset_postdata();

        $visible = array_slice($all_logos, 0, 8); // ثابت روی ۸ عدد
        $pool = array_slice($all_logos, 8);

        echo '<div class="wls-wrapper"><div class="wls-logo-grid '.esc_attr($settings['animation_style']).'" 
                data-interval="'.esc_attr($settings['swap_interval']).'" 
                data-count="'.esc_attr($settings['swap_count']).'">';

        foreach($visible as $logo) {
            echo '<div class="wls-logo-item"><div class="wls-logo-inner">';
            echo '<a href="'.esc_url($logo['link']).'" target="_blank"><img src="'.esc_url($logo['src']).'" alt="'.esc_attr($logo['title']).'"></a>';
            echo '</div></div>';
        }

        echo '<script class="wls-hidden-pool" type="application/json">'.json_encode($pool).'</script>';
        echo '</div></div>';
    }
}