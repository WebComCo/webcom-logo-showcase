<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Webcom_Logo_Widget extends Widget_Base {
    public function get_name() { return 'webcom_logo_showcase'; }
    public function get_title() { return 'لوگوی مشتریان 4x2'; }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'webcom' ]; }

    protected function register_controls() {
        $this->start_controls_section('content', ['label' => 'تنظیمات']);

         $this->add_control('wls_entrance_anim', [
            'label' => 'انیمیشن ورود (Entrance)',
            'type' => Controls_Manager::ANIMATION,
            'default' => 'fadeIn', // پیش‌فرض
        ]);


        $this->add_control('hover_animation', [
            'label' => 'انیمیشن هاور',
            'type' => Controls_Manager::HOVER_ANIMATION,
        ]);

        $this->add_control('wls_exit_anim', [
            'label' => 'انیمیشن خروج (Exit)',
            'type' => Controls_Manager::SELECT,
            'default' => 'fadeOutUp',
            'options' => [
                // Fading
                'fadeOut' => 'Fade Out',
                'fadeOutDown' => 'Fade Out Down',
                'fadeOutLeft' => 'Fade Out Left',
                'fadeOutRight' => 'Fade Out Right',
                'fadeOutUp' => 'Fade Out Up',

                // Zooming
                'zoomOut' => 'Zoom Out',
                'zoomOutDown' => 'Zoom Out Down',
                'zoomOutLeft' => 'Zoom Out Left',
                'zoomOutRight' => 'Zoom Out Right',
                'zoomOutUp' => 'Zoom Out Up',

                // Bouncing
                'bounceOut' => 'Bounce Out',
                'bounceOutDown' => 'Bounce Out Down',
                'bounceOutLeft' => 'Bounce Out Left',
                'bounceOutRight' => 'Bounce Out Right',
                'bounceOutUp' => 'Bounce Out Up',

                // Sliding
                'slideOutDown' => 'Slide Out Down',
                'slideOutLeft' => 'Slide Out Left',
                'slideOutRight' => 'Slide Out Right',
                'slideOutUp' => 'Slide Out Up',

                // Rotating
                'rotateOut' => 'Rotate Out',
                'rotateOutDownLeft' => 'Rotate Out Down Left',
                'rotateOutDownRight' => 'Rotate Out Down Right',
                'rotateOutUpLeft' => 'Rotate Out Up Left',
                'rotateOutUpRight' => 'Rotate Out Up Right',

                // Light Speed
                'lightSpeedOut' => 'Light Speed Out',

                // Specials
                'rollOut' => 'Roll Out',

            ]
        ]);

        $this->add_control('wls_swap_count', [
            'label' => 'تعداد تعویض همزمان',
            'type' => Controls_Manager::NUMBER,
            'min' => 1, 'max' => 4, 'default' => 2,
        ]);

        $this->add_control('wls_interval', [
            'label' => 'فاصله زمانی بین هر تعویض (ms)',
            'type' => Controls_Manager::NUMBER,
            'default' => 3000,
        ]);

        $this->add_control('wls_duration', [
            'label' => esc_html__('مدت زمان اجرای انیمیشن (ms)'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['ms', 'custom'],
            'range' => ['ms' => ['min' => 0, 'max' => 2000, 'step' => 10]],
            'default' => ['unit' => 'ms', 'size' => 1000],
            'selectors' => ['{{WRAPPER}}' => '--wls-anim-duration: {{SIZE}}{{UNIT}};'],
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

        $this->add_responsive_control('wls_cell_height', [
            'label' => 'ارتفاع باکس لوگو',
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 100, 'max' => 250, 'step' => 1]],
            'default' => ['size' => 150],
            'selectors' => ['{{WRAPPER}} .wls-logo-grid' => '--wls-cell-height: {{SIZE}}px;']
        ]);

        $this->add_responsive_control('img_max_height', [
            'label' => 'حداکثر ارتفاع تصویر',
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 50, 'max' => 200, 'step' => 1]],
            'default' => ['size' => 70],
            'selectors' => ['{{WRAPPER}} .wls-logo-grid' => '--wls-img-height: {{SIZE}}px;']
        ]);

        $this->add_control('wls_opacity', [
            'label' => 'شفافیت قبل هاور',
            'type' => Controls_Manager::SLIDER,
            'range' => ['px' => ['min' => 0.01, 'max' => 1, 'step' => 0.01]],
            'default' => ['size' => 0.3],
            'selectors' => ['{{WRAPPER}} .wls-logo-grid' => '--wls-opacity: {{SIZE}};']
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $query = new WP_Query(['post_type' => 'webcom_logo', 'posts_per_page' => 80, 'orderby' => 'rand']);
        if ( ! $query->have_posts() ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo 'لطفاً ابتدا چند لوگو در بخش مدیریت لوگوها اضافه کنید.';
            }
            return;
        }

        $all_logos = [];
        while ($query->have_posts()) {
            $query->the_post();
            $thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'full');
            $all_logos[] = [
                'src' => $thumbnail,
                'link' => get_post_meta(get_the_ID(), '_logo_url', true) ?: '#',
                'title' => get_the_title()
            ];
        }
        wp_reset_postdata();

        if (count($all_logos) < 8) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo 'برای عملکرد صحیح انیمیشن، حداقل باید ۸ لوگو منتشر شده داشته باشید.';
            }
        }

        $visible = array_slice($all_logos, 0, 8);
        $pool = array_slice($all_logos, 8);

        $exit     = isset($settings['wls_exit_anim'])     ? $settings['wls_exit_anim']     : 'fadeOutUp';
        $entrance = isset($settings['wls_entrance_anim']) ? $settings['wls_entrance_anim'] : 'fadeInDown';
        $interval = isset($settings['wls_interval'])      ? intval($settings['wls_interval']) : 3000;
        $count    = isset($settings['wls_swap_count'])    ? intval($settings['wls_swap_count']) : 2;

        $duration_size = isset($settings['wls_duration']['size']) ? intval($settings['wls_duration']['size']) : 1000;
        $duration_unit = isset($settings['wls_duration']['unit']) ? $settings['wls_duration']['unit'] : 'ms';
        $duration = $duration_size . $duration_unit;

        $hover_class = !empty($settings['wls_hover_animation']) ? 'elementor-animation-' . $settings['wls_hover_animation'] : '';

        echo '<div class="wls-wrapper">
                <div class="wls-logo-grid" 
                data-interval="' . esc_attr($interval) . '" 
                data-count="' . esc_attr($count) . '"
                data-entrance="' . esc_attr($entrance) . '"
                data-exit="' . esc_attr($exit) . '"
                data-duration="' . esc_attr($duration) . '">';

        foreach ($visible as $logo) {
            echo '<div class="wls-logo-item">
                    <div class="wls-logo-inner p-2 ' . esc_attr($hover_class) . '">
                        <a href="' . esc_url($logo['link']) . '" target="_blank">
                            <img src="' . esc_url($logo['src']) . '" alt="' . esc_attr($logo['title']) . '"">
                        </a>
                    </div>
                  </div>';
        }

        echo '<script class="wls-hidden-pool" type="application/json">' . json_encode($pool) . '</script>';
        echo '</div></div>';
    }
}