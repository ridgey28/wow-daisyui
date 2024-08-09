<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <?php get_template_part('inc/class-daisyui-navwalker'); ?>
    <header id="header" role="banner">
        <div class="navbar bg-base-200">
            <div class="navbar-start" id="site-title" itemprop="publisher" itemscope
                itemtype="https://schema.org/Organization">
                <div class="dropdown">
                    <button tabindex="0" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                    </button>
                    <?php wp_nav_menu(
                        array(
                            'menu_id' => 'mobile-menu',
                            'theme_location' => 'mobile-menu',
                            'link_before' => '<span itemprop="name">',
                            'link_after' => '</span>',
                            'container' => false,
                            'items_wrap' => '<ul id="%1$s" tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">%3$s</ul>'
                        )
                    ); ?>

                    </ul>

                </div>
                <?php
                if (is_front_page() || is_home() || is_front_page() && is_home()) {
                    echo '<h1>';
                }
                echo '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '" rel="home" itemprop="url"><span class="btn btn-ghost text-xl" itemprop="name">' . esc_html(get_bloginfo('name')) . '</span></a>';
                if (is_front_page() || is_home() || is_front_page() && is_home()) {
                    echo '</h1>';
                }
                ?>
            </div>
            <nav class="navbar-center hidden lg:flex" id="menu" role="navigation" itemscope
                itemtype="https://schema.org/SiteNavigationElement">
                <?php
                wp_nav_menu(
                    array(
                        'menu_id' => 'navbar-menu',
                        'container' => false,
                        'theme_location' => 'main-menu',
                        'link_before' => '<span itemprop="name">',
                        'link_after' => '</span>',
                        'items_wrap' => '<ul id="%1$s" class="menu menu-horizontal px-1">%3$s</ul>',
                        'walker' => new Daisyui_NavWalker()
                    )
                ); ?>
            </nav>
            <div class="navbar-end" id="search"><?php get_search_form(); ?></div>
        </div>
    </header>
    <div id="wrapper" class="m-10">
        <!--Start of wrapper, ends in footer-->
        <!-- Using CSS Grid to create a two-column layout-->
        <div id="container" class="md:grid grid-rows-1 grid-cols-[2fr_1fr] gap-6 w-full h-full">
            <div>
                <main id="content" role="main">
