<?php
/*Created post edit link so it can be used in index, single and page files */
$edit = '<svg class="h-6 w-6 inline text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
</svg>';?>

<?php
    $id = get_the_ID();
    $post = ($id === null) ? 0 : get_post($id);
?>
<?php if (current_user_can('edit_post', $id)):?>
        <?php edit_post_link('edit', $edit, '', $post, 'text-accent'); ?>
    <?php
endif;
