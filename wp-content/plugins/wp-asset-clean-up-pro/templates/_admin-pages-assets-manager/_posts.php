<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
	exit;
}
?>
<div style="margin: 25px 0 0;">
	<?php
	$data['post_id'] = (isset($_GET['wpacu_post_id']) && $_GET['wpacu_post_id']) ? (int)$_GET['wpacu_post_id'] : false;
    ?>
        <p style="margin-bottom: 0;">Тип сообщения: «сообщение» (например, записи в блоге) &#10230; <a target="_blank" href="https://wordpress.org/support/article/writing-posts/"><?php _e('read more', 'wp-asset-clean-up'); ?></a></p>
        <div style="margin: 15px 0 0;" class="clearfix"></div>
    <?php
    $data['dashboard_edit_not_allowed'] = false;

    require_once __DIR__.'/common/_is-dashboard-edit-allowed.php';

    if ($data['dashboard_edit_not_allowed']) {
        return; // stop here as the message about the restricted access has been printed
    }

	if ($data['post_id']) {
	    // There's a POST ID requested in the URL / Show the assets
	    $data['post_type'] = get_post_type($data['post_id']);
		do_action('wpacu_admin_notices');
	    require_once __DIR__.'/_singular-page.php';
    } else {
		// There's no POST ID requested
	    $data['post_type'] = 'post';
		require_once '_singular-page-search-form.php';
	}
	?>
</div>