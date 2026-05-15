<?php

/**
 * Displays the post meta on the single.php.
 * Uses wp_docs_add_post_link() to add a class to the next and previous post links.
 */
function slate_single_navigation()
{
    $previous_icon = '<svg aria-describedby="descprev" role="img" aria-labelledby="titleprev"
                    class="inline ml-2 h-8 w-8"
                    focusable="false" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      <title id="titleprev" lang="en">Previous Article</title>
                    <desc id="descprev">Go to the previous article</desc></svg>';

    $next_icon = '<svg aria-describedby="descnext" role="img" aria-labelledby="titlenext" class="inline mr-2 h-8 w-8"
                   focusable="false" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round"
                   stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                   <title id="titlenext" lang="en">Next Article</title>
                 <desc id="descnext">Go to the next article</desc></svg>';

    $next_post = get_next_post();
    $previous_post = get_previous_post();
    ?>
    <div class="flex flex-col w-full lg:flex-row my-4 not-prose">
        <?php if ($next_post !== '') { ?>
            <div class="card w-96 bg-base-300">
                <div class="card-body">
                    <h4 class="text-2xl font-bold">Next Article</h4>
                    <div class="card-actions">
                        <?php next_post_link('%link', $next_icon . '%title'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($next_post !== '' && $previous_post !== '') { ?>
            <div class="divider lg:divider-horizontal">OR</div>
        <?php } ?>
        <?php if ($previous_post !== '') { ?>
            <div class="card w-96 bg-base-300">
                <div class="card-body">
                    <h4 class="text-2xl font-bold">Previous Article</h4>
                    <div class="card-actions">
                        <?php previous_post_link('%link', '%title' . $previous_icon); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
}

/********
 * Change page-navi css classes
 * */
add_filter('wp_pagenavi_class_previouspostslink', 'theme_pagination_class');
add_filter('wp_pagenavi_class_nextpostslink', 'theme_pagination_class');
add_filter('wp_pagenavi_class_page', 'theme_pagination_class');
add_filter('wp_pagenavi_class_extend', 'theme_pagination_class');
add_filter('wp_pagenavi_class_current', 'theme_pagination_class');
add_filter('wp_pagenavi_wrapper_class', 'theme_pagination_class');

function theme_pagination_class($class_name)
{
    switch ($class_name) {
        case 'previouspostslink':
            $class_name = 'join-item btn btn-outline';
            break;
        case 'nextpostslink':
            $class_name = 'join-item btn btn-outline';
            break;
        case 'page':
            $class_name = 'join-item btn';
            break;
        case 'extend':
            $class_name = 'join-item btn btn-disabled';
            break;
        case 'current':
            $class_name = 'join-item btn btn-active';
            break;
        case 'wrapper_class':
            $class_name = 'join';
    }

    return $class_name;
}
/***
 * Prevents the category description from displaying HTML tags
 */
add_filter('category_description', 'strip_category_description_html');
function strip_category_description_html($description) {
    return wp_strip_all_tags($description);
}
