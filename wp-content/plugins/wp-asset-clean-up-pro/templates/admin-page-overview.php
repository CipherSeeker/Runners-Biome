<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
	exit;
}

include_once '_top-area.php';

if (! defined('WPACU_USE_MODAL_BOX')) {
	define('WPACU_USE_MODAL_BOX', true);
}
?>
<div class="wrap wpacu-overview-wrap">
    <div style="padding: 0 0 10px; line-height: 22px;"><strong>Примечание:</strong> Этот обзор содержит все изменения любого рода (правила выгрузки, исключения загрузки, предварительные загрузки, примечания, атрибуты async/defer SCRIPT, измененные позиции и т. д.), внесенные с помощью Asset CleanUp в любой из загруженных (поставленных в очередь) файлов CSS/JS, а также как плагины (например, выгружаются на определенных страницах). Чтобы внести какие-либо изменения в приведенные ниже значения, используйте вкладки «Менеджер CSS и JS», «Менеджер плагинов» или «Массовые изменения».</div>
    <div style="padding: 0 10px 0 0;">
        <?php
        include_once '_admin-page-overview-areas/_styles.php';

        // [wpacu_pro]
        include_once '_admin-page-overview-areas/_critical-css.php';
        // [/wpacu_pro]

        include_once '_admin-page-overview-areas/_scripts.php';

        // [wpacu_pro]
        include_once '_admin-page-overview-areas/_plugins-manager.php';
        // [/wpacu_pro]

        include_once '_admin-page-overview-areas/_page-options.php';
        include_once '_admin-page-overview-areas/_special-settings.php';
        ?>
    </div>
</div>