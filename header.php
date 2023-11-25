<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php blankslate_schema_type(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <?php get_template_part('inc/class-daisyui-navwalker');?>
    <header id="header" role="banner">
        <div class="navbar bg-base-200">
            <div class="navbar-start" id="site-title" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                <?php
                            if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '<h1>'; }
                            echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home" itemprop="url"><span class="btn btn-ghost text-xl" itemprop="name">' . esc_html( get_bloginfo( 'name' ) ) . '</span></a>';
                            if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '</h1>'; }
                            ?>
                        </div>
                        <nav class="navbar-center" id="menu" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
                            <?php
                     wp_nav_menu( array('menu_id' => 'navbar-menu',
                     'container'=>false,
                     'theme_location' => 'main-menu',
                     'link_before' => '<span itemprop="name">',
                     'link_after' => '</span>',
                     'items_wrap' => '<ul id="%1$s" class="menu menu-horizontal px-1">%3$s</ul>',
                     'walker' => new Daisyui_NavWalker() ) ); ?>
                </nav>
                <div class="navbar-end" id="search"><?php get_search_form(); ?></div>
            </div>
        </header>
        <div id="wrapper" class="grid m-10"><!--Start of wrapper, ends in footer-->
        <div id="container" class="m-10">
            <main id="content" role="main">