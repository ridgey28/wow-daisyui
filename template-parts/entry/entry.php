<?php
$path = 'template-parts/entry/entry';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('my-4'); ?>>
    <header>
        <?php if ( is_singular() ) { echo '<h1 class="text-5xl break-all" itemprop="headline">'; } else { echo '<h2 class="text-4xl break-all">'; } ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
            rel="bookmark"><?php the_title(); ?></a>
        <?php if ( is_singular() ) { echo '</h1>'; } else { echo '</h2>'; } ?>
        <?php if ( !is_search() ) { get_template_part( $path,'meta' ); } ?>
        <?php get_template_part( $path,'edit-post' ); ?>
    </header>
    <?php get_template_part( $path, ( is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
    <?php if ( is_singular() ) { get_template_part( $path ,'footer' ); } ?>
</article>
