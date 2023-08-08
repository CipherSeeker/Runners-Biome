<?php
/*
 * No direct access to this file
 */
use WpAssetCleanUp\Misc;
use WpAssetCleanUp\OptimiseAssets\OptimizeCommon;
use WpAssetCleanUp\OptimiseAssets\OptimizeCss;

if (! isset($data, $selectedTabArea)) {
    exit;
}

global $wp_version;

$tabIdArea = 'wpacu-setting-optimize-css';
$styleTabContent = ($selectedTabArea === $tabIdArea) ? 'style="display: table-cell;"' : '';
?>
<div id="<?php echo esc_attr($tabIdArea); ?>" class="wpacu-settings-tab-content" <?php echo wp_kses($styleTabContent, array('style' => array())); ?>>
    <h2 class="wpacu-settings-area-title"><?php _e('Minify / Combine loaded CSS files to reduce total page size and the number of HTTP requests', 'wp-asset-clean-up'); ?></h2>
	<?php
    $wpRocketIssues = array();

	if (($wpRocketIssues['minify_html'] = Misc::isWpRocketMinifyHtmlEnabled())
        || ($wpRocketIssues['optimize_css_delivery'] = OptimizeCss::isWpRocketOptimizeCssDeliveryEnabled())) {
		?>
        <div class="wpacu-warning" style="font-size: 13px; margin-bottom: 18px; border: 1px solid #cc000059;">
            <span class="dashicons dashicons-warning" style="color: #cc0000;"></span> <strong>Уведомление о несовместимости:</strong>
            <?php if (isset($wpRocketIssues['minify_html']) && $wpRocketIssues['minify_html']) { ?>
                <p style="margin-bottom: 0;">На данный момент, "<strong>Объедините загруженные CSS (таблицы стилей) в меньшее количество файлов</strong>" &amp; "<strong>Параметры «Отложить CSS, загруженные в <BODY> (нижний колонтитул)</strong>» не действуют, так как параметр «<em>Минифицировать HTML</em>» активен в настройках «WP Rocket» -> «Оптимизация файлов». Если вы хотите сохранить Minify HTML в WP Rocket, рассмотрите возможность оптимизации CSS с помощью WP Rocket, одновременно очищая бесполезный CSS с помощью <?php echo WPACU_PLUGIN_TITLE; ?>.</p>
            <?php } ?>
	        <?php if (isset($wpRocketIssues['optimize_css_delivery']) && $wpRocketIssues['optimize_css_delivery']) { ?>
                <p style="margin-bottom: 0;"><?php echo WPACU_PLUGIN_TITLE; ?>'s "<strong>Объединить загруженные CSS (таблицы стилей) в меньшее количество файлов</strong>» и «<strong>Отложить загрузку CSS в <BODY> (нижний колонтитул)</strong>» не имеют никакого эффекта, так как «<em>Оптимизировать доставку CSS< /em>» активен в настройках «WP Rocket» -> «Оптимизация файлов». Эта функция изменяет способ доставки CSS, добавляя критический CSS в раздел HEAD веб-сайта, а также предварительно загружая остальные файлы CSS перед применяя их синтаксис при загрузке страницы. Это не влияет на производительность вашего веб-сайта, поскольку вы можете устранить раздувание с помощью <?php echo WPACU_PLUGIN_TITLE; ?> и использовать WP Rocket для оптимизации/доставки CSS, если это лучше всего подходит для вашего веб-сайта.</p>
	        <?php } ?>
        </div>
    <?php
	}
	?>
    <table class="wpacu-form-table">
        <?php
        $minifyCssDisabled = ! empty($data['is_optimize_css_enabled_by_other_party']);
        ?>
        <tr valign="top">
            <th scope="row" class="setting_title">
                <label for="wpacu_minify_css_enable"><?php _e('CSS Files Minification', 'wp-asset-clean-up'); ?></label>
                <p class="wpacu_subtitle"><small><em><?php _e('Helps decrease the total page size even further', 'wp-asset-clean-up'); ?></em></small></p>
            </th>
            <td>
                <label class="wpacu_switch <?php if (! empty($data['is_optimize_css_enabled_by_other_party'])) { echo 'wpacu_disabled'; } ?>">
                    <input id="wpacu_minify_css_enable"
                           data-target-opacity="wpacu_minify_css_area"
                           type="checkbox"
                           <?php
                           if ($minifyCssDisabled) {
                               echo 'disabled="disabled"';
                           } else {
	                           echo ($data['minify_loaded_css'] == 1) ? 'checked="checked"' : '';
                           }
                           ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[minify_loaded_css]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>

                &nbsp;<?php _e('This will take the remaining enqueued CSS files, minify them and load them from the cache.', 'wp-asset-clean-up'); ?>
	             <?php _e('You might want to minify the local files, the inline CSS code within STYLE tags or both.', 'wp-asset-clean-up'); ?>

                <?php
                if (! empty($data['is_optimize_css_enabled_by_other_party'])) {
                    ?>
                    <div style="border-left: 4px solid green; background: #f2faf2; padding: 10px; margin-top: 10px;">
                        <ul style="margin: 0;">
                            <li>Этот параметр заблокирован, так как оптимизация/минимизация таблиц стилей (CSS) уже включена в следующих плагинах: <strong><?php echo implode(', ', $data['is_optimize_css_enabled_by_other_party']); ?></strong>. <?php echo WPACU_PLUGIN_TITLE; ?> works together with the mentioned plugin(s).</li>
                            <li>Сначала устраните раздувание через <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_assets_manager')); ?>">CSS & JAVASCRIPT LOAD MANAGER</a>, а затем уменьшите оставшийся CSS с помощью любого подключаемого модуля.</li>
                        </ul>
                    </div>
                    <?php
                }

				$minifyCssExceptionsAreaStyle = empty($data['is_optimize_css_enabled_by_other_party']) && ($data['minify_loaded_css'] == 1) ? 'opacity: 1;' : 'opacity: 0.4;';
                ?>
                <div id="wpacu_minify_css_area" style="<?php echo esc_attr($minifyCssExceptionsAreaStyle); ?>">
							

                    <div style="margin-top: 8px; padding: 12px; background: #f2faf2; border-radius: 10px;">
                        <ul style="margin: 0;">
                            <li style="float: left; margin-right: 30px; margin-bottom: 0; line-height: 32px;" class="wpacu-fancy-radio">
                                <label for="minify_loaded_css_for_link_href_radio">
                                    <input id="minify_loaded_css_for_link_href_radio"
                                           style="margin: -1px 0 0;"
                                            <?php
                                            echo in_array($data['minify_loaded_css_for'], array('href', '')) ? 'checked="checked"' : '';
                                            ?>
                                           type="radio"
                                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[minify_loaded_css_for]"
                                           value="href" />
                                    &nbsp;<?php _e('LINK tags with "href" attribute', 'wp-asset-clean-up'); ?> (<?php _e('default', 'wp-asset-clean-up'); ?>)
                                </label>
                            </li>
                            <li style="float: left; margin-right: 30px; margin-bottom: 0; line-height: 32px;" class="wpacu-fancy-radio">
                                <label for="minify_loaded_css_for_style_inline_radio">
                                    <input id="minify_loaded_css_for_style_inline_radio"
                                           style="margin: -1px 0 0;"
						                <?php echo (($data['minify_loaded_css_for'] === 'inline') ? 'checked="checked"' : ''); ?>
                                           type="radio"
                                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[minify_loaded_css_for]"
                                           value="inline" />
                                    &nbsp;<?php _e('STYLE tags with inline CSS code ', 'wp-asset-clean-up'); ?>
                                </label>
                            </li>
                            <li style="float: left; margin-bottom: 0; line-height: 32px;" class="wpacu-fancy-radio">
                                <label for="minify_loaded_css_for_link_style_all_radio">
                                    <input id="minify_loaded_css_for_link_style_all_radio"
                                           style="margin: -1px 0 0;"
						                <?php echo (($data['minify_loaded_css_for'] === 'all') ? 'checked="checked"' : ''); ?>
                                           type="radio"
                                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[minify_loaded_css_for]"
                                           value="all" />
                                    &nbsp;<?php _e('All LINK &amp; STYLE tags', 'wp-asset-clean-up'); ?> * <small>both options</small>
                                </label>
                            </li>
                        </ul>
                        <div style="clear: both;"></div>
                    </div>

                    <div id="wpacu_minify_css_exceptions_area">
                        <div style="margin: 0 0 6px;"><?php _e('Do not minify the CSS files matching the patterns below (one per line)', 'wp-asset-clean-up'); ?>:</div>
                        <label for="wpacu_minify_css_exceptions">
                                        <textarea style="width: 100%;"
                                                  rows="4"
                                                  id="wpacu_minify_css_exceptions"
                                                  name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[minify_loaded_css_exceptions]"><?php echo esc_textarea($data['minify_loaded_css_exceptions']); ?></textarea>
                        </label>
                    </div>
                    <ul style="list-style: none; margin-left: 18px; margin-bottom: 0;">
                        <li style="margin-bottom: 18px;"><span style="color: #ffc107;" class="dashicons dashicons-lightbulb"></span> Кэшированные файлы таблиц стилей (.css) будут созданы заново после изменения версии файла (значение из <code>?ver=</code>). Кроме того, номер версии (значение) из источника будет добавлен к имени нового кэшированного файла .css (например, новое-имя-файла-здесь-вер-1.2.css).</li>
                        <li><span style="color: #ffc107;" class="dashicons dashicons-lightbulb"></span> <?php _e('For maximum performance and to reduce server resources, the following stylesheet files will not be minified since they are already optimised and minified by the WordPress core contributors &amp; developers', 'wp-asset-clean-up'); ?>:
                            <div style="margin: 15px 0 0 28px;">
                                <ul style="list-style: disc;">
                                    <li>Основные файлы CSS WordPress, которые заканчиваются на .min.css (например, <code>/wp-includes/css/dashicons.min.css</code>, <code>/wp-includes/css/admin-bar.min. css</code> и т. д.)</li>
                                    <li>CSS files from <code>/wp-content/uploads/elementor/</code> (если используется плагин конструктора Elementor) и <code>/wp-content/uploads/oxygen/</code> (if Oxygen builder plugin is used)</li>
                                    <li>Определенные файлы CSS из WooCommerce (например, расположенные в <code>/wp-content/plugins/woocommerce/assets/css/</code>) if the plugin is used, etc.</li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
			</td>
		</tr>

        <tr>
            <td colspan="2" style="padding: 0;">
                <div class="wpacu-combine-notice-default wpacu_hide" style="line-height: 22px; background: #f8f8f8; border-left: 4px solid #008f9c; padding: 10px; margin: 0 0 15px;">
                    <strong><?php _e('NOTE', 'wp-asset-clean-up'); ?>:</strong> <?php _e('Concatenating assets is no longer a recommended practice in HTTP/2', 'wp-asset-clean-up'); ?>. &nbsp; <a id="wpacu-http2-info-css-target" href="#wpacu-http2-info-css"><?php _e('Read more', 'wp-asset-clean-up'); ?></a> &nbsp;/&nbsp; <a class="wpacu_verify_http2_protocol" target="_blank" href="https://tools.keycdn.com/http2-test"><strong><?php _e('Verify if the website is delivered through the HTTP/2 network protocol', 'wp-asset-clean-up'); ?></strong></a>
                </div>
                <div class="wpacu-combine-notice-http-2-detected wpacu_hide" style="line-height: 22px; background: #f8f8f8; border-left: 4px solid #008f9c; padding: 10px; margin: 0 0 15px;">
                    <span class="wpacu_http2_protocol_is_supported" style="color: green; font-weight: 400;"><span class="dashicons dashicons-yes-alt"></span> Ваш сайт `<span style="font-weight: 500;"><?php echo get_site_url(); ?></span>` доставляется по сетевому протоколу HTTP/2, поэтому веб-сайт будет работать так же быстро без использования этой функции, которая время от времени может требовать обслуживания.</span> <a class="wpacu-http2-info-css-target" href="#wpacu-http2-info-css"><?php _e('Read more', 'wp-asset-clean-up'); ?></a>
                </div>
            </td>
        </tr>

			 
																					   
		  
        <tr valign="top">
            <th scope="row" class="setting_title">
                <label for="wpacu_combine_loaded_css_enable"><?php _e('Combine loaded CSS (Stylesheets) into fewer files', 'wp-asset-clean-up'); ?></label>
                <p class="wpacu_subtitle"><small><em><?php _e('Helps reducing the number of HTTP Requests even further', 'wp-asset-clean-up'); ?></em></small></p>
            </th>
            <td>
                <label class="wpacu_switch <?php if ($combineCssDisabled) { echo 'wpacu_disabled'; } ?>">
                    <input id="wpacu_combine_loaded_css_enable"
                           data-target-opacity="wpacu_combine_loaded_css_info_area"
                           type="checkbox"
                            <?php
                            if ($combineCssDisabled) {
                                echo 'disabled="disabled"';
                            } else {
                                echo in_array( $data['combine_loaded_css'], array( 'for_admin', 'for_all', 1 ) ) ? 'checked="checked"' : '';
                            }
                            ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[combine_loaded_css]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>

                &nbsp;<small>* если <code style="font-size: inherit;"><?php echo '/'.str_replace(Misc::getWpRootDirPath(), '', WP_CONTENT_DIR) . \WpAssetCleanUp\OptimiseAssets\OptimizeCommon::getRelPathPluginCacheDir(); ?></code> директория по какой-то причине недоступна для записи, эта функция не будет работать; требует, чтобы DOMDocument XML DOM Parser был включен в PHP (что по умолчанию) для максимальной производительности</small>
                &nbsp;
			    <?php
			    if (! empty($data['is_optimize_css_enabled_by_other_party'])) {
				    ?>
                    <div style="border-left: 4px solid green; background: #f2faf2; padding: 10px; margin-top: 10px;">
                        <ul style="margin: 0;">
                            <li>Этот параметр заблокирован, так как оптимизация/минимизация таблиц стилей (CSS) уже включена в следующих плагинах.: <strong><?php echo implode(', ', $data['is_optimize_css_enabled_by_other_party']); ?></strong></li>
                            <li><?php echo WPACU_PLUGIN_TITLE; ?> работает вместе с упомянутыми плагинами. Сначала устраните раздувание через <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_assets_manager')); ?>"> CSS & JAVASCRIPT LOAD MANAGER</a>, затем соедините (при необходимости) оставшийся CSS с любым подключаемым модулем, который вы предпочитаете.</li>
                        </ul>
                    </div>
				    <?php
			    }
			    ?>

                <div id="wpacu_combine_loaded_css_info_area" <?php if (empty($data['is_optimize_css_enabled_by_other_party']) && in_array($data['combine_loaded_css'], array('for_admin', 'for_all', 1))) { ?> style="opacity: 1;" <?php } else { ?>style="opacity: 0.4;"<?php } ?>>
                    <div style="margin-top: 8px; padding: 12px; background: #f2faf2; border-radius: 10px;">
                        <ul style="margin: 0;">
                            <li style="float: left; margin-right: 30px; margin-bottom: 0; line-height: 32px;" class="wpacu-fancy-radio">
                                <label for="combine_loaded_css_for_guests_radio">
                                    <input id="combine_loaded_css_for_guests_radio"
                                           style="margin: -1px 0 0;"
                                        <?php echo (in_array($data['combine_loaded_css_for'], array('guests', '')) ? 'checked="checked"' : ''); ?>
                                           type="radio"
                                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[combine_loaded_css_for]"
                                           value="guests" />
                                    &nbsp;<?php _e('Apply it only for guest visitors', 'wp-asset-clean-up'); ?> (<?php _e('default', 'wp-asset-clean-up'); ?>)
                                </label>
                            </li>
                            <li style="float: left; margin-bottom: 0; line-height: 32px;" class="wpacu-fancy-radio">
                                <label for="combine_loaded_css_for_all_radio">
                                    <input id="combine_loaded_css_for_all_radio"
                                           style="margin: -1px 0 0;"
                                        <?php echo (($data['combine_loaded_css_for'] === 'all') ? 'checked="checked"' : ''); ?>
                                           type="radio"
                                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[combine_loaded_css_for]"
                                           value="all" />
                                    &nbsp;<?php _e('Apply it for all visitors (not recommended)', 'wp-asset-clean-up'); ?> * <small>чтобы не использовать дополнительное место на диске</small>
                                </label>
                            </li>
                        </ul>
                        <div style="clear: both;"></div>
                    </div>

                    <p style="margin-top: 10px;"><strong>Примечание:</strong> Когда таблица стилей добавляется в объединенную группу файлов, любой другой встроенный контент (например, добавленный через <code style="font-size: inherit;">wp_add_inline_style()</code>) связанные с ним, также будут добавлены в объединенные файлы. Это уменьшает количество элементов DOM, а также гарантирует, что код CSS будет загружаться в правильном (установленном) порядке.</p>

                    <hr />

                    <div id="wpacu_combine_loaded_css_exceptions_area">
                        <div style="margin: 8px 0 6px;"><?php _e('Do not combine the CSS files matching the patterns below', 'wp-asset-clean-up'); ?> (<?php _e('one per line', 'wp-asset-clean-up'); ?>):</div>
                        <label for="combine_loaded_css_exceptions">
                                    <textarea style="width: 100%;"
                                              rows="4"
                                              id="combine_loaded_css_exceptions"
                                              name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[combine_loaded_css_exceptions]"><?php echo esc_textarea($data['combine_loaded_css_exceptions']); ?></textarea>
                        </label>

                        <p>Примеры шаблонов (не обязательно указывать полный URL, так как рекомендуется использовать относительные пути)):</p>
                        <code>/wp-includes/css/dashicons.min.css<br />/wp-includes/css/admin-bar.min.css<br />/wp-content/plugins/plugin-title/css/(.*?).css</code>
                    </div>

                    <p>Это сканирует оставшиеся файлы CSS (оставшиеся после очистки ненужных) из <code>&lt;head&gt;</code> и <code>&lt;body&gt;</code> местоположения и объединяет их в ~ 2 файла (по одному в каждом месте). Чтобы быть на 100% уверенным, что после активации все работает нормально, рассмотрите возможность включения этой функции только для вошедшего в систему администратора, чтобы только вы могли видеть обновленную страницу. Если все выглядит хорошо, вы можете позже снять флажок, чтобы применить эту функцию ко всем остальным.</p>

                    <hr />
                    <p style="margin: 8px 0 4px;"><span style="color: #ffc107;" class="dashicons dashicons-lightbulb"></span> Эта функция не будет работать, <strong>ЕСЛИ</strong>:</p>
                    <ul style="margin-top: 0; margin-left: 35px; list-style: disc;">
                        <li>«Тестовый режим» включен, эта функция не будет действовать для гостевых пользователей, и она применит изменения только для вас.</li>
                        <li>URL-адрес содержит строки запроса (например, такой URL-адрес, как //www.yourdomain.com/product/title-here/?param=1&amp;param_two=value_here)</li>
                    </ul>
                </div>
                <hr />
            </td>
        </tr>

        <tr valign="top">
            <th scope="row" class="setting_title">
                <label for="wpacu_inline_css_files_enable"><?php _e('Inline CSS Files', 'wp-asset-clean-up'); ?></label>
                <p class="wpacu_subtitle"><small><em><?php _e('This will work for local (same domain) files. External requests tags will not be altered (e.g. stackpath.bootstrapcdn.com, ajax.googleapis.com etc.).', 'wp-asset-clean-up'); ?></em></small></p>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_inline_css_files_enable"
                           data-target-opacity="wpacu_inline_css_files_info_area"
                           type="checkbox"
                           <?php
                           echo (($data['inline_css_files'] == 1) ? 'checked="checked"' : '');
                           ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[inline_css_files]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>

	            &nbsp;<?php _e('This is usually good for small stylesheet files to save the overhead of fetching them and thus reduce the number of HTTP requests', 'wp-asset-clean-up'); ?>. Вы можете выбрать автоматическое встраивание для файлов CSS меньше определенного размера (в КБ) или вручную указать относительные пути к файлам (например, если есть исключение для большего файла, который вы хотите встроить или просто не хотите использовать). автоматическое встраивание).

                <?php
                $inlineCssFiles = ($data['inline_css_files'] == 1) ? 'opacity: 1;' : 'opacity: 0.4;';
                ?>
                <div id="wpacu_inline_css_files_info_area" style="<?php echo esc_attr($inlineCssFiles); ?>">
                    <p style="margin-top: 8px; padding: 10px; background: #f2faf2;">
                        <label for="wpacu_inline_css_files_below_size_checkbox">
                            <input id="wpacu_inline_css_files_below_size_checkbox"
				                <?php echo ($data['inline_css_files_below_size'] == 1 ? 'checked="checked"' : ''); ?>
                                   type="checkbox"
                                   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[inline_css_files_below_size]"
                                   value="1" />
			                <?php echo sprintf(__('Inline Stylesheet (.css) Files Smaller Than %s KB', 'wp-asset-clean-up'), '<input type="number" min="1" style="width: 60px;" name="'.WPACU_PLUGIN_ID.'_settings[inline_css_files_below_size_input]" value="'.$data['inline_css_files_below_size_input'].'" />'); ?>
                        </label>
                    </p>

                    <div id="wpacu_inline_css_files_list_area">
                        <div style="margin: 12px 0 6px;"><?php _e('Alternatively or in addition to automatic inlining, you can place the relative path(s) or part of them to the files you wish to inline below:', 'wp-asset-clean-up'); ?> (<strong><?php _e('one per line', 'wp-asset-clean-up'); ?></strong>):</div>
                        <p style="margin-top: 8px;"><span class="dashicons dashicons-warning" style="color: #ffc107;"></span> <strong>Примечание.</strong> Пожалуйста, вводите исходники в исходные файлы CSS (по одному на строку), как в приведенных ниже примерах, а не в кешированные/оптимизированные файлы (которые обычно находятся в <em><?php echo str_replace(site_url(), '', WP_CONTENT_URL) . OptimizeCommon::getRelPathPluginCacheDir(); ?></em>). Регулярные выражения принимаются. Обратите внимание, что решетка (#) автоматически используется в качестве разделителя, поэтому вам не нужно добавлять ее ниже..</p>
                        <label for="wpacu_inline_css_files_list">
                                    <textarea style="width: 100%;"
                                              rows="4"
                                              id="wpacu_inline_css_files_list"
                                              name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[inline_css_files_list]"><?php echo esc_textarea($data['inline_css_files_list']); ?></textarea>
                        </label>
                        <p style="margin-bottom: 6px;"><strong>Примеры</strong> (вам не нужно добавлять полный URL-адрес, так как рекомендуется использовать относительные пути, особенно если вы используете среды разработки/постановки или меняете доменное имя своего веб-сайта):</p>
                        <code>/wp-content/plugins/plugin-title/styles/small-file.css<br />/wp-content/themes/my-wp-theme-dir/css/small.css</code>
                    </div>
                </div>
                <hr />
            </td>
        </tr>

        <!-- [wpacu_pro] -->
        <?php
        $wpRocketIsEnabledWithRemoveUnusedCss = (defined('WPACU_WP_ROCKET_REMOVE_UNUSED_CSS_ENABLED') && WPACU_WP_ROCKET_REMOVE_UNUSED_CSS_ENABLED);

        $movedOptionDisabledStatus = $wpRocketIsEnabledWithRemoveUnusedCss ? 'disabled="disabled"' : '';
        $allOptionDisabledStatus   = $wpRocketIsEnabledWithRemoveUnusedCss ? 'disabled="disabled"' : '';
        ?>
        <tr valign="top">
            <th scope="row" class="setting_title">
                <label style="cursor: auto;"><?php _e('Defer CSS Loaded in the <code>&lt;BODY&gt;</code> (Footer)', 'wp-asset-clean-up'); ?></label>
            </th>
            <td>
                <div>
                    <?php
                    if ($wpRocketIsEnabledWithRemoveUnusedCss) {
                        ?>
                        <div style="border-left: 4px solid green; background: #f2faf2; padding: 10px; margin: 10px 0;">
                            <ul style="margin: 0;">
                                <li>Эта опция заблокирована, чтобы предотвратить любое изменение тегов LINK, поскольку в WP Rocket включена следующая опция: <a target="_blank" href="<?php echo admin_url('options-general.php?page=wprocket#file_optimization'); ?>"><em>"FILE OPTIMIZATION" - "Optimize CSS delivery" - "REMOVE UNUSED CSS"</em></a>.</li>
                                <li>И WP Rocket, и <?php echo WPACU_PLUGIN_TITLE; ?> можно использовать вместе, если функции не смешиваются.</li>
                            </ul>
                        </div>
                        <?php
                    }
                    ?>
                    <ul style="margin: 0;">
                        <li style="margin-bottom: 13px;" class="wpacu-fancy-radio"><label for="wpacu_defer_css_loaded_body_moved"><input style="margin: 0;" id="wpacu_defer_css_loaded_body_moved" type="radio" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[defer_css_loaded_body]" <?php if (in_array($data['defer_css_loaded_body'], array('moved', ''))) { ?>checked="checked"<?php } ?> value="moved" /> &nbsp;Да, для любой таблицы стилей теги LINK перемещены из HEAD в BODY через <?php echo WPACU_PLUGIN_TITLE; ?> * <em>дефолт</em></label></li>
                        <li style="margin-bottom: 13px;" class="wpacu-fancy-radio"><label for="wpacu_defer_css_loaded_body_all"><input style="margin: 0;" id="wpacu_defer_css_loaded_body_all" type="radio" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[defer_css_loaded_body]" <?php if ($data['defer_css_loaded_body'] === 'all') { ?>checked="checked"<?php } ?> value="all" /> &nbsp;Да, для всех тегов LINK таблицы стилей, которые перемещены или уже загружены в BODY</label></li>
                        <li><label for="wpacu_defer_css_loaded_body_no" class="wpacu-fancy-radio"><input style="margin: 0;" id="wpacu_defer_css_loaded_body_no" type="radio" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[defer_css_loaded_body]" <?php if ($data['defer_css_loaded_body'] === 'no') { ?>checked="checked"<?php } ?> value="no" /> &nbsp;Нет, оставьте теги LINK таблицы стилей из BODY такими, какие они есть, без каких-либо изменений.</label></li>
                    </ul>
                </div>
                <div>
                    <p><strong>Примечание.</strong> По умолчанию любой CSS, с которого вы перемещаетесь, <code>&lt;HEAD&gt;</code> к <code>&lt;BODY&gt;</code> при изменении его положения (при управлении активами через "CSS & JAVASCRIPT LOAD MANAGER") откладывается. В большинстве случаев CSS, загруженный в BODY, не должен блокировать рендеринг и должен начать загружаться позже, после того, как HTML-документ будет полностью загружен и проанализирован. Например, это может быть стиль для модального окна, которое появляется позже после загрузки страницы, или слайдер контента, который находится внизу страницы и его не нужно загружать очень быстро, поскольку он не нужен в верхней части страницы. .</p>
                    <p class="wpacu-warning" style="font-size: inherit;">Это помогает улучшить показатель «Устранение ресурсов, блокирующих отрисовку» в PageSpeed ​​Insights, и браузер быстрее отрисовывает первое содержимое страницы (поскольку CSS не блокирует отрисовку), предлагая лучший пользовательский интерфейс.</p>
                </div>
            </td>
        </tr>

        <?php
        // [CRITICAL CSS]
        ?>
            <tr valign="top" id="wpacu-critical-css-status">
                <th scope="row" class="setting_title">
                    <label style="cursor: auto;"><?php _e('Critical CSS Status', 'wp-asset-clean-up'); ?></label>
                    <p class="wpacu_subtitle"><small><em><?php echo sprintf(__('This option is useful if you want to stop using the critical CSS functionality for any reason from %s', 'wp-asset-clean-up'), WPACU_PLUGIN_TITLE); ?></em></small></p>
                </th>
                <td>
                    <div>
                        <ul style="margin: 0 0 18px;">
                            <li style="margin-bottom: 13px;" class="wpacu-fancy-radio"><label for="wpacu_critical_css_loaded"><input style="margin: 0;" id="wpacu_critical_css_loaded" type="radio" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[critical_css_status]" <?php if (in_array($data['critical_css_status'], array('on', ''))) { ?>checked="checked"<?php } ?> value="on" /> &nbsp;Загрузите любой критический CSS, который включен из "CSS &amp; JS MANAGER" -&gt; "MANAGE CRITICAL CSS" и через "wpacu_critical_css" hook/filter</label></li>
                            <li class="wpacu-fancy-radio"><label for="wpacu_critical_css_disabled"><input style="margin: 0;" class="wpacu-disabled-status" id="wpacu_critical_css_disabled" type="radio" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[critical_css_status]" <?php if ($data['critical_css_status'] === 'off') { ?>checked="checked"<?php } ?> value="off" /> &nbsp;Не загружайте какие-либо критические CSS из «CSS & JS MANAGER» -> «MANAGE CRITICAL CSS» / Это сделает настройки на странице управления бездействующими и деактивирует хук/фильтр «wpacu_critical_css», эта опция полезна, когда вы хотите остановить используя любой критический CSS из<?php echo WPACU_PLUGIN_TITLE; ?> (например у вас это включено через другой плагин или через пользовательское кодирование в вашей теме)</label></li>
                        </ul>
                    </div>
                    <div>
                        <p class="wpacu-warning" style="font-size: inherit;">После реализации на страницах по вашему выбору больше не будет загрузки CSS, блокирующей рендеринг, что значительно улучшит оценку «Устранение ресурсов, блокирующих рендеринг» (оставив в отчете только файлы JavaScript, если таковые имеются). Все остальные CSS, за исключением критического CSS, будут отображаться после того, как показана складка выше (без блокировки рендеринга).</p>
                    </div>
                </td>
            </tr>
	    <?php
	    // [/CRITICAL CSS]
	    ?>

        <!-- [/wpacu_pro] -->

        <tr valign="top">
            <th scope="row" class="setting_title">
                <label for="wpacu_cache_dynamic_loaded_css_enable"><?php _e('Cache Dynamic Loaded CSS', 'wp-asset-clean-up'); ?></label>
                <p class="wpacu_subtitle"><small><span class="dashicons dashicons-warning"></span> <em><?php _e('Please do not enable this option unless you have non-static (dynamic) loaded CSS', 'wp-asset-clean-up'); ?>.</em></small></p>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_cache_dynamic_loaded_css_enable"
                           data-target-opacity="wpacu_cache_dynamic_loaded_css_info_area"
                           type="checkbox"
					    <?php
					    echo (($data['cache_dynamic_loaded_css'] == 1) ? 'checked="checked"' : '');
					    ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[cache_dynamic_loaded_css]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>

                &nbsp;<?php _e('Avoid loading the whole WP environment whenever a dynamic request is made such as <code>/?custom-css=value_here</code>, or <code>/wp-content/plugins/plugin-name-here/css/generate-style.php?ver=1</code>', 'wp-asset-clean-up'); ?>.
                <hr />
                <p>например <code>&lt;link type="text/css" href="//yourwebsite.com/wp-content/plugins/plugin-name-here/css/generate-style.php?ver=<?php echo esc_html($wp_version); ?>" /&gt;</code></p>
                <?php
                $cacheDynamicLoadedCssAreaStyle = ($data['cache_dynamic_loaded_css'] == 1) ? 'opacity: 1;' : 'opacity: 0.4;';
                ?>
                <div id="wpacu_cache_dynamic_loaded_css_info_area" style="<?php echo esc_attr($cacheDynamicLoadedCssAreaStyle); ?>">
                    <p>В некоторых плагинах и темах есть возможность создать свой собственный CSS/макет и сохранить его на панели инструментов. Вместо того, чтобы создавать статические файлы CSS из сохраненных настроек, сделанные вами изменения извлекаются из базы данных, а содержимое CSS создается «на лету», таким образом, используя больше ресурсов, загружая всю среду WP и создавая MySQL (или любой другой тип базы данных). если используется) запросы для печати содержимого CSS. <?php echo WPACU_PLUGIN_TITLE; ?> обнаруживает такие запросы и кэширует вывод для более быстрого поиска. Это очень важно, особенно если ваш сайт посещают много раз (представьте, что WordPress загружается несколько раз только от одного посетителя), и вы находитесь в общей среде с ограниченными ресурсами. Это также улучшит взаимодействие с пользователем за счет сокращения времени рендеринга страницы.</p>
                </div>
            </td>
        </tr>
	</table>
</div>

<div id="wpacu-http2-info-css" class="wpacu-modal" style="padding-top: 100px;">
    <div class="wpacu-modal-content" style="max-width: 800px;">
        <span class="wpacu-close">&times;</span>
        <h2 style="margin-top: 5px;"><?php _e('Combining CSS files in HTTP/2 protocol', 'wp-asset-clean-up'); ?></h2>
        <p><?php _e('While it\'s still a good idea to combine assets into fewer (or only one) files in HTTP/1 (since you are restricted to the number of open connections), doing the same in HTTP/2 is no longer a performance optimization due to the ability to transfer multiple small files simultaneously without much overhead.', 'wp-asset-clean-up'); ?></p>

        <hr />

        <p><?php _e('In HTTP/2 some of the issues that were addressed are', 'wp-asset-clean-up'); ?>:</p>
        <ul>

            <li><strong>Multiplexing</strong>: <?php _e('allows concurrent requests across a single TCP connection', 'wp-asset-clean-up'); ?></li>
            <li><strong>Server Push</strong>: <?php _e('whereby a server can push vital resources to the browser before being asked for them.', 'wp-asset-clean-up'); ?></li>
        </ul>

        <hr />

        <p><?php _e('Since HTTP requests are loaded concurrently in HTTP/2, it\'s better to only serve the files that your visitors need and don\'t worry much about concatenation.', 'wp-asset-clean-up'); ?></p>
        <p><?php _e('Note that page speed testing tools such as PageSpeed Insights, YSlow, Pingdom Tools or GTMetrix still recommend combining CSS/JS files because they haven\'t updated their recommendations based on HTTP/1 or HTTP/2 protocols so you should take into account the actual load time, not the performance grade.', 'wp-asset-clean-up'); ?></p>

        <hr />

        <p style="margin-bottom: 12px;"><?php _e('If you do decide to move on with the concatenation (which at least would improve the GTMetrix performance grade from a cosmetic point of view), please remember to <strong>test thoroughly</strong> the pages that have the assets combined (pay attention to any JavaScript errors in the browser\'s console which is accessed via right click &amp; "Inspect") as, in rare cases, due to the order in which the scripts were loaded and the way their code was written, it could break some functionality.', 'wp-asset-clean-up'); ?></p>
    </div>
</div>
