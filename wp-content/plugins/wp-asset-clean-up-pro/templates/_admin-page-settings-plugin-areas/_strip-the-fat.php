<?php
/*
 * No direct access to this file
 */
use WpAssetCleanUp\Misc;

if (! isset($data, $selectedTabArea)) {
	exit;
}

$tabIdArea = 'wpacu-setting-strip-the-fat';
$styleTabContent = ($selectedTabArea === $tabIdArea) ? 'style="display: table-cell;"' : '';
?>
<div id="<?php echo esc_attr($tabIdArea); ?>" class="wpacu-settings-tab-content" <?php echo wp_kses($styleTabContent, array('style' => array())); ?>>
    <h2 class="wpacu-settings-area-title"><span class="dashicons dashicons-info"></span> <?php _e('Prevent useless and often large CSS &amp; JS files increasing your total page size', 'wp-asset-clean-up'); ?></h2>
    <p class="wpacu-notice wpacu-warning" style="font-size: 13px;">Прочтите следующие советы по использованию <?php echo WPACU_PLUGIN_TITLE; ?> чтобы потом не было неудобств. Это полезно, если вы раньше не использовали подключаемый модуль для увеличения скорости страницы или также используете подключаемый модуль кэширования для функции кэширования страницы. Если вы уже знакомы с плагином или читали приведенные ниже пояснения, просто отметьте эту область как «прочитанную» с помощью ползунка внизу этой страницы..</p>
    <p>Основная функциональность <?php echo WPACU_PLUGIN_TITLE; ?>, как следует из названия, помогает выгружать файлы таблиц стилей CSS (.css) и JavaScript (.js) через <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_assets_manager')); ?>">Менеджер загрузки CSS и JavaScript</a> везде, где они загружаются с избытком. Это всегда было основной целью этого плагина для увеличения скорости страницы.</p>
    <p>Рекомендуется выполнить это действие сначала на любой странице, которую вы хотите оптимизировать (например, на домашней странице), перед минификацией и объединением оставшихся загруженных файлов (поскольку в конечном итоге вы получите все меньше и меньше оптимизированных файлов). Это дополнительные функции, добавленные в плагин, которые предназначены для дальнейшего сокращения количества HTTP-запросов, а также для уменьшения размера страницы, поскольку в этом поможет минификация.</p>
    <p>Если вы уже используете другой плагин для минификации и конкатенации, вас устраивает его конфигурация и вы решили оставить его, вы можете просто использовать <?php echo WPACU_PLUGIN_TITLE; ?> для удаления «жира», а другие плагины, такие как WP Rocket или Autoptimize, возьмут оставшиеся файлы и оптимизируют их. Не включайте минификацию/конкатенацию для обоих <?php echo WPACU_PLUGIN_TITLE; ?> и другие плагины кеширования одновременно, так как это может привести к загрузке дополнительных ресурсов и вызвать конфликты или даже дублирование файлов, что в конечном итоге приведет к увеличению общего размера страницы.</p>

    <hr />
    <div style="margin: 20px 0 10px;"><strong style="font-size: 15px; line-height: 17px;">Как плагины, такие как WP Rocket, WP Fastest Cache, Autoptimize или W3 Total Cache, работают вместе с <?php echo WPACU_PLUGIN_TITLE; ?>?</strong></div>
    <p>Предположим, вы оптимизируете домашнюю страницу, на которой загружается в общей сложности 20 файлов CSS/JS, и решили, что 8 файлов CSS и JavaScript там не нужны. После того, как они будут предотвращены от загрузки (не удалены и не изменены каким-либо образом из исходного источника, этот плагин этого не делает), оставшиеся 12 файлов будут минимизированы/объединены (если у вас включена эта опция) либо <?php echo WPACU_PLUGIN_TITLE; ?>, WP Rocket или другой плагин, который вы решили сделать и сохранили в файлы меньшего размера. Это приведет к уменьшению общего размера страницы, отложенным неиспользуемым CSS и меньшему количеству HTTP-запросов, что приведет к более быстрой загрузке страницы и более высокому показателю скорости страницы (с помощью таких инструментов, как GTMetrix)..</p>

    <hr />
    <div style="margin: 20px 0 10px;"><strong style="font-size: 15px; line-height: 17px;"><?php _e('Is a decrease in the total page size or a higher page speed score guaranteed?', 'wp-asset-clean-up'); ?></strong></div>
    <p>Если вы предотвратите загрузку бесполезных файлов, у вас наверняка будет более легкий и быстрый веб-сайт. Если что-либо изменится в конфигурации вашего хостинга, размере ваших изображений или каких-либо внешних скриптов и т. д., загружаемых вашим веб-сайтом, вы можете получить более медленный веб-сайт, и это не зависит от <?php echo WPACU_PLUGIN_TITLE; ?> ни какой-либо другой плагин производительности WordPress, поскольку есть внешние вещи, которые никогда не будут полностью зависеть от плагина..</p>

    <hr />
    <div style="margin: 20px 0 10px;"><strong style="font-size: 15px; line-height: 17px;"><?php _e('Can this plugin make the pages load slower?', 'wp-asset-clean-up'); ?></strong></div>
    <p><?php echo WPACU_PLUGIN_TITLE; ?> не добавляет никаких дополнительных файлов для загрузки в представлении переднего плана, что каким-либо образом увеличит количество HTTP-запросов, поскольку это не соответствует его назначению. Его основная задача — предотвратить загрузку других файлов и очистку HTML-кода. Кроме того, включив конкатенацию (если ваш сайт не использует протокол HTTP/2), вы еще больше сократите количество HTTP-запросов. Если вы используете другой плагин, у которого также есть возможность минификации/конкатенации, и вы включили эту функцию в обоих плагинах (никогда не делайте этого) или не настроили что-то правильно, вы можете получить дополнительный CSS/JS. загружен, что в конечном итоге приведет к снижению скорости страницы и замедлению работы веб-сайта.</p>
    <p><?php echo WPACU_PLUGIN_TITLE; ?> никогда не будет изменять (каким-либо образом) или удалять файлы CSS и JS из их исходного источника (например, плагинов, тем). Файлы, созданные с помощью минификации/объединения, кэшируются и сохраняются в <code><em><?php echo '/'.str_replace(Misc::getWpRootDirPath(), '', WP_CONTENT_DIR) . \WpAssetCleanUp\OptimiseAssets\OptimizeCommon::getRelPathPluginCacheDir(); ?></em></code> directory.</p>
    <hr />

    <label class="wpacu_switch">
        <input id="wpacu_wiki_read"
               type="checkbox"
			<?php echo (($data['wiki_read'] == 1) ? 'checked="checked"' : ''); ?>
               name="<?php echo WPACU_PLUGIN_ID . '_settings'; ?>[wiki_read]"
               value="1" /> <span class="wpacu_slider wpacu_round"></span> </label>
    &nbsp;<?php echo sprintf(__('I understand how the plugin works and I will make sure to make proper tests (via "%s" if necessary) after the changes I\'m making.', 'wp-asset-clean-up'), __('Test Mode', 'wp-asset-clean-up')); ?> <?php _e('I\'m aware that unloading the wrong CSS/JS files can break the layout and front-end functionality of the pages I\'m optimising.', 'wp-asset-clean-up'); ?>
</div>