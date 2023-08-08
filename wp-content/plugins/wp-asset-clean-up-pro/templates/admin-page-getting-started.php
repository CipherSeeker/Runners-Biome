<?php
/*
 * No direct access to this file
 */
if (! isset($data)) {
    exit;
}
?>
<div class="wpacu-wrap">
    <div class="about-wrap wpacu-about-wrap">
        <h1><?php echo sprintf(__('Welcome to %s %s', 'wp-asset-clean-up'), WPACU_PLUGIN_TITLE, WPACU_PRO_PLUGIN_VERSION); ?></h1>
        <p class="about-text wpacu-about-text">
            Благодарим вас за установку этого премиального плагина для ускорения страницы! Приготовьтесь сделать свой веб-сайт WordPress быстрее и легче, удалив бесполезные файлы CSS и JavaScript со своих страниц. Для максимальной производительности<?php echo WPACU_PLUGIN_TITLE; ?> лучше всего работает при использовании либо с плагином кэширования, либо со встроенным кэшированием хостинга (например, <a style="text-decoration: none; color: #555d66;" href="https://www.gabelivan.com/visit/wp-engine">WPEngine</a>, Кинста есть) или что-то вроде Varnish.
            <img src="<?php echo esc_url(WPACU_PLUGIN_URL); ?>/assets/images/wpacu-logo-transparent-bg-v1.png" alt="" />
        </p>

        <h2 class="nav-tab-wrapper wp-clearfix">
            <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_getting_started&wpacu_for=how-it-works')); ?>" class="nav-tab <?php if ($data['for'] === 'how-it-works') { ?>nav-tab-active<?php } ?>"><?php _e('How it works', 'wp-asset-clean-up'); ?></a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_getting_started&wpacu_for=benefits-fast-pages')); ?>" class="nav-tab <?php if ($data['for'] === 'benefits-fast-pages') { ?>nav-tab-active<?php } ?>"><?php _e('Benefits of a Fast Website', 'wp-asset-clean-up'); ?></a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_getting_started&wpacu_for=start-optimization')); ?>" class="nav-tab <?php if ($data['for'] === 'start-optimization') { ?>nav-tab-active<?php } ?>"><?php _e('Start Optimization', 'wp-asset-clean-up'); ?></a>
            <a href="<?php echo esc_url(admin_url('admin.php?page=wpassetcleanup_getting_started&wpacu_for=video-tutorials')); ?>" class="nav-tab <?php if ($data['for'] === 'video-tutorials') { ?>nav-tab-active<?php } ?>"><span class="dashicons dashicons-video-alt3" style="color: #ff0000;"></span> <?php _e('Video Tutorials', 'wp-asset-clean-up'); ?></a>
        </h2>

        <div class="about-wrap-content">
	        <?php
	        if ($data['for'] === 'how-it-works') {
		        include_once '_admin-page-getting-started-areas/_how-it-works.php';
	        } elseif ($data['for'] === 'benefits-fast-pages') {
		        include_once '_admin-page-getting-started-areas/_benefits-fast-pages.php';
	        } elseif ($data['for'] === 'start-optimization') {
		        include_once '_admin-page-getting-started-areas/_start-optimization.php';
	        } elseif ($data['for'] === 'video-tutorials') {
		        include_once '_admin-page-getting-started-areas/_video-tutorials.php';
	        }
            ?>
        </div>
    </div>
</div>