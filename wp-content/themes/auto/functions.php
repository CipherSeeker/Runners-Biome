<?php
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
function theme_name_scripts() {
	wp_enqueue_style( 'styles', get_template_directory_uri() . '/assets/css/styles.css' );
    wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600&display=swap' );
    add_theme_support('post-thumbnails' );
    add_theme_support('title-tag' );
    add_theme_support('custom-logo' );
    wp_enqueue_script('index', get_template_directory_uri() . '/assets/js/index.js', '', '', true);
    wp_enqueue_script('tailwind', 'https://cdn.tailwindcss.com', array(), '', false);
    wp_enqueue_script('tailwind-config',  get_template_directory_uri() . '/assets/js/tailwind.config.js', '', '', false);
}
function exclude_pages_from_search($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }
    if ($query->is_search()) {
        $query->set('post_type', 'post');
    }
}
add_action('pre_get_posts', 'exclude_pages_from_search');
function get_breadcrumb() {
    global $post;
    echo '<ul class="flex text-textTitles gap-[25px] md:gap-[0px] rounded-[5px] items-center">';
    if (!is_home()) {
        echo '<li class="hover:bg-primary hover:text-[white] rounded-lg px-[12px] py-[6px] mr-[2px] transition-all duration-250"><a href="' . home_url() . '">Home</a></li>';
        echo '<div class="h-0 w-0 border-y-4 border-y-transparent border-l-[7px] border-l-black-600"></div>';
        if (is_category() || is_single()) {
            $category = get_the_category();
            if ($category) {
                echo '<li class="hover:bg-primary hover:text-[white] rounded-lg px-[12px] py-[6px] transition-all duration-250"><a href="' . get_category_link($category[0]->term_id) . '">' . $category[0]->cat_name . '</a></li>';
                echo '<div class="h-0 w-0 border-y-4 border-y-transparent border-l-[7px] border-l-black-600"></div>';
            }
            if (is_single()) {
                echo '<li class="ml-[12px] md:ml-[6px] line-clamp-1">' . get_the_title() . '</li>';
            }
        } elseif (is_page()) {
            if ($post->post_parent) {
                $anc = get_post_ancestors($post->ID);
                $anc = array_reverse($anc);
                foreach ($anc as $ancestor) {
                    $output = '<li"><a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    echo $output;
                }
            }
            echo '<li>' . get_the_title() . '</li>';
        }
    }
    echo '</ul>';
}
?>