<?php
    
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );

function theme_name_scripts() {
	wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/styles.css' );
    wp_enqueue_style( 'googleapis', 'href=https://fonts.googleapis.com' );
    wp_enqueue_style( 'gstatic', 'href=https://fonts.gstatic.com' );
    wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600&display=swap' );
    wp_enqueue_style( 'modern-normalize', 'href=https://cdnjs.cloudflare.com/ajax/libs/modern-normalize/2.0.0/modern-normalize.min.css' );
    

    add_theme_support('post-thumbnails' );
    add_theme_support('title-tag' );
    add_theme_support('custom-logo' );

    

    
    

    

    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com', array(), 'null', false);
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp', array(), 'null', false);
    wp_enqueue_script('tailwind-config',  get_template_directory_uri() . '/assets/js/tailwind.config.js', array(), 'null', false);
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com/2.2.19/tailwind.min.js');
	wp_enqueue_script( 'index', get_template_directory_uri() . '/assets/js/index.js', array(), 'null', true );
}
function custom_flush_rewrite_rules() {
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'custom_flush_rewrite_rules');

?>