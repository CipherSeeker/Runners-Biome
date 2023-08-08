<?php
/*
 * No direct access to this file
 */
if (! isset($data, $selectedTabArea)) {
	exit;
}

$tabIdArea = 'wpacu-setting-disable-xml-rpc';
$styleTabContent = ($selectedTabArea === $tabIdArea) ? 'style="display: table-cell;"' : '';
?>
<div id="<?php echo esc_attr($tabIdArea); ?>" class="wpacu-settings-tab-content" <?php echo wp_kses($styleTabContent, array('style' => array())); ?>>
	<h2 class="wpacu-settings-area-title"><?php _e('Disable XML-RPC Protocol Support partially or completely', 'wp-asset-clean-up'); ?></h2>
    <table class="wpacu-form-table">
		<!-- Disable "XML-RPC" protocol support? -->
		<tr valign="top">
			<td>
				<select id="wpacu_disable_xmlrpc"
				        name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[disable_xmlrpc]">
					<option <?php if (! in_array($data['disable_xmlrpc'], array('disable_pingback', 'disable_all'))) { echo 'selected="selected"'; } ?>
						value="keep_it_on">Оставьте его включенным (по умолчанию)</option>

					<option <?php if ($data['disable_xmlrpc'] === 'disable_pingback') { echo 'selected="selected"'; } ?>
						value="disable_pingback">Отключить только эхо-запрос XML-RPC

					<option <?php if ($data['disable_xmlrpc'] === 'disable_all') { echo 'selected="selected"'; } ?>
						value="disable_all">Полностью отключить XML-RPC</option>
				</select>
				<code>&lt;link rel=&quot;pingback&quot; href=&quot;https://www.yourwebsite.com/xmlrpc.php&quot; /&gt;</code>
				<p style="margin-bottom: 10px;">Это отключит поддержку протокола XML-RPC и удалит тег «pingback» из раздела HEAD вашего веб-сайта.</p>
				<p style="margin-bottom: 10px;">Это служба API, используемая WordPress для сторонних приложений, таких как мобильные приложения, связь между блогами, плагины, такие как Jetpack. Если вы используете или планируете использовать удаленную систему для публикации контента на своем веб-сайте, вы можете оставить эту функцию включенной (которая включена по умолчанию). Многие пользователи вообще не используют эту функцию, и если вы один из них, вы можете отключить ее.</p>

				<p style="margin-bottom: 10px;"><strong>Отключить только XML-RPC Pingback</strong>: если вам нужна поддержка протокола XML-RPC, но вы не используете pingback, который используется вашим веб-сайтом для уведомления другого веб-сайта о том, что вы связались с ним со своей страницы (страниц) , вы можете просто отключить пинбэки и сохранить другие функции XML-RPC. Это также мера безопасности для предотвращения DDoS-атак.</p>

				<p style="margin-bottom: 0;"><strong>Полностью отключить XML-RPC</strong>: Если вы не используете подключаемый модуль Jetpack для связи с внешним сервером или используете панель инструментов только для публикации контента (без какого-либо удаленного программного подключения к веб-сайту WordPress, такого как Windows Live Writer или мобильные приложения), вы можете отключить XML-RPC. функциональность. Вы всегда можете снова включить его, когда считаете, что он вам понадобится.</p>
			</td>
		</tr>
	</table>
</div>
