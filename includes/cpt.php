<?php

function wls_register_logo_cpt() {
    register_post_type('webcom_logo', [
        'labels' => [
            'name' => 'لوگوها',
            'singular_name' => 'لوگو',
            'add_new' => 'لوگوی جدید',
            'add_new_item' => 'افزودن لوگوی جدید',
            'featured_image' => 'تصویر لوگو',
            'set_featured_image'       => 'قرار دادن به‌عنوان تصویر لوگو',
            'remove_featured_image'    => 'حذف تصویر لوگو',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-images-alt',
        'supports' => ['title', 'thumbnail'],
    ]);
}
add_action( 'init', 'wls_register_logo_cpt' );

add_action( 'add_meta_boxes', function() {
    add_meta_box( 'wls_link', 'تنظیمات لوگو', function($post){
        $url = get_post_meta( $post->ID, '_logo_url', true );
        echo '<input type="url" name="logo_url" value="'.esc_attr($url).'" placeholder="لینک مقصد لوگو..." style="width:100%">';
    }, 'webcom_logo' );
});

add_action( 'save_post', function($post_id){
    if ( isset($_POST['logo_url']) ) update_post_meta( $post_id, '_logo_url', esc_url($_POST['logo_url']) );
});