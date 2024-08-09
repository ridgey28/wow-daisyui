<?php if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
<aside id="sidebar" class="md:grid md:grid-cols-1">
    <div id="primary" class="widget-area">
        <ul class="xoxo">
            <?php dynamic_sidebar( 'primary-widget-area' ); ?>
        </ul>
    </div>
</aside>
<?php endif;
