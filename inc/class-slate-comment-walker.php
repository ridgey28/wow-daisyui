<?php
/**
 * Comment API: Walker_Comment class.
 *
 * @since 4.4.0
 */

/**
 * Core walker class used to create an HTML list of comments.
 *
 * @since 2.7.0
 * @see Walker
 */
class Slate_Comment_Walker extends Walker_Comment
{
    /**
     * What the class handles.
     *
     * @since 2.7.0
     *
     * @var string
     *
     * @see Walker::$tree_type
     */
    public $tree_type = 'comment';

    /**
     * Database fields to use.
     *
     * @since 2.7.0
     *
     * @var array
     *
     * @see Walker::$db_fields
     *
     * @todo Decouple this
     */
    public $db_fields = [
        'parent' => 'comment_parent',
        'id' => 'comment_ID',
    ];

    /**
     * Traverses elements to create list from elements.
     *
     * This function is designed to enhance Walker::display_element() to
     * display children of higher nesting levels than selected inline on
     * the highest depth level displayed. This prevents them being orphaned
     * at the end of the comment list.
     *
     * Example: max_depth = 2, with 5 levels of nested content.
     *     1
     *      1.1
     *        1.1.1
     *        1.1.1.1
     *        1.1.1.1.1
     *        1.1.2
     *        1.1.2.1
     *     2
     *      2.2
     *
     * @since 2.7.0
     * @see Walker::display_element()
     * @see wp_list_comments()
     *
     * @param WP_Comment $element           comment data object
     * @param array      $children_elements List of elements to continue traversing. Passed by reference.
     * @param int        $max_depth         max depth to traverse
     * @param int        $depth             depth of the current element
     * @param array      $args              an array of arguments
     * @param string     $output            Used to append additional content. Passed by reference.
     */
    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        if (!$element) {
            return;
        }

        $id_field = $this->db_fields['id'];
        $id = $element->$id_field;

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);

        /*
         * If at the max depth, and the current element still has children, loop over those
         * and display them at this level. This is to prevent them being orphaned to the end
         * of the list.
         */
        if ($max_depth <= $depth + 1 && isset($children_elements[$id])) {
            foreach ($children_elements[$id] as $child) {
                $this->display_element($child, $children_elements, $max_depth, $depth, $args, $output);
            }

            unset($children_elements[$id]);
        }
    }

    /**
     * Starts the element output.
     *
     * @since 2.7.0
     * @see Walker::start_el()
     * @see wp_list_comments()
     *
     * @global int        $comment_depth
     * @global WP_Comment $comment       Global comment object.
     *
     * @param string     $output  Used to append additional content. Passed by reference.
     * @param WP_Comment $comment comment data object
     * @param int        $depth   Optional. Depth of the current comment in reference to parents. Default 0.
     * @param array      $args    Optional. An array of arguments. Default empty array.
     * @param int        $id      Optional. ID of the current comment. Default 0 (unused).
     */
    public function start_el(&$output, $comment, $depth = 0, $args = [], $id = 0)
    {
        ++$depth;
        $GLOBALS['comment_depth'] = $depth;
        $GLOBALS['comment'] = $comment;

        if (!empty($args['callback'])) {
            ob_start();
            call_user_func($args['callback'], $comment, $args, $depth);
            $output .= ob_get_clean();

            return;
        }

        if ('comment' === $comment->comment_type) {
            add_filter('comment_text', [$this, 'filter_comment_text'], 40, 2);
        }

        if (('pingback' === $comment->comment_type || 'trackback' === $comment->comment_type) && $args['short_ping']) {
            ob_start();
            $this->ping($comment, $depth, $args);
            $output .= ob_get_clean();
        } elseif ('html5' === $args['format']) {
            ob_start();
            $this->html5_comment($comment, $depth, $args);
            $output .= ob_get_clean();
        } else {
            ob_start();
            $this->comment($comment, $depth, $args);
            $output .= ob_get_clean();
        }

        if ('comment' === $comment->comment_type) {
            remove_filter('comment_text', [$this, 'filter_comment_text'], 40, 2);
        }
    }

    /**
     * Ends the element output, if needed.
     *
     * @since 2.7.0
     * @see Walker::end_el()
     * @see wp_list_comments()
     *
     * @param string     $output  Used to append additional content. Passed by reference.
     * @param WP_Comment $comment The current comment object. Default current comment.
     * @param int        $depth   Optional. Depth of the current comment. Default 0.
     * @param array      $args    Optional. An array of arguments. Default empty array.
     */
    public function end_el(&$output, $comment, $depth = 0, $args = [])
    {
        if (!empty($args['end-callback'])) {
            ob_start();
            call_user_func($args['end-callback'], $comment, $args, $depth);
            $output .= ob_get_clean();

            return;
        }
        if ('div' === $args['style']) {
            $output .= "</div><!-- #comment-## -->\n";
        } else {
            $output .= "</li><!-- #comment-## -->\n";
        }
    }

    /**
     * Outputs a pingback comment.
     *
     * @since 3.6.0
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment the comment object
     * @param int        $depth   depth of the current comment
     * @param array      $args    an array of arguments
     */
    protected function ping($comment, $depth, $args)
    {
        $tag = ('div' === $args['style']) ? 'div' : 'li';
        ?>
<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('', $comment); ?>>
    <div class="comment-body">
        <?php _e('Pingback:'); ?> <?php comment_author_link($comment); ?>
        <?php edit_comment_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
    </div>
    <?php
    }

    /**
     * Filters the comment text.
     *
     * Removes links from the pending comment's text if the commenter did not consent
     * to the comment cookies.
     *
     * @since 5.4.2
     *
     * @param string          $comment_text text of the current comment
     * @param WP_Comment|null $comment      The comment object. Null if not found.
     *
     * @return string filtered text of the current comment
     */
    public function filter_comment_text($comment_text, $comment)
    {
        $commenter = wp_get_current_commenter();
        $show_pending_links = !empty($commenter['comment_author']);

        if ($comment && '0' == $comment->comment_approved && !$show_pending_links) {
            $comment_text = wp_kses($comment_text, []);
        }

        return $comment_text;
    }

    /**
     * Outputs a comment in the HTML5 format.
     *
     * @since 3.6.0
     * @see wp_list_comments()
     *
     * @param WP_Comment $comment comment to display
     * @param int        $depth   depth of the current comment
     * @param array      $args    an array of arguments
     */
    protected function html5_comment($comment, $depth, $args)
    {
        $tag = ('div' === $args['style']) ? 'div' : 'li';

        $commenter = wp_get_current_commenter();
        $show_pending_links = !empty($commenter['comment_author']);

        if ($commenter['comment_author_email']) {
            $moderation_note = __('Your comment is awaiting moderation.');
        } else {
            $moderation_note = __('Your comment is awaiting moderation.
                                This is a preview; your comment will be visible after it has been approved.');
        }
        ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>"
        <?php comment_class($this->has_children ? 'parent' : '', $comment); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="my-6">
            <div class="flex flex-wrap md:flex-nowrap shadow-xl bg-base-200">
                <div class="items-start mr-3 avatar">
                    <div class="mask mask-squircle w-16">
                        <?php
                        if (0 != $args['avatar_size']) {
                            echo get_avatar($comment, $args['avatar_size']);
                        }
        ?>
                    </div>
                </div>
                <div class="flex-1 px-4 py-2 sm:px-6 sm:py-4">
                    <div class="flex mb-4 flex-wrap items-center">
                        <?php
        $comment_author = get_comment_author_link($comment);

        if ('0' == $comment->comment_approved && !$show_pending_links) {
            $comment_author = get_comment_author($comment);
        }

        printf(
            /* translators: %s: Comment author link. */
            __('<div class="text-2xl mr-2 text-primary">%1$s</div> <span class="sr-only">%1$s</span>'),
            sprintf('<b class="fn">%s</b>', $comment_author)
        );
        ?>
                       
                            <a class="" href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                                <?php
            /* Translators: 1 = comment date, 2 = comment time */
            $comment_timestamp = sprintf(__('%1$s<span class="text-accent mx-2">@</span>%2$s', 'blankslate'),
                get_comment_date('', $comment), get_comment_time());
        ?>
                                On <time datetime="<?php comment_time('c'); ?>"
                                    title="<?php echo esc_attr($comment_timestamp); ?>"> <svg
                                        class="h-4 w-4 inline-flex text-accent" focusable="false" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" />
                                        <circle cx="12" cy="12" r="9" />
                                        <polyline points="12 7 12 12 15 15" />
                                    </svg>
                                    <?php printf($comment_timestamp); ?>
                                </time>
                            </a>
                    </div>
                    <?php if ('0' == $comment->comment_approved) { ?>
                    <em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
                    <?php } ?>

                    <div class="mb-4 prose">
                        <?php comment_text(); ?>
                    </div><!-- .comment-content -->

                    <?php
                if ('1' == $comment->comment_approved || $show_pending_links) {
                    comment_reply_link(
                        array_merge(
                            $args,
                            [
                                'add_below' => 'div-comment',
                                'depth' => $depth,
                                'max_depth' => $args['max_depth'],
                                'before' => '<div class="flex-1"><span>
                                <svg class="h-8 w-8 text-accent" focusable="false"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                              </svg></span>',
                                'after' => '</div>',
                            ]
                        )
                    );
                }
        ?>
                </div>
        </article><!-- .comment-body -->
        <?php
    }
}
