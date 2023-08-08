<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
	exit;
}
?>
<div style="margin: 0 0 15px;">
	<?php
	$loadSearchFormForPages = true;

    $searchPlaceholderText = sprintf(__('You can type a keyword or the ID to search the %s for which you want to manage its CSS/JS (e.g. unloading)', 'wp-asset-clean-up'), $data['post_type']);

	// Anything that is not within the array, is a custom post type
	if (isset($_GET['wpacu_for'])) {
        if ($_GET['wpacu_for'] === 'custom-post-types') {
            $postTypes = get_post_types( array( 'public' => true ) );

            if ( ! empty($postTypes) ) {
                $postTypesList = \WpAssetCleanUp\Misc::filterCustomPostTypesList($postTypes);
            ?>
                После того, как вы выберете настраиваемый тип сообщения, вы можете искать среди всех сообщений, которые находятся на ваш выбор:
                <select id="wpacu-custom-post-type-choice">
                    <?php foreach ($postTypesList as $listPostType => $listPostTypeLabel) { ?>
                        <option <?php if ($data['post_type'] === $listPostType) { echo 'selected="selected"'; } ?> value="<?php echo esc_attr($listPostType); ?>"><?php echo esc_html($listPostTypeLabel); ?></option>
                    <?php } ?>
                </select>
            <?php } else { ?>
                <div style="padding: 10px; background: white; border-radius: 10px; border: 1px solid #c3c4c7;">
                    <span class="dashicons dashicons-warning" style="color: #004567;"></span> У вас нет настраиваемых типов сообщений. Таким образом, эта площадь не используется. Как только вы будете использовать плагины с пользовательскими типами сообщений (например, WooCommerce с его типом сообщений «продукт») или добавите их в свою (дочернюю) тему, они появятся здесь, чтобы вы могли управлять страницами, относящимися к определенному сообщению. типы.
                </div>
            <?php } ?>

            <div style="margin: 0 0 15px;"></div>
		<?php
        } elseif ($_GET['wpacu_for'] === 'posts') {
           $posts = get_posts(array('post_type' => 'post', 'post_status' => 'publish,private'));
	        if (empty($posts)) {
	           $loadSearchFormForPages = false; // no posts added
               ?>
               <div style="padding: 10px; background: white; border-radius: 10px; border: 1px solid #c3c4c7;">
                   <span class="dashicons dashicons-warning" style="color: #004567;"></span> Не добавлено ни одной записи <a style="text-decoration: none;" target="_blank" href="<?php echo admin_url('edit.php'); ?>"><span class="dashicons dashicons-admin-post"></span> "Сообщения" --> "Все сообщения"</a>.
               </div>
               <?php
           }
        } elseif ($_GET['wpacu_for'] === 'pages') {
	        $pages = get_pages(array('post_type' => 'page', 'post_status' => array('publish', 'private')));
	        if (empty($pages)) {
		        $loadSearchFormForPages = false; // no pages added
		        ?>
                <div style="padding: 10px; background: white; border-radius: 10px; border: 1px solid #c3c4c7;">
                    <span class="dashicons dashicons-warning" style="color: #004567;"></span> Не добавлено ни одной страницы <a style="text-decoration: none;" target="_blank" href="<?php echo admin_url('edit.php?post_type=page'); ?>"><span class="dashicons dashicons-admin-page"></span> "Страницы" --> "Все страницы"</a>.
                </div>
		        <?php
	        }
        }
	}

    if (isset($postTypes) && empty($postTypes)) {
	    $loadSearchFormForPages = false; // no post types added
    }

    if ($loadSearchFormForPages) {
    ?>
        <form id="wpacu-search-form-assets-manager">
            Менеджер загрузки активов для:
            <input type="text"
                   class="search-field"
                   value=""
                   placeholder="<?php echo esc_attr($searchPlaceholderText); ?>"
                   style="max-width: 800px; width: 100%; padding-right: 15px;" />
            * <small>После выбора поста загрузится менеджер CSS и JS для управления активами для выбранного поста.</small>
            <div style="display: none; padding: 10px; color: #cc0000;" id="wpacu-search-form-assets-manager-no-results"><span class="dashicons dashicons-warning"></span> <?php _e('There are no results based on your search', 'wp-asset-clean-up'); ?>. <?php echo sprintf(__('Remember that you can also use the %s ID in the input', 'wp-asset-clean-up'), $data['post_type']); ?>.</div>
        </form>

        <div style="display: none;" id="wpacu-post-chosen-loading-assets">
            <img style="margin: 2px 0 4px;"
                 src="<?php echo esc_url(WPACU_PLUGIN_URL); ?>/assets/icons/loader-horizontal.svg?x=<?php echo time(); ?>"
                 align="top"
                 width="120"
                 alt="" />
        </div>
    <?php
    }
    ?>
</div>