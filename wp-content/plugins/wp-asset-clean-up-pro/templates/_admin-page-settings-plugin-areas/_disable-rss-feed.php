<?php
/*
 * No direct access to this file
 */
if (! isset($data, $selectedTabArea)) {
	exit;
}

$tabIdArea = 'wpacu-setting-disable-rss-feed';
$styleTabContent = ($selectedTabArea === $tabIdArea) ? 'style="display: table-cell;"' : '';

$disableRssFeedAreaStyle = ($data['disable_rss_feed'] == 1) ? 'opacity: 1;' : 'opacity: 0.4;';
?>
<div id="<?php echo esc_attr($tabIdArea); ?>" class="wpacu-settings-tab-content" <?php echo wp_kses($styleTabContent, array('style' => array())); ?>>
	<h2 class="wpacu-settings-area-title"><?php _e('Disable RSS Feed &amp; its references from &lt;HEAD&gt;', 'wp-asset-clean-up'); ?></h2>
    <p style="margin-top: 10px;">Если вы вообще не используете WordPress для ведения блога и в нем нет сообщений в блоге (кроме основных страниц, которые вы добавили), вы можете отключить RSS-каналы, удалить ссылку на основной канал и комментарии из<code>&lt;HEAD&gt;</code> раздел исходного кода HTML.</p>
    <table class="wpacu-form-table">
        <!-- Disable RSS Feed -->
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_disable_rss_feed">Отключить RSS-канал?</label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_disable_rss_feed"
                           data-target-opacity="wpacu_disable_rss_feed_message_area"
                           type="checkbox"
					    <?php echo (($data['disable_rss_feed'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[disable_rss_feed]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>&nbsp;
              Это покажет сообщение об ошибке, которое вы можете настроить ниже, всякий раз, когда кто-то получает доступ к RSS-ссылкам веб-сайта (например, <code><?php echo get_feed_link(); ?></code>). Если эта опция включена (отключение любого канала RSS), дополнительные параметры ниже также будут включены, поскольку ссылки RSS больше не будут актуальны.
            <div style="margin: 6px 0 0; <?php echo $disableRssFeedAreaStyle; ?>"
                 id="wpacu_disable_rss_feed_message_area">
                <textarea id="wpacu_disable_rss_feed_message"
                         name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[disable_rss_feed_message]"
                         rows="5"
                         style="width: 100%;"><?php echo esc_textarea($data['disable_rss_feed_message']); ?></textarea></div>
            </td>
        </tr>

        <!-- Remove Main RSS Feed Link -->
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_remove_main_feed_link">Удалить основную ссылку на RSS-канал?</label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_remove_main_feed_link"
                           type="checkbox"
					    <?php echo (($data['remove_main_feed_link'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[remove_main_feed_link]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                <code>e.g. &lt;link rel=&quot;alternate&quot; type=&quot;application/rss xml&quot; title=&quot;Your Site Title &amp;raquo; Feed&quot; href=&quot;https://www.yourwebsite.com/feed/&quot; /&gt;</code>
            </td>
        </tr>

        <!-- Remove Comment Feeds Link -->
        <tr valign="top">
            <th scope="row">
                <label for="wpacu_remove_comment_feed_link">Удалить ссылку на RSS-канал комментариев?</label>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_remove_comment_feed_link"
                           type="checkbox"
					    <?php echo (($data['remove_comment_feed_link'] == 1) ? 'checked="checked"' : ''); ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[remove_comment_feed_link]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
                &nbsp;
                <code>e.g. &lt;link rel=&quot;alternate&quot; type=&quot;application/rss xml&quot; title=&quot;Название вашего веб-сайта &amp;raquo; Лента комментариев&quot; href=&quot;https://www.yourdomain.com/comments/feed/&quot; /&gt;</code>
            </td>
        </tr>
	</table>
</div>
