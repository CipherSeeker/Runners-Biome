<?php
use WpAssetCleanUp\Misc;
use WpAssetCleanUp\OptimiseAssets\OptimizeCommon;

if (! isset($data)) {
	exit;
}
?>
<table class="wpacu-form-table">
	<tr valign="top">
		<th scope="row" class="setting_title">
			<label for="wpacu_google_fonts_remove"><?php _e('Remove Google Fonts', 'wp-asset-clean-up'); ?></label>
		</th>
		<td style="padding-bottom: 10px;">
			<label class="wpacu_switch">
				<input id="wpacu_google_fonts_remove"
				       type="checkbox"
				       data-target-opacity="google_fonts_remove_wrap"
					<?php echo (($data['google_fonts_remove'] == 1) ? 'checked="checked"' : ''); ?>
					   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[google_fonts_remove]"
					   value="1" /> <span class="wpacu_slider wpacu_round"></span></label>
			&nbsp;Эта опция удаляет запросы Google Fonts с вашего веб-сайта, включая: <code>&lt;LINK&gt;</code> теги (включая предварительно загруженные), @import в файлах таблиц стилей CSS / <code>&lt;STYLE&gt;</code> теги и любой @font-face, который загружает файлы шрифтов с <em>fonts.gstatic.com</em>)
		</td>
	</tr>
</table>
<div id="google_fonts_remove_wrap" style="padding: 0 10px 10px; <?php if (! $data['google_fonts_remove']) { ?>opacity: 0.4;<?php } ?>">
	<hr />

	<p style="margin-bottom: 10px;"><strong style="border-bottom: 1px dotted black;">Возможные причины для удаления запросов Google Font</strong></p>
	<ul style="list-style: circle; margin-left: 22px; margin-top: 0;">
		<li>У вас есть собственные файлы шрифтов, которые вы хотите внедрить, и вам не нужны запросы к Google Fonts.</li>
		<li>Вы уже используете свои собственные локальные шрифты и только что установили плагин, который отправляет запросы к Google Fonts, что приводит к дополнительным внешним запросам, влияющим на производительность.</li>
	</ul>

	<hr />

	<p style="margin-bottom: 10px;"><strong style="border-bottom: 1px dotted black;">Какой контент будет удален?</strong> * несколько примеров:</p>

	<strong>&#10230; ССЫЛКА теги</strong>
	<ul style="list-style: none; margin-left: 0; margin-top: 8px; margin-bottom: 20px;">
		<li><code>&lt;link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto' /&gt;</code></li>
		<li><code>&lt;link rel='preload' as='style' href='https://fonts.googleapis.com/css?family=Roboto' /&gt;</code></li>
		<li><code>&lt;link rel='preload' as='font' href='https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu7mxKKTU1Kvnz.woff2' crossorigin /&gt;</code></li>
		<li><code>&lt;link rel='dns-prefetch' href='//fonts.googleapis.com' /&gt;</code></li>
		<li><code>&lt;link rel='preconnect' href='https://fonts.gstatic.com' crossorigin /&gt;</code></li>
	</ul>

	<strong>&#10230; @import &amp; @font-face в файлах CSS (из того же домена) или тегах STYLE</strong>
	<ul style="list-style: none; margin-left: 0; margin-top: 8px;">
		<li><code>@import "https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300";</code></li>
		<li><code>@import url("https://fonts.googleapis.com/css?family=Verdana:700");</code></li>
		<li><?php
			$cssFontFaceSample = <<<CSS
@font-face {
font-family: 'Roboto';
font-style: normal;
font-weight: 400;
src: local('Roboto'), local('Roboto-Regular'), url(https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu7mxKKTU1Kvnz.woff2) format('woff2');
unicode-range: U+1F00-1FFF;
}
CSS;

			echo '<code>'.$cssFontFaceSample.'</code>';
			?></li>
	</ul>

    <strong>&#10230; URL-адреса шрифтов Google в файлах JavaScript и встроенных тегах SCRIPT</strong>
    <ul style="list-style: none; margin-left: 0; margin-top: 8px; margin-bottom: 0;">
        <li><code>loadCss("<span style="background-color: #f2faf2;">https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300</span>");</code></li>
        <li><code>WebFontConfig={google:{/* code here */}};(function(d) { var wf=d.createElement('script'), s=d.scripts[0]; wf.src='<span style="background-color: #f2faf2;">https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js</span>'; wf.async=!0; s.parentNode.insertBefore(wf,s)})(document);</code>, etc.</li>
    </ul>
    <p style="font-size: inherit; font-style: italic; margin-top: 0;"><small>* Запросы CDN для Web Font Loader от Google, Cloudflare и jsDelivr обнаруживаются и удаляются..</small></p>

	<p style="margin-bottom: 6px;"><strong style="border-bottom: 1px dotted black;">Это решение работает на 100% для любого веб-сайта?</strong></p>
	Если вы уже используете «WebFontConfig» и он жестко запрограммирован в вашей теме или в одном из плагинов, удалить его с помощью универсального шаблона непросто, так как его код может быть разбросан по разным местам, и некоторые попытки удалить его могут привести к поломке Файл JavaScript, который запускает его. Таким образом, в редких случаях у вас могут остаться некоторые следы запросов Google Font, и вам придется удалить их вручную.

	<p style="margin-top: 10px; font-size: inherit;" class="wpacu-warning"><strong>Примечание.</strong> После того, как вы включите этот параметр, любые параметры из «Оптимизировать доставку шрифтов» больше не будут срабатывать. Если в файлах CSS будут найдены совпадения @import или @font-face, новые обновленные файлы будут кэшированы и сохранены в <strong>/<?php echo str_replace(Misc::getWpRootDirPath(), '', WP_CONTENT_DIR) . OptimizeCommon::getRelPathPluginCacheDir(); ?></strong>. Исходные файлы (из плагинов или из темы) не будут изменены никоим образом.</p>
</div>
