<footer class="entry-footer">
    <div class="cat-links my-2"><b><?php esc_html_e( 'Categories: ', 'blankslate' ); ?></b><?php the_category( ', ' ); ?></div>
    <div class="tag-links my-2"><?php the_tags("<b>Tags:</b> "); ?></div>
    <?php if ( comments_open() ) { echo '<span class="comments-link text-lg"><a href="' . esc_url( get_comments_link() ) . '">' . sprintf( esc_html__( 'Comments', 'blankslate' ) ) . '</a></span>'; } ?>
</footer>
