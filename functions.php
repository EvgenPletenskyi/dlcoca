<?php
// Disable Gutenberg on the back end.
add_filter( 'use_block_editor_for_post', '__return_false' );

// Disable Gutenberg for widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );

add_action( 'wp_enqueue_scripts', function() {
    // Remove CSS on the front end.
    wp_dequeue_style( 'wp-block-library' );

    // Remove Gutenberg theme.
    wp_dequeue_style( 'wp-block-library-theme' );

    // Remove inline global CSS on the front end.
    wp_dequeue_style( 'global-styles' );
}, 20 );

add_theme_support( 'custom-logo' );

function add_custom_logo_class($html) {
    $html = str_replace('custom-logo', 'custom-logo header__logo', $html);
    return $html;
}
add_filter('get_custom_logo', 'add_custom_logo_class');

function register_my_menu() {
    register_nav_menus(array(
        'header-menu' => __('Header Menu')
    ));
}
add_action('init', 'register_my_menu');

add_action( 'wp_enqueue_scripts', 'theme_add_scripts' );

function theme_add_scripts() {

    wp_enqueue_style( 'main.css', get_template_directory_uri() . '/assets/css/main.css' );
    wp_enqueue_style( 'swiper.css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css' );
    wp_enqueue_script( 'jquery-cdn', 'https://code.jquery.com/jquery-3.7.1.min.js', array(), '3.7.1', true );
    wp_enqueue_script( 'swiper-cdn', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11', true );
    wp_enqueue_script( 'pixi-cdn', 'https://cdn.jsdelivr.net/npm/pixi.js@7.x/dist/pixi.min.js', array(), '7.x', true );
    wp_enqueue_script( 'main.js', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), '1.0', true );
}


class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    // Оновлює HTML для кожного елемента меню
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        // Зберігаємо клас та id
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_id', 'menu-item-'. $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        // Додаємо атрибут data-replace з назвою пункту меню
        $data_replace = !empty($item->title) ? ' data-replace="' . esc_attr($item->title) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        // Оновлюємо атрибути
        $atts = array();
        $atts['href'] = !empty($item->url) ? $item->url : '';
        $atts['data-replace'] = $item->title; // Додаємо data-replace з назвою пункту меню

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if (!empty($value)) {
                $value = esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= '<span>' . $title . '</span>'; // Поміщаємо назву в <span>
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}


