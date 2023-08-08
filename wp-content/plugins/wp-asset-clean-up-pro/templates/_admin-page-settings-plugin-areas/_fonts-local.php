<?php
/*
 * No direct access to this file
 */
if (! isset($data, $selectedTabArea)) {
	exit;
}

$tabIdArea = 'wpacu-setting-local-fonts';
$styleTabContent = ($selectedTabArea === $tabIdArea) ? 'style="display: table-cell;"' : '';

$ddOptions = array(
	'swap'     => 'swap (most used)',
	'auto'     => 'auto',
	'block'    => 'block',
	'fallback' => 'fallback',
	'optional' => 'optional'
);
?>
<div id="<?php echo esc_attr($tabIdArea); ?>" class="wpacu-settings-tab-content" <?php echo wp_kses($styleTabContent, array('style' => array())); ?>>
    <h2 class="wpacu-settings-area-title"><?php esc_html_e('Local Fonts Optimization', 'wp-asset-clean-up'); ?></h2>
    <table class="wpacu-form-table">
        <tr valign="top">
            <th scope="row" class="setting_title">
			    <?php echo sprintf(esc_html__('Apply %s CSS property value', 'wp-asset-clean-up'), '<span style="background: #f5f5f5; padding: 4px;">font-display:</span>'); ?>
            </th>
            <td>
                <select name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[local_fonts_display]">
                    <option value="">Не применять (по умолчанию)</option>
				    <?php
				    foreach ($ddOptions as $ddOptionValue => $ddOptionText) {
					    $selectedOption = ($data['local_fonts_display'] === $ddOptionValue) ? 'selected="selected"' : '';
					    echo '<option '.$selectedOption.' value="'.$ddOptionValue.'">'.$ddOptionText.'</option>'."\n";
				    }
				    ?>
                </select> &nbsp; / &nbsp;

                    Перезаписать любое существующее значение «отображение шрифта»? &nbsp;
                <label for="wpacu_local_fonts_display_overwrite_no"><input id="wpacu_local_fonts_display_overwrite_no"
                           <?php if (! $data['local_fonts_display_overwrite']) { echo 'checked="checked"'; } ?>
                           type="radio"
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[local_fonts_display_overwrite]"
                               value="" />Нет</label>
                    &nbsp;&nbsp;&nbsp;
                    <label for="wpacu_local_fonts_display_overwrite_yes"><input id="wpacu_local_fonts_display_overwrite_yes"
                           <?php if ($data['local_fonts_display_overwrite']) { echo 'checked="checked"'; } ?>
                           type="radio"
                           name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[local_fonts_display_overwrite]"
                           value="1" />Да</label>
                &nbsp;
                <p><?php _e('This feature applies site-wide "font-display:" property (if none set already in the file) within @font-face in every loaded CSS file.', 'wp-asset-clean-up'); ?> &nbsp; <span style="color: #0073aa;" class="dashicons dashicons-info"></span>&nbsp;<a id="wpacu-local-fonts-display-info-target" href="#wpacu-local-fonts-display-info"><?php _e('Read more', 'wp-asset-clean-up'); ?></a></p>
                <p><?php echo sprintf(__('The new generated CSS files will be loaded from <code>%s</code>, as the existing files from plugins/themes will not be altered in any way.', 'wp-asset-clean-up'), \WpAssetCleanUp\OptimiseAssets\OptimizeCommon::getRelPathPluginCacheDir()); ?></p>

                <hr />

                <p><?php esc_html_e('Deciding the behavior for a web font as it is loading can be an important performance tuning technique. If applied, this option ensures text remains visible during webfont load.', 'wp-asset-clean-up'); ?> <?php _e('The <code>font-display</code> CSS property defines how font files are loaded and display by the browser.', 'wp-asset-clean-up'); ?></p>

                <strong>Подробнее об этом:</strong>
                    <a target="_blank" href="https://css-tricks.com/hey-hey-font-display/">эй эй `font-display`</a> &nbsp;|&nbsp;
                    <a target="_blank" href="https://css-tricks.com/font-display-masses/">`font-display` для масс</a> &nbsp;|&nbsp;
                    <a target="_blank" href="https://developers.google.com/web/updates/2016/02/font-display">Управление производительностью шрифта с помощью font-display</a> &nbsp;|&nbsp;
                    <a target="_blank" href="https://font-display.glitch.me/">https://font-display.glitch.me/</a> &nbsp;|&nbsp;
                    <a target="_blank" href="https://vimeo.com/241111413">Video: Fontastic Web Performance</a>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" class="setting_title">
				<?php _e('Preload Local Font Files', 'wp-asset-clean-up'); ?>
                <p class="wpacu_subtitle"><small><em><?php _e('One per line', 'wp-asset-clean-up'); ?></em></small></p>
            </th>
            <td>
                <div style="margin: 0 0 6px;"><?php _e('If you wish to preload any of the Local Font Files (ending in .woff, .woff2, .ttf etc.), you can add their URI here like in the examples below (one per line)', 'wp-asset-clean-up'); ?>:</div>
                <textarea style="width:100%;"
                          rows="5"
                          name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[local_fonts_preload_files]"><?php echo esc_textarea($data['local_fonts_preload_files']); ?></textarea>
                <hr />
                <strong>Примеры:</strong>
                <div style="margin-top: 5px;">
                    <div><code>/wp-content/themes/your-theme-dir/fonts/lato.woff</code></div>
                    <div><code>/wp-content/plugins/plugin-title-here/fonts/fontawesome-webfont.ttf?v=4.5.0</code></div>
                </div>
                <hr />
                <strong>Generated Output</strong>, printed within <code>&lt;HEAD&gt;</code> and <code>&lt;/HEAD&gt;</code>
                <div style="margin-top: 5px;">
                    <div style="margin-bottom: 8px;"><code>&lt;link rel="preload" as="font" href="/wp-content/themes/your-theme-dir/fonts/lato.woff" data-wpacu-preload-font="1" crossorigin&gt;</code></div>
                    <div style="margin-bottom: 8px;"><code>&lt;link rel="preload" as="font" href="/wp-content/plugins/plugin-title-here/fonts/fontawesome-webfont.ttf?v=4.5.0" data-wpacu-preload-font="1" crossorigin&gt;</code></div>
                </div>
            </td>
        </tr>
    </table>
</div>

<div id="wpacu-local-fonts-display-info" class="wpacu-modal" style="padding-top: 60px;">
    <div class="wpacu-modal-content" style="max-width: 800px;">
        <span class="wpacu-close">&times;</span>
        <h3 style="margin-top: 2px; margin-bottom: 4px;">font-display: <span style="background: #f2faf2;">swap</span></h3>
        <p style="margin-top: 0; margin-bottom: 22px;">Текст отображается немедленно (без точки блокировки, без невидимого текста) в резервном шрифте до тех пор, пока не загрузится пользовательский шрифт, а затем он заменяется пользовательским шрифтом. Вы получаете <strong>FOUT</strong> (<em>мигание нестилизованного текста</em>).</p>

        <h3 style="margin-bottom: 4px;">font-display: <span style="background: #f2faf2;">block</span></h3>
        <p style="margin-top: 0; margin-bottom: 22px;">Текст блокируется (невидим) на короткий период. Затем, если пользовательский шрифт еще не был загружен, браузер меняет местами (отображает текст в резервном шрифте) столько времени, сколько требуется для загрузки пользовательского шрифта, а затем повторно отображает текст в пользовательском шрифте. Вы получаете <strong>FOIT</strong> (<em>вспышку невидимого текста</em>).</p>

        <h3 style="margin-bottom: 4px;">font-display: <span style="background: #f2faf2;">fallback</span></h3>
        <p style="margin-top: 0; margin-bottom: 22px;">Это что-то среднее между блоком и обменом. Текст невидим в течение короткого периода времени (100 мс). Затем, если пользовательский шрифт не загружен, текст отображается резервным шрифтом (около 3 с), а затем меняется местами после загрузки пользовательского шрифта.</p>

        <h3 style="margin-bottom: 4px;">font-display: <span style="background: #f2faf2;">optional</span></h3>
        <p style="margin-top: 0; margin-bottom: 22px;">Это ведет себя так же, как резервный вариант, только браузер может решить вообще не использовать пользовательский шрифт в зависимости от скорости соединения пользователя (если у вас медленный 3G или меньше, загрузка пользовательского шрифта и последующая замена будут занимать целую вечность). будет поздно и крайне раздражает)</p>

        <h3 style="margin-bottom: 4px;">font-display: <span style="background: #f2faf2;">auto</span></h3>
        <p style="margin-top: 0; margin-bottom: 0;">По умолчанию. Будет иметь место типичное поведение загрузки шрифта браузера. Такое поведение может быть FOIT или FOIT с относительно длительным периодом невидимости. Это может измениться, поскольку поставщики браузеров решат улучшить поведение по умолчанию.</p>

        <h3 style="margin-bottom: 4px;">Example of a @font-face CSS output</h3>
        <code>@font-face{font-family:'proxima-nova-1';src:url("/wp-content/themes/my-theme-dir/fonts/proxima-nova-light.woff2") format("woff2"),url("/wp-content/themes/my-theme-dir/fonts/proxima-nova-light.woff") format("woff");font-weight:300;font-style:normal;font-stretch:normal;<span style="background: #f2faf2;">font-display:swap</span>}</code>
    </div>
</div>