<?php
/*
 * No direct access to this file
 */
use WpAssetCleanUp\Misc;
use WpAssetCleanUp\OptimiseAssets\OptimizeCommon;

if (! isset($data, $selectedTabArea)) {
    exit;
}

global $wp_version;

$tabIdArea = 'wpacu-setting-cdn-rewrite-urls';
$styleTabContent = ($selectedTabArea === $tabIdArea) ? 'style="display: table-cell;"' : '';

$wpacuCloudFlareIconUrl = WPACU_PLUGIN_URL . '/assets/icons/icon-cloudflare.svg';
?>
<div id="<?php echo esc_attr($tabIdArea); ?>" class="wpacu-settings-tab-content" <?php echo wp_kses($styleTabContent, array('style' => array())); ?>>
    <h2 class="wpacu-settings-area-title"><?php _e('Rewrite cached static assets URLs with the CDN ones if necessary', 'wp-asset-clean-up'); ?></h2>

    <div class="wpacu-warning" style="margin: 0 0 20px;">
        <p style="margin: 0;"><strong>Примечание:</strong> Этот параметр необходим только в том случае, если вы <strong>уже используете CDN</strong> (кроме Cloudflare) и URL-адрес любого кэшированного CSS/JS из Asset CleanUp Pro является локальным, а не URL-адресом из CDN.. <span style="white-space: nowrap;"><a style="display: inline; text-decoration: none; color: #0073aa;" target="_blank" href="https://assetcleanup.com/docs/?p=957"><span style="font-size: 25px; margin-top: -2px;" class="dashicons dashicons-editor-help"></span</a> <a style="display: inline; margin-left: 6px;" target="_blank" href="https://assetcleanup.com/docs/?p=957">Read more about it</a></span></p>
        <p id="wpacu-site-uses-cloudflare" style="display: none; margin: 10px 0 0 0;"><img alt="" style="margin-left: 4px; vertical-align: middle; width: 22px; height: 22px;" src="<?php echo esc_url($wpacuCloudFlareIconUrl); ?>" /> Cloudflare CDN/Proxy используется для вашего веб-сайта, что означает, что CDN уже активен. Если по какой-либо причине ресурсы уже не настроены на загрузку из другой CDN, вам <strong>не нужно</strong> чтобы включить эту функцию.</p>
    </div>

    <table class="wpacu-form-table">
        <tr valign="top">
            <th scope="row" class="setting_title">
                <label for="wpacu_cdn_rewrite_enable"><?php esc_html_e('Enable CDN URL rewrite?', 'wp-asset-clean-up'); ?></label>
                <p class="wpacu_subtitle"><small><em><?php echo sprintf(esc_html__('This applies ONLY to files saved in %s', 'wp-asset-clean-up'), '<code style="font-size: inherit;">'.str_replace(Misc::getWpRootDirPath(), '', '/' . WP_CONTENT_DIR . OptimizeCommon::getRelPathPluginCacheDir().'</code>')); ?></em></small></p>
            </th>
            <td>
                <label class="wpacu_switch">
                    <input id="wpacu_cdn_rewrite_enable"
                           data-target-opacity="wpacu_cdn_rewrite_enable_area"
                           type="checkbox"
                           <?php
                           echo (($data['cdn_rewrite_enable'] == 1) ? 'checked="checked"' : '');
                           ?>
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[cdn_rewrite_enable]"
                           value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>

                &nbsp;Если вы используете CDN, включенный через вашу хостинговую компанию или сторонний плагин, внешний URL-адрес не всегда распознается <?php echo WPACU_PLUGIN_TITLE; ?> и считается внешним URL-адресом, не связанным с файлами CSS/JS вашего веб-сайта. Чтобы исправить это, введите CNAME/URL CDN в поля ввода ниже, чтобы убедиться, что файлы определяются как локальные файлы и оптимизируются соответствующим образом.

                <?php
				$cdnRewriteAreaStyle = ($data['cdn_rewrite_enable'] == 1) ? 'opacity: 1;' : 'opacity: 0.4;';
				?>
                <div id="wpacu_cdn_rewrite_enable_area" style="<?php echo esc_attr($cdnRewriteAreaStyle); ?>">
                    <div style="margin-top: 20px; margin-bottom: 0;"></div>
                    <table>
                        <tr>
                            <td style="vertical-align: top;" valign="top">Для файлов таблиц стилей (.css):&nbsp;&nbsp;</td>
                            <td style="padding-bottom: 10px;">
                                <label for="wpacu_cdn_rewrite_url_css"><input id="wpacu_cdn_rewrite_url_css"
                                        name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[cdn_rewrite_url_css]"
                                        value="<?php echo esc_attr($data['cdn_rewrite_url_css']); ?>"
                                        style="width: 300px;" /><br />
                                </label>

                                <ul style="font-style: italic; line-height: 13px; font-size: 12px; margin-top: 5px; margin-bottom: 0;">
                                    <li>например //css-zone-name.kxcdn.com</li>
                                    <li>zone-name.kxcdn.com etc.</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;" valign="top">Для файлов JavaScript (.js):&nbsp;&nbsp;</td>
                            <td style="padding-bottom: 3px;"><label for="wpacu_cdn_rewrite_url_js">
                                    <input id="wpacu_cdn_rewrite_url_js"
                                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[cdn_rewrite_url_js]"
                                           value="<?php echo esc_attr($data['cdn_rewrite_url_js']); ?>"
                                           style="width: 300px;" /><br />
                                </label>
                                <ul style="font-style: italic; line-height: 13px; font-size: 12px; margin-top: 5px;">
                                    <li>например //js-zone-name.kxcdn.com</li>
                                    <li>zone-name.kxcdn.com etc.</li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                    <hr />
                    <p style="margin-top: 10px;"><strong>Примечание.</strong> В большинстве случаев URL-адрес CNAME/CDN одинаков для файлов CSS и JS. Вы можете использовать одно и то же значение в обоих полях.</p>

                    <p class="wpacu-warning" style="font-size: inherit;">
                        <span class="dashicons dashicons-warning"></span> Если вы не уверены, что CNAME/URL сети <strong>C</strong>Content <strong>D</strong>delivery <strong>N</strong> является правильным, включите «Тестовый режим», чтобы проверить это, чтобы убедиться, что макет не будет нарушен для посетителей вашего сайта.
                    </p>
                </div>
			</td>
		</tr>
	</table>
</div>
