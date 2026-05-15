<?php get_header(); ?>
<?php if (have_posts()) {
    while (have_posts()) {
        the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="header">
        <h1 class="text-3xl font-bold my-4" itemprop="name"><?php the_title(); ?></h1>
        <?php get_template_part('template-parts/entry/entry', 'edit-post'); ?>
    </header>
    <div class="entry-content prose" itemprop="mainContentOfPage">
        <?php if (has_post_thumbnail()) {
    the_post_thumbnail('full', ['itemprop' => 'image']);
} ?>
        <?php the_content(); ?>
        <div class="entry-links"><?php wp_link_pages(); ?></div>
    </div>
</article>
<?php if (comments_open() && !post_password_required()) {
    comments_template();
} ?>
<?php }
    } ?>
<?php get_footer(); ?>
