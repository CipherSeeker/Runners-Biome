<?php
if (! isset($data, $ddOptions)) {
	exit;
}
?>

<?php
if ($data['google_fonts_remove']) {
	?>
	<div class="wpacu-warning" style="font-size: inherit;"><span class="dashicons dashicons-warning"></span> Поскольку параметр удаления шрифтов Google <strong>включен</strong>, приведенные ниже параметры не имеют значения. Если вы отключите <strong>отключение</strong> параметра "Удалить шрифты Google" и сохраните настройки, это уведомление исчезнет, ​​а приведенные ниже параметры вступят в силу по мере загрузки шрифтов..</div>
	<?php
}
?>

<table class="wpacu-form-table">
	<tr valign="top">
		<th scope="row" class="setting_title">
			<label for="wpacu_google_fonts_combine"><?php _e('Combine Multiple Requests Into Fewer Ones', 'wp-asset-clean-up'); ?></label>
			<p class="wpacu_subtitle"><small><em>И выберите вариант загрузки</em></small></p>
		</th>
		<td>
			<label class="wpacu_switch">
				<input id="wpacu_google_fonts_combine"
				       type="checkbox"
				       data-target-opacity="google_fonts_combine_wrap"
					<?php echo (($data['google_fonts_combine'] == 1) ? 'checked="checked"' : ''); ?>
					   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[google_fonts_combine]"
					   value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>

			&nbsp;<?php _e('This option combines multiple font requests into fewer requests', 'wp-asset-clean-up'); ?>. Когда он активен, вы можете выбрать, как будет происходить загрузка, в зависимости от вашего веб-сайта, выбрав один из вариантов радио ниже. <strong>Вы можете включить эту опцию, даже если знаете, что у вас есть один запрос LINK. Если комбинация не будет выполнена, будет применен тип загрузки, указанный ниже.</strong> Обратите внимание, что асинхронная загрузка может вызвать <strong>FOUT</strong> (мигание нестилизованного текста) до тех пор, пока не будут загружены шрифты Google, поэтому Рекомендуется протестировать его после изменения.

			<div id="google_fonts_combine_wrap" <?php if (! $data['google_fonts_combine']) { ?>style="opacity: 0.4;"<?php } ?>>
				<div class="google_fonts_load_types">
					<div style="flex-basis: 70%; padding-right: 20px;" class="wpacu-fancy-radio"><label for="google_fonts_combine_type_rb"><input id="google_fonts_combine_type_rb" class="google_fonts_combine_type" type="radio" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[google_fonts_combine_type]" <?php if (! $data['google_fonts_combine_type']) { ?>checked="checked"<?php } ?> value="" />Блокировка рендеринга (по умолчанию)</label></div>
					<div style="flex-basis: 90%; padding-right: 20px;" class="wpacu-fancy-radio"><label for="google_fonts_combine_type_async"><input id="google_fonts_combine_type_async" class="google_fonts_combine_type" type="radio" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[google_fonts_combine_type]" <?php if ($data['google_fonts_combine_type'] === 'async') { ?>checked="checked"<?php } ?> value="async" />Асинхронно через загрузчик веб-шрифтов (webfont.js)</label></div>
					<div style="flex-basis: 90%;" class="wpacu-fancy-radio"><label for="google_fonts_combine_type_async_preload"><input id="google_fonts_combine_type_async_preload" class="google_fonts_combine_type" type="radio" name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[google_fonts_combine_type]" <?php if ($data['google_fonts_combine_type'] === 'async_preload') { ?>checked="checked"<?php } ?> value="async_preload" />Асинхронный с предварительной загрузкой таблицы стилей CSS</label></div>
				</div>

				<!-- Render-blocking (default) info -->
				<div id="wpacu_google_fonts_combine_type_rb_info_area" class="wpacu_google_fonts_combine_type_area" <?php if ($data['google_fonts_combine_type']) { echo 'style="display: none;"'; } ?>>
					<p><strong>Пример</strong> Следующие теги LINK будут объединены в один тег:</p>

					<ul>
						<li><code>&lt;link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Droid+Sans"&gt;</code></li>
						<li><code>&lt;link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata:bold"&gt;</code></li>
					</ul>
					<hr />
					<ul>
						<li><code>&lt;link rel="stylesheet" id="wpacu-combined-google-fonts-css" href="https://fonts.googleapis.com/css?family=Droid+Sans|Inconsolata:bold"&gt;</code></li>
					</ul>

					<p><strong>Результат:</strong> эта простая функция экономит один цикл обращения к серверу для каждого запрошенного дополнительного шрифта (уменьшая количество HTTP-запросов), а также защищает от блокировки в старых браузерах, в которых одновременно открыто только 2 соединения для каждого домена.</p>
				</div>
				<!-- /Render-blocking (default) info -->

				<!-- Async info -->
				<div id="wpacu_google_fonts_combine_type_async_info_area" class="wpacu_google_fonts_combine_type_area" <?php if ($data['google_fonts_combine_type'] !== 'async') { echo 'style="display: none;"'; } ?>>
					<p><strong>Пример</strong> Следующие теги LINK будут преобразованы во встроенные теги JavaScript:</p>

					<ul>
						<li><code>&lt;link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Droid+Sans"&gt;</code></li>
						<li><code>&lt;link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata:bold"&gt;</code></li>
					</ul>
					<hr />
					<ul>
						<li>
							<code>
								<?php
                                $typeAttr = \WpAssetCleanUp\Misc::getScriptTypeAttribute();
								$asyncWebFontLoaderSnippet = <<<HTML
&lt;script id='wpacu-google-fonts-async-load' {$typeAttr}&gt;
WebFontConfig = { google: { families: ['Droid+Sans', 'Inconsolata:bold'] } };
(function(wpacuD) {
&nbsp;&nbsp;var wpacuWf = wpacuD.createElement('script'), wpacuS = wpacuD.scripts[0];
&nbsp;&nbsp;wpacuWf.src = ('https:' === document.location.protocol ? 'https' : 'http') 
&nbsp;&nbsp;&nbsp;&nbsp;+ '://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
&nbsp;&nbsp;wpacuWf.async = true;
&nbsp;&nbsp;wpacuS.parentNode.insertBefore(wpacuWf, wpacuS);
})(document);
&lt;/script&gt;&lt;noscript&gt;&lt;link rel="stylesheet" id="wpacu-combined-google-fonts-css" href="https://fonts.googleapis.com/css?family=Droid+Sans|Inconsolata:bold"&gt;&lt;/noscript&gt;
HTML;
								echo nl2br($asyncWebFontLoaderSnippet);
								?>
							</code>
							<p style="margin-top: 5px;"><small><strong>Примечание.</strong> Содержимое встроенного тега будет уменьшено в результирующем HTML-коде. Тег NOSCRIPT добавляется к тегу SCRIPT в качестве запасного варианта на случай, если JavaScript отключен по какой-либо причине.</small></p>
						</li>
					</ul>

					<p>Асинхронное использование загрузчика веб-шрифтов позволяет избежать блокировки вашей страницы при загрузке JavaScript. <strong>Недостаток</strong> заключается в том, что остальная часть страницы может отображаться до того, как загрузчик веб-шрифтов будет загружен и выполнен, что может вызвать <strong>мигание нестилизованного текста (FOUT)</strong>.</p>
				</div>
				<!-- /Async info -->

				<!-- Async preload info -->
				<div id="wpacu_google_fonts_combine_type_async_preload_info_area" class="wpacu_google_fonts_combine_type_area" <?php if ($data['google_fonts_combine_type'] !== 'async_preload') { echo 'style="display: none;"'; } ?>>
					<p><strong>Пример</strong> Следующие теги LINK будут преобразованы в теги LINK "preload", не блокирующие рендеринг:</p>

					<ul>
						<li><code>&lt;link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Droid+Sans"&gt;</code></li>
						<li><code>&lt;link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata:bold"&gt;</code></li>
					</ul>
					<hr />
					<ul>
						<li>
							<code>
								<?php
								$asyncPreloadSnippet = <<<HTML
&lt;link rel="preload" as="style" onload="this.onload=null;this.rel='stylesheet'" id="wpacu-combined-google-fonts-css-preload" href="https://fonts.googleapis.com/css?family=Droid+Sans|Inconsolata:bold"&gt;
&lt;noscript&gt;&lt;link rel="stylesheet" id="wpacu-combined-google-fonts-css" href="https://fonts.googleapis.com/css?family=Droid+Sans|Inconsolata:bold"&gt;&lt;/noscript&gt;
HTML;

								echo nl2br($asyncPreloadSnippet);
								?>
							</code>
							<p style="margin-top: 5px;"><small><strong>Примечание.</strong> Тег NOSCRIPT добавляется к тегу LINK "preload" в качестве запасного варианта на случай, если по какой-либо причине отключен JavaScript. Для некоторых браузеров, таких как Mozilla Firefox, которые не поддерживают предварительную загрузку, а также Google Chrome, в разделе HEAD веб-сайта загружается дополнительный резервный сценарий. <a target="_blank" href="https://github.com/filamentgroup/loadCSS">Подробнее о loadCSS</a></small></p>
						</li>
					</ul>
				</div>
				<!-- /Async preload info -->
			</div>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row" class="setting_title">
			<?php echo sprintf(__('Apply %s CSS property value', 'wp-asset-clean-up'), '<span style="background: #f5f5f5; padding: 4px;">font-display:</span>'); ?>
		</th>
		<td>
			<select name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[google_fonts_display]">
				<option value="">Не применять (по умолчанию)</option>
				<?php
				foreach ($ddOptions as $ddOptionValue => $ddOptionText) {
					$selectedOption = ($data['google_fonts_display'] === $ddOptionValue) ? 'selected="selected"' : '';
					echo '<option '.$selectedOption.' value="'.$ddOptionValue.'">'.$ddOptionText.'</option>'."\n";
				}
				?>
			</select>
			&nbsp;
			<?php _e('This feature applies site-wide "&display=" with the chosen value to all the Google Font URL requests (if the parameter is not already set in the URL).', 'wp-asset-clean-up'); ?>
			<?php _e('This will result in printing of "font-display" CSS property within @font-face.', 'wp-asset-clean-up'); ?>
			<span style="color: #0073aa;" class="dashicons dashicons-info"></span> <a id="wpacu-google-fonts-display-info-target" href="#wpacu-google-fonts-display-info"><?php _e('Read more', 'wp-asset-clean-up'); ?></a>

			<hr />
			<ul>
				<li><code>&lt;link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Mono<strong>&amp;display=swap</strong>"&gt;</code></li>
				<li><code>&lt;link rel="stylesheet" id="wpacu-combined-google-fonts-css" href="https://fonts.googleapis.com/css?family=Droid+Sans|Inconsolata:bold<strong>&amp;display=swap</strong>"&gt;</code></li>
			</ul>
			<hr />

			<p><?php _e('Deciding the behavior for a web font as it is loading can be an important performance tuning technique. If applied, this option ensures text remains visible during webfont load.', 'wp-asset-clean-up'); ?> <?php _e('The <code>font-display</code> CSS property defines how font files are loaded and display by the browser.', 'wp-asset-clean-up'); ?></p>

			<strong>Подробнее об этом:</strong>
			<a target="_blank" href="https://css-tricks.com/hey-hey-font-display/">Hey hey `font-display`</a> &nbsp;|&nbsp;
			<a target="_blank" href="https://css-tricks.com/font-display-masses/">`font-display` for the Masses</a> &nbsp;|&nbsp;
			<a target="_blank" href="https://developers.google.com/web/updates/2016/02/font-display">Управление производительностью шрифта с помощью font-display</a> &nbsp;|&nbsp;
			<a target="_blank" href="https://font-display.glitch.me/">https://font-display.glitch.me/</a> &nbsp;|&nbsp;
			<a target="_blank" href="https://vimeo.com/241111413">Video: Fontastic Web Performance</a>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row" class="setting_title">
			<?php _e('Preconnect?', 'wp-asset-clean-up'); ?>
			<p class="wpacu_subtitle"><small><em><?php _e('Don\'t let the browser wait until it sees the CSS call font files before it begins DNS/TCP/TLS', 'wp-asset-clean-up'); ?></em></small></p>
		</th>
		<td>
			<label class="wpacu_switch">
				<input id="wpacu_google_fonts_preconnect"
				       type="checkbox"
				       data-target-opacity="google_fonts_preconnect_wrap"
					<?php echo (($data['google_fonts_preconnect'] == 1) ? 'checked="checked"' : ''); ?>
					   name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[google_fonts_preconnect]"
					   value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
			&nbsp;Если вы знаете, что ваш веб-сайт запрашивает ресурсы у Google Fonts (fonts.gstatic.com), то добавление подсказки ресурса перед подключением даст браузеру указание предварительно подключиться к Google Fonts во время загрузки CSS, что сэкономит время загрузки.
			<hr />
			<div id="google_fonts_preconnect_wrap">
				<p style="margin-bottom: 5px;">Это сгенерирует следующий вывод в пределах <code>&lt;HEAD&gt;</code> и <code>&lt;/HEAD&gt;</code>:</p>
				<code>&lt;link href='https://fonts.gstatic.com' crossorigin rel='preconnect' /&gt;</code>
			</div>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row" class="setting_title">
			<?php _e('Preload Google Font Files', 'wp-asset-clean-up'); ?>
			<p class="wpacu_subtitle"><small><em><?php _e('One per line', 'wp-asset-clean-up'); ?>, разрешены только внешние файлы шрифтов Google</em></small></p>
		</th>
		<td>
			<div style="margin: 0 0 6px;"><?php _e('If you wish to preload any of the Google Font Files (e.g. ending in .woff2), you can add their URL here (one per line)', 'wp-asset-clean-up'); ?>:</div>
			<textarea style="width:100%;"
			          rows="5"
			          name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[google_fonts_preload_files]"><?php echo esc_textarea($data['google_fonts_preload_files']); ?></textarea>
			<hr />
			<p>Чтобы получить URL-адрес фактического файла шрифта, вам нужно открыть ссылку Google Fonts (например, https://fonts.googleapis.com/css?family=Open+Sans:bold), найти фактический @font-face (или все они зависят от обстоятельств), а затем скопируйте значение <code>url</code> в свойство 'src:'.</p>
			<strong>Examples:</strong>
			<div style="margin-top: 5px;">
				<div><code>https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu72xKKTU1Kvnz.woff2</code></div>
				<div><code>https://fonts.gstatic.com/s/robotomono/v7/L0x5DF4xlVMF-BfR8bXMIjhFq3-cXbKDO1w.woff2</code></div>
			</div>
			<hr />
			<strong>Сгенерированный вывод</strong>, распечатанный внутри <code>&lt;HEAD&gt;</code> и <code>&lt;/HEAD&gt;</code>
			<div style="margin-top: 5px;">
				<div style="margin-bottom: 8px;"><code>&lt;link rel="preload" as="font" href="https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu72xKKTU1Kvnz.woff2" data-wpacu-preload-font="1" crossorigin&gt;</code></div>
				<div style="margin-bottom: 8px;"><code>&lt;link rel="preload" as="font" href="https://fonts.gstatic.com/s/robotomono/v7/L0x5DF4xlVMF-BfR8bXMIjhFq3-cXbKDO1w.woff2" data-wpacu-preload-font="1" crossorigin&gt;</code></div>
			</div>
		</td>
	</tr>
</table>
