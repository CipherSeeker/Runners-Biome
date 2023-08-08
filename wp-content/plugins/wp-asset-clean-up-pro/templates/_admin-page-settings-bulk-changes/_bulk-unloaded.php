<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
	exit;
}

if (! defined('WPACU_USE_MODAL_BOX')) {
	define('WPACU_USE_MODAL_BOX', true);
}

$possibleWpacuFor = array('everywhere', 'post_types', 'taxonomies', 'authors', 'search_results', 'dates', '404_not_found');

if ( ! in_array($data['for'], $possibleWpacuFor) ) {
    exit('Invalid request');
}
?>
<nav class="nav-tab-wrapper">
    <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_bulk_unloads')); ?>" class="nav-tab <?php if ($data['for'] === 'everywhere') { ?>nav-tab-active<?php } ?>">Везде</a>
    <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_bulk_unloads&wpacu_for=post_types')); ?>" class="nav-tab <?php if ($data['for'] === 'post_types') { ?>nav-tab-active<?php } ?>">Посты, Страницы &amp; Пользовательские типы сообщений</a>
    <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_bulk_unloads&wpacu_for=taxonomies')); ?>" class="nav-tab <?php if ($data['for'] === 'taxonomies') { ?>nav-tab-active<?php } ?>">Taxonomies</a>
    <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_bulk_unloads&wpacu_for=authors')); ?>" class="nav-tab <?php if ($data['for'] === 'authors') { ?>nav-tab-active<?php } ?>">Авторы</a>
    <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_bulk_unloads&wpacu_for=search_results')); ?>" class="nav-tab <?php if ($data['for'] === 'search_results') { ?>nav-tab-active<?php } ?>">результаты поиска</a>
    <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_bulk_unloads&wpacu_for=dates')); ?>" class="nav-tab <?php if ($data['for'] === 'dates') { ?>nav-tab-active<?php } ?>">Даты</a>
    <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_bulk_unloads&wpacu_for=404_not_found')); ?>" class="nav-tab <?php if ($data['for'] === '404_not_found') { ?>nav-tab-active<?php } ?>">404 Не Найдено</a>
</nav>

<div class="wpacu-clearfix"></div>

<?php
do_action('wpacu_admin_notices');

if ($data['for'] === 'post_types') {
	?>
    <div style="margin: 15px 0;">
        <form id="wpacu_post_type_form" method="get" action="<?php echo esc_url(admin_url('admin.php')); ?>">
            <input type="hidden" name="page" value="wpassetcleanup_bulk_unloads" />
            <input type="hidden" name="wpacu_for" value="post_types" />

            <div style="margin: 0 0 10px 0;">Выберите тип страницы или записи (включая пользовательские), для которых вы хотите увидеть выгруженные скрипты и стили:</div>
            <?php \WpAssetCleanUp\BulkChanges::buildPostTypesListDd($data['post_types_list'], $data['post_type']); ?>
        </form>
    </div>
	<?php
}

// [wpacu_pro]
if ($data['for'] === 'taxonomies') {
	?>
    <div style="margin: 15px 0;">
        <form id="wpacu_taxonomy_form" method="get" action="<?php echo esc_url(admin_url('admin.php')); ?>">
            <input type="hidden" name="page" value="wpassetcleanup_bulk_unloads" />
            <input type="hidden" name="wpacu_for" value="taxonomies" />

            <div style="margin: 0 0 10px 0;">Выберите страницу или тип записи (включая пользовательские), для которых вы хотите увидеть выгруженные скрипты и стили.:</div>
            <select id="wpacu_taxonomy_select" name="wpacu_taxonomy">
				<?php foreach ($data['taxonomies_list'] as $taxonomyKey => $taxonomyValue) { ?>
                    <option <?php if ($data['taxonomy'] === $taxonomyKey) { echo 'selected="selected"'; } ?> value="<?php echo esc_attr($taxonomyKey); ?>"><?php echo esc_html($taxonomyValue); ?></option>
				<?php } ?>
            </select>
        </form>
    </div>
	<?php
}
// [/wpacu_pro]
?>

<form action="" method="post">
	<?php
    // [wpacu_pro]
    $isCustomPostTypeArchivePageRequest = isset($data['post_type']) && (strpos($data['post_type'], 'wpacu_custom_post_type_archive_') !== false);
    // [/wpacu_pro]

	if ($data['for'] === 'everywhere') {
		?>
        <div class="wpacu-clearfix"></div>

        <div class="alert">
            <p>Это список ресурсов, которые <strong>выгружаются везде</strong> (по всему сайту) на всех страницах (включая главную). &nbsp;&nbsp;<a id="wpacu-add-bulk-rules-info-target" href="#wpacu-add-bulk-rules-info" style="text-decoration: none;"><span class="dashicons dashicons-info"></span> Как приведенный ниже список заполняется правилами для всего сайта?</a></p>
            <p>Если вы хотите удалить это правило и разрешить их загрузку, установите флажок «Удалить правило для всего сайта».</p>
            <div style="margin: 0; background: white; padding: 10px; border: 1px solid #ccc; width: auto; display: inline-block;">
                <ul>
                    <li>Этот список заполняется, когда вы выбираете «<em>Выгрузить везде</em>», когда редактируете записи/страницы для ресурсов, которые вы не хотите загружать на каждой странице.</li>
                    <li>На этой странице вы можете удалить только те глобальные правила, которые были добавлены при редактировании страниц/сообщений.</li>
                </ul>
            </div>
        </div>

        <div class="wpacu-clearfix"></div>

		<div style="padding: 0 10px 0 0;">
			<p style="margin-bottom: 10px;"><strong><?php _e('Stylesheets (.css) Unloaded', 'wp-asset-clean-up'); ?></strong></p>
			<?php
			if (! empty($data['values']['styles'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Действия</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['styles'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td>
                                <?php wpacuRenderHandleTd($handle, 'styles', $data); ?>
                            </td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_styles[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Удалить правило для всего сайта</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
				<p><?php _e('There are no site-wide unloaded styles.', 'wp-asset-clean-up'); ?></p>
				<?php
			}
			?>

            <hr style="margin: 15px 0;"/>

			<p style="margin-bottom: 10px;"><strong><?php _e('Scripts (.js) Unloaded', 'wp-asset-clean-up'); ?></strong></p>
			<?php
			if (! empty($data['values']['scripts'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Действия</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['scripts'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td>
	                            <?php wpacuRenderHandleTd($handle, 'scripts', $data); ?>
                            </td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_scripts[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Удалить правило для всего сайта</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
				<p><?php _e('There are no site-wide unloaded scripts.', 'wp-asset-clean-up'); ?></p>
				<?php
			}
			?>
        </div>
		<?php
	}

	if ($data['for'] === 'post_types'
        // [wpacu_pro]
        && ! $isCustomPostTypeArchivePageRequest
        // [/wpacu_pro]
    ) {
		?>
        <div class="wpacu-clearfix"></div>

        <div class="alert">
            <p>Это список ресурсов, которые <strong>выгружаются</strong> на всех страницах, принадлежащих <strong><u><?php echo esc_html($data['post_type']); ?></u></strong> post type. &nbsp;&nbsp;<a id="wpacu-add-bulk-rules-info-target" href="#wpacu-add-bulk-rules-info" style="text-decoration: none;"><span class="dashicons dashicons-info"></span> Как приведенный ниже список заполняется правилами для всего сайта?</a></p>
            <p>Если вы хотите, чтобы ресурс загружался снова, используйте флажок «Удалить массовое правило».</p>
            <div style="margin: 0; background: white; padding: 10px; border: 1px solid #ccc; width: auto; display: inline-block;">
                <ul>
                    <li>Этот список заполняется, когда вы выбираете «<em>Выгрузить на все страницы <strong><?php echo esc_html($data['post_type']); ?></strong> тип сообщения</em>", когда вы редактируете сообщения/страницы для ресурсов, загрузку которых вы хотите предотвратить.</li>
                    <li>На этой странице можно удалить только те глобальные правила, которые были добавлены при редактировании. <strong><?php echo esc_html($data['post_type']); ?></strong>типы сообщений.</li>
                </ul>
            </div>
        </div>

		<div class="wpacu-clearfix"></div>

		<div style="padding: 0 10px 0 0;">
            <p style="margin-bottom: 10px;"><strong><?php _e('Stylesheets (.css) Unloaded', 'wp-asset-clean-up'); ?></strong></p>
			<?php
			if (! empty($data['values']['styles'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Действия</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['styles'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'styles', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_post_type_styles[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Удалить массовое правило</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Нет массовой выгрузки стилей для <strong><?php echo esc_html($data['post_type']); ?></strong> тип сообщения.</p>
				<?php
			}
			?>

            <hr style="margin: 15px 0;"/>

            <p style="margin-bottom: 10px;"><strong><?php _e('Scripts (.js) Unloaded', 'wp-asset-clean-up'); ?></strong></p>

			<?php
			if (! empty($data['values']['scripts'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Действия</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['scripts'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'scripts', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_post_type_scripts[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Удалить массовое правило</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Нет массовых выгружаемых скриптов для <strong><?php echo esc_html($data['post_type']); ?></strong> тип сообщения.</p>
				<?php
			}
			?>
        </div>
		<?php
	}

	// [wpacu_pro]
	if ($data['for'] === 'post_types' && $isCustomPostTypeArchivePageRequest) {
	    $targetCustomPostTypeKey = str_replace('wpacu_custom_post_type_archive_', 'custom_post_type_archive_', $data['post_type']);
	    $targetCustomPostType = str_replace('wpacu_custom_post_type_archive_', '', $data['post_type']);
		?>
        <div class="wpacu-clearfix"></div>

        <div class="alert">
            <p>Это список ресурсов, которые <strong>выгружаются</strong> на странице архива (с любой разбивкой на страницы), принадлежащей <strong><u><?php echo esc_html($targetCustomPostType); ?></u></strong> post type. &nbsp;&nbsp;<a id="wpacu-add-bulk-rules-info-target" href="#wpacu-add-bulk-rules-info" style="text-decoration: none;"><span class="dashicons dashicons-info"></span> How the list below gets filled with site-wide rules?</a></p>
            <p>Если вы хотите, чтобы актив загружался снова, используйте флажок «Удалить правило».</p>
            <div style="margin: 0; background: white; padding: 10px; border: 1px solid #ccc; width: auto; display: inline-block;">
                <ul>
                    <li>Этот список заполняется, когда вы выбираете `<em>Выгрузить на этом "<?php echo ucfirst($targetCustomPostType); ?>` post type archive page</em>` when you edit posts/pages for the assets that you want to prevent from loading.</li>
                    <li>На этой странице можно удалить только те правила выгрузки, которые были добавлены при редактировании <strong><?php echo esc_html($targetCustomPostType); ?></strong> archive page.</li>
                </ul>
            </div>
        </div>

        <div class="wpacu-clearfix"></div>

        <div style="padding: 0 10px 0 0;">
            <p style="margin-bottom: 10px;"><strong><?php _e('Stylesheets (.css) Unloaded', 'wp-asset-clean-up'); ?></strong></p>
			<?php
			if (! empty($data['values']['styles'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['styles'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'styles', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_<?php echo esc_attr($targetCustomPostTypeKey); ?>_styles[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Remove rule</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Выгруженных стилей нет. <strong><?php echo esc_html($targetCustomPostType); ?></strong> страница архива.</p>
				<?php
			}
			?>

            <hr style="margin: 15px 0;"/>

            <p style="margin-bottom: 10px;"><strong><?php _e('Scripts (.js) Unloaded', 'wp-asset-clean-up'); ?></strong></p>

			<?php
			if (! empty($data['values']['scripts'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['scripts'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'scripts', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_<?php echo esc_attr($targetCustomPostTypeKey); ?>_scripts[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Remove rule</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Массовых выгружаемых скриптов в <strong><?php echo esc_html($targetCustomPostType); ?></strong> страница архива.</p>
				<?php
			}
			?>
        </div>
		<?php
	}

	if ($data['for'] === 'taxonomies') {
		?>
        <div class="wpacu-clearfix"></div>

        <div class="alert">
            <p>Это список ресурсов, которые <strong>выгружаются</strong> на всех страницах таксономий, принадлежащих <strong><u><?php echo esc_html($data['taxonomy']); ?></u></strong> type. &nbsp;&nbsp;<a id="wpacu-add-bulk-rules-info-target" href="#wpacu-add-bulk-rules-info" style="text-decoration: none;"><span class="dashicons dashicons-info"></span> Как приведенный ниже список заполняется правилами для всего сайта?</a></p>
            <p>Если вы хотите снова загрузить ресурс, установите флажок «Удалить массовое правило»..</p>
            <div style="margin: 0; background: white; padding: 10px; border: 1px solid #ccc; width: auto; display: inline-block;">
                <ul>
                    <li>Этот список заполняется, когда вы выбираете «<em>Выгрузить на все страницы <strong><?php echo esc_html($data['taxonomy']); ?></strong> тип таксономии</em>" при редактировании страниц таксономии для объектов, загрузку которых вы хотите запретить..</li>
                    <li>На этой странице можно удалить только те глобальные правила, которые были добавлены при редактировании. <strong><?php echo esc_html($data['taxonomy']); ?></strong> страницы таксономии.</li>
                </ul>
            </div>
        </div>

        <div class="wpacu-clearfix"></div>

        <div style="padding: 0 10px 0 0;">
            <h3>Стили</h3>
			<?php
			if (! empty($data['values']['styles'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['styles'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'styles', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_taxonomy_styles[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Remove bulk rule</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Нет массовой выгрузки стилей для <strong><?php echo esc_html($data['taxonomy']); ?></strong>тип таксономии.</p>
				<?php
			}
			?>

            <h3>Scripts</h3>
			<?php
			if (! empty($data['values']['scripts'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['scripts'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'scripts', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_taxonomy_scripts[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Remove bulk rule</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Нет массовых выгружаемых скриптов для <strong><?php echo esc_html($data['taxonomy']); ?></strong> тип таксономии.</p>
				<?php
			}
			?>
        </div>
		<?php
	}

	if ($data['for'] === 'authors') {
		?>
        <div class="wpacu-clearfix"></div>

        <div class="alert">
            <p>Это список ресурсов, которые <strong>выгружаются</strong> на всех страницах авторов.</p>
            <p>Если вы хотите, чтобы актив загружался снова, используйте флажок «Удалить правило»..</p>
            <div style="margin: 0; background: white; padding: 10px; border: 1px solid #ccc; width: auto; display: inline-block;">
                <ul>
                    <li>Этот список заполняется после выбора "<em>Выгрузить на все <strong>Author</strong> Pages</em>" когда вы редактируете авторские страницы для активов, которые вы хотите предотвратить от загрузки.</li>
                    <li>На этой странице можно удалить только те глобальные правила, которые были добавлены при редактировании авторских страниц..</li>
                </ul>
            </div>
        </div>

        <div class="wpacu-clearfix"></div>

        <div style="padding: 0 10px 0 0;">
            <h3>Styles</h3>
			<?php
			if (! empty($data['values']['styles'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['styles'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'styles', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_author_styles[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Удалить массовое правило</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Для страницы архива <strong>Автор</strong> не существует массовой выгрузки стилей.</p>
				<?php
			}
			?>

            <h3>Scripts</h3>
			<?php
			if (! empty($data['values']['scripts'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['scripts'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'scripts', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_author_scripts[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Remove bulk rule</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Для страницы архива <strong>Автор</strong> отсутствуют массовые выгружаемые скрипты..</p>
				<?php
			}
			?>
        </div>
		<?php
	}

	if ($data['for'] === 'search_results') {
		?>
        <div class="wpacu-clearfix"></div>

        <div class="alert">
            <p>Это список ресурсов, которые <strong>выгружаются</strong> на всех страницах результатов поиска WordPress по умолчанию.</p>
            <p>Если вы хотите, чтобы ресурс загружался снова, используйте флажок «Удалить массовое правило».</p>
            <div style="margin: 0; background: white; padding: 10px; border: 1px solid #ccc; width: auto; display: inline-block;">
                <ul>
                    <li>Этот список заполняется, когда вы выбираете ресурс для выгрузки на странице поиска WordPress по умолчанию (любые результаты).</li>
                    <li>На этой странице можно удалить только те глобальные правила, которые были добавлены при редактировании страниц результатов поиска..</li>
                </ul>
            </div>
        </div>

        <div class="wpacu-clearfix"></div>

        <div style="padding: 0 10px 0 0;">
            <h3>Styles</h3>
			<?php
			if (! empty($data['values']['styles'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['styles'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'styles', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_search_styles[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Remove bulk rule</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Для страницы <strong>результатов поиска WordPress по умолчанию</strong> нет массовой выгрузки стилей.</p>
				<?php
			}
			?>

            <h3>Scripts</h3>
			<?php
			if (! empty($data['values']['scripts'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['scripts'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'scripts', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_search_scripts[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Remove bulk rule</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Для страницы <strong>результатов поиска WordPress по умолчанию</strong> нет сценариев массовой выгрузки..</p>
				<?php
			}
			?>
        </div>
		<?php
	}

	if ($data['for'] === 'dates') {
		?>
        <div class="wpacu-clearfix"></div>

        <div class="alert">
            <p>Это список ресурсов, которые <strong>выгружаются</strong> на всех страницах архива дат..</p>
            <p>Если вы хотите, чтобы ресурс загружался снова, используйте флажок «Удалить массовое правило».</p>
            <div style="margin: 0; background: white; padding: 10px; border: 1px solid #ccc; width: auto; display: inline-block;">
                <ul>
                    <li>Этот список заполняется, как только вы выбираете актив для выгрузки на странице даты WordPress по умолчанию (любая дата).</li>
                    <li>На этой странице вы можете удалить только те глобальные правила, которые были добавлены при редактировании страниц даты.</li>
                </ul>
            </div>
        </div>

        <div class="wpacu-clearfix"></div>

        <div style="padding: 0 10px 0 0;">
            <h3>Styles</h3>
			<?php
			if (! empty($data['values']['styles'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['styles'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'styles', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_date_styles[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Remove bulk rule</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Для страницы <strong>date</strong> нет массовой выгрузки стилей..</p>
				<?php
			}
			?>

            <h3>Scripts</h3>
			<?php
			if (! empty($data['values']['scripts'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['scripts'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'scripts', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_date_scripts[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Удалить массовое правило</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Для страницы <strong>date</strong> нет скриптов массовой выгрузки.</p>
				<?php
			}
			?>
        </div>
		<?php
	}

	if ($data['for'] === '404_not_found') {
		?>
        <div class="wpacu-clearfix"></div>

        <div class="alert">
            <p>Это список ресурсов, которые <strong>выгружаются</strong> на всех страницах архива дат..</p>
            <p>Если вы хотите, чтобы ресурс загружался снова, используйте флажок «Удалить массовое правило».</p>
            <div style="margin: 0; background: white; padding: 10px; border: 1px solid #ccc; width: auto; display: inline-block;">
                <ul>
                    <li>Этот список заполняется, когда вы выбираете актив для выгрузки на странице 404 Not Found (любой URL).</li>
                    <li>На этой странице вы можете удалить только те глобальные правила, которые были добавлены при редактировании 404 Not Found.</li>
                </ul>
            </div>
        </div>

        <div class="wpacu-clearfix"></div>

        <div style="padding: 0 10px 0 0;">
            <h3>Styles</h3>
			<?php
			if (! empty($data['values']['styles'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['styles'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'styles', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_404_styles[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Remove bulk rule</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Для страницы <strong>404 Not Found</strong> не существует массовой выгрузки стилей.</p>
				<?php
			}
			?>

            <h3>Scripts</h3>
			<?php
			if (! empty($data['values']['scripts'])) {
				?>
                <table class="wp-list-table widefat fixed striped">
                    <tr>
                        <td><strong>Handle</strong></td>
                        <td><strong>Actions</strong></td>
                    </tr>
					<?php
					foreach ($data['values']['scripts'] as $handle) {
						?>
                        <tr class="wpacu_global_rule_row wpacu_bulk_change_row">
                            <td><?php wpacuRenderHandleTd($handle, 'scripts', $data); ?></td>
                            <td>
                                <label><input type="checkbox"
                                              class="wpacu_bulk_rule_checkbox"
                                              name="wpacu_options_404_scripts[<?php echo esc_attr($handle); ?>]"
                                              value="remove" /> Remove bulk rule</label>
                            </td>
                        </tr>
						<?php
					}
					?>
                </table>
				<?php
			} else {
				?>
                <p>Для страницы <strong>404 Not Found</strong> не существует сценариев массовой выгрузки.</p>
				<?php
			}
			?>
        </div>
		<?php
	}
	// [/wpacu_pro]

	$noAssetsToRemove = (empty($data['values']['styles']) && empty($data['values']['scripts']));
	?>
	<?php wp_nonce_field($data['nonce_action'], $data['nonce_name']); ?>

    <input type="hidden" name="wpacu_for" value="<?php echo esc_attr($data['for']); ?>" />
    <input type="hidden" name="wpacu_update" value="1" />

	<?php
	if ($data['for'] === 'post_types' && isset($data['post_type'])) {
		?>
        <input type="hidden" name="wpacu_post_type" value="<?php echo esc_attr($data['post_type']); ?>" />
		<?php
	}

	// [wpacu_pro]
	if ($data['for'] === 'taxonomies' && isset($data['taxonomy'])) {
		?>
        <input type="hidden" name="wpacu_taxonomy" value="<?php echo esc_attr($data['taxonomy']); ?>" />
		<?php
	}
	// [/wpacu_pro]
	?>

    <div class="wpacu-clearfix"></div>

    <div id="wpacu-update-button-area" class="no-left-margin">
        <p class="submit">
			<?php
			wp_nonce_field('wpacu_bulk_unloads_update', 'wpacu_bulk_unloads_update_nonce' );
			?>
            <input type="submit"
                   name="submit"
                   id="submit"
				<?php if ($noAssetsToRemove) { ?>
                    disabled="disabled"
				<?php } ?>
                   class="button button-primary"
                   value="<?php esc_attr_e('Apply changes', 'wp-asset-clean-up'); ?>" />
			<?php
			if ($noAssetsToRemove) {
				?>
				&nbsp;<small><?php _e('Note: As there are no unloaded assets (scripts &amp; styles) to be managed, the button is disabled.', 'wp-asset-clean-up'); ?></small>
				<?php
			}
			?>
        </p>
        <div id="wpacu-updating-settings" style="margin-left: 150px;">
            <img src="<?php echo esc_url(admin_url('images/spinner.gif')); ?>" align="top" width="20" height="20" alt="" />
        </div>
    </div>
</form>
<!-- Start Site-Wide Modal -->
<div id="wpacu-add-bulk-rules-info" class="wpacu-modal">
    <div class="wpacu-modal-content">
        <span class="wpacu-close">&times;</span>
        <h2><?php _e('Unloading CSS/JS site-wide or for a group of pages', 'wp-asset-clean-up'); ?></h2>
        <p>Это обзор всех активов, к которым применены массовые изменения. Все, что вы видите на этой странице, заполняется в тот момент, когда вы переходите к редактированию страницы через «Диспетчер загрузки CSS/JS» (например, домашнюю страницу или сообщение) и используете такие параметры, как:</p>

        <ul style="list-style: disc; margin-left: 20px;">
            <li>Выгрузка по всему сайту (везде)</strong></li>
            <li>Выгрузить на все страницы поста типа `товар`</li>
            <li>Выгрузить на все страницы типа таксономии `product_cat` и т. д.</li>
            <li>Выгрузить на этой странице архива `[название пользовательского типа сообщения]`</li>
            <li>Выгрузить на этом типе страницы (любой 404 Not Found URL) и т. д.</li>
        </ul>

        <p>Массовым изменением считается все, что применяется один раз и влияет на несколько страниц одного типа или всего сайта.</p>
    </div>
</div>
<!-- End Site-Wide Modal -->