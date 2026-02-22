<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Webcom_Logo_Widget extends Widget_Base {

    public function get_name() { return 'webcom_logo_showcase'; }
    public function get_title() { return 'لوگوی مشتریان (وب‌کام)'; }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'general' ]; }

    protected function register_controls() {
        $this->start_controls_section('section_content', ['label' => 'تنظیمات نمایش']);

        $this->add_control('posts_per_page', [
            'label' => 'تعداد کل لوگوها برای لود',
            'type' => Controls_Manager::NUMBER,
            'default' => 20,
        ]);

        $this->add_control('visible_count', [
            'label' => 'تعداد نمایش همزمان (گرید)',
            'type' => Controls_Manager::NUMBER,
            'default' => 8,
        ]);

        $this->add_control('columns', [
            'label' => 'تعداد ستون‌ها',
            'type' => Controls_Manager::SELECT,
            'default' => '4',
            'options' => [
                '2' => '2 ستونه',
                '3' => '3 ستونه',
                '4' => '4 ستونه',
                '5' => '5 ستونه',
                '6' => '6 ستونه',
            ],
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_animation', ['label' => 'تنظیمات انیمیشن']);

        $this->add_control('animation_style', [
            'label' => 'شیوه انیمیشن',
            'type' => Controls_Manager::SELECT,
            'default' => 'wls-fade',
            'options' => [
                'wls-fade'   => 'Fade (محو شدن)',
                'wls-zoom'   => 'Zoom (بزرگ‌نمایی)',
                'wls-slide'  => 'Slide (کشویی)',
                'wls-rotate' => 'Rotate (چرخشی)',
                'wls-blur'   => 'Blur (تار شدن)',
            ],
        ]);

        $this->add_control('swap_interval', [
            'label' => 'فاصله زمانی جابجایی (میلی‌ثانیه)',
            'type' => Controls_Manager::NUMBER,
            'default' => 3000,
        ]);

        $this->add_control('swap_count', [
            'label' => 'تعداد تعویض در هر مرحله',
            'type' => Controls_Manager::NUMBER,
            'default' => 2,
        ]);

        $this->end_controls_section();

        $this->start_controls_section('section_style', [
            'label' => 'شخصی‌سازی ظاهر',
            'tab' => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('bg_color', [
            'label' => 'رنگ پس‌زمینه',
            'type' => Controls_Manager::COLOR,
            'default' => '#0a192f',
            'selectors' => [
                '{{WRAPPER}} .wls-logo-grid' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('border_color', [
            'label' => 'رنگ خطوط جداکننده',
            'type' => Controls_Manager::COLOR,
            'default' => 'rgba(255, 255, 255, 0.1)',
            'selectors' => [
                '{{WRAPPER}} .wls-logo-grid' => 'border-color: {{VALUE}};',
                '{{WRAPPER}} .wls-logo-item' => 'border-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $query = new WP_Query([
            'post_type' => 'webcom_logo',
            'posts_per_page' => (int)$settings['posts_per_page'],
            'orderby' => 'rand'
        ]);

        if ( ! $query->have_posts() ) return;

        $all_logos = [];
        while ( $query->have_posts() ) {
            $query->the_post();
            $all_logos[] = [
                'src'  => get_the_post_thumbnail_url(get_the_ID(), 'full'),
                'link' => get_post_meta(get_the_ID(), '_logo_url', true) ?: '#',
                'title' => get_the_title()
            ];
        }
        wp_reset_postdata();

        $visible_logos = array_slice($all_logos, 0, (int)$settings['visible_count']);
        $hidden_pool = array_slice($all_logos, (int)$settings['visible_count']);

        $cols = $settings['columns'];
        echo '<div class="wls-logo-grid" style="--wls-cols: ' . esc_attr($cols) . ';" 
                data-interval="' . esc_attr($settings['swap_interval']) . '" 
                data-change-count="' . esc_attr($settings['swap_count']) . '">';

        foreach ( $visible_logos as $logo ) {
            echo '<div class="wls-logo-item">';
            echo '<a href="' . esc_url($logo['link']) . '" target="_blank">';
            echo '<img src="' . esc_url($logo['src']) . '" alt="' . esc_attr($logo['title']) . '">';
            echo '</a>';
            echo '</div>';
        }

        echo '<script class="wls-hidden-pool" type="application/json">' . json_encode($hidden_pool) . '</script>';
        echo '</div>';
    }
}