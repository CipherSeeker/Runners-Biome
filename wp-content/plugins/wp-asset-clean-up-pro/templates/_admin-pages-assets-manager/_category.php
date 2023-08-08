<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
	exit;
}
?>
<div style="margin: 25px 0 0;">
    <p>Таксономия по умолчанию (они находятся в «Сообщения» » «Категории», доступ к ссылке на категорию показывает все сообщения из этой категории) &#10230; <a target="_blank" href="https://wordpress.org/support/article/posts-categories-screen/"><?php _e('read more', 'wp-asset-clean-up'); ?></a></p>

    <strong>Как получить загруженные стили и скрипты?</strong>

    <p style="margin-bottom: 0;"><span class="dashicons dashicons-yes" style="color: green;"></span> Если «Управление на панели инструментов?» включен:</p>
    <p style="margin-top: 0;">Идти к <a target="_blank" href="<?php echo esc_url(admin_url('edit-tags.php?taxonomy=category')); ?>">"Posts" &#187; "Categories"</a> &#187; [Выберите категорию, для которой вы хотите управлять активами, и нажмите на ее название.] -&gt; Scroll to "<?php echo esc_html(WPACU_PLUGIN_TITLE); ?>" область, где вы увидите загруженные файлы CSS и JavaScript.</p>
    <hr />
    <p style="margin-bottom: 0;"><span class="dashicons dashicons-yes" style="color: green;"></span> Если «Управление во внешнем интерфейсе?» включен, и вы вошли в систему:</p>
    <p style="margin-top: 0;">Перейти на постоянную ссылку страницы категории (ссылка «Просмотреть» под ее названием в списке Dashboard)) such as <code>/www.yoursite.com/category/my-category-title/</code> где вы хотите управлять файлами и прокрутите страницу вниз, где вы увидите список.</p>
</div>
