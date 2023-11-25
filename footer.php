</main>
    <?php get_sidebar(); ?>
</div>
</div><!--end wrapper -->
<footer class="footer footer-center p-4 bg-base-300 text-base-content">
  <aside>
    <p>&copy; <?php echo esc_html( date_i18n( __( 'Y', 'blankslate' ) ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
  </aside>
</footer>
<?php wp_footer(); ?>
</body>
</html>