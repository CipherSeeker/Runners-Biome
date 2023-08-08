<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
    exit;
}

include_once '_top-area.php';
?>
<div class="wpacu-wrap wpacu-get-help-wrap">
    <!-- [wpacu_pro] -->
    <p>Go to: &nbsp; <span class="dashicons dashicons-welcome-learn-more"></span> <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_getting_started')); ?>">Начиная</a> &nbsp;&nbsp; <span class="dashicons dashicons-text-page"></span> <a target="_blank" href="https://assetcleanup.com/docs/?utm_source=plugin_help_page_pro">Документация</a></p>
    <!-- [/wpacu_pro] -->

    <p>If you believe <?php echo WPACU_PLUGIN_TITLE; ?> имеет ошибку (например, вы получаете ошибки JavaScript или PHP, сгенерированные <?php echo WPACU_PLUGIN_TITLE; ?> или выбранные скрипты не выгружаются и т.д.) что нужно исправить, то <a target="_blank" href="https://www.gabelivan.com/contact/">сообщите об этом, открыв заявку в службу поддержки</a>. Обратите внимание, что поддержка предназначена только для сообщений об ошибках и любой несовместимости с темами/плагинами, а не для пользовательских запросов на работу.</p>

    <hr />
    <h2><?php _e('In case you are stuck, need assistance or just want to save time you would spend for your website optimization, we can help you!', 'wp-asset-clean-up'); ?></h2>

    <p>Если к вам применимы следующие сценарии и у вас нет разработчика, который мог бы предоставить то, что вам нужно, то я или любой из моих коллег из <a href="https://codeable.io/developers/speed-optimization/?ref=d3TOr">Кодируемый</a>, мог бы помочь вам:</p>

    <ul class="hire-reasons">
        <li><span class="dashicons dashicons-yes"></span> У вас на странице загружено много файлов CSS и JavaScript, и вы не знаете, какие из них можно запретить загружать, опасаясь, что что-то может быть напутано. Эксперт Codeable может проанализировать ваши страницы и дать необходимые советы.</li>
        <li><span class="dashicons dashicons-yes"></span> Вы хотите повысить скорость своего веб-сайта, и вам нужна помощь в ускорении загрузки страницы и улучшении оценки Google PageSpeed.</li>
        <li><span class="dashicons dashicons-yes"></span> Вам нужна помощь с задачей WordPress, и вы ищете профессионала, который поможет вам во всем, что вам нужно.</li>
        <li><span class="dashicons dashicons-yes"></span> Вы хотите полностью оптимизировать свой веб-сайт, чтобы получить как можно более высокий показатель скорости страницы.</li>
    </ul>

            <p><strong>Начать работу легко:</strong></p>
            <ol class="getting-started">
                <li>Объясните потребности или проблемы вашего веб-сайта</li>
                <li>Эксперты обращаются к вам с вопросами и оценками.</li>
                <li>Вы выбираете того, с кем хотите работать.</li>
            </ol>

            <div class="wpacu-clearfix"></div>
            <hr /><br />

            <div class="wpacu-btns">
                <a class="btn btn-success" href="https://codeable.io/developers/speed-optimization/?ref=d3TOr"><?php _e('Hire a Speed Optimization Expert', 'wp-asset-clean-up'); ?></a>
                &nbsp;&nbsp;
                <a class="btn btn-secondary" href="https://codeable.io/?ref=d3TOr"><?php _e('Find out more', 'wp-asset-clean-up'); ?></a>
            </div>
        </div>
    </div>
</div>