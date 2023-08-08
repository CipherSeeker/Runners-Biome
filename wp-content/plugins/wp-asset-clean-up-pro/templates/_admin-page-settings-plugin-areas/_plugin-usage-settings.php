<?php
/*
 * No direct access to this file
 */
if (! isset($data, $selectedTabArea)) {
	exit;
}

use WpAssetCleanUp\Misc;

$tabIdArea = 'wpacu-setting-plugin-usage-settings';
$styleTabContent = ($selectedTabArea === $tabIdArea) ? 'style="display: table-cell;"' : '';

$postTypesList = get_post_types(array('public' => true));

// Hide hardcoded irrelevant post types
foreach (\WpAssetCleanUp\MetaBoxes::$noMetaBoxesForPostTypes as $noMetaBoxesForPostType) {
    unset($postTypesList[$noMetaBoxesForPostType]);
}
?>
<div id="<?php echo esc_attr($tabIdArea); ?>" class="wpacu-settings-tab-content" <?php echo wp_kses($styleTabContent, array('style' => array())); ?>>
    <h2 class="wpacu-settings-area-title"><?php _e('General &amp; Files Management', 'wp-asset-clean-up'); ?></h2>
    <p><?php _e('Choose how the assets are retrieved and whether you would like to see them within the Dashboard / Front-end view', 'wp-asset-clean-up'); ?>; <?php _e('Decide how the management list of CSS &amp; JavaScript files will show up and get sorted, depending on your preferences.', 'wp-asset-clean-up'); ?></p>
    <table class="wpacu-form-table">
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_dashboard"><?php _e('Manage in the Dashboard', 'wp-asset-clean-up'); ?></label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_dashboard"
                           data-target-opacity="wpacu_manage_dashboard_assets_list"
                           type="checkbox"
						<?php echo (($data['dashboard_show'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[dashboard_show]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                <?php _e('This will show the list of assets in a meta box on edit the post (any type) / page within the Dashboard', 'wp-asset-clean-up'); ?>

                <div id="wpacu_manage_dashboard_assets_list" <?php if ($data['dashboard_show'] != 1) { echo 'style="opacity: 0.4;"'; } ?>>
                    <p><?php _e('The assets would be retrieved via AJAX call(s) that will fetch the post/page URL and extract all the styles &amp; scripts that are enqueued.', 'wp-asset-clean-up'); ?></p>
                    <p><?php _e('Note that sometimes the assets list is not loading within the Dashboard. That could be because "mod_security" Apache module is enabled or some security plugins are blocking the AJAX request. If this option doesn\'t work, consider managing the list in the front-end view.', 'wp-asset-clean-up'); ?></p>

                    <div id="wpacu-settings-assets-retrieval-mode" <?php if (! ($data['dashboard_show'] == 1)) { echo 'style="display: none;"'; } ?>>
                        <ul id="wpacu-dom-get-type-selections">
                            <li>
                                <label><?php _e('Select a retrieval way', 'wp-asset-clean-up'); ?>:</label>
                            </li>
                            <li>
                                <label>
                                    <input class="wpacu-dom-get-type-selection"
                                           data-target="wpacu-dom-get-type-direct-info"
                                           <?php if ($data['dom_get_type'] === 'direct') { ?>checked="checked"<?php } ?>
                                           type="radio" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[dom_get_type]"
                                           value="direct" /> <?php _e('Direct', 'wp-asset-clean-up'); ?>
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input class="wpacu-dom-get-type-selection"
                                           data-target="wpacu-dom-get-type-wp-remote-post-info"
                                           <?php if ($data['dom_get_type'] === 'wp_remote_post') { ?>checked="checked"<?php } ?>
                                           type="radio" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[dom_get_type]"
                                           value="wp_remote_post" /> WP Remote Post
                                </label>
                            </li>
                        </ul>

                        <div class="wpacu-clearfix" style="height: 0;"></div>

                        <ul id="wpacu-dom-get-type-infos">
                            <li <?php if ($data['dom_get_type'] !== 'direct') { ?>style="display: none;"<?php } ?>
                                class="wpacu-dom-get-type-info"
                                id="wpacu-dom-get-type-direct-info">
                                <strong><?php _e('Direct', 'wp-asset-clean-up'); ?></strong> - <?php _e('This one makes an AJAX call directly on the URL for which the assets are retrieved, then an extra WordPress AJAX call to process the list. Sometimes, due to some external factors (e.g. mod_security module from Apache, security plugin or the fact that non-http is forced for the front-end view and the AJAX request will be blocked), this might not work and another choice method might work better. This used to be the only option available, prior to version 1.2.4.4 and is set as default.', 'wp-asset-clean-up'); ?>
                            </li>
                            <li <?php if ($data['dom_get_type'] !== 'wp_remote_post') { ?>style="display: none;"<?php } ?>
                                class="wpacu-dom-get-type-info"
                                id="wpacu-dom-get-type-wp-remote-post-info">
                                <strong>WP Remote Post</strong> - <?php _e('It makes a WordPress AJAX call and gets the HTML source code through wp_remote_post(). This one is less likely to be blocked as it is made on the same protocol (no HTTP request from HTTPS). However, in some cases (e.g. a different load balancer configuration), this might not work when the call to fetch a domain\'s URL (your website) is actually made from the same domain.', 'wp-asset-clean-up'); ?>
                            </li>
                        </ul>
                    </div>

                    <hr /><div class="wpacu-clearfix" style="height: 0;"></div>

                    <input type="hidden" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[show_assets_meta_box]" value="0" />
                    <fieldset style="margin: 15px 0 0 0; padding: 10px; border: 1px solid #8c8f94; border-radius: 10px;">
                        <legend style="border: 1px solid #8c8f94; padding: 10px; border-radius: 10px;"><label for="wpacu-show-assets-meta-box-checkbox"><input <?php echo (($data['show_assets_meta_box'] == 1) ? 'checked="checked"' : ''); ?> id="wpacu-show-assets-meta-box-checkbox" type="checkbox" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[show_assets_meta_box]" value="1" /> Show "<?php echo WPACU_PLUGIN_TITLE; ?>: CSS &amp; JavaScript Manager / Page Options" meta box (applies only to edit post/page/taxonomy area)</label></legend>

                        <div id="wpacu-show-assets-enabled-area" style="<?php echo (! $data['show_assets_meta_box']) ? 'display: none;' : ''; ?>">
                            <p style="margin-top: 8px;"><?php _e('When you are in the Dashboard and edit a post, page, custom post type, category or custom taxonomy and rarely manage loaded CSS/JS from the "Asset CleanUp: CSS & JavaScript Manager", you can choose to fetch the list when you click on a button. This will help declutter the edit page on load and also save resources as AJAX calls to the front-end won\'t be made to retrieve the assets\' list.', 'wp-asset-clean-up'); ?></p>
                            <ul style="margin-bottom: 0;">
                                <li>
                                    <label for="assets_list_show_status_default">
                                        <input id="assets_list_show_status_default"
                                               <?php if (! $data['assets_list_show_status'] || $data['assets_list_show_status'] === 'default') { ?>checked="checked"<?php } ?>
                                               type="radio"
                                               name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[assets_list_show_status]"
                                               value="default" /> <?php _e('Fetch the assets automatically and show the list', 'wp-asset-clean-up'); ?> (<?php _e('Default', 'wp-asset-clean-up'); ?>)
                                    </label>
                                </li>
                                <li>
                                    <label for="assets_list_show_status_fetch_on_click">
                                        <input id="assets_list_show_status_fetch_on_click"
                                               <?php if ($data['assets_list_show_status'] === 'fetch_on_click') { ?>checked="checked"<?php } ?>
                                               type="radio"
                                               name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[assets_list_show_status]"
                                               value="fetch_on_click" /> <?php _e('Fetch the assets on a button click', 'wp-asset-clean-up'); ?>
                                    </label>
                                </li>
                            </ul><div class="wpacu-clearfix" style="height: 0; clear: both;"></div>

                            <hr />

                            <div id="wpacu-settings-hide-meta-boxes">
                                <label for="wpacu-hide-meta-boxes-for-post-types">Скрыть мета-поле для следующих общедоступных типов сообщений (раскрывающийся список с множественным выбором):</label><br />
                                <select style="margin-top: 4px; min-width: 340px;"
                                        id="wpacu-hide-meta-boxes-for-post-types"
                                        <?php if ($data['input_style'] !== 'standard') { ?>
                                            data-placeholder="Choose Post Type(s)..."
                                            class="wpacu_chosen_select"
                                        <?php } ?>
                                        multiple="multiple"
                                        name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[hide_meta_boxes_for_post_types][]">
                                    <?php foreach ($postTypesList as $postTypeKey => $postTypeValue) { ?>
                                        <option <?php if (in_array($postTypeKey, $data['hide_meta_boxes_for_post_types'])) { echo 'selected="selected"'; } ?>
                                                value="<?php echo esc_attr($postTypeKey); ?>"><?php echo esc_html($postTypeValue); ?></option>
                                    <?php } ?>
                                </select>
                                <p id="wpacu-hide-meta-boxes-for-post-types-info" style="margin-top: 4px;"><small>Иногда у вас может быть тип записи, помеченный как «общедоступный», но он не доступен для запросов или не имеет собственного общедоступного URL-адреса, что делает список активов неактуальным. Или вы завершили оптимизацию страниц для определенного типа сообщений и хотите скрыть список активов. Вы можете скрыть мета-поля для этих конкретных типов сообщений..</small></p>
                            </div>
                        </div>

                        <div id="wpacu-show-assets-disabled-area" style="<?php echo ($data['show_assets_meta_box'] == 1) ? 'display: none;' : ''; ?>">
                            <p>Чтобы просмотреть параметры, относящиеся к метаокну менеджера CSS и JS, расположенному в области редактирования записи/страницы/таксономии, необходимо включить указанную выше опцию.</p>
                        </div>
                    </fieldset>
                </div>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_frontend"><?php _e('Manage in the Front-end', 'wp-asset-clean-up'); ?></label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_frontend"
                           data-target-opacity="wpacu_frontend_manage_assets_list"
                           type="checkbox"
						<?php echo (($data['frontend_show'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[frontend_show]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                Если вы вошли в систему, список активов будет отображаться под страницей, которую вы просматриваете (будь то домашняя страница, сообщение или страница).).

                <div id="wpacu_frontend_manage_assets_list" <?php if ($data['frontend_show'] != 1) { echo 'style="opacity: 0.4;"'; } ?>>
                    <p style="margin-top: 10px;">Область будет показана через <code>wp_footer</code> действие, поэтому, если вы не видите список ресурсов внизу страницы, убедитесь, что тема использует<a href="https://codex.wordpress.org/Function_Reference/wp_footer"><code>wp_footer()</code></a> функционировать перед <code>&lt;/body&gt;</code> tag. Любая тема, которая следует стандартам, должна иметь его. Если нет, вам придется добавить его, чтобы другие плагины и код из functions.php работали нормально.</p>
                    <!-- [wpacu_pro] -->
                    <p style="margin-top: 18px;">&#10230; <strong>NOTE:</strong> Эта опция должна быть включена, если вы хотите управлять активами на следующих страницах: Результаты поиска, Архивы авторов и дат, 404 Not Found..</p>
                    <!-- [/wpacu_pro] -->

                    <div id="wpacu-settings-frontend-exceptions" <?php if (! ($data['frontend_show'] == 1)) { echo 'style="display: none;"'; } ?>>
                        <div style="margin: 0 0 10px;"><label for="wpacu_frontend_show_exceptions"><span class="dashicons dashicons-info"></span> В некоторых ситуациях вы можете не показывать список CSS/JS в нижней части страниц (например, вы используете конструктор страниц, такой как Divi, вы часто загружаете определенные страницы в качестве администратора и вам не нужно управлять активов нет или вы делаете это редко и т.д.). В этом случае вы можете использовать следующую текстовую область, чтобы предотвратить отображение списка на страницах, где <strong>URI содержит</strong> указанные строки. (<?php _e('one per line', 'wp-asset-clean-up'); ?>):</label></div>
                        <textarea id="wpacu_frontend_show_exceptions"
                                  name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[frontend_show_exceptions]"
                                  rows="5"
                                  style="width: 100%;"><?php echo esc_textarea($data['frontend_show_exceptions']); ?></textarea>
                        <p><strong>Example:</strong> If the URI contains <strong>et_fb=1</strong> который запускает интерфейсный построитель страниц Divi, затем вы можете указать его в списке выше (он добавлен по умолчанию), чтобы предотвратить отображение списка ресурсов под областью построителя страниц.</p>
                    </div>
                </div>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="setting_title">
                <label for="wpacu_frontend"><?php _e('Allow managing assets to:', 'wp-asset-clean-up'); ?></label>
                <p class="wpacu_subtitle"><small><em><?php _e('Only the chosen administrators will have access to the plugin\'s CSS &amp; JS Manager.', 'wp-asset-clean-up'); ?></em></small></p>
            </th>
            <td>
                <?php
                $currentUserId = get_current_user_id();

                $args = array(
	                'role'    => 'administrator',
	                'orderby' => 'user_nicename',
	                'order'   => 'ASC'
                );

                $users = get_users( $args );

                ?>
                <select style="vertical-align: top;" id="wpacu-allow-manage-assets-to-select" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[allow_manage_assets_to]">
                    <option <?php if (in_array($data['allow_manage_assets_to'], array('', 'any_admin'))) { ?>selected="selected"<?php } ?> value="any_admin">any administrator</option>
                    <option <?php if ($data['allow_manage_assets_to'] === 'chosen') { ?>selected="selected"<?php } ?> value="chosen">только следующему администратору(ам):</option>
                </select>
                &nbsp;
                <div <?php if (in_array($data['allow_manage_assets_to'], array('', 'any_admin'))) { ?>class="wpacu_hide"<?php } ?>
                    id="wpacu-allow-manage-assets-to-select-list-area">
                <select id="wpacu-allow-manage-assets-to-select-list"
                        name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[allow_manage_assets_to_list][]"
                        <?php if ($data['input_style'] !== 'standard') { ?>
                            data-placeholder="Choose the admin(s) who will access the list..."
                        <?php } ?>
                        multiple="multiple">
                    <?php
                    foreach ( $users as $user ) {
                        $appendText = $selected = '';

                        if ($currentUserId === $user->ID) {
                            $appendText = ' &#10141; yourself';
                        }

                        if (isset($data['allow_manage_assets_to_list']) && is_array($data['allow_manage_assets_to_list']) && in_array($user->ID, $data['allow_manage_assets_to_list'])) {
                            $selected = 'selected="selected"';
                        }

                        echo '<option '.$selected.' value="'.$user->ID.'">' . esc_html( $user->display_name ) . ' (' . esc_html( $user->user_email ) . ')'.$appendText.'</option>';
                    }
                    ?>
                </select>
                    <div style="margin: 2px 0 0;"><small>Это раскрывающийся список множественного выбора. Если ничего не выбрано из списка, по умолчанию будет «любой администратор»..</small></div>
                </div>

                <div style="margin: 10px 0 0;"><p>Некоторых людей с доступом администратора может смутить менеджер CSS/JS (который может быть для разработчика веб-сайта). Если они в основном редактируют статьи, обновляют продукты WooCommerce и т. д., им нет смысла продолжать видеть загроможденную публикацию/страницу редактирования с активами CSS/JS, которые могут быть изменены даже по ошибке. Вы можете оставить это только разработчикам с ролью «администратор»..</p></div>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="setting_title">
                <label for="wpacu_assets_list_layout"><?php _e('Assets List Layout', 'wp-asset-clean-up'); ?></label>
                <p class="wpacu_subtitle"><small><em><?php _e('You can decide how would you like to view the list of the enqueued CSS &amp; JavaScript', 'wp-asset-clean-up'); ?></em></small></p>
            </th>
            <td>
                <label>
                    <?php echo \WpAssetCleanUp\Settings::generateAssetsListLayoutDropDown($data['assets_list_layout'], WPACU_PLUGIN_ID . '_settings[assets_list_layout]' ); ?>
				</label>

                <div id="wpacu-assets-list-by-location-selected" style="margin: 10px 0; <?php if ($data['assets_list_layout'] !== 'by-location') { ?> display: none; <?php } ?>">
                    <div style="margin-bottom: 6px;"><?php _e('When list is grouped by location, keep the assets from each of the plugins in the following state', 'wp-asset-clean-up'); ?>:</div>
                    <ul class="assets_list_layout_areas_status_choices">
                        <li>
                            <label for="assets_list_layout_plugin_area_status_expanded">
                                <input id="assets_list_layout_plugin_area_status_expanded"
				                       <?php if (! $data['assets_list_layout_plugin_area_status'] || $data['assets_list_layout_plugin_area_status'] === 'expanded') { ?>checked="checked"<?php } ?>
                                       type="radio"
                                       name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[assets_list_layout_plugin_area_status]"
                                       value="expanded"> <?php _e('Expanded', 'wp-asset-clean-up'); ?> (<?php _e('Default', 'wp-asset-clean-up'); ?>)
                            </label>
                        </li>
                        <li>
                            <label for="assets_list_layout_plugin_area_status_contracted">
                                <input id="assets_list_layout_plugin_area_status_contracted"
				                       <?php if ($data['assets_list_layout_plugin_area_status'] === 'contracted') { ?>checked="checked"<?php } ?>
                                       type="radio"
                                       name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[assets_list_layout_plugin_area_status]"
                                       value="contracted"> <?php _e('Contracted', 'wp-asset-clean-up'); ?>
                            </label>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>

                <div class="wpacu-clearfix"></div>

                <p style="margin-top: 8px;"><?php _e('These are various ways in which the list of assets that you will manage will show up. Depending on your preference, you might want to see the list of styles &amp; scripts first, or all together sorted in alphabetical order etc.', 'wp-asset-clean-up'); ?> <?php _e('Options that are disabled are available in the Pro version.', 'wp-asset-clean-up'); ?></p>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">
                <label><?php _e('On Assets List Layout Load, keep the groups:', 'wp-asset-clean-up'); ?></label>
            </th>
            <td>
                <ul class="assets_list_layout_areas_status_choices">
                    <li>
                        <label for="assets_list_layout_areas_status_expanded">
                            <input id="assets_list_layout_areas_status_expanded"
							       <?php if (! $data['assets_list_layout_areas_status'] || $data['assets_list_layout_areas_status'] === 'expanded') { ?>checked="checked"<?php } ?>
                                   type="radio"
                                   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[assets_list_layout_areas_status]"
                                   value="expanded"> <?php _e('Expanded', 'wp-asset-clean-up'); ?> (<?php _e('Default', 'wp-asset-clean-up'); ?>)
                        </label>
                    </li>
                    <li>
                        <label for="assets_list_layout_areas_status_contracted">
                            <input id="assets_list_layout_areas_status_contracted"
							       <?php if ($data['assets_list_layout_areas_status'] === 'contracted') { ?>checked="checked"<?php } ?>
                                   type="radio"
                                   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[assets_list_layout_areas_status]"
                                   value="contracted"> <?php _e('Contracted', 'wp-asset-clean-up'); ?>
                        </label>
                    </li>
                </ul>
                <div class="wpacu-clearfix"></div>

                <p><?php _e('Sometimes, when you have plenty of elements in the edit page, you might want to contract the list of assets when you\'re viewing the page as it will save space. This can be a good practice, especially when you finished optimising the pages and you don\'t want to keep seeing the long list of files every time you edit a page.', 'wp-asset-clean-up'); ?></p>
                <p><strong><?php _e('Note', 'wp-asset-clean-up'); ?>:</strong> <?php _e('This does not include the assets rows within the groups which are expanded &amp; contracted individually, depending on your preference.', 'wp-asset-clean-up'); ?></p>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">
                <label><?php _e('On Assets List Layout Load, keep "Inline code associated with this handle" area', 'wp-asset-clean-up'); ?>:</label>
            </th>
            <td>
                <ul class="assets_list_inline_code_status_choices">
                    <li>
                        <label for="assets_list_inline_code_status_contracted">
                            <input id="assets_list_inline_code_status_contracted"
			                       <?php if ($data['assets_list_inline_code_status'] === 'contracted') { ?>checked="checked"<?php } ?>
                                   type="radio"
                                   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[assets_list_inline_code_status]"
                                   value="contracted"> <?php _e('Contracted', 'wp-asset-clean-up'); ?> (<?php _e('Default', 'wp-asset-clean-up'); ?>)
                        </label>
                    </li>
                    <li>
                        <label for="assets_list_inline_code_status_expanded">
                            <input id="assets_list_inline_code_status_expanded"
							       <?php if (! $data['assets_list_inline_code_status'] || $data['assets_list_inline_code_status'] === 'expanded') { ?>checked="checked"<?php } ?>
                                   type="radio"
                                   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[assets_list_inline_code_status]"
                                   value="expanded"> <?php _e('Expanded', 'wp-asset-clean-up'); ?>
                        </label>
                    </li>
                </ul>
                <div class="wpacu-clearfix"></div>

                <p><?php echo sprintf(
                        __('Some assets (CSS &amp; JavaScript) have inline code associate with them and often, they are quite large, making the asset row bigger and requiring you to scroll more until you reach a specific area. By setting it to "%s", it will hide all the inline code by default and you can view it by clicking on the toggle link inside the asset row.', 'wp-asset-clean-up'),
                        __('Contracted', 'wp-asset-clean-up')
                    ); ?></p>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="setting_title">
                <label><?php _e('Input Fields Style', 'wp-asset-clean-up'); ?>:</label>
                <p class="wpacu_subtitle"><small><em><?php _e('How would you like to view the checkboxes / selectors?', 'wp-asset-clean-up'); ?></em></small></p>
                <p class="wpacu_read_more"><a href="https://assetcleanup.com/docs/?p=95" target="_blank"><?php _e('Read More', 'wp-asset-clean-up'); ?></a></p>
            </th>
            <td>
                <ul class="input_style_choices">
                    <li>
                        <label for="input_style_enhanced">
                            <input id="input_style_enhanced"
							       <?php if (! $data['input_style'] || $data['input_style'] === 'enhanced') { ?>checked="checked"<?php } ?>
                                   type="radio"
                                   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[input_style]"
                                   value="enhanced"> <?php _e('Enhanced iPhone Style (Default)', 'wp-asset-clean-up'); ?>
                        </label>
                    </li>
                    <li>
                        <label for="input_style_standard">
                            <input id="input_style_standard"
							       <?php if ($data['input_style'] === 'standard') { ?>checked="checked"<?php } ?>
                                   type="radio"
                                   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[input_style]"
                                   value="standard"> <?php _e('Standard', 'wp-asset-clean-up'); ?>
                        </label>
                    </li>
                </ul>
                <div class="wpacu-clearfix"></div>

                <p><?php _e('In case you prefer standard HTML checkboxes instead of the enhanced CSS3 iPhone style ones (on &amp; off) or you need a simple HTML layout in case you\'re using a screen reader software (e.g. for people with disabilities) which requires standard/clean HTML code, then you can choose "Standard" as an option.', 'wp-asset-clean-up'); ?> <span style="color: #004567;" class="dashicons dashicons-info"></span> <a href="https://assetcleanup.com/docs/?p=95" target="_blank">Read more</a></p>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row" class="setting_title">
                <label><?php echo sprintf(__('Hide %s menus', 'wp-asset-clean-up'), '"'.WPACU_PLUGIN_TITLE.'"'); ?></label>
                <p class="wpacu_subtitle"><small><em><?php _e('Are you rarely using the plugin and want to make some space in the admin menus?', 'wp-asset-clean-up'); ?></em></small></p>
            </th>
            <td>
                <ul style="padding: 0;">
                    <li style="margin-bottom: 14px;">
                        <label for="wpacu_hide_from_admin_bar">
                            <input id="wpacu_hide_from_admin_bar"
                                   type="checkbox"
							    <?php echo (($data['hide_from_admin_bar'] == 1) ? 'checked="checked"' : ''); ?>
                                   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[hide_from_admin_bar]"
                                   value="1" /> <span class="wpacu_slider wpacu_round"></span>
                            <span>Скрыть его из верхней панели администратора</span> / Это может быть полезно, если ваша верхняя панель администратора заполнена слишком большим количеством элементов, и вы редко используете плагин.</label> <span style="color: #004567;" class="dashicons dashicons-info"></span> <a href="https://assetcleanup.com/docs/?p=187" target="_blank">Read more</a>
                    </li>
                    <li>
                        <label for="wpacu_hide_from_side_bar">
                            <input id="wpacu_hide_from_side_bar"
                                   type="checkbox"
							    <?php echo (($data['hide_from_side_bar'] == 1) ? 'checked="checked"' : ''); ?>
                                   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[hide_from_side_bar]"
                                   value="1" /> <span class="wpacu_slider wpacu_round"></span>
                            <span>Скройте его с левой боковой панели в панели управления</span> / Доступ будет только из <em>"Настройки" -&gt; "<?php echo WPACU_PLUGIN_TITLE; ?>"</em>.</label> <span style="color: #004567;" class="dashicons dashicons-info"></span> <a href="https://assetcleanup.com/docs/?p=584" target="_blank">Read more</a>
                    </li>
                </ul>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">
                <label for="wpacu_hide_core_files"><?php _e('Hide WordPress Core Files From The Assets List?', 'wp-asset-clean-up'); ?></label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_hide_core_files"
                           type="checkbox"
						<?php echo (($data['hide_core_files'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[hide_core_files]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                <?php echo sprintf(__('WordPress Core Files have handles such as %s', 'wp-asset-clean-up'), "'jquery', 'wp-embed', 'comment-reply', 'dashicons'"); ?> etc.
                <p style="margin-top: 10px;"><?php _e('They should only be unloaded by experienced developers when they are convinced that are not needed in particular situations. It\'s better to leave them loaded if you have any doubts whether you need them or not. By hiding them in the assets management list, you will see a smaller assets list (easier to manage) and you will avoid updating by mistake any option (unload, async, defer) related to any core file.', 'wp-asset-clean-up'); ?></p>
            </td>
        </tr>
        <tr valign="top" id="wpacu-settings-allow-usage-tracking">
            <th scope="row">
                <label for="wpacu_allow_usage_tracking"><?php _e('Allow Usage Tracking', 'wp-asset-clean-up'); ?></label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_allow_usage_tracking"
                           type="checkbox"
					    <?php echo (($data['allow_usage_tracking'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[allow_usage_tracking]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                Разрешать <?php echo WPACU_PLUGIN_TITLE; ?> анонимно отслеживать использование плагина, чтобы помочь нам сделать плагин лучше? Никакие конфиденциальные или личные данные не собираются. <span style="color: #004567;" class="dashicons dashicons-info"></span> <a id="wpacu-show-tracked-data-list-modal-target" href="#wpacu-show-tracked-data-list-modal">What kind of data will be sent for the tracking?</a>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">
                <label for="wpacu_fetch_cached_files_details_from"><?php _e('Fetch assets\' caching information from:', 'wp-asset-clean-up'); ?></label>
            </th>
            <td>
                <select id="wpacu_fetch_cached_files_details_from"
                        name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[fetch_cached_files_details_from]">
                    <option <?php if ($data['fetch_cached_files_details_from'] === 'disk') { ?>selected="selected"<?php } ?> value="disk">Disk (default)</option>
                    <option <?php if ($data['fetch_cached_files_details_from'] === 'db') { ?>selected="selected"<?php } ?> value="db">Database</option>
                    <option <?php if ($data['fetch_cached_files_details_from'] === 'db_disk') { ?>selected="selected"<?php } ?> value="db_disk">Database &amp; Disk (50% / 50%)</option>
                </select> &nbsp; <span style="color: #004567; vertical-align: middle;" class="dashicons dashicons-info"></span> <a style="vertical-align: middle;" id="wpacu-fetch-assets-details-location-modal-target" href="#wpacu-fetch-assets-details-location-modal">Читать далее</a>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">
                <label for="wpacu_clear_cached_files_after"><?php _e('Clear previously cached CSS/JS files older than (x) days', 'wp-asset-clean-up'); ?></label>
            </th>
            <td>
                    <input id="wpacu_clear_cached_files_after"
                           type="number"
                           min="0"
                           style="width: 60px; margin-bottom: 10px;"
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[clear_cached_files_after]"
                           value="<?php echo esc_attr($data['clear_cached_files_after']); ?>" /> дни <small>(установка значения 0 приведет к удалению всех ранее кэшированных файлов CSS/JS.).</small>
                <br />Это имеет значение в случае, если в содержимое файлов CSS/JS вносятся изменения посредством минимизации, комбинирования или любых других настроек, которые потребуют обновления содержимого файла (например, применить «font-display» к @font-face в таблицах стилей). Когда кеширование очищается, ранее кэшированные файлы CSS/JS, хранящиеся в <code><?php echo \WpAssetCleanUp\OptimiseAssets\OptimizeCommon::getRelPathPluginCacheDir(); ?></code> которые старше (X) дней, будут удалены, так как они устарели и, вероятно, больше не упоминаются в каком-либо исходном коде (например, старые кэшированные страницы, кэшированная версия Google Search и т. д.).). <span style="color: #004567;" class="dashicons dashicons-info"></span> <a href="https://assetcleanup.com/docs/?p=237" target="_blank">Читать далее</a>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">
                <label for="wpacu_frontend"><?php _e('Do not load the plugin on certain pages', 'wp-asset-clean-up'); ?></label>
            </th>
            <td>
                &nbsp;Если вы хотите предотвратить запуск Asset CleanUp Pro на определенных страницах (кроме информационной панели) или группе страниц по какой-либо причине (например, несовместимость с другим плагином), вы можете указать некоторые шаблоны URI в следующей текстовой области (по одному на строку), просто как в примерах, показанных ниже:
                <div style="margin: 8px 0 5px;">
                <textarea id="wpacu_do_not_load_plugin_patterns"
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[do_not_load_plugin_patterns]"
                           rows="4"
                           style="width: 100%;"><?php echo esc_textarea($data['do_not_load_plugin_patterns']); ?></textarea>
                </div>
                <div>
                    <p>Вы можете использовать определенные строки или шаблоны (разделитель # будет автоматически применен к<code>preg_match()</code> Функция PHP, которая проверяла бы соответствие запрошенного URI). Пожалуйста, не указывайте доменное имя. Вот несколько примеров:</p>
                    <ul>
                        <li><code>/checkout/</code> - если он содержит строку</li>
                        <li><code>/product/(.*?)/</code> - любая страница продукта (скорее всего, из WooCommerce)</li>
                    </ul>
                </div>
            </td>
        </tr>
    </table>
</div>

<style <?php echo Misc::getStyleTypeAttribute(); ?>>
    #wpacu-show-tracked-data-list-modal {
        margin: 14px 0 0;
    }

    #wpacu-show-tracked-data-list-modal .table-striped {
        border: none;
        border-spacing: 0;
    }

    #wpacu-show-tracked-data-list-modal .table-striped tbody tr:nth-of-type(even) {
        background-color: rgba(0, 143, 156, 0.05);
    }

    #wpacu-show-tracked-data-list-modal .table-striped tbody tr td:first-child {
        font-weight: bold;
    }
</style>

<div id="wpacu-show-tracked-data-list-modal" class="wpacu-modal" style="padding-top: 100px;">
    <div class="wpacu-modal-content" style="max-width: 800px;">
        <span class="wpacu-close">&times;</span>
        <p>Следующая информация будет отправлена ​​нам, и было бы полезно сделать плагин лучше.</p>
        <p>например увидеть, какие темы и плагины используются чаще всего, и сделать плагин максимально совместимым с ними, просмотреть наиболее часто используемые настройки плагина, определить наиболее используемые языки после английского, что полезно для определения приоритетов переводов и т. д.</p>
        <?php
        $pluginTrackingClass = new \WpAssetCleanUp\PluginTracking();
        $pluginTrackingClass->setupData();
        $pluginTrackingClass::showSentInfoDataTable($pluginTrackingClass->data);
        ?>
    </div>
</div>

<div id="wpacu-fetch-assets-details-location-modal" class="wpacu-modal" style="padding-top: 100px;">
    <div class="wpacu-modal-content" style="max-width: 800px;">
        <span class="wpacu-close">&times;</span>
        <p>Любые оптимизированные файлы (например, с помощью минимизации, объединения) имеют информацию о кэшировании (такую ​​как исходное местоположение, новое оптимизированное местоположение, версия), которая по умолчанию хранится на диске (в большинстве случаев это наиболее эффективный вариант), чтобы избежать дополнительных подключений к базе данных. для информации о нескольких файлах.</p>
        <p>Однако, если у вас уже есть небольшая база данных и множество ресурсов Apache/NGINX, уже используемых вашей темой/другими плагинами, вы можете сбалансировать использование <?php echo WPACU_PLUGIN_TITLE; ?> и перейдите к опции «База данных и диск (50% / 50%)» (пример: если, например, на странице есть 19 файлов CSS/JS, которые оптимизированы и кэшированы, 10 будут иметь их кеширующая информация извлекается из базы данных, а 9 с диска).</p>

        <p>Содержимое сохраняется, как в следующем примере:</p>
        <p><code>{"source_uri":"\/wp-content\/plugins\/plugin-title-here\/assets\/style.css","optimize_uri":"\/wp-content\/uploads\/asset-cleanup\/css\/item\/handle-title-here-v10-8683e3d8975dab70c7f368d58203e66e70fb3e06.css","ver":10}</code></p>

        <p>Как только эта информация будет получена, исходный URL-адрес файла будет обновлен, чтобы соответствовать оптимизированному URL-адресу для содержимого файла, хранящегося в <code><?php echo \WpAssetCleanUp\OptimiseAssets\OptimizeCommon::getRelPathPluginCacheDir(); ?></code>.</p>

        <p><strong>Примечание.</strong> Если вы используете плагин, такой как WP Rocket, WP Fastest Cache, или систему кэширования, предоставляемую вашей хостинговой компанией, то этот процесс выборки будет значительно сокращен, поскольку посетители будут получать доступ к статическим HTML-страницам, считанным из кэша. Технически не следует делать никаких SQL-запросов, поскольку среда WordPress не будет загружена, как это происходит с некешированной страницей (например, когда вы вошли в систему и получаете доступ к внешним страницам).).</p>
    </div>
</div>