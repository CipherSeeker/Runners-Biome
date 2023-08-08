<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
	exit;
}

$assetsPositionsClass = new \WpAssetCleanUpPro\Positions();
$assetsPositions = $assetsPositionsClass->getAssetsPositions();

$hasChangedStylesPositions  = isset($assetsPositions['styles'])  && ! empty($assetsPositions['styles']);
$hasChangedScriptsPositions = isset($assetsPositions['scripts']) && ! empty($assetsPositions['scripts']);

$isUpdateable = $hasChangedStylesPositions || $hasChangedScriptsPositions;

do_action('wpacu_admin_notices');
?>
<p>Это список всех CSS/JS, исходное положение которых было изменено (например, из <code>&lt;HEAD&gt;</code> to <code>&lt;BODY&gt;</code> (также известный как: нижний колонтитул) для уменьшения ресурсов, блокирующих рендеринг, или от <code>&lt;BODY&gt;</code> to <code>&lt;HEAD&gt;</code> для раннего запуска).</p>

<form action="" method="post">
    <h2>Styles (.css)</h2>
<?php if ($hasChangedStylesPositions) { ?>
    <table style="width: 96%;" class="wp-list-table widefat fixed striped">
        <tr>
            <td style="width: 320px;"><strong>Handle</strong></td>
            <td style="width: 150px;">Initial Position</td>
            <td style="width: 150px;"><strong>Current Position</strong></td>
            <td><strong>Действия</strong></td>
        </tr>

        <?php
        ksort($assetsPositions['styles']);

        foreach ($assetsPositions['styles'] as $styleHandle => $styleNewPosition) {
            $initialPosition = ($styleNewPosition === 'body') ? '&lt;HEAD&gt;' : '&lt;BODY&gt;';
            $newPosition     = ($styleNewPosition === 'body') ? '&lt;BODY&gt;' : '&lt;HEAD&gt;';
        ?>
            <tr class="wpacu_restore_position_row">
                <td><?php wpacuRenderHandleTd($styleHandle, 'styles', $data); ?></td>
                <td><code><?php echo esc_html($initialPosition); ?></code></td>
                <td><code style="color: #004567; font-weight: bold;"><?php echo esc_html($newPosition); ?></code></td>
                <td>
                    <label><input type="checkbox"
                                  class="wpacu_restore_position"
                                  name="wpacu_styles_new_positions[<?php echo esc_attr($styleHandle); ?>]"
                                  value="remove" /> Переместите тег ссылки CSS обратно в <?php echo esc_html($initialPosition); ?></label>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php } else { ?>
    <p>Нет никаких изменений относительно положения тега LINK ни для одного из файлов CSS.</p>
    <?php } ?>

<div style="margin: 20px 0; width: 96%;">
    <hr/>
</div>

    <h2>Scripts (.js)</h2>
<?php if ($hasChangedScriptsPositions) { ?>
    <table style="width: 96%;" class="wp-list-table widefat fixed striped">
        <tr>
            <td style="width: 320px;"><strong>Handle</strong></td>
            <td style="width: 150px;">Initial Position</td>
            <td style="width: 150px;"><strong>Current Position</strong></td>
            <td><strong>Действия</strong></td>
        </tr>

	    <?php
	    ksort($assetsPositions['scripts']);

	    foreach ($assetsPositions['scripts'] as $scriptHandle => $scriptNewPosition) {
		    $initialPosition = ($scriptNewPosition === 'body') ? '&lt;HEAD&gt;' : '&lt;BODY&gt;';
		    $newPosition     = ($scriptNewPosition === 'body') ? '&lt;BODY&gt;' : '&lt;HEAD&gt;';
		    ?>
            <tr class="wpacu_restore_position_row">
                <td><?php wpacuRenderHandleTd($scriptHandle, 'scripts', $data); ?></td>
                <td><code><?php echo esc_html($initialPosition); ?></code></td>
                <td><code style="color: #004567; font-weight: bold;"><?php echo esc_html($newPosition); ?></code></td>
                <td>
                    <label><input type="checkbox"
                                  class="wpacu_restore_position"
                                  name="wpacu_scripts_new_positions[<?php echo esc_attr($scriptHandle); ?>]"
                                  value="remove" /> Move JS script tag back to <?php echo esc_html($initialPosition); ?></label>
                </td>
            </tr>
		    <?php
	    }
	    ?>
    </table>
<?php } else { ?>
    <p>Нет никаких изменений в отношении положения тега SCRIPT ни для одного из файлов JavaScript..</p>
<?php } ?>

    <?php
    if ($isUpdateable) {
	    wp_nonce_field('wpacu_restore_assets_positions', 'wpacu_restore_assets_positions_nonce');
    }
    ?>
    <div id="wpacu-update-button-area" class="no-left-margin">
        <p style="margin: 20px 0 0 0;">
            <input type="submit"
                   name="submit"
                   <?php if (! $isUpdateable) { ?>disabled="disabled"<?php } ?>
                   class="wpacu-restore-pos-btn button button-primary"
                   value="Restore position of chosen CSS/JS" />

            <?php
            if (! $isUpdateable) {
                ?>
                &nbsp;&nbsp; <small>Примечание. Поскольку ни для одного CSS/JS позиции не меняются, кнопка обновления не активна..</small>
                <?php
            }
            ?>
        </p>
        <div id="wpacu-updating-settings" style="margin-left: 266px; top: 21px;">
            <img src="<?php echo esc_url(admin_url('images/spinner.gif')); ?>" align="top" width="20" height="20" alt="" />
        </div>
    </div>
</form>