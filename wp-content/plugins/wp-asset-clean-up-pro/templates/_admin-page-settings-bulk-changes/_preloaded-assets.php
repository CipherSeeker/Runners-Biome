<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
	exit;
}

if (! defined('WPACU_USE_MODAL_BOX')) {
	define('WPACU_USE_MODAL_BOX', true);
}

use WpAssetCleanUp\Preloads;

$assetsPreloaded = Preloads::instance()->getPreloads();

$hasCssPreloads = isset($assetsPreloaded['styles'])  && ! empty($assetsPreloaded['styles']);
$hasJsPreloads  = isset($assetsPreloaded['scripts']) && ! empty($assetsPreloaded['scripts']);

$isUpdateable = $hasCssPreloads || $hasJsPreloads;

do_action('wpacu_admin_notices');
?>
<p>Это список всех предварительно загруженных CSS/JS.. &nbsp;&nbsp;<a id="wpacu-preloaded-assets-info-target" href="#wpacu-preloaded-assets-info" style="text-decoration: none;"><span class="dashicons dashicons-info"></span> How the list below gets filled?</a></p>

<form action="" method="post">
    <h2>Styles (.css)</h2>
	<?php if ($hasCssPreloads) { ?>
        <table style="width: 96%;" class="wp-list-table widefat fixed striped">
            <tr>
                <td style="min-width: 400px;"><strong>Handle</strong></td>
                <td><strong>Действия</strong></td>
            </tr>

			<?php
			ksort($assetsPreloaded['styles']);

			foreach ($assetsPreloaded['styles'] as $styleHandle => $preloadedStatus) {
				?>
                <tr class="wpacu_bulk_change_row">
                    <td>
                        <?php
	                    $data['assets_info'][ 'styles' ][ $styleHandle ] ['preloaded_status'] = $preloadedStatus;
                        wpacuRenderHandleTd($styleHandle, 'styles', $data);
                        ?>
                    </td>
                    <td>
                        <label><input type="checkbox"
                                      class="wpacu_remove_preload"
                                      name="wpacu_styles_remove_preloads[<?php echo esc_attr($styleHandle); ?>]"
                                      value="remove" /> Удалить предварительную загрузку для этого файла CSS</label>
                    </td>
                </tr>
				<?php
			}
			?>
        </table>
	<?php } else { ?>
        <p>Нет предварительно загруженных таблиц стилей.</p>
	<?php } ?>

    <div style="margin: 20px 0; width: 96%;">
        <hr/>
    </div>

    <h2>Scripts (.js)</h2>
	<?php if ($hasJsPreloads) { ?>
        <table style="width: 96%;" class="wp-list-table widefat fixed striped">
            <tr>
                <td style="min-width: 400px;"><strong>Handle</strong></td>
                <td><strong>Actions</strong></td>
            </tr>

			<?php
			ksort($assetsPreloaded['scripts']);

			foreach ($assetsPreloaded['scripts'] as $scriptHandle => $preloadedStatus) {
				?>
                <tr class="wpacu_bulk_change_row">
                    <td><?php wpacuRenderHandleTd($scriptHandle, 'scripts', $data); ?></td>
                    <td>
                        <label><input type="checkbox"
                                      class="wpacu_remove_preload"
                                      name="wpacu_scripts_remove_preloads[<?php echo esc_attr($scriptHandle); ?>]"
                                      value="remove" /> Удалить предварительную загрузку для этого JS-файла</label>
                    </td>
                </tr>
				<?php
			}
			?>
        </table>
	<?php } else { ?>
        <p>Предустановленных скриптов нет.</p>
	<?php } ?>

	<?php
	if ($isUpdateable) {
		wp_nonce_field('wpacu_remove_preloaded_assets', 'wpacu_remove_preloaded_assets_nonce');
	}
	?>
    <div id="wpacu-update-button-area" class="no-left-margin">
        <p style="margin: 20px 0 0 0;">
            <input type="submit"
                   name="submit"
                   <?php if (! $isUpdateable) { ?>disabled="disabled"<?php } ?>
                   class="wpacu-remove-preloads-btn button button-primary"
                   value="Remove preload for chosen CSS/JS" />

            <?php
            if (! $isUpdateable) {
                ?>
                &nbsp;&nbsp; <small>Примечание. Поскольку предварительно загруженных CSS/JS нет, кнопка обновления не активна..</small>
                <?php
            }
            ?>
        </p>
        <div id="wpacu-updating-settings" style="margin-left: 285px; top: 10px;">
            <img src="<?php echo esc_url(admin_url('images/spinner.gif')); ?>" align="top" width="20" height="20" alt="" />
        </div>
    </div>
</form>

<!-- Start Site-Wide Modal -->
<div id="wpacu-preloaded-assets-info" class="wpacu-modal">
    <div class="wpacu-modal-content">
        <span class="wpacu-close">&times;</span>
        <h2><?php _e('Preloading CSS/JS site-wide', 'wp-asset-clean-up'); ?></h2>
        <p>Это обзор всех активов (таблиц стилей и скриптов), которые были выбраны для предварительной загрузки. Все, что вы видите на этой странице, заполняется в тот момент, когда вы переходите к редактированию страницы через «Диспетчер загрузки CSS/JS» (например, домашнюю страницу или сообщение) и используете опцию «Предварительная загрузка» (раскрывающийся список) для любого из ресурсов.</p>

        <p>Предварительную загрузку для CSS/JS также можно удалить, отредактировав страницу, загружающую этот конкретный файл, и просто выбрав вариант «Нет (по умолчанию)».</p>

        <p>Это считается массовым изменением, поскольку предварительная загрузка выбранного файла применяется ко всему сайту (а не только к странице, на которой вы активировали предварительную загрузку).</p>
    </div>
</div>
<!-- End Site-Wide Modal -->