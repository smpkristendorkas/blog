<?php
function smp_kristen_dorkas_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 64,
        'width'       => 64,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));

    register_nav_menus(array(
        'primary' => 'Primary Menu',
    ));
}
add_action('after_setup_theme', 'smp_kristen_dorkas_setup');

function smp_kristen_dorkas_assets() {
    wp_enqueue_style('theme-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap', array(), null);
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
    wp_enqueue_script('theme-main', get_template_directory_uri() . '/assets/js/theme.js', array(), wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'smp_kristen_dorkas_assets');

function smp_kristen_dorkas_menu_fallback() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Beranda</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about')) . '">Tentang</a></li>';
    echo '<li><a href="' . esc_url(home_url('/news')) . '">Berita</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact')) . '">Kontak</a></li>';
    echo '</ul>';
}
