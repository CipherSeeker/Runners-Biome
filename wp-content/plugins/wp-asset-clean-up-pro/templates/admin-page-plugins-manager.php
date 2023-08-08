<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
	exit;
}

include_once '_top-area.php';

do_action('wpacu_admin_notices');

if ( ! \WpAssetCleanUp\Main::instance()->currentUserCanViewAssetsList() ) {
	?>
    <div class="wpacu-error" style="padding: 10px;">
		<?php echo sprintf(esc_html__('Only the administrators listed here can manage plugins: %s"Settings" &#10141; "Plugin Usage Preferences" &#10141; "Allow managing assets to:"%s. If you believe you should have access to managing plugins, you can add yourself to that list.', 'wp-asset-clean-up'), '<a target="_blank" href="'.esc_url(admin_url('admin.php?page=wpassetcleanup_settings&wpacu_selected_tab_area=wpacu-setting-plugin-usage-settings')).'">', '</a>'); ?></div>
	<?php
	return;
}

// [wpacu_pro]
if ($data['mu_file_missing']) {
    ?>
    <div style="border-radius: 5px; line-height: 20px; background: white; padding: 8px; margin-bottom: 16px; width: 95%; border-left: 4px solid #CC0000; border-top: 1px solid #e7e7e7; border-right: 1px solid #e7e7e7; border-bottom: 1px solid #e7e7e7;">
        Файл подключаемого модуля MU, который фильтрует правила подключаемых модулей, не был успешно скопирован в <code><?php echo esc_html($data['mu_file_rel_path']); ?></code>. Убедитесь, что каталог плагина MU доступен для записи, или скопируйте файл вручную из <code>/<?php echo \WpAssetCleanUp\Misc::getPluginsDir(); ?>/wp-asset-clean-up-pro/pro/mu-plugins/to-copy/wpacu-plugins-filter.php</code> в <code><?php echo esc_html($data['mu_file_rel_path']); ?></code>.
    </div>
    <?php
    return;
}
// [/wpacu_pro]
?>
<div class="wpacu-sub-page-tabs-wrap"> <!-- Sub-tabs wrap -->
    <!-- Sub-nav menu -->
    <label class="wpacu-sub-page-nav-label <?php if ($data['wpacu_sub_page'] === 'manage_plugins_front') { ?>wpacu-selected<?php } ?>"><a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_plugins_manager&wpacu_sub_page=manage_plugins_front')); ?>"><span class="dashicons dashicons-admin-home"></span> ПЕРЕДНЕГО ВИДА (ваши посетители)</a></label>
    <label class="wpacu-sub-page-nav-label <?php if ($data['wpacu_sub_page'] === 'manage_plugins_dash') { ?>wpacu-selected<?php } ?>"><a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_plugins_manager&wpacu_sub_page=manage_plugins_dash')); ?>"><span class="dashicons dashicons-dashboard"></span> В ПРИБОРНОЙ ПАНЕЛИ /wp-admin/</a></label>
    <!-- /Sub-nav menu -->
</div> <!-- /Sub-tabs wrap -->

<?php if ($data['wpacu_sub_page'] === 'manage_plugins_front') { ?>
    <div id="wpacu-plugins-manage-front-notice-top">
        <p style="margin-top: 0;"><strong>Помните:</strong> будьте осторожны при использовании этой функции, так как она не только выгрузит весь CSS/JS, который загружается из плагина, но и все остальное (например, его серверный код PHP, вывод HTML, напечатанный через <code>wp_head()</code> или <code>wp_footer()</code> хуки действий, любые установленные файлы cookie и т. д.). Похоже, что плагин деактивирован для страниц, на которых он выбран для выгрузки. Рассмотрите возможность включения «Тестового режима» в «Настройках» плагина, если вы в чем-то не уверены. Все установленные ниже правила применяются только во внешнем виде. Они не действуют в Dashboard (функция <code style="font-size: inherit;">is_admin()</code> используется для проверки этого), чтобы убедиться, что ничего не сломается, пока вы настраиваете параметры любых плагинов. <a style="text-decoration: none; color: #004567;" target="_blank" href="https://www.assetcleanup.com/docs/?p=372"><span class="dashicons dashicons-info"></span>&nbsp;Читать далее</a></p>
        <p style="margin-bottom: 0;">Если вы хотите полностью прекратить использование плагина как на странице администрирования, так и на странице внешнего интерфейса, наиболее эффективным способом будет его деактивация в разделе «Плагины» -> «Установленные плагины».</p>
    </div>
<?php
    include_once __DIR__.'/_admin-page-plugins-manager/_front.php';
} elseif ($data['wpacu_sub_page'] === 'manage_plugins_dash') {
    // [wpacu_pro]
	$wpacuShowPluginManagerForDash = true;

    $wpacuIsDashConstantSetToTrue   = defined('WPACU_ALLOW_DASH_PLUGIN_FILTER') && WPACU_ALLOW_DASH_PLUGIN_FILTER;
    $wpacuIsDashConstantNotInEffect = defined('WPACU_ALLOW_DASH_PLUGIN_FILTER_NOT_IN_EFFECT') && WPACU_ALLOW_DASH_PLUGIN_FILTER_NOT_IN_EFFECT;

    if ($wpacuIsDashConstantSetToTrue && $wpacuIsDashConstantNotInEffect) {
	    $wpacuShowPluginManagerForDash = false;
        ?>
        <div style="border-radius: 5px; line-height: 20px; background: white; padding: 8px; margin-bottom: 16px; width: 95%; border-left: 4px solid #cc0000; border-top: 1px solid #e7e7e7; border-right: 1px solid #e7e7e7; border-bottom: 1px solid #e7e7e7;">
            <p style="margin-top: 0;"><strong><span class="dashicons dashicons-warning" style="color: #cc0000;"></span> Похоже, требуемое изменение не было сделано правильно в течение <em>wp-config.php</em></strong>. <span class="dashicons dashicons-info"></span> <a target="_blank" href="https://www.assetcleanup.com/docs/?p=1128">Подробнее</a>. Фрагмент ниже должен быть добавлен, <strong>ПЕРЕД</strong> строкой со следующим текстом: <em style="color: grey;">/** Настраивает переменные WordPress и включаемые файлы. */</em>:</p>
            <p style="margin-top: 0;"><code>define('WPACU_ALLOW_DASH_PLUGIN_FILTER', true);</code></p>
            <p style="margin-top: 0;">Вот как это должно выглядеть:</p>
            <div style="margin-top: 0;">
            <pre style="margin: 0;"><code>define('WPACU_ALLOW_DASH_PLUGIN_FILTER', true);

/** Настраивает переменные WordPress и включаемые файлы. */
require_once(ABSPATH . 'wp-settings.php');</code>
                </pre>
            </div>
            <p style="margin: 0;">Как только фрагмент будет добавлен правильно, это уведомление исчезнет, ​​и список плагинов появится для управления.</p>
        </div>
        <?php
    } elseif (! $wpacuIsDashConstantSetToTrue) {
	    $wpacuShowPluginManagerForDash = false;
    ?>
        <div style="border-radius: 5px; line-height: 20px; background: white; padding: 8px; margin-bottom: 16px; width: 95%; border-left: 4px solid #cc0000; border-top: 1px solid #e7e7e7; border-right: 1px solid #e7e7e7; border-bottom: 1px solid #e7e7e7;">
            <p style="margin-top: 0;">Из-за характера этой функции, которая требует особой осторожности при выгрузке плагинов в панели инструментов, фрагмент кода (константа PHP) должен быть включен в <a target="_blank" href="https://wordpress.org/support/article/editing-wp-config-php/">файл <strong>wp-config.php</strong></a>.</p>

            <p style="margin-top: 0;">
                <?php if (defined('WPACU_ALLOW_DASH_PLUGIN_FILTER') && WPACU_ALLOW_DASH_PLUGIN_FILTER === false) { ?>
                    В настоящее время константа установлена ​​на <strong>false</strong>.
                <?php } elseif ( ! defined('WPACU_ALLOW_DASH_PLUGIN_FILTER') ) { ?>
                    В настоящее время константа вообще не установлена.
                <?php } ?>

                Фрагмент ниже должен быть добавлен, в идеале перед строкой со следующим текстом: <em style="color: grey;">/** Настраивает переменные WordPress и включаемые файлы. */</em>:
            </p>

            <p style="margin-top: 0;"><code>define('WPACU_ALLOW_DASH_PLUGIN_FILTER', true);</code></p>
            <p style="margin-top: 0;">Вот как это должно выглядеть:</p>
            <div style="margin-top: 0;">
            <pre style="margin: 0;"><code>define('WPACU_ALLOW_DASH_PLUGIN_FILTER', true);

/** Настраивает переменные WordPress и включаемые файлы. */
require_once(ABSPATH . 'wp-settings.php');</code>
                </pre>
            </div>
            <p style="margin: 0;">Как только фрагмент будет добавлен правильно, это уведомление исчезнет, ​​и список плагинов появится для управления.</p>
        </div>
    <?php
    }
	// [/wpacu_pro]
    ?>
    <div id="wpacu-plugins-manage-dash-notice-top">
        <p style="margin-top: 0;"><strong>Помните:</strong> использовать эту функцию рекомендуется только опытным пользователям (например, разработчикам/администраторам, которые очень хорошо знают свой веб-сайт и последствия выгрузки плагинов для определенных страниц) и тем, кому она действительно нужна. Установленное правило будет выгружать не только весь CSS/JS, который загружается из плагина, но и все остальное (например, его серверный PHP-код, вывод HTML, напечатанный с помощью хуков действий <code>admin_head()</code> или <code>admin_footer()</code>, любые установленные файлы cookie и т. д.).</p>
        <p style="margin-top: 0;">Причины использования этой функции включают в себя: некоторые страницы администрирования работают очень медленно, вы хотите избежать конфликта между двумя плагинами и т. д. Это похоже на деактивацию плагина в панели инструментов для страниц, на которых он выбран для выгрузки. Функция <code style="font-size: inherit;">is_admin()</code> используется для выполнения проверки, чтобы определить, находится ли пользователь на странице информационной панели. Если вы допустили ошибку и установили правило, запрещающее вам больше доступ к странице, вы можете отменить его, добавив к URL-адресу следующую строку запроса:<code>&amp;wpacu_no_dash_plugin_unload</code>, что позволяет вам изменить/удалить правило на этой странице управления. <a style="text-decoration: none; color: #004567;" target="_blank" href="https://www.assetcleanup.com/docs/?p=1128"><span class="dashicons dashicons-info"></span>&nbsp;Читать далее</a></p>
        <p style="margin-bottom: 0;">Если вы хотите полностью прекратить использование плагина как на странице администрирования, так и на странице внешнего интерфейса, наиболее эффективным способом будет его деактивация в разделе «Плагины» -> «Установленные плагины».</p>
    </div>
<?php
    // [wpacu_pro]
    if (! $wpacuShowPluginManagerForDash) {
        return; // stop here as the option is not enabled
    }
    // [/wpacu_pro]

	include_once __DIR__.'/_admin-page-plugins-manager/_dash.php';
}
