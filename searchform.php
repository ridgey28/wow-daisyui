<?php
/*
 * Displays Searchform in nav and 404 page.
 */
?>
<?php
$unique_id = wp_unique_id('search-form-'); ?>
<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" autocomplete="on">
    <label for="<?php echo esc_attr($unique_id); ?>" class="input input-bordered flex items-center gap-2">
        <input type="search" class="grow" id="<?php echo esc_attr($unique_id); ?>" name="s" placeholder="Search"
            value="<?php echo get_search_query(); ?>" />
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70">
            <path fill-rule="evenodd"
                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                clip-rule="evenodd" />
        </svg>
    </label>
</form>
