<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
	exit;
}
?>
<div style="margin: 25px 0 0;">
    <p>Таксономия по умолчанию (они находятся в «Сообщениях» » «Теги», доступ к ссылке тега показывает все сообщения, связанные с тегом) &#10230; <a target="_blank" href="https://wordpress.org/support/article/posts-tags-screen/"><?php _e('read more', 'wp-asset-clean-up'); ?></a></p>

    <strong>Как получить загруженные стили и скрипты?</strong>

    <p style="margin-bottom: 0;"><span class="dashicons dashicons-yes" style="color: green;"></span> Если «Управление на панели инструментов?» включен:</p>
    <p style="margin-top: 0;">Идти к <a target="_blank" href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=post_tag')); ?>">"Posts" &#187; "Tags"</a> &#187; [Выберите тег, для которого вы хотите управлять активами, и нажмите на его имя.] -&gt; Scroll to "<?php echo WPACU_PLUGIN_TITLE; ?>" область, где вы увидите загруженные файлы CSS и JavaScript.</p>
    <hr />
    <p style="margin-bottom: 0;"><span class="dashicons dashicons-yes" style="color: green;"></span> Если «Управление во внешнем интерфейсе?» включено, и вы вошли в систему:</p>
    <p style="margin-top: 0;">Перейдите на постоянную ссылку страницы категории (ссылка «Просмотреть» под ее названием в списке панели инструментов), например <code>//www.yoursite.com/blog/tag/the-tag-title-here/</code> где вы хотите управлять файлами и прокрутите страницу вниз, где вы увидите список.</p>
</div>