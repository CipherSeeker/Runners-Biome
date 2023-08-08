<?php
/*
 * No direct access to this file
 */
if (! isset($data, $selectedTabArea)) {
	exit;
}

$tabIdArea = 'wpacu-setting-html-source-cleanup';
$styleTabContent = ($selectedTabArea === $tabIdArea) ? 'style="display: table-cell;"' : '';
?>
<div id="<?php echo esc_attr($tabIdArea); ?>" class="wpacu-settings-tab-content" <?php echo wp_kses($styleTabContent, array('style' => array())); ?>>
    <h2 class="wpacu-settings-area-title"><?php _e('Remove unused elements from the &lthead&gt; section', 'wp-asset-clean-up'); ?></h2>

    <p>Есть элементы, которые включены по умолчанию во многих средах WordPress, но включать их не обязательно. Очистите ненужный код между <code>&lt;head&gt;</code> and <code>&lt;/head&gt;</code>.</p>
    <table class="wpacu-form-table">
        <!-- Remove "Really Simple Discovery (RSD)" link? -->
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_remove_rsd_link">Удалить тег ссылки «Really Simple Discovery (RSD)»?</label>
            </th>
            <td>
	            <?php
	            $opacityStyle = '';

                if ($data['disable_xmlrpc'] === 'disable_all') {
                    $opacityStyle = 'opacity: 0.4;';
                }
                ?>
                <label class="wpacu_switch" style="<?php echo $opacityStyle; ?>">
                    <input id="wpacu_remove_rsd_link" type="checkbox"
						<?php echo (($data['remove_rsd_link'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[remove_rsd_link]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                <code style="<?php echo $opacityStyle; ?>">&lt;link rel=&quot;EditURI&quot; type=&quot;application/rsd xml&quot; title=&quot;RSD&quot; href=&quot;http://yourwebsite.com/xmlrpc.php?rsd&quot; /&gt;</code>
                <p style="margin-top: 10px; <?php echo $opacityStyle; ?>">Клиенты XML-RPC используют этот метод обнаружения. Если вы не знаете, что это такое, и не используете сервисные интеграции, такие как <a href="http://www.flickr.com/services/api/request.xmlrpc.html">Flickr</a> на своем веб-сайте WordPress вы можете удалить его.</p>
                <?php if ($data['disable_xmlrpc'] === 'disable_all') { ?>
                    <p style="margin-top: 10px; color: #cc0000;"><strong>Примечание.</strong> Поскольку вы уже решили полностью отключить "<a data-wpacu-vertical-link-target="wpacu-setting-disable-xml-rpc" href="#wpacu-setting-disable-xml-rpc">Disable XML-RPC</a>", тег ссылки «Really Simple Discovery (RSD)» уже удален.</p>
                <?php } ?>
            </td>
        </tr>

        <!-- Remove "Windows Live Writer" link? -->
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_remove_wlw_link">Удалить тег ссылки «Windows Live Writer»?</label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_remove_wlw_link" type="checkbox"
						<?php echo (($data['remove_wlw_link'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[remove_wlw_link]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                <code>&lt;link rel=&quot;wlwmanifest&quot; type=&quot;application/wlwmanifest xml&quot; href=&quot;https://yourwebsite.com/wp-includes/wlwmanifest.xml&quot; /&gt;</code>
                <p style="margin-top: 10px;">Если вы не используете Windows Live Writer для редактирования содержимого блога, удалить его безопасно.</p>
            </td>
        </tr>

        <!-- Remove "REST API" link? -->
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_remove_rest_api_link">Удалить тег ссылки "REST API"?</label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_remove_rest_api_link" type="checkbox"
						<?php echo (($data['remove_rest_api_link'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[remove_rest_api_link]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                <code>&lt;link rel=&#39;https://api.w.org/&#39; href=&#39;https://yourwebsite.com/wp-json/&#39; /&gt;</code>
                <p style="margin-top: 10px;">Получаете ли вы доступ к своему контенту через конечные точки (например, https://yourwebsite.com/wp-json/, https://yourwebsite.com/wp-json/wp/v2/posts/1 - <em>1</em> в этом примере это POST ID)? Если нет, вы можете удалить это.</p>
            </td>
        </tr>

        <!-- Remove "Shortlink"? -->
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_remove_shortlink">Удалить тег «Короткая ссылка» для страниц/сообщений?</label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_remove_shortlink" type="checkbox"
						<?php echo (($data['remove_shortlink'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[remove_shortlink]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                <code>&lt;link rel=&#39;shortlink&#39; href=&quot;https://yourdomain.com/?p=1&quot;&gt;</code>
                <p style="margin-top: 10px;">Используете ли вы SEO-дружественные URL-адреса и вам не нужна короткая ссылка WordPress по умолчанию? Вы можете просто удалить его, так как он занимает главную часть вашего сайта.</p>
            </td>
        </tr>

        <!-- Remove "Post's Relational Links" tag? -->
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_remove_posts_rel_links">Удалить тег "Реляционные ссылки публикации"?</label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_remove_posts_rel_links" type="checkbox"
						<?php echo (($data['remove_posts_rel_links'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[remove_posts_rel_links]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                <code>&lt;link rel=&#39;prev&#39; title=&#39;Post title&#39; href=&#39;https://yourdomain.com/prev-post-slug-here/&#39; /&gt;</code> <strong>&amp;</strong> <code>&lt;link rel=&#39;next&#39; title=&#39;Заголовок поста&#39; href=&#39;https://yourdomain.com/next-post-slug-here/&#39; /&gt;</code>
                <p style="margin-top: 10px;">Это удаляет реляционные ссылки для сообщений, смежных с текущим сообщением, для отдельных страниц сообщений.</p>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">&nbsp;</th>
            <td>
                <div class="wpacu-notice wpacu-warning" style="font-size: inherit; margin-top: 0 !important; line-height: 1.4rem;">
                    <span class="dashicons dashicons-warning" style="font-size: 22px; color: #ff9800 !important;"></span>
                    Параметр отключения RSS-каналов был перемещен в отдельную область в"<a data-wpacu-vertical-link-target="wpacu-setting-disable-rss-feed" href="#wpacu-setting-disable-rss-feed">Отключить RSS-канал</a>" (вертикальное меню), начиная с версии 1.2.1.2.
                </div>
            </td>
        </tr>

        <!-- Remove "WordPress version" meta tag? -->
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_remove_wp_version">Удалить метатег «Версия WordPress»?</label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_remove_wp_version" type="checkbox"
						<?php echo (($data['remove_wp_version'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[remove_wp_version]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                <code>&lt;meta name=&quot;generator&quot; content=&quot;WordPress 4.9.8&quot; /&gt;</code>
                <p style="margin-top: 10px;">Это хорошо и в целях безопасности, так как скрывает используемую вами версию WordPress (в случае попыток взлома).</p>
            </td>
        </tr>

        <!-- Remove "WordPress version" meta tag and all other tags? -->
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_remove_generator_tag">Удалить все метатеги "генератор"?</label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_remove_generator_tag"
                           type="checkbox"
						<?php echo (($data['remove_generator_tag'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[remove_generator_tag]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                <code>e.g. &lt;meta name=&quot;generator&quot; content=&quot;Easy Digital Downloads v2.9.8&quot; /&gt;</code>
                <p style="margin-top: 10px;">Это приведет к удалению всех метатегов с именем «генератор», включая метатег «версия WordPress». Вы можете использовать плагин или тему, которая добавила уведомление о генераторе, но вам не обязательно иметь его там. Кроме того, он скроет используемую вами версию подключаемых модулей и темы, что хорошо по соображениям безопасности.</p>
            </td>
        </tr>
    </table>

    <hr />

    <h2><?php _e('Remove extra elements from the generated page source', 'wp-asset-clean-up'); ?></h2>

    <table class="wpacu-form-table">
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_remove_html_comments">Удалить HTML-комментарии?</label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_remove_html_comments"
                           data-target-opacity="wpacu_remove_html_comments_area"
                           type="checkbox"
			            <?php echo (($data['remove_html_comments'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[remove_html_comments]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>

                &nbsp;Эта функция удалит все комментарии, кроме условных комментариев Internet Explorer. Если вы хотите оставить определенные комментарии, используйте текстовое поле ниже, чтобы добавить шаблоны исключений (по одному на строку).

	            <?php
	            $removeHtmlCommentsAreaStyle = ($data['remove_html_comments'] == 1) ? 'opacity: 1;' : 'opacity: 0.4;';
	            ?>
                <div id="wpacu_remove_html_comments_area" style="<?php echo esc_attr($removeHtmlCommentsAreaStyle); ?>">
                    <div style="margin: 14px 0 8px;"><label for="wpacu_remove_html_comments_exceptions">Не удаляйте комментарии, содержащие следующий текст (без учета регистра):</label></div>
                    <textarea id="wpacu_remove_html_comments_exceptions"
                              name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[remove_html_comments_exceptions]"
                              rows="4"
                              style="width: 100%;"><?php echo esc_textarea($data['remove_html_comments_exceptions']); ?></textarea>
                    <div class="wpacu-notice wpacu-warning" style="font-size: inherit; line-height: 1.4rem;">
                        <span class="dashicons dashicons-warning" style="font-size: 22px; color: #ff9800 !important;"></span>
                       Есть комментарии, которые не могут быть удалены из окончательного исходного HTML-кода, и это связано с тем, что источник обновляется вне среды WordPress или с помощью кеширующих плагинов, которые добавляют свои собственные подписи перед рендерингом кэшированных страниц.<a target="_blank" href="https://assetcleanup.com/docs/?p=116">Read more</a> about how you can strip those comments too!
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
