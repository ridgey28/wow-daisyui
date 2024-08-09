<?php get_header(); ?>
<header class="header">
    <h1 class="text-5xl font-bold entry-title" itemprop="name"><?php single_term_title(); ?></h1>
    <div class="archive-meta" itemprop="description">
        <?php if ( '' != get_the_archive_description() ) { echo esc_html( get_the_archive_description() ); } ?></div>
</header>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'template-parts/entry/entry' ); ?>
<?php endwhile; endif; ?>
<?php get_template_part( 'template-parts/navigation/nav', 'below' ); ?>
<?php get_footer(); ?>
