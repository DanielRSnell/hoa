<?php
acf_form_head();
$editor = new \Artisan\Editor\Editor();
?>
<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        <?php echo $editor->getEditorStyles(); ?>
    </style>
    <?php wp_head();?>
</head>
<body <?php body_class('umbral-editor-body');?>>
<div class="umbral-editor">
    <div class="umbral-editor__sidebar">
        <div class="umbral-editor__form">
            <div class="umbral-editor__form-content">
                <?php
acf_form([
    'post_id' => get_the_ID(),
    'post_title' => false,
    'post_content' => false,
    'submit_value' => 'Update Page',
    'return' => add_query_arg('editor', 'true', get_permalink()),
]);
?>
            </div>
        </div>
    </div>
    <div class="umbral-editor__preview">
        <iframe src="<?php echo add_query_arg('editor', 'preview', get_permalink()); ?>" frameborder="0"></iframe>
    </div>
</div>
<script type="module" src="<?php echo get_template_directory_uri(); ?>/artisan/editor/assets/scripts/editor.js"></script>
<?php wp_footer();?>
</body>
</html>
