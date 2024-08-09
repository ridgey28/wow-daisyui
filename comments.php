<?php
get_template_part('/inc/class-slate-comment-walker');
/*
 * The template file for displaying the comments and comment form.
 *
 * @since 1.0.0
 */
?>
<section class="m-8">

<?php if ($comments) { ?>
<div class="md:grid md:grid-cols-1" id="comments">
    <div>

    <?php $comments_number = absint(get_comments_number()); ?>

    <h2 class="text-4xl font-bold my-6">
        <?php
                if (!have_comments()) {
                    _e('Leave a comment', 'blankslate');
                } elseif ('1' === $comments_number) {
                    /* translators: %s: post title */
                    printf(_x('One reply on &ldquo;%s&rdquo;', 'comments title', 'blankslate'),
                        esc_html(get_the_title()));
                } else {
                    echo sprintf(
                        /* translators: 1: number of comments, 2: post title */
                        _nx(
                            '%1$s reply on &ldquo;%2$s&rdquo;',
                            '%1$s replies on &ldquo;%2$s&rdquo;',
                            $comments_number,
                            'comments title',
                            'blankslate'
                        ),
                        number_format_i18n($comments_number),
                        esc_html(get_the_title())
                    );
                }
    ?>
    </h2><!-- .comments-title -->

        <?php
        $comments_arr = [
            'avatar_size' => 64,
            'style' => 'div',
            'short_ping' => true,
            'walker' => new Slate_Comment_Walker(),
        ];
    wp_list_comments($comments_arr);

    $comment_pagination = paginate_comments_links(
        [
            'echo' => false,
            'prev_next' => false,
            'type' => 'array',
        ]
    );
    $search_str = ['current', 'page-numbers'];
    $replace_str = ['btn-active', 'join-item btn'];
    $comment_pag = str_replace($search_str, $replace_str, $comment_pagination);
    if ($comment_pag) {
        ?>

        <nav class="join" aria-label="<?php esc_attr_e('Comments', 'blankslate'); ?>">
                <?php
                        foreach ($comment_pag as $cp) {
                            echo wp_kses_post($cp);
                        }?>
        </nav>

        <?php
    }
    ?>
</div>

<?php
}

if (comments_open() || pings_open()) {
    $form_control = '<div class="form-control w-full">';
    $form_control_close = '</div>';
    $required = '<span class="font-bold ml-2">*</span>';
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $fields = [
        'author' => $form_control.'<label for="author" class="label">
                        <span class="label-text">'.__('Name', 'blankslate').
                        ($req ? $required : '').'</span></label>
            <input name="author" id="author" class="input input-bordered w-full max-w-xs"
             type="text" value="'.esc_attr($commenter['comment_author']).'"'.$aria_req.' />'.$form_control_close,

        'email' => $form_control.'<label for="email" class="label">
                                  <span class="label-text">'.__('Email', 'blankslate').
                                 ($req ? $required : '').'</span></label>
            <input id="email" name="email" class="input input-bordered w-full max-w-xs" type="email"
             value="'.esc_attr($commenter['comment_author_email']).'"'.$aria_req.' />'.$form_control_close,

        'url' => $form_control.'<label for="url" class="label"><span class="label-text">'.__('Website', 'blankslate')
                 .'</span>'.'</label>
                <input id="url" name="url" class="input input-bordered w-full max-w-xs" type="text"
                value="'.esc_attr($commenter['comment_author_url']).'"/>'.$form_control_close,
    ];
    $comment_field = $form_control.'<label for="comment" class="label">
                        <span class="label-text">'._x('Comment', 'comment-label', 'blankslate').
    ($req ? $required : '').'</span></label>';
    $comment_field .= '<textarea id="comment" name="comment"
                        class="textarea textarea-bordered textarea-lg w-full max-w-xs"
                        aria-required="true"></textarea>'.$form_control_close;
    comment_form(
        [
            'fields' => $fields,
            'title_reply_before' => '<h2 class="text-4xl my-6 font-bold">',
            'title_reply_after' => '</h2>',
            'format' => 'html5',
            'class_container' => 'col-span-1',
            'submit_button' => '<button name="%1$s" type="submit" id="%2$s"
                                class="btn btn-primary my-8"> %4$s </button>',
            'comment_field' => $comment_field,
        ]
    );
} elseif (is_single()) {
    ?>

<div id="respond" class="col-span-1">

    <p class="text-4xl my-6 text-info"><?php _e('Comments are closed.', 'blankslate'); ?></p>

</div><!-- #respond-->
<?php
}?>
</section>
