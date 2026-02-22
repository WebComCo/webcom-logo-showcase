<?php
function wls_register_logo_cpt() {
    $labels = array(
        'name'               => 'لوگوها',
        'singular_name'      => 'لوگو',
        'menu_name'          => 'نمایش لوگوها',
        'add_new'            => 'افزودن لوگوی جدید',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => false,
        'menu_icon'          => 'dashicons-images-alt2',
        'supports'           => array( 'title', 'thumbnail' ),
    );

    register_post_type( 'webcom_logo', $args );
}
add_action( 'init', 'wls_register_logo_cpt' );

add_action( 'add_meta_boxes', function() {
    add_meta_box( 'wls_link_meta', 'تنظیمات لوگو', 'wls_link_meta_callback', 'webcom_logo', 'normal', 'high' );
});

function wls_link_meta_callback( $post ) {
    $url = get_post_meta( $post->ID, '_logo_url', true );
    echo '<label>لینک مشتری: </label>';
    echo '<input type="url" name="logo_url" value="' . esc_attr( $url ) . '" style="width:100%">';
}

add_action( 'save_post', function( $post_id ) {
    if ( isset( $_POST['logo_url'] ) ) {
        update_post_meta( $post_id, '_logo_url', esc_url( $_POST['logo_url'] ) );
    }
});