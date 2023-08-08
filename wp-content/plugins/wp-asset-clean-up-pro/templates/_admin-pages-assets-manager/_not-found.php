<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
	exit;
}
?>
<div style="margin: 25px 0 0;">
    <p>Эта страница (404.php в теме) открывается, когда запрос недействителен. Это может быть старая ссылка, которая больше не используется, или посетитель ввел неверный URL-адрес статьи. etc. (e.g. https://yourwebsite.com/this-is-a-non-existent-page.html). Активы могут быть выгружены <strong>только во внешнем интерфейсе</strong> (<em>должен быть включен параметр «Управление во внешнем интерфейсе?» на вкладке «Настройки»</em>). &#10230; <a target="_blank" href="https://codex.wordpress.org/Creating_an_Error_404_Page"><?php _e('read more', 'wp-asset-clean-up'); ?></a></p>
    <p><strong>Пример:</strong> <code>//www.yoursite.comn/blog/a-post-title-that-does-not-exist/</code></p>
    <hr />

    <strong>Как получить загруженные стили и скрипты?</strong>

    <p style="margin-bottom: 0;"><span class="dashicons dashicons-yes" style="color: green;"></span> Если «Управление во внешнем интерфейсе?» (<em>из "Настройки" -> "Настройки использования подключаемых модулей"</em>) включен, и вы вошли в систему:</p>
    <p style="margin-top: 0;">Перейдите на любую страницу, которая возвращает ошибку 404 (не имеет значения, какой URL у вас будет, поскольку правила выгрузки будут применяться ко всем страницам с ошибкой 404) и прокрутите до конца страницы, где вы увидите список.</p>
</div>
