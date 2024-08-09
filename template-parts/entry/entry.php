<?php $edit = '<svg class="h-6 w-6 inline text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
</svg>';

$path = 'template-parts/entry/entry';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header>
        <?php if ( is_singular() ) { echo '<h1 class="text-5xl break-all" itemprop="headline">'; } else { echo '<h2 class="text-4xl break-all">'; } ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
            rel="bookmark"><?php the_title(); ?></a>
        <?php if ( is_singular() ) { echo '</h1>'; } else { echo '</h2>'; } ?>
        <?php if ( !is_search() ) { get_template_part( $path,'meta' ); } ?>
        <?php edit_post_link('edit',$edit,'',$post,'text-accent'); ?>
    </header>
    <?php get_template_part( $path, ( is_front_page() || is_home() || is_front_page() && is_home() || is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
    <?php if ( is_singular() ) { get_template_part( $path ,'footer' ); } ?>
</article>
