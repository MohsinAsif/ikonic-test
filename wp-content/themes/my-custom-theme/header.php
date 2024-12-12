<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header>
        <nav class="nav-container">
            <button class="menu-toggle" aria-label="Toggle navigation">
                ☰
            </button>
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'menu_class' => 'primary-menu',
            ]);
            ?>
        </nav>
    </header>