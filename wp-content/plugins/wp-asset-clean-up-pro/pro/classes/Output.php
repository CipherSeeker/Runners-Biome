<?php
namespace WpAssetCleanUpPro;

use WpAssetCleanUp\Main;
use WpAssetCleanUp\Misc;

/**
 * Class Output
 * @package WpAssetCleanUpPro
 */
class Output
{
	/**
	 * Output constructor.
	 */
	public function __construct()
	{
		add_action('wpacu_pro_frontend_before_asset_list', array($this, 'frontendBeforeAssetList'));
		add_action('wpacu_pro_bulk_unload_output',         array($this, 'bulkUnloadOutput'), 10, 3);
	}

	/**
	 *
	 */
	public function frontendBeforeAssetList()
	{
	    global $wp_query;

		$object = $wp_query->get_queried_object();

		if (is_404()) {
			?>
			<p><strong><span style="color: #0f6cab;" class="dashicons dashicons-warning"></span> Это страница <u>404 (не найдена)</u>. Любые изменения, сделанные здесь, будут применены к любому URL-адресу, который возвращает ответ 404.</strong></p>
			<?php
		}

		elseif (Main::isWpDefaultSearchPage()) {
			?>
			<p><strong><span style="color: #0f6cab;" class="dashicons dashicons-search"></span> Это страница <u>Search</u> WordPress по умолчанию. Любые изменения, сделанные здесь, будут применены к любому поисковому запросу, сделанному на этой странице.</strong></p>
			<?php
		}

		elseif (is_author()) {
			$authorName = '';

			if (isset($object->data->ID)) {
				$authorName = ($object->data->display_name) ?: $object->data->user_login;
            } elseif (function_exists('get_the_author_meta')) {
                $authorName = get_the_author_meta('display_name') ?: get_the_author_meta('user_login');
			}
			?>
			<p><strong><span style="color: #0f6cab;" class="dashicons dashicons-admin-users"></span> Это вордпресс "<?php echo esc_html($authorName); ?>" <u>Страница архива автора</u>. Изменения также будут применены к страницам пагинации.</strong></p>
			<?php
		}

		elseif (is_date()) {
			?>
			<p><strong><span style="color: #0f6cab;" class="dashicons dashicons-calendar-alt"></span> Это вордпресс <u>Дата</u> страницы архива. Изменения также будут применены к страницам пагинации.</strong></p>
			<?php
		}

		elseif (is_tag()) {
		    $tagName = $object->name;
		    ?>
            <p><strong><span style="color: #0f6cab;" class="dashicons dashicons-tag"></span> Это вордпресс "<?php echo esc_html($tagName); ?>" <u>Отметить</u> страницу архива. Изменения также будут применены к страницам пагинации.</strong></p>
            <?php
        }

        elseif (isset($object->taxonomy)) {
		    $taxonomySlug = $object->taxonomy;

	        $isWooPage = false;

	        if (function_exists('is_woocommerce') && function_exists('is_product_category')
                && (is_woocommerce() || is_product_category())) {
		        $isWooPage = true;
	        }
		    ?>
            <p>
                <strong>
                <?php if ($isWooPage) { ?>
                    <img src="<?php echo esc_url(WPACU_PLUGIN_URL . '/assets/icons/woocommerce-icon-logo.svg'); ?>" alt="" style="height: 40px !important; margin-top: -6px; margin-right: 5px;" align="middle" />
                <?php } else { ?>
                    <span style="color: #0f6cab;" class="dashicons dashicons-category"></span><?php } ?> Это вордпресс "<?php echo esc_html($taxonomySlug); ?>" <u>Таксономия</u>. Изменения также будут применены к страницам пагинации..
                </strong>
            </p>
			<?php
        }
	}

	/**
	 * @param array $data
	 * @param object $obj
	 * @param string $assetType ('css' or 'js')
	 */
	public function bulkUnloadOutput($data, $obj, $assetType)
    {
        global $wp_query;

	    $object = $wp_query->get_queried_object();

	    // Taxonomy or Author page
        // Post Type is already added in the Lite version
        // 404, Search and Date pages are considered as "single" pages and do not belong to this group
        // e.g. Search page will have the same assets unloaded disregarding the keyword used for the search
        // Same thing for the 404 page (does not matter the requested not found URL)

        // Front-end view
	    if ( Main::instance()->isFrontendEditView && (! ( isset($object->taxonomy) || is_author()))) {
		    return;
	    }

	    // Dashboard view
	    if (Main::instance()->settings['dashboard_show']
            && isset($_REQUEST[WPACU_LOAD_ASSETS_REQ_KEY])
            && ! isset($_REQUEST['tag_id'])) {
		    return;
	    }

	    $keyString = false;

	    // $arrayKey is for bulk unload checkbox
	    if (Main::instance()->isFrontendEditView && isset($object->taxonomy)) {
		    $keyString = 'taxonomy';
		    $checkBoxArrayKeyValue = $object->taxonomy;
	    } elseif(Misc::getVar('request', 'wpacu_taxonomy') && Main::instance()->settings['dashboard_show']) {
		    $keyString = 'taxonomy';
		    $object = (object)array('taxonomy' => Misc::getVar('request', 'wpacu_taxonomy'));
		    $checkBoxArrayKeyValue = $object->taxonomy;
        }

	    if (is_author()) {
	        $keyString = 'author';
		    $checkBoxArrayKeyValue = 'all';
        }

        if (! $keyString) {
	        return;
        }

	    /*
		 * STYLES (.css)
		 */
        if ($assetType === 'css') {
	        $bulkUnloadedStyles = (isset($data['bulk_unloaded'][$keyString]['styles']) && ! empty($data['bulk_unloaded'][$keyString]['styles']));
	        $isBulkUnloadedAsset = $bulkUnloadedStyles && in_array( $obj->handle, $data['bulk_unloaded'][ $keyString ]['styles'] );
	        ?>
            <div class="wpacu_asset_options_wrap">
            <?php
            if ( $isBulkUnloadedAsset ) {
	            // Unloaded On Taxonomy Pages for the Selected Taxonomy (e.g. 'category', 'product_cat', 'post_tag' etc.)
	            if ( $keyString === 'taxonomy' ) {
		            ?>
                    <p><strong style="color: #d54e21;">Эта таблица стилей выгружается на всех
                            <u><?php echo esc_html($object->taxonomy); ?></u>
                            taxonomy pages.</strong></p>
                    <div style="height: 0; margin-top: -5px;" class="wpacu-clearfix"></div>
		            <?php
	            } elseif ( $keyString === 'author' ) {
		            ?>
                    <p><strong style="color: #d54e21;">Эта таблица стилей выгружается на всех страницах <u>author</u>.</strong>
                    </p>
                    <div style="height: 0; margin-top: -5px;" class="wpacu-clearfix"></div>
		            <?php
	            }
            }
	        ?>

            <ul class="wpacu_asset_options">
		        <?php
		        if ( $isBulkUnloadedAsset ) {
                ?>
                    <li>
                        <label><input data-handle="<?php echo esc_attr($obj->handle); ?>"
                                      class="wpacu_bulk_option wpacu_style wpacu_keep_bulk_rule"
                                      type="radio"
                                      name="wpacu_options_<?php echo esc_attr($keyString); ?>_styles[<?php echo esc_attr($obj->handle); ?>]"
                                      checked="checked"
                                      value="default"/>
                            Сохранить массовое правило</label>
                    </li>

                    <li>
                        <label><input data-handle="<?php echo esc_attr($obj->handle); ?>"
                                      class="wpacu_bulk_option wpacu_style wpacu_remove_bulk_rule"
                                      type="radio"
                                      name="wpacu_options_<?php echo esc_attr($keyString); ?>_styles[<?php echo esc_attr($obj->handle); ?>]"
                                      value="remove"/>
                            Удалить массовое правило</label>
                    </li>
			        <?php
		        } else {
                ?>
                    <li>
                        <label><input data-handle="<?php echo esc_attr($obj->handle); ?>"
                                      data-handle-for="style"
                                      class="wpacu_bulk_unload wpacu_<?php echo esc_attr($keyString); ?>_unload wpacu_<?php echo esc_attr($keyString); ?>_style"
                                      id="wpacu_bulk_unload_<?php echo esc_attr($keyString); ?>_style_<?php echo esc_attr($obj->handle); ?>"
                                      type="checkbox"
                                      name="wpacu_bulk_unload_styles[<?php echo esc_attr($keyString); ?>][<?php echo esc_attr($checkBoxArrayKeyValue); ?>][]"
                                      value="<?php echo esc_attr($obj->handle); ?>"/>

                            <?php if ($keyString === 'taxonomy') { ?>
                                Выгрузить на все страницы <strong><?php echo esc_attr($object->taxonomy); ?></strong> тип таксономии
                            <?php } elseif ($keyString === 'author') { ?>
                                Выгрузить на все страницы <strong>Автор</strong>
                            <?php } ?>
                            <small>* массовая разгрузка</small>
                        </label>
                    </li>
                <?php
		        }
		        ?>
            </ul>
        </div>
            <?php
            /*
             * SCRIPTS (.js)
             */
        } elseif ($assetType === 'js') {
	        $bulkUnloadedScripts = (isset($data['bulk_unloaded'][$keyString]['scripts']) && ! empty($data['bulk_unloaded'][$keyString]['scripts']));
	        $isBulkUnloadedAsset = $bulkUnloadedScripts && in_array( $obj->handle, $data['bulk_unloaded'][ $keyString ]['scripts'] );
	        ?>
            <div class="wpacu_asset_options_wrap">
		        <?php
                if ( $isBulkUnloadedAsset ) {
	                // Unloaded On Taxonomy Pages for the Selected Taxonomy (e.g. 'category', 'product_cat', 'post_tag' etc.)
	                if ( $keyString === 'taxonomy' ) {
		                ?>
                        <p><strong style="color: #d54e21;">Этот файл JavaScript выгружается на всех
                                <u><?php echo esc_html($object->taxonomy); ?></u>
                                taxonomy pages.</strong></p>
                        <div class="wpacu-clearfix" style="margin-top: -5px; height: 0;"></div>
		                <?php
	                } elseif ( $keyString === 'author' ) {
		                ?>
                        <p><strong style="color: #d54e21;">Этот файл JavaScript выгружается на всех страницах <u>author</u>..</strong>
                        </p>
                        <div class="wpacu-clearfix"></div>
		                <?php
	                }
                }
		        ?>

                <ul class="wpacu_asset_options">
			        <?php
			        if ( $isBulkUnloadedAsset ) {
				        ?>
                        <li>
                            <label><input data-handle="<?php echo esc_attr($obj->handle); ?>"
                                          class="wpacu_bulk_option wpacu_script wpacu_keep_bulk_rule"
                                          type="radio"
                                          name="wpacu_options_<?php echo esc_attr($keyString); ?>_scripts[<?php echo esc_attr($obj->handle); ?>]"
                                          checked="checked"
                                          value="default"/>
                                Сохранить правило</label>
                        </li>

                        <li>
                            <label><input data-handle="<?php echo esc_attr($obj->handle); ?>"
                                          class="wpacu_bulk_option wpacu_script wpacu_remove_bulk_rule"
                                          type="radio"
                                          name="wpacu_options_<?php echo esc_attr($keyString); ?>_scripts[<?php echo esc_attr($obj->handle); ?>]"
                                          value="remove"/>
                                Удалить массовое правило</label>
                        </li>
				        <?php
			        } else {
				        ?>
                        <li>
                            <label><input data-handle="<?php echo esc_attr($obj->handle); ?>"
                                          data-handle-for="script"
                                          class="wpacu_bulk_unload wpacu_<?php echo esc_attr($keyString); ?>_unload wpacu_<?php echo esc_attr($keyString); ?>_script"
                                          id="wpacu_bulk_unload_<?php echo esc_attr($keyString); ?>_script_<?php echo esc_attr($obj->handle); ?>"
                                          type="checkbox"
                                          name="wpacu_bulk_unload_scripts[<?php echo esc_attr($keyString); ?>][<?php echo esc_attr($checkBoxArrayKeyValue); ?>][]"
                                          value="<?php echo esc_attr($obj->handle); ?>"/>

	                            <?php if ($keyString === 'taxonomy') { ?>
                                    Выгрузить на все страницы <strong><?php echo esc_html($object->taxonomy); ?></strong> taxonomy type
	                            <?php } elseif ($keyString === 'author') { ?>
                                    Выгрузить на все страницы <strong>Автор</strong>
	                            <?php } ?>
                                <small>* массовая разгрузка</small>
                            </label>
                        </li>
				        <?php
			        }
			        ?>
                </ul>
            </div>
            <?php
        }
    }
}
