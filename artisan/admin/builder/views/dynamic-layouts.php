<?php
if (!defined('ABSPATH')) exit;
?>

<div class="wrap">
    <h1>Dynamic Layouts</h1>
    <div class="about-text">
        Configure dynamic layouts and template settings for your site.
    </div>

    <div class="card">
        <h2>Available Layouts</h2>
        <p>Manage your layouts and templates:</p>
        <p><a href="<?php echo admin_url('edit.php?post_type=layout'); ?>" class="button button-primary">Manage Layouts</a></p>
    </div>
</div>

<style>
.about-text {
    margin: 1em 0;
    min-height: auto;
    font-size: 16px;
}

.card {
    max-width: 800px;
    margin-top: 20px;
}
</style>
