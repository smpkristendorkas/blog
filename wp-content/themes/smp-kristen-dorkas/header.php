<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <span class="brand-text"><?php bloginfo('name'); ?></span>
            <?php endif; ?>
        </a>

        <button id="menuToggle" class="menu-toggle" aria-label="Toggle menu">☰</button>

        <nav id="nav" class="nav" aria-label="Main navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'nav-menu',
                'fallback_cb'    => 'smp_kristen_dorkas_menu_fallback',
            ));
            ?>
        </nav>
    </div>
</header>

<main class="site-main">
