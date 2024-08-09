<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'template-parts/entry/entry' ); ?>
<?php get_template_part( 'template-parts/navigation/nav', 'below-single' ); ?>
<?php if ( comments_open() && !post_password_required() ) { comments_template(); } ?>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
