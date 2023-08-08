<?php
/*
 * No direct access to this file
 */
if (! isset($data, $selectedTabArea, $selectedSubTabArea)) {
	exit;
}

$tabIdArea = 'wpacu-setting-google-fonts';
$styleTabContent = ($selectedTabArea === $tabIdArea) ? 'style="display: table-cell;"' : '';

$ddOptions = array(
    'swap' => 'swap (most used)',
    'auto' => 'auto',
    'block' => 'block',
    'fallback' => 'fallback',
    'optional' => 'optional'
);
?>
<div id="<?php echo esc_attr($tabIdArea); ?>" class="wpacu-settings-tab-content" <?php echo wp_kses($styleTabContent, array('style' => array())); ?>>
	<h2 class="wpacu-settings-area-title"><?php _e('Google Fonts: Load Optimizer', 'wp-asset-clean-up'); ?></h2>

    <div class="wpacu-sub-tabs-wrap"> <!-- Sub-tabs wrap -->
        <!-- Sub-nav menu -->
        <input class="wpacu-nav-input"
               id="wpacu-google-fonts-optimize-tab-item"
               type="radio"
               name="wpacu_sub_tab_area"
               value="wpacu-google-fonts-optimize"
               <?php if (in_array($selectedSubTabArea, array('wpacu-google-fonts-optimize', ''))) { ?>checked="checked"<?php } ?> />
        <label class="wpacu-nav-label"
               for="wpacu-google-fonts-optimize-tab-item">Оптимизация доставки шрифтов</label>

        <input class="wpacu-nav-input"
               id="wpacu-google-fonts-remove-tab-item"
               type="radio"
               name="wpacu_sub_tab_area"
               value="wpacu-google-fonts-remove"
               <?php if ($selectedSubTabArea === 'wpacu-google-fonts-remove') { ?>checked="checked"<?php } ?> />
        <label class="wpacu-nav-label"
               for="wpacu-google-fonts-remove-tab-item">Убрать все</label>
        <!-- /Sub-nav menu -->

        <section class="wpacu-sub-tabs-item" id="wpacu-google-fonts-optimize-tab-item-area">
            <?php include_once __DIR__.'/_fonts-google/_optimize-area.php'; ?>
        </section>
        <section class="wpacu-sub-tabs-item" id="wpacu-google-fonts-remove-tab-item-area">
	        <?php include_once __DIR__.'/_fonts-google/_remove-area.php'; ?>
        </section>
    </div> <!-- /Sub-tabs wrap -->
</div>

<div id="wpacu-google-fonts-display-info" class="wpacu-modal" style="padding-top: 70px;">
    <div class="wpacu-modal-content" style="max-width: 800px;">
        <span class="wpacu-close">&times;</span>
        <h3 style="margin-top: 2px; margin-bottom: 5px;">font-display: <span style="background: #f2faf2;">swap</span></h3>
        <p style="margin-top: 0; margin-bottom: 24px;">Текст отображается немедленно (без точки блокировки, без невидимого текста) в резервном шрифте до тех пор, пока не загрузится пользовательский шрифт, а затем он заменяется пользовательским шрифтом. Вы получаете <strong>FOUT</strong> (<em>мигание нестилизованного текста</em>).</p>

        <h3 style="margin-bottom: 5px;">font-display: <span style="background: #f2faf2;">block</span></h3>
        <p style="margin-top: 0; margin-bottom: 24px;">Текст блокируется (невидим) на короткий период. Затем, если пользовательский шрифт еще не был загружен, браузер меняет местами (отображает текст в резервном шрифте) столько времени, сколько требуется для загрузки пользовательского шрифта, а затем повторно отображает текст в пользовательском шрифте. Вы получаете <strong>FOIT</strong> (<em>вспышку невидимого текста</em>).</p>

        <h3 style="margin-bottom: 5px;">font-display: <span style="background: #f2faf2;">fallback</span></h3>
        <p style="margin-top: 0; margin-bottom: 24px;">Это что-то среднее между блоком и обменом. Текст невидим в течение короткого периода времени (100 мс). Затем, если пользовательский шрифт не загружен, текст отображается резервным шрифтом (около 3 с), а затем меняется местами после загрузки пользовательского шрифта.</p>

        <h3 style="margin-bottom: 5px;">font-display: <span style="background: #f2faf2;">optional</span></h3>
        <p style="margin-top: 0; margin-bottom: 24px;">Это ведет себя так же, как резервный вариант, только браузер может решить вообще не использовать пользовательский шрифт в зависимости от скорости соединения пользователя (если у вас медленный 3G или меньше, загрузка пользовательского шрифта и последующая замена будут занимать целую вечность). будет поздно и крайне раздражает)</p>

        <h3 style="margin-bottom: 5px;">font-display: <span style="background: #f2faf2;">auto</span></h3>
        <p style="margin-top: 0; margin-bottom: 0;">По умолчанию. Будет иметь место типичное поведение загрузки шрифта браузера. Такое поведение может быть FOIT или FOIT с относительно длительным периодом невидимости. Это может измениться, поскольку поставщики браузеров решат улучшить поведение по умолчанию..</p>
    </div>
</div>