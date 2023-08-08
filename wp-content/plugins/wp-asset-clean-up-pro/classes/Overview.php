<?php
namespace WpAssetCleanUp;

/**
 *
 * Class Overview
 * @package WpAssetCleanUp
 */
class Overview
{
	/**
	 * @var array
	 */
	public $data = array(
        'page_options_to_text' => array(
	        'no_css_minify'      => 'Не минифицировать CSS',
	        'no_css_optimize'    => 'Не комбинируйте CSS',
            'no_js_minify'       => 'Не минифицировать JS',
	        'no_js_optimize'     => 'Не совмещайте JS',
            'no_assets_settings' => 'Не применяйте никакие настройки CSS и JavaScript (включая предварительную загрузку, «асинхронность», «отсрочку» и любые правила выгрузки)',
            'no_wpacu_load'      => 'Не загружать %s на этой странице'
        )
    );

	/**
	 * Overview constructor.
	 */
	public function __construct()
    {
        // The code initiated in this function is relevant only in the "Overview" page
        if (Misc::getVar('request', 'page') !== WPACU_PLUGIN_ID . '_overview') {
            return;
        }

        $this->data['page_options_to_text']['no_wpacu_load'] = sprintf(__($this->data['page_options_to_text']['no_wpacu_load'], 'wp-asset-clean-up'), WPACU_PLUGIN_TITLE);

        // [START] Clear load exceptions for a handle
	    $transientName = 'wpacu_load_exceptions_cleared';
	    if ( isset( $_POST['wpacu_action'], $_POST['wpacu_handle'], $_POST['wpacu_asset_type'] )
	         && ( $wpacuAction = $_POST['wpacu_action'] )
	         && ( $wpacuHandle = $_POST['wpacu_handle'] )
	         && ( $wpacuAssetType = $_POST['wpacu_asset_type'] ) && $wpacuAction === 'clear_load_exceptions'
        ) {
	        check_admin_referer('wpacu_clear_load_exceptions', 'wpacu_clear_load_exceptions_nonce');
            Maintenance::removeAllLoadExceptionsFor($wpacuHandle, $wpacuAssetType);
            set_transient($transientName, array('handle' => $wpacuHandle, 'type' => $wpacuAssetType));
            wp_redirect(admin_url('admin.php?page=wpassetcleanup_overview&wpacu_load_exceptions_cleared=1'));
            exit();
        }

	    if (Misc::getVar('get', 'wpacu_load_exceptions_cleared') && $transientData = get_transient($transientName)) {
	        add_action('admin_notices', static function() use ($transientData, $transientName) {
		        $wpacuAssetTypeToPrint = ($transientData['type'] === 'styles') ? 'CSS' : 'JavaScript';
	            ?>
                <div class="notice wpacu-notice-info is-dismissible">
                    <p><span style="color: #008f9c; font-size: 26px; margin-right: 4px; vertical-align: text-bottom; margin-bottom: 0;" class="dashicons dashicons-yes"></span> <?php echo sprintf(__('The load exception rules for the `<strong>%s</strong>` %s handle have been removed.', 'wp-asset-clean-up'), $transientData['handle'], $wpacuAssetTypeToPrint); ?></p>
                </div>
                <?php
                delete_transient($transientName);
            }, PHP_INT_MAX);
        }
	    // [END] Clear load exceptions for a handle

	    // [START] Clear all rules for the chosen "orphaned" handle
	    $transientName = 'wpacu_all_rules_cleared';
	    if ( isset( $_POST['wpacu_action'], $_POST['wpacu_handle'], $_POST['wpacu_asset_type'] )
	         && ( $wpacuAction = $_POST['wpacu_action'] )
	         && ( $wpacuHandle = $_POST['wpacu_handle'] )
	         && ( $wpacuAssetType = $_POST['wpacu_asset_type'] ) && $wpacuAction === 'clear_all_rules'
	    ) {
		    check_admin_referer('wpacu_clear_all_rules', 'wpacu_clear_all_rules_nonce');
		    Maintenance::removeAllRulesFor($wpacuHandle, $wpacuAssetType);
		    set_transient('wpacu_all_rules_cleared', array('handle' => $wpacuHandle, 'type' => $wpacuAssetType));
		    wp_redirect(admin_url('admin.php?page=wpassetcleanup_overview&wpacu_all_rules_cleared=1'));
		    exit();
	    }

	    if (Misc::getVar('get', 'wpacu_all_rules_cleared') && $transientData = get_transient($transientName)) {
		    add_action('admin_notices', static function() use ($transientData, $transientName) {
			    $wpacuAssetTypeToPrint = ($transientData['type'] === 'styles') ? 'CSS' : 'JavaScript';
			    ?>
                <div class="notice wpacu-notice-info is-dismissible">
                    <p><span style="color: #008f9c; font-size: 26px; margin-right: 4px; vertical-align: text-bottom; margin-bottom: 0;" class="dashicons dashicons-yes"></span> <?php echo sprintf(__('All the rules were cleared for the orphaned `<strong>%s</strong>` %s handle.', 'wp-asset-clean-up'), $transientData['handle'], $wpacuAssetTypeToPrint); ?></p>
                </div>
			    <?php
			    delete_transient($transientName);
		    }, PHP_INT_MAX);
	    }
	    // [END] Clear all rules for the chosen "orphaned" handle

	    // [START] Clear all redundant unload rules (if the site-wide one is already enabled)
	    $transientName = 'wpacu_all_redundant_unload_rules_cleared';
	    if ( isset( $_POST['wpacu_action'], $_POST['wpacu_handle'], $_POST['wpacu_asset_type'] )
	         && ( $wpacuAction = $_POST['wpacu_action'] )
	         && ( $wpacuHandle = $_POST['wpacu_handle'] )
	         && ( $wpacuAssetType = $_POST['wpacu_asset_type'] ) && $wpacuAction === 'clear_all_redundant_unload_rules'
	    ) {
		    check_admin_referer('wpacu_clear_all_redundant_rules', 'wpacu_clear_all_redundant_rules_nonce');
		    Maintenance::removeAllRedundantUnloadRulesFor($wpacuHandle, $wpacuAssetType);
		    set_transient($transientName, array('handle' => $wpacuHandle, 'type' => $wpacuAssetType));
		    wp_redirect(admin_url('admin.php?page=wpassetcleanup_overview&wpacu_all_redundant_unload_rules_cleared=1'));
		    exit();
	    }

	    if (Misc::getVar('get', 'wpacu_all_redundant_unload_rules_cleared') && $transientData = get_transient($transientName)) {
		    add_action('admin_notices', static function() use ($transientData, $transientName) {
			    $wpacuAssetTypeToPrint = ($transientData['type'] === 'styles') ? 'CSS' : 'JavaScript';
			    ?>
                <div class="notice wpacu-notice-info is-dismissible">
                    <p><span style="color: #008f9c; font-size: 26px; margin-right: 4px; vertical-align: text-bottom; margin-bottom: 0;" class="dashicons dashicons-yes"></span> <?php echo sprintf(__('All the redundant unload rules were cleared for the `<strong>%s</strong>` %s handle, leaving the only one relevant: `site-wide (everywhere)`.', 'wp-asset-clean-up'), $transientData['handle'], $wpacuAssetTypeToPrint); ?></p>
                </div>
			    <?php
			    delete_transient($transientName);
		    }, PHP_INT_MAX);
	    }
	    // [END] Clear all redundant unload rules (if the site-wide one is already enabled)
    }

    /**
	 * @return array
	 */
	public static function handlesWithAtLeastOneRule()
    {
        global $wpdb;

	    $wpacuPluginId = WPACU_PLUGIN_ID;

	    $allHandles = array();

	    /*
		 * Per page rules (unload, load exceptions if a bulk rule is enabled, async & defer for SCRIPT tags)
		 */
	    // Homepage (Unloads)
	    $wpacuFrontPageUnloads = get_option(WPACU_PLUGIN_ID . '_front_page_no_load');

	    if ($wpacuFrontPageUnloads) {
		    $wpacuFrontPageUnloadsArray = @json_decode( $wpacuFrontPageUnloads, ARRAY_A );

		    foreach (array('styles', 'scripts') as $assetType) {
			    if ( isset( $wpacuFrontPageUnloadsArray[$assetType] ) && ! empty( $wpacuFrontPageUnloadsArray[$assetType] ) ) {
				    foreach ( $wpacuFrontPageUnloadsArray[$assetType] as $assetHandle ) {
					    $allHandles[$assetType][ $assetHandle ]['unload_on_home_page'] = 1;
					    }
			    }
		    }
	    }

	    // Homepage (Load Exceptions)
	    $wpacuFrontPageLoadExceptions = get_option(WPACU_PLUGIN_ID . '_front_page_load_exceptions');

	    if ($wpacuFrontPageLoadExceptions) {
		    $wpacuFrontPageLoadExceptionsArray = @json_decode( $wpacuFrontPageLoadExceptions, ARRAY_A );

		    foreach ( array('styles', 'scripts') as $assetType ) {
			    if ( isset( $wpacuFrontPageLoadExceptionsArray[$assetType] ) && ! empty( $wpacuFrontPageLoadExceptionsArray[$assetType] ) ) {
				    foreach ( $wpacuFrontPageLoadExceptionsArray[$assetType] as $assetHandle ) {
					    $allHandles[$assetType][ $assetHandle ]['load_exception_on_home_page'] = 1;
					    }
			    }
		    }
	    }

	    // Homepage (async, defer)
	    $wpacuFrontPageData = get_option(WPACU_PLUGIN_ID . '_front_page_data');

	    if ($wpacuFrontPageData) {
		    $wpacuFrontPageDataArray = @json_decode( $wpacuFrontPageData, ARRAY_A );
		    if ( isset($wpacuFrontPageDataArray['scripts']) && ! empty($wpacuFrontPageDataArray['scripts']) ) {
			    foreach ($wpacuFrontPageDataArray['scripts'] as $assetHandle => $assetData) {
				    if (isset($assetData['attributes']) && ! empty($assetData['attributes'])) {
					    // async, defer attributes
					    $allHandles['scripts'][ $assetHandle ]['script_attrs']['home_page'] = $assetData['attributes'];
					    }
			    }
		    }

		    // Do not apply "async", "defer" exceptions (e.g. "defer" is applied site-wide, except the home page)
		    if (isset($wpacuFrontPageDataArray['scripts_attributes_no_load']) && ! empty($wpacuFrontPageDataArray['scripts_attributes_no_load'])) {
			    foreach ($wpacuFrontPageDataArray['scripts_attributes_no_load'] as $assetHandle => $assetAttrsNoLoad) {
				    $allHandles['scripts'][$assetHandle]['attrs_no_load']['home_page'] = $assetAttrsNoLoad;
				    }
		    }
	    }

	    // Custom Post Type Load Exceptions
        // e.g. the asset could be unloaded site-wide and loaded on all pages belonging to a post type such as WooCommerce single 'product' page
	    $wpacuPostTypeLoadExceptions = get_option(WPACU_PLUGIN_ID . '_post_type_load_exceptions');

	    if ($wpacuPostTypeLoadExceptions) {
		    $wpacuPostTypeLoadExceptionsArray = @json_decode( $wpacuPostTypeLoadExceptions, ARRAY_A );

            foreach ( $wpacuPostTypeLoadExceptionsArray as $wpacuPostType => $dbAssetHandles ) {
	            foreach ( array('styles', 'scripts') as $assetType ) {
	                if (isset($dbAssetHandles[$assetType]) && $dbAssetHandles[$assetType]) {
	                    foreach ($dbAssetHandles[$assetType] as $assetHandle => $assetValue) {
	                        if ($assetValue !== '') {
		                        $allHandles[ $assetType ][ $assetHandle ]['load_exception_post_type'][] = $wpacuPostType;
		                        }
	                    }
	                }
	            }
            }
	    }

	    // [wpacu_pro]
        // Load exception for all pages of [post] type having specific taxonomies set
	    $wpacuPostTypeLoadExceptionsViaTax = \WpAssetCleanUpPro\MainPro::getTaxonomyValuesAssocToPostTypeLoadExceptions();

	    if (! empty($wpacuPostTypeLoadExceptionsViaTax)) {
	        foreach ($wpacuPostTypeLoadExceptionsViaTax as $postType => $assetsData) {
	            if (! (isset($assetsData['styles']) || isset($assetsData['scripts']))) {
                    continue;
	            }

	            foreach ($assetsData as $assetType => $assetsValues) {
	                foreach ($assetsValues as $assetHandle => $assetData) {
	                    if (isset($assetData['enable'], $assetData['values']) && $assetData['enable'] && ! empty($assetData['values'])) {
		                    $allHandles[ $assetType ][ $assetHandle ]['load_exception_post_type_via_tax'][$postType] = $assetData['values'];
		                    }
	                }
	            }
	        }
	    }

	    // [/wpacu_pro]

	    // Get all Asset CleanUp (Pro) meta keys from all WordPress meta tables where it can be possibly used
	    foreach (array($wpdb->postmeta, $wpdb->termmeta, $wpdb->usermeta) as $tableName) {
		    $wpacuGetValuesQuery = <<<SQL
SELECT * FROM `{$tableName}`
WHERE meta_key IN('_{$wpacuPluginId}_no_load', '_{$wpacuPluginId}_data', '_{$wpacuPluginId}_load_exceptions')
SQL;
		    $wpacuMetaData = $wpdb->get_results( $wpacuGetValuesQuery, ARRAY_A );

		    foreach ( $wpacuMetaData as $wpacuValues ) {
			    $decodedValues = @json_decode( $wpacuValues['meta_value'], ARRAY_A );

			    if ( empty( $decodedValues ) ) {
				    continue;
			    }

			    // $refId is the ID for the targeted element from the meta table which could be: post, taxonomy ID or user ID
			    if ($tableName === $wpdb->postmeta) {
				    $refId = $wpacuValues['post_id'];
				    $refKey = 'post';
			    } elseif ($tableName === $wpdb->termmeta) {
				    $refId = $wpacuValues['term_id'];
				    $refKey = 'term';
			    } else {
				    $refId = $wpacuValues['user_id'];
				    $refKey = 'user';
			    }

			    if ( $wpacuValues['meta_key'] === '_' . $wpacuPluginId . '_no_load' ) {
				    foreach ( $decodedValues as $assetType => $assetHandles ) {
					    foreach ( $assetHandles as $assetHandle ) {
						    // Unload it on this page
						    $allHandles[ $assetType ][ $assetHandle ]['unload_on_this_page'][$refKey][] = $refId;
						    }
				    }
			    } elseif ( $wpacuValues['meta_key'] === '_' . $wpacuPluginId . '_load_exceptions' ) {
				    foreach ( $decodedValues as $assetType => $assetHandles ) {
					    foreach ( $assetHandles as $assetHandle ) {
						    // If bulk unloaded, 'Load it on this page'
						    $allHandles[ $assetType ][ $assetHandle ]['load_exception_on_this_page'][$refKey][] = $refId;
						    }
				    }
			    } elseif ( $wpacuValues['meta_key'] === '_' . $wpacuPluginId . '_data' ) {
				    if ( isset( $decodedValues['scripts'] ) && ! empty( $decodedValues['scripts'] ) ) {
					    foreach ( $decodedValues['scripts'] as $assetHandle => $scriptData ) {
						    if ( isset( $scriptData['attributes'] ) && ! empty( $scriptData['attributes'] ) ) {
							    // async, defer attributes
							    $allHandles['scripts'][ $assetHandle ]['script_attrs'][$refKey][$refId] = $scriptData['attributes'];
							    }
					    }
				    }

				    if ( isset( $decodedValues['scripts_attributes_no_load'] ) && ! empty( $decodedValues['scripts_attributes_no_load'] ) ) {
					    foreach ( $decodedValues['scripts_attributes_no_load'] as $assetHandle => $scriptNoLoadAttrs ) {
						    $allHandles['scripts'][$assetHandle]['attrs_no_load'][$refKey][$refId] = $scriptNoLoadAttrs;
						    }
				    }
			    }
		    }
	    }

	    // [wpacu_pro]
	    /*
	     * Load exceptions for 404, Search, Date
	     */
	    $loadExceptionsClass = new \WpAssetCleanUpPro\LoadExceptions();
	    $loadExceptionsExtras = $loadExceptionsClass->getAllExtrasLoadExceptions();

	    if ( ! empty($loadExceptionsExtras) ) {
	    	foreach ($loadExceptionsExtras as $refKeyExtra => $values) {
			    foreach ($values as $assetType => $assetHandles) {
	    			foreach ($assetHandles as $assetHandle) {
					    $allHandles[ $assetType ][ $assetHandle ]['load_exception_on_this_page'][ $refKeyExtra ] = 1;
					    }
			    }
		    }
	    }
	    // [/wpacu_pro]

	    /*
		 * Global (Site-wide) Rules: Preloading, Position changing, Unload via RegEx, etc.
		 */
	    $wpacuGlobalData = get_option(WPACU_PLUGIN_ID . '_global_data');
	    $wpacuGlobalDataArray = @json_decode($wpacuGlobalData, ARRAY_A);

	    $allPossibleDataTypes = array(
            'load_it_logged_in',
            'preloads',

            // [wpacu_pro]
            'positions',
            'media_queries_load',
            // [/wpacu_pro]

            'notes',
            'ignore_child',
            'everywhere',

            // [wpacu_pro]
            'date',
            '404',
            'search'
            // [/wpacu_pro]
        );

	    foreach (array('styles', 'scripts') as $assetType) {
		    if ($assetType === 'scripts' && isset( $wpacuGlobalDataArray[ $assetType ])) {
                foreach (array_keys($wpacuGlobalDataArray[ $assetType ]) as $dataType) {
                    if ( strpos( $dataType, 'custom_post_type_archive_' ) !== false ) {
                        $allPossibleDataTypes[] = $dataType;
                    }
                }

			    }

		    foreach ($allPossibleDataTypes as $dataType) {
			    if ( isset( $wpacuGlobalDataArray[ $assetType ][$dataType] ) && ! empty( $wpacuGlobalDataArray[ $assetType ][$dataType] ) ) {
				    foreach ( $wpacuGlobalDataArray[ $assetType ][$dataType] as $assetHandle => $dataValue ) {
					    if ($dataType === 'everywhere' && $assetType === 'scripts' && isset($dataValue['attributes'])) {
						    if (count($dataValue['attributes']) === 0) {
							    continue;
						    }
						    // async/defer applied site-wide
						    $allHandles[ $assetType ][ $assetHandle ]['script_site_wide_attrs'] = $dataValue['attributes'];
						    } elseif ($dataType !== 'everywhere' && $assetType === 'scripts' && isset($dataValue['attributes'])) {
						    // For date, 404, search pages
						    $allHandles[ $assetType ][ $assetHandle ]['script_attrs'][$dataType] = $dataValue['attributes'];
						    } else {
						    $allHandles[ $assetType ][ $assetHandle ][ $dataType ] = $dataValue;
						    }
				    }
			    }
		    }

		    foreach (array('unload_regex', 'load_regex') as $unloadType) {
			    if (isset($wpacuGlobalDataArray[$assetType][$unloadType]) && ! empty($wpacuGlobalDataArray[$assetType][$unloadType])) {
				    foreach ($wpacuGlobalDataArray[$assetType][$unloadType] as $assetHandle => $unloadData) {
					    if (isset($unloadData['enable'], $unloadData['value']) && $unloadData['enable'] && $unloadData['value']) {
						    $allHandles[ $assetType ][ $assetHandle ][$unloadType] = $unloadData['value'];
						    }
				    }
			    }
		    }
	    }

	    // Do not apply "async", "defer" exceptions (e.g. "defer" is applied site-wide, except the 404, search, date)
	    if (isset($wpacuGlobalDataArray['scripts_attributes_no_load']) && ! empty($wpacuGlobalDataArray['scripts_attributes_no_load'])) {
		    foreach ($wpacuGlobalDataArray['scripts_attributes_no_load'] as $unloadedIn => $unloadedInValues) {
			    foreach ($unloadedInValues as $assetHandle => $assetAttrsNoLoad) {
				    $allHandles['scripts'][$assetHandle]['attrs_no_load'][$unloadedIn] = $assetAttrsNoLoad;
				    }
		    }
	    }

	    /*
		 * Unload Site-Wide (Everywhere) Rules: Preloading, Position changing, Unload via RegEx, etc.
		 */
	    $wpacuGlobalUnloadData = get_option(WPACU_PLUGIN_ID . '_global_unload');
	    $wpacuGlobalUnloadDataArray = @json_decode($wpacuGlobalUnloadData, ARRAY_A);

	    foreach (array('styles', 'scripts') as $assetType) {
		    if (isset($wpacuGlobalUnloadDataArray[$assetType]) && ! empty($wpacuGlobalUnloadDataArray[$assetType])) {
			    foreach ($wpacuGlobalUnloadDataArray[$assetType] as $assetHandle) {
				    $allHandles[ $assetType ][ $assetHandle ]['unload_site_wide'] = 1;
				    }
		    }
	    }

	    /*
		* Bulk Unload Rules - post, page, custom post type (e.g. product, download), taxonomy (e.g. category), 404, date, archive (for custom post type) with pagination etc.
		*/
	    $wpacuBulkUnloadData = get_option(WPACU_PLUGIN_ID . '_bulk_unload');
	    $wpacuBulkUnloadDataArray = @json_decode($wpacuBulkUnloadData, ARRAY_A);

	    foreach (array('styles', 'scripts') as $assetType) {
		    if (isset($wpacuBulkUnloadDataArray[$assetType]) && ! empty($wpacuBulkUnloadDataArray[$assetType])) {
			    foreach ($wpacuBulkUnloadDataArray[$assetType] as $unloadBulkType => $unloadBulkValues) {
				    if (empty($unloadBulkValues)) {
					    continue;
				    }

				    // $unloadBulkType could be 'post_type', 'post_type_via_tax', 'date', '404', 'taxonomy', 'search', 'custom_post_type_archive_[post_type_name_here]', etc.
				    if ($unloadBulkType === 'post_type') {
					    foreach ($unloadBulkValues as $postType => $assetHandles) {
						    foreach ($assetHandles as $assetHandle) {
							    $allHandles[ $assetType ][ $assetHandle ]['unload_bulk'][$unloadBulkType][] = $postType;
							    }
					    }
				    }

                    // [wpacu_pro]
                    if ($unloadBulkType === 'post_type_via_tax') {
					    foreach ($unloadBulkValues as $postType => $assetHandles) {
					        foreach ($assetHandles as $assetHandle => $assetData) {
					            if (isset($assetData['enable'], $assetData['values']) && $assetData['enable'] && ! empty($assetData['values'])) {
						            $allHandles[ $assetType ][ $assetHandle ]['unload_bulk'][$unloadBulkType][$postType] = $assetData['values'];
						            }
					        }
					    }

                    }

                    if (in_array($unloadBulkType, array('date', '404', 'search')) || (strpos($unloadBulkType, 'custom_post_type_archive_') !== false)) {
					    foreach ($unloadBulkValues as $assetHandle) {
						    $allHandles[ $assetType ][ $assetHandle ]['unload_bulk'][$unloadBulkType] = 1;
						    }
				    }

                    if ($unloadBulkType === 'taxonomy') {
					    foreach ($unloadBulkValues as $taxonomyType => $assetHandles) {
						    foreach ($assetHandles as $assetHandle) {
							    $allHandles[ $assetType ][ $assetHandle ]['unload_bulk'][$unloadBulkType][] = $taxonomyType;
							    }
					    }
				    }

                    if ($unloadBulkType === 'author' && isset($unloadBulkValues['all']) && ! empty($unloadBulkValues['all'])) {
					    foreach ($unloadBulkValues['all'] as $assetHandle) {
						    $allHandles[ $assetType ][ $assetHandle ]['unload_bulk'][$unloadBulkType] = 1;
						    }
				    }
				    // [/wpacu_pro]
			    }
		    }
	    }

	    if (isset($allHandles['styles'])) {
		    ksort($allHandles['styles']);
	    }

	    if (isset($allHandles['scripts'])) {
		    ksort($allHandles['scripts']);
	    }

	    return $allHandles;
    }

	/**
	 *
	 */
	public function pageOverview()
	{
		$allHandles = self::handlesWithAtLeastOneRule();
		$this->data['handles'] = $allHandles;

		if (isset($this->data['handles']['styles']) || isset($this->data['handles']['scripts'])) {
			// Only fetch the assets information if there is something to be shown
			// to avoid useless queries to the database
			$this->data['assets_info'] = Main::getHandlesInfo();
			}

		// [wpacu_pro]
		$this->data['plugins_with_rules'] = array();

		// Any plugins unloaded site-wide (with exceptions) or based on other conditions?
        // Get all the saved rules for both active, inactive and deleted plugins
		$getAllPluginsRules = PluginsManager::getPluginRulesFiltered(false, true);

		if ( ! empty($getAllPluginsRules) ) {
			// Are there plugins with rules?
			// Fetch all plugins and get the needed information (title, path, icon)
			// only from the ones with rules
			$currentPluginsWithRules = array();

            // Get all current plugins (active and inactive) and their basic information
            $allCurrentPlugins = get_plugins();

            foreach ($allCurrentPlugins as $currentPluginPath => $currentPluginData) {
                // Skip Asset CleanUp as it's obviously needed for the functionality
                if (strpos($currentPluginPath, 'wp-asset-clean-up') !== false) {
                    continue;
                }

                foreach (array_keys($getAllPluginsRules) as $locationKey) {
	                if ( ! isset( $getAllPluginsRules[ $locationKey ][ $currentPluginPath ] ) ) {
		                continue; // the rule is irrelevant because the targeted plugin is deleted (not even inactive)
	                }

	                $currentPluginsWithRules[$locationKey][] = array(
		                'title' => $currentPluginData['Name'],
		                'path'  => $currentPluginPath,
		                'rules' => $getAllPluginsRules[ $locationKey][ $currentPluginPath ]
	                );
                }
            }

			if ( ! empty($currentPluginsWithRules) ) {
				foreach ( array_keys( $currentPluginsWithRules ) as $locationKey ) {
					usort( $currentPluginsWithRules[ $locationKey ], static function( $a, $b ) {
						return strcmp( $a['title'], $b['title'] );
					} );
				}
			}

			// [CRITICAL CSS]
			$this->data['critical_css_disabled'] = $this->data['critical_css_config'] = false;
			if (Main::instance()->settings['critical_css_status'] === 'off') {
			    $this->data['critical_css_disabled'] = true;
			}

			$criticalCssConfigOption = get_option(WPACU_PLUGIN_ID.'_critical_css_config');

			if ($criticalCssConfigOption) {
				$this->data['critical_css_config'] = json_decode( $criticalCssConfigOption, ARRAY_A );
			}
			// [/CRITICAL CSS]

			$pluginsDir = dirname( WPACU_PLUGIN_DIR ) . '/';

			// Get active plugins and their basic information
            $activePlugins = wp_get_active_and_valid_plugins();

			foreach ($activePlugins as $activePluginKey => $activePluginValue) {
			    $activePlugins[$activePluginKey] = str_replace($pluginsDir, '', $activePluginValue);
            }

			// Multisite?
			$this->data['plugins_active_network'] = array();

			if (is_multisite()) {
                $networkActivePlugins = wp_get_active_network_plugins();

                if ( ! empty( $networkActivePlugins ) ) {
                    foreach ( $networkActivePlugins as $networkActivePlugin ) {
                        $networkActivePluginSanitized           = str_replace( $pluginsDir, '', $networkActivePlugin );
                        $activePlugins[]                        = $networkActivePluginSanitized;
                        $this->data['plugins_active_network'][] = $networkActivePluginSanitized;
                    }
                }
		    }

			$activePlugins = array_unique($activePlugins);

            $this->data['plugins_active']     = $activePlugins;
			$this->data['plugins_with_rules'] = $currentPluginsWithRules; // all rules for all plugins
            $this->data['plugins_icons']      = Misc::getAllActivePluginsIcons();
		}
        // [/wpacu_pro]

		// [PAGE OPTIONS]
		// 1) For posts, pages and custom post types
		global $wpdb;

		$this->data['page_options_results'] = array();

		$pageOptionsResults = $wpdb->get_results('SELECT post_id, meta_value FROM `'.$wpdb->postmeta."` WHERE meta_key='_".WPACU_PLUGIN_ID."_page_options' && meta_value !=''", ARRAY_A);

		foreach ($pageOptionsResults as $pageOptionResult) {
			$postId = $pageOptionResult['post_id'];
			$optionsDecoded = @json_decode( $pageOptionResult['meta_value'], ARRAY_A );

			if (is_array($optionsDecoded) && ! empty($optionsDecoded)) {
				$this->data['page_options_results']['posts'][] = array('post_id' => $postId, 'options' => $optionsDecoded);
			}
		}

		// 2) For the homepage set as latest posts (e.g. not a single page set as the front page, this is included in the previous check)
		$globalPageOptions = get_option(WPACU_PLUGIN_ID . '_global_data');

		if ($globalPageOptions) {
			$globalPageOptionsList = @json_decode( $globalPageOptions, true );
			if ( isset( $globalPageOptionsList['page_options']['homepage'] ) && ! empty( $globalPageOptionsList['page_options']['homepage'] ) ) {
				$this->data['page_options_results']['homepage'] = array('options' => $globalPageOptionsList['page_options']['homepage']);
			}
		}
		// [/PAGE OPTIONS]

		Main::instance()->parseTemplate('admin-page-overview', $this->data, true);
	}

	/**
	 * @param $handle
	 * @param $assetType
	 * @param $data
	 * @param string $for ('default': bulk unloads, regex unloads)
	 */
	public static function renderHandleTd($handle, $assetType, $data, $for = 'default')
	{
		global $wp_version;

		$handleData = '';
		$isCoreFile = false; // default

		// [wpacu_pro]
        $isHardcoded = (strpos($handle, 'wpacu_hardcoded_') === 0);
		$hardcodedTagOutput = false;
        // [/wpacu_pro]

        if (isset($data['handles'][$assetType][$handle]) && $data['handles'][$assetType][$handle]) {
            $handleData = $data['handles'][$assetType][$handle];
        }

        if ( $for === 'default' ) {
	        // [wpacu_pro]
            $attrToGet = ($assetType === 'styles') ? 'href' : 'src';

            if ( $isHardcoded
                 && isset( $data['assets_info'][ $assetType ][ $handle ]['output'] )
                 && ( $hardcodedTagOutput = $data['assets_info'][ $assetType ][ $handle ]['output'] )
                 && stripos( $hardcodedTagOutput, ' '.$attrToGet ) !== false ) {
                    $sourceValue = Misc::getValueFromTag($hardcodedTagOutput);

		            if ( $sourceValue ) {
			            $data['assets_info'][ $assetType ][ $handle ]['src'] = $sourceValue;
		            }
            }
            // [/wpacu_pro]

            // Show the original "src" and "ver, not the altered one
            // (in case filters such as "wpacu_{$handle}_(css|js)_handle_obj" were used to load alternative versions of the file, depending on the situation)
            $srcKey = isset($data['assets_info'][ $assetType ][ $handle ]['src_origin']) ? 'src_origin' : 'src';
	        $verKey = isset($data['assets_info'][ $assetType ][ $handle ]['ver_origin']) ? 'ver_origin' : 'ver';

            $src = (isset( $data['assets_info'][ $assetType ][ $handle ][$srcKey] ) && $data['assets_info'][ $assetType ][ $handle ][$srcKey]) ? $data['assets_info'][ $assetType ][ $handle ][$srcKey] : false;

            $isExternalSrc = true;

            if (Misc::getLocalSrc($src)
                || strpos($src, '/?') !== false // Dynamic Local URL
                || strpos(str_replace(site_url(), '', $src), '?') === 0 // Starts with ? right after the site url (it's a local URL)
            ) {
                $isExternalSrc = false;
                $isCoreFile = Misc::isCoreFile($data['assets_info'][$assetType][$handle]);
            }

            if (strpos($src, '/') === 0 && strpos($src, '//') !== 0) {
                $src = site_url() . $src;
            }

            if (strpos($src, '/wp-content/plugins/') !== false) {
                $src = str_replace('/wp-content/plugins/', '/'.Misc::getPluginsDir().'/', $src);
            }

	        $ver = $wp_version; // default
	        if (isset($data['assets_info'][ $assetType ][ $handle ][$verKey] ) && $data['assets_info'][ $assetType ][ $handle ][$verKey] ) {
		        $ver = is_array($data['assets_info'][ $assetType ][ $handle ][$verKey] )
			        ? implode(',', $data['assets_info'][ $assetType ][ $handle ][$verKey] )
			        : $data['assets_info'][ $assetType ][ $handle ][$verKey] ;
	        }

	        // [wpacu_pro]
	        if (! $isHardcoded) {
	        ?>
            <strong><span style="color: green;"><?php echo esc_html($handle); ?></span></strong>
	        <?php
            // [/wpacu_pro]

		        // Only valid if the asset is enqueued
		        ?>
		        <small><em>v<?php echo esc_html($ver); ?></em></small>
		        <?php
            // [wpacu_pro]
	        } else {
	        	// Hardcoded Link/Style/Script
		        $hardcodedTitle = '';

                if (strpos($handle, '_link_') !== false) {
			        $hardcodedTitle = 'Hardcoded LINK (rel="stylesheet")';
		        } elseif (strpos($handle, '_style_') !== false) {
			        $hardcodedTitle = 'Hardcoded inline STYLE';
		        } elseif (strpos($handle, '_script_inline_') !== false) {
			        $hardcodedTitle = 'Hardcoded inline SCRIPT';
		        } elseif (strpos($handle, '_noscript_inline_') !== false) {
			        $hardcodedTitle = 'Hardcoded inline NOSCRIPT';
		        } elseif (strpos($handle, '_script_') !== false) {
			        $hardcodedTitle = 'Hardcoded SCRIPT (with "src")';
		        }
		        ?>
				<strong><?php echo esc_html($hardcodedTitle); ?></strong>
		        <?php
		        if ( $hardcodedTagOutput ) {
		            $maxCharsToShow = 400;

		            if (strlen($hardcodedTagOutput) > $maxCharsToShow) {
			            echo '<code><small>' . htmlentities2( substr($hardcodedTagOutput, 0, $maxCharsToShow) ) . '</small></code>... &nbsp;<a id="wpacu-'.esc_attr($handle).'-modal-target" href="#wpacu-'.esc_attr($handle).'-modal" class="button button-secondary">Посмотреть все</a>';
		                ?>
			            <div id="<?php echo 'wpacu-'.esc_attr($handle).'-modal'; ?>" class="wpacu-modal" style="padding: 40px 0; height: 100%;">
			                <div class="wpacu-modal-content" style="max-width: 900px; height: 80%;">
				                <span class="wpacu-close">&times;</span>
				                <pre style="overflow-y: auto; height: 100%; max-width: 900px; white-space: pre-wrap;"><code><?php echo htmlentities2($hardcodedTagOutput); ?></code></pre>
			                </div>
			            </div>
			            <?php
		            } else {
		            	// Under the limit? Show everything
			            echo '<code><small>' . htmlentities2( $hardcodedTagOutput ) . '</small></code>';
		            }
		        }
 	        }
	        // [/wpacu_pro]

            if ($isCoreFile) {
                ?>
                <span title="WordPress Core File" style="font-size: 15px; vertical-align: middle;" class="dashicons dashicons-wordpress-alt wpacu-tooltip"></span>
                <?php
            }
            ?>
            <?php
            // [wpacu_pro]
            // If called from "Bulk Changes" -> "Preloads"
            $preloadedStatus = isset($data['assets_info'][ $assetType ][ $handle ]['preloaded_status']) ? $data['assets_info'][ $assetType ][ $handle ]['preloaded_status'] : false;
            if ($preloadedStatus === 'async') { echo '&nbsp;(<strong><em>'.$preloadedStatus.'</em></strong>)'; }
            // [/wpacu_pro]

            $handleExtras = array();

            // If called from "Overview"
	        if (isset($handleData['preloads']) && $handleData['preloads']) {
		        $handleExtras[0] = '<span style="font-weight: 600;">Предзагружено</span>';

	            if ($handleData['preloads'] === 'async') {
		            $handleExtras[0] .= ' (async)';
                }
	        }

	        if (isset($handleData['positions']) && $handleData['positions']) {
                $handleExtras[1] = '<span style="color: #004567; font-weight: 600;">Переехал в <code>&lt;'.esc_html($handleData['positions']).'&gt;</code></span>';
            }

	        /*
	         * 1) Per page (homepage, a post, a category, etc.)
	         * Async, Defer attributes
	         */
            // Per home page
	        if (isset($handleData['script_attrs']['home_page']) && ! empty($handleData['script_attrs']['home_page'])) {
		        ksort($handleData['script_attrs']['home_page']);
		        $handleExtras[2] = 'Атрибуты главной страницы: <strong>'.esc_html(implode(', ', $handleData['script_attrs']['home_page'])).'</strong>';
	        }

	        // Date archive pages
	        if (isset($handleData['script_attrs']['date']) && ! empty($handleData['script_attrs']['date'])) {
		        ksort($handleData['script_attrs']['date']);
		        $handleExtras[22] = 'Атрибуты архива даты: <strong>'.esc_html(implode(', ', $handleData['script_attrs']['date'])).'</strong>';
	        }

	        // 404 page
	        if (isset($handleData['script_attrs']['404']) && ! empty($handleData['script_attrs']['404'])) {
		        ksort($handleData['script_attrs']['404']);
		        $handleExtras[23] = '404 Атрибуты не найдены: <strong>'.esc_html(implode(', ', $handleData['script_attrs']['404'])).'</strong>';
	        }

	        // Search results page
	        if (isset($handleData['script_attrs']['search']) && ! empty($handleData['script_attrs']['search'])) {
		        ksort($handleData['script_attrs']['search']);
		        $handleExtras[24] = '404 Атрибуты не найдены: <strong>'.esc_html(implode(', ', $handleData['script_attrs']['search'])).'</strong>';
	        }

            // Archive page for Custom Post Type (those created via theme editing or via plugins such as "Custom Post Type UI")
            $scriptAttrsStr = (isset($handleData['script_attrs']) && is_array($handleData['script_attrs'])) ? implode('', array_keys($handleData['script_attrs'])) : '';

	        if (strpos($scriptAttrsStr, 'custom_post_type_archive_') !== false) {
	            $keyNo = 225;
	            foreach ($handleData['script_attrs'] as $scriptAttrsKey => $scriptAttrsValue) {
	                $customPostTypeName = str_replace('custom_post_type_archive_', '', $scriptAttrsKey);
		            $handleExtras[$keyNo] = 'Архив страницы пользовательского типа записи "'.$customPostTypeName.'" attributes: <strong>'.esc_html(implode(', ', $handleData['script_attrs'][$scriptAttrsKey])).'</strong>';
		            $keyNo++;
	            }
	        }

	        // Per post page
            if (isset($handleData['script_attrs']['post']) && ! empty($handleData['script_attrs']['post'])) {
	            $handleExtras[3] = 'По атрибутам поста: ';

		        $postsList = '';

		        ksort($handleData['script_attrs']['post']);

		        foreach ($handleData['script_attrs']['post'] as $postId => $attrList) {
			        $postData   = get_post($postId);

                    if (isset($postData->post_title, $postData->post_type)) {
	                    $postTitle = $postData->post_title;
	                    $postType  = $postData->post_type;
	                    $postsList .= '<a title="Заголовок поста: ' . esc_attr( $postTitle ) . ', Тип сообщения: ' . esc_attr( $postType ) . '" class="wpacu-tooltip" target="_blank" href="' . esc_url( admin_url( 'post.php?post=' . $postId . '&action=edit' ) ) . '">' . $postId . '</a> - <strong>' . esc_html( implode( ', ', $attrList ) ) . '</strong> / ';
                    } else {
	                    $postsList .= '<s class="wpacu-tooltip" title="Н/Д (сообщение удалено)" style="color: #cc0000;">'.$postId.'</s> / ';
                    }
		        }

	            $handleExtras[3] .= rtrim($postsList, ' / ');
	        }

            // User archive page (specific author)
	        if (isset($handleData['script_attrs']['user']) && ! empty($handleData['script_attrs']['user'])) {
		        $handleExtras[31] = 'Атрибуты страницы автора: ';

		        $authorPagesList = '';

		        ksort($handleData['script_attrs']['user']);

		        foreach ($handleData['script_attrs']['user'] as $userId => $attrList) {
			        $authorLink = get_author_posts_url(get_the_author_meta('ID', $userId));
			        $authorRelLink = str_replace(site_url(), '', $authorLink);

			        $authorPagesList .= '<a target="_blank" href="'.$authorLink.'">'.$authorRelLink.'</a> - <strong>'.implode(', ', $attrList).'</strong> | ';
		        }

		        $authorPagesList = trim($authorPagesList, ' | ');

		        $handleExtras[31] .= rtrim($authorPagesList, ' / ');
	        }

            // Per category page
            if (isset($handleData['script_attrs']['term']) && ! empty($handleData['script_attrs']['term'])) {
	            $handleExtras[33] = 'По атрибутам таксономии: ';

                $taxPagesList = '';

	            foreach ($handleData['script_attrs']['term'] as $termId => $attrList) {
		            $taxData = term_exists( (int)$termId ) ? get_term( $termId ) : false;

		            if ( ! $taxData || ( isset($taxData->errors['invalid_taxonomy']) && ! empty($taxData->errors['invalid_taxonomy']) ) ) {
			            $taxPagesList .= '<span style="color: darkred; font-style: italic;">Ошибка: Таксономия с ID '.$termId.' больше не существует (правило не применяется)</span> | ';
		            } else {
			            $taxonomy    = $taxData->taxonomy;
			            $termLink    = get_term_link( $taxData, $taxonomy );
			            $termRelLink = str_replace( site_url(), '', $termLink );
			            $taxPagesList .= '<a href="' . esc_attr($termRelLink) . '">' . esc_html($termRelLink) . '</a> - <strong>' . esc_html(implode( ', ', $attrList )) . '</strong> | ';
		            }
	            }

	            $taxPagesList = trim($taxPagesList, ' | ');

	            $handleExtras[33] .= rtrim($taxPagesList, ' / ');
            }

            /*
             * 2) Site-wide type
             * Any async, defer site-wide attributes? Exceptions will be also shown
             */
	        if (isset($handleData['script_site_wide_attrs'])) {
		        $handleExtras[4] = 'Site-wide attributes: ';
		        foreach ( $handleData['script_site_wide_attrs'] as $attrValue ) {
			        $handleExtras[4] .= '<strong>' . esc_html($attrValue) . '</strong>';

			        // Are there any exceptions? e.g. async, defer unloaded site-wide, but loaded on the homepage
			        if ( isset( $handleData['attrs_no_load'] ) && ! empty( $handleData['attrs_no_load'] ) ) {
				        // $attrSetIn could be 'home_page', 'term', 'user', 'date', '404', 'search'
				        $handleExtras[4] .= ' <em>(с исключениями из применения, добавленными для этих страниц: ';

				        $handleAttrsExceptionsList = '';

				        foreach ( $handleData['attrs_no_load'] as $attrSetIn => $attrSetValues ) {
					        if ( $attrSetIn === 'home_page' && in_array($attrValue, $attrSetValues) ) {
						        $handleAttrsExceptionsList .= ' Homepage, ';
					        }

					        if ( $attrSetIn === 'date' && in_array($attrValue, $attrSetValues) ) {
						        $handleAttrsExceptionsList .= ' Архив дат, ';
					        }

					        if ( (int)$attrSetIn === 404 && in_array($attrValue, $attrSetValues) ) {
						        $handleAttrsExceptionsList .= ' 404 Not Found, ';
					        }

					        if ( $attrSetIn === 'search' && in_array($attrValue, $attrSetValues) ) {
						        $handleAttrsExceptionsList .= ' результаты поиска, ';
					        }

					        if (strpos($attrSetIn, 'custom_post_type_archive_') !== false) {
						        $customPostTypeName = str_replace('custom_post_type_archive_', '', $attrSetIn);
					            $handleAttrsExceptionsList .= ' Archive "'.$customPostTypeName.'" custom post type, ';
					        }

					        // Post pages such as posts, pages, product (WooCommerce), download (Easy Digital Downloads), etc.
					        if ( $attrSetIn === 'post' ) {
						        $postPagesList = '';

						        foreach ( $attrSetValues as $postId => $attrSetValuesTwo ) {
							        if (! in_array($attrValue, $attrSetValuesTwo)) {
								        continue;
							        }

							        $postData   = get_post($postId);

                                    if (isset($postData->post_title, $postData->post_type)) {
	                                    $postTitle = $postData->post_title;
	                                    $postType  = $postData->post_type;

	                                    $postPagesList .= '<a title="Заголовок поста: ' . esc_attr( $postTitle ) . ', Post Type: ' . esc_attr( $postType ) . '" class="wpacu-tooltip" target="_blank" href="' . esc_url( admin_url( 'post.php?post=' . $postId . '&action=edit' ) ) . '">' . $postId . '</a> | ';
                                    } else {
	                                    $postPagesList .= '<s style="color: #cc0000;">'.$postId.'</s> <em>N/A (post deleted)</em> | ';
                                    }
						        }

						        if ($postPagesList) {
						            $postPagesList = trim( $postPagesList, ' | ' ).', ';
						            $handleAttrsExceptionsList .= $postPagesList;
						        }
					        }

					        // Taxonomy pages such as category archive, product category in WooCommerce
					        if ( $attrSetIn === 'term' ) {
						        $taxPagesList = '';

						        foreach ( $attrSetValues as $termId => $attrSetValuesTwo ) {
						            if (! in_array($attrValue, $attrSetValuesTwo)) {
						                continue;
                                    }

							        $taxData = term_exists((int)$termId) ? get_term( $termId ) : false;

							        if ( ! $taxData || (isset($taxData->errors['invalid_taxonomy']) && ! empty($taxData->errors['invalid_taxonomy'])) ) {
								        $taxPagesList .= '<span style="color: darkred; font-style: italic;">Ошибка: Таксономия с ID '.(int)$termId.' больше не существует (правило не применяется)</span> | ';
							        } else {
								        $taxonomy    = $taxData->taxonomy;
								        $termLink    = get_term_link( $taxData, $taxonomy );
								        $termRelLink = str_replace( site_url(), '', $termLink );

								        $taxPagesList .= '<a href="' . esc_url($termRelLink) . '">' . esc_url($termRelLink) . '</a> | ';
							        }
						        }

						        if ($taxPagesList) {
							        $taxPagesList = trim( $taxPagesList, ' | ' ) . ', ';
							        $handleAttrsExceptionsList .= $taxPagesList;
						        }
					        }

					        // Author archive pages (e.g. /author/john/page/2/)
					        if ($attrSetIn === 'user') {
						        $authorPagesList = '';

						        foreach ( $attrSetValues as $userId => $attrSetValuesTwo ) {
							        if (! in_array($attrValue, $attrSetValuesTwo)) {
								        continue;
							        }

							        $authorLink = get_author_posts_url(get_the_author_meta('ID', $userId));
							        $authorRelLink = str_replace(site_url(), '', $authorLink);

							        $authorPagesList .= '<a target="_blank" href="'.esc_url($authorLink).'">'.esc_html($authorRelLink).'</a> | ';
						        }

						        if ($authorPagesList) {
						            $authorPagesList = trim( $authorPagesList, ' | ' ).', ';
						            $handleAttrsExceptionsList .= $authorPagesList;
						        }
                            }
				        }

				        $handleAttrsExceptionsList = trim($handleAttrsExceptionsList, ', ');

				        $handleExtras[4] .= $handleAttrsExceptionsList;
				        $handleExtras[4] .= '</em>), ';
			        }

			        $handleExtras[4] .= ', ';
		        }

		        $handleExtras[4] = trim($handleExtras[4], ', ');
	        }

	        if (! empty($handleExtras)) {
		        echo '<small>' . implode( ' <span style="font-weight: 300; color: grey;">/</span> ', $handleExtras ) . '</small>';
	        }

            if ( $src ) {
                $verDb = (isset($data['assets_info'][ $assetType ][ $handle ][$verKey]) && $data['assets_info'][ $assetType ][ $handle ][$verKey]) ? $data['assets_info'][ $assetType ][ $handle ][$verKey] : false;

		        $appendAfterSrc = (strpos($src, '?') === false) ? '?' : '&';

		        if ( $verDb ) {
		            if (is_array($verDb)) {
			            $appendAfterSrc .= http_build_query(array('ver' => $data['assets_info'][ $assetType ][ $handle ][$verKey]));
                    } else {
			            $appendAfterSrc .= 'ver='.$ver;
                    }
		        } else {
			        $appendAfterSrc .= 'ver='.$wp_version; // default
		        }
		        ?>
                <div><a <?php if ($isExternalSrc) { ?> data-wpacu-external-source="<?php echo esc_attr($src . $appendAfterSrc); ?>" <?php } ?> href="<?php echo esc_attr($src . $appendAfterSrc); ?>" target="_blank"><small><?php echo str_replace( site_url(), '', $src ); ?></small></a> <?php if ($isExternalSrc) { ?><span data-wpacu-external-source-status></span><?php } ?></div>
                <?php
	            $maybeInactiveAsset = \WpAssetCleanUp\Misc::maybeIsInactiveAsset($src);

	            if (is_array($maybeInactiveAsset) && ! empty($maybeInactiveAsset)) {
	                $uniqueStr = md5($handle . $assetType);
		            $clearAllRulesConfirmMsg = sprintf(esc_attr(__('This will clear all rules (unloads, load exceptions and other settings) for the `%s` CSS handle', 'wp-asset-clean-up')), $handle) . ".\n\n" . esc_attr(__('Click `OK` to confirm the action', 'wp-asset-clean-up')).'!';
	                ?>
                    <div>
                        <?php if ($maybeInactiveAsset['from'] === 'plugin') { ?>
                            <small><strong>Примечание:</strong> <span style="color: darkred;">Плагин `<strong><?php echo esc_html($maybeInactiveAsset['name']); ?></strong>` кажется неактивным, поэтому любые установленные правила также неактивны и не имеют значения, если вы не активируете плагин повторно.</span></small>
                        <?php } elseif ($maybeInactiveAsset['from'] === 'theme') { ?>
                            <small><strong>Примечание:</strong> <span style="color: darkred;">Тема `<strong><?php echo esc_html($maybeInactiveAsset['name']); ?></strong>` кажется неактивным, поэтому любой набор правил также неактивен и не имеет значения, если вы не активируете тему повторно.</span></small>
                        <?php } ?>
                        <form method="post" action="" style="display: inline-block;">
                            <input type="hidden" name="wpacu_action" value="clear_all_rules" />
                            <input type="hidden" name="wpacu_handle" value="<?php echo esc_attr($handle); ?>" />
                            <input type="hidden" name="wpacu_asset_type" value="<?php echo esc_attr($assetType); ?>" />
                            <?php echo wp_nonce_field('wpacu_clear_all_rules', 'wpacu_clear_all_rules_nonce'); ?>
                            <script type="text/javascript">
                                var wpacuClearAllRulesConfirmMsg_<?php echo $uniqueStr; ?> = '<?php echo esc_js($clearAllRulesConfirmMsg); ?>';
                            </script>
                            <button onclick="return confirm(wpacuClearAllRulesConfirmMsg_<?php echo $uniqueStr; ?>);" type="submit" class="button button-secondary"><span class="dashicons dashicons-trash" style="vertical-align: text-bottom;"></span> Удалить все правила для этого "осиротевшего" дескриптора</button>
                        </form>
                    </div>
		            <?php
	            }
            }

            // [wpacu_pro]
            // Any media query load?
	        if (isset($handleData['media_queries_load']['enable'], $handleData['media_queries_load']['value'])
                && $handleData['media_queries_load']['enable'] && $handleData['media_queries_load']['value']) {
		        ?>
                <div><small><span class="dashicons dashicons-desktop" style="vertical-align: middle;"></span> Загружается, если медиа-запрос соответствует: <code><?php echo ucfirst(htmlspecialchars($data['handles'][$assetType][$handle]['media_queries_load']['value'])); ?></code></small></div>
		        <?php
	        }
	        // [/wpacu_pro]

            // Any note?
            if (isset($handleData['notes']) && $handleData['notes']) {
                ?>
                <div><small><span class="dashicons dashicons-welcome-write-blog" style="vertical-align: middle;"></span> Примечание: <em><?php echo ucfirst(htmlspecialchars($data['handles'][$assetType][$handle]['notes'])); ?></em></small></div>
                <?php
            }
            ?>
        <?php
        }
	}

	/**
	 * @param $handleData
	 *
	 * @return array
	 */
	public static function renderHandleChangesOutput($handleData)
	{
		$handleChangesOutput = array();
		$anyUnloadRule = false; // default (turns to true if at least an unload rule is set)
		$anyLoadExceptionRule = false; // default (turns to true if any load exception rule is set)

		// It could turn to "true" IF the site-wide rule is turned ON and there are other unload rules on top of it (useless ones in this case)
		$hasRedundantUnloadRules = false;

		// Site-wide
		if (isset($handleData['unload_site_wide'])) {
			$handleChangesOutput['site_wide'] = '<span style="color: #cc0000;">Выгружается по всему сайту (везде)</span>';
			$anyUnloadRule = true;
		}

		// Bulk unload (on all posts, categories, etc.)
		if (isset($handleData['unload_bulk'])) {
			$handleChangesOutput['bulk'] = '';

			if (isset($handleData['unload_bulk']['post_type'])) {
				foreach ($handleData['unload_bulk']['post_type'] as $postType) {
                    $textToShow = 'Unloaded on all pages of <strong>' . $postType . '</strong> post type';

                    $handleChangesOutput['bulk'] .= ' <span style="color: #cc0000;">'.$textToShow.'</span>'.
                                                    self::anyNoPostTypeEntriesMsg($postType).', ';

					$anyUnloadRule = true;
				}
			}

			// [wpacu_pro]
			if (isset($handleData['unload_bulk']['post_type_via_tax'])) {
			    foreach ($handleData['unload_bulk']['post_type_via_tax'] as $postType => $termIds) {
                    if (empty($termIds)) {
                        continue;
                    }

				    $taxTermsToList = $taxLabelsToNames = array();
                    $anyDelTaxList = array();

				    foreach ($termIds as $termId) {
				        if ( ! term_exists((int)$termId) ) {
					        $anyDelTaxList[] = $termId;
                            continue;
				        }

					    $term = get_term( $termId );
					    $taxonomy = get_taxonomy($term->taxonomy);
					    $taxLabelsToNames[$taxonomy->label] = $term->taxonomy;
					    $taxTermsToList[$taxonomy->label][] = $term->name. ' ('.$term->count.')';
				    }

                    $handleChangesOutput['bulk'] .= ' <span style="color: #cc0000;">Выгружается на всех страницах <strong>' . $postType . '</strong> post type'.self::anyNoPostTypeEntriesMsg($postType).' с этими таксономиями:</span> ';

                    if ( ! empty($taxTermsToList) ) {
	                    foreach ( array_keys( $taxTermsToList ) as $taxonomyLabel ) {
		                    usort( $taxTermsToList[ $taxonomyLabel ], static function( $a, $b ) {
			                    return strcasecmp( $a, $b );
		                    } );
	                    }
                    }

                    foreach ( $taxTermsToList as $categoryTitle => $termsAssoc ) {
                        $handleChangesOutput['bulk'] .= '<strong>' . $categoryTitle . '</strong> (' . $taxLabelsToNames[ $categoryTitle ] . '): ' . implode( ', ', $termsAssoc ) . ' | ';
                    }
                    $handleChangesOutput['bulk'] = rtrim( $handleChangesOutput['bulk'], ' | ' );

                    if ( ! empty($anyDelTaxList) ) {
	                    $handleChangesOutput['bulk'] = ' <span style="color: #cc0000;" title="The following taxonomy IDs were also found (the taxonomies might have been deleted from the database): '.implode(', ', $anyDelTaxList).'" class="wpacu-tooltip dashicons dashicons-warning"></span>';
                    }

                    $handleChangesOutput['bulk'] .= '<br />';

                    $anyUnloadRule = true;
			    }
			}

			if (isset($handleData['unload_bulk']['taxonomy']) && ! empty($handleData['unload_bulk']['taxonomy'])) {
				$handleChangesOutput['bulk'] .= ' Выгружено для всех страниц, принадлежащих к следующим таксономиям: <strong>';

                $taxonomyList = '';

                foreach ($handleData['unload_bulk']['taxonomy'] as $taxonomy) {
                    $appendAfter = '';

                    if ( ! taxonomy_exists($taxonomy) ) {
	                    $appendAfter = ' <span style="color: #cc0000;" title="Следующая таксономия может больше не существовать: ' . $taxonomy . '" class="wpacu-tooltip dashicons dashicons-warning"></span>';
                    }

	                $taxonomyList .= $taxonomy . $appendAfter . ', ';
                }

				$taxonomyList = trim($taxonomyList, ', ');

				$handleChangesOutput['bulk'] .= $taxonomyList;

				$handleChangesOutput['bulk'] .= '</strong>, ';

				$anyUnloadRule = true;
			}

			$unloadBulkKeys = isset($handleData['unload_bulk']) ? array_keys($handleData['unload_bulk']) : array();
			$unloadBulkKeysStr = implode('', $unloadBulkKeys);

			if (isset($handleData['unload_bulk']['date'])
                || isset($handleData['unload_bulk']['404'])
                || isset($handleData['unload_bulk']['search'])
                || (strpos($unloadBulkKeysStr, 'custom_post_type_archive_') !== false)
            ) {
				foreach ($handleData['unload_bulk'] as $bulkType => $bulkValue) {
					if ($bulkType === 'date' && $bulkValue === 1) {
						$handleChangesOutput['bulk'] .= ' Выгружается на всех страницах архива `Дата` (любая дата), ';
						$anyUnloadRule = true;
					}
					if ($bulkType === 'search' && $bulkValue === 1) {
						$handleChangesOutput['bulk'] .= ' Выгружается на странице `Поиск` (любое ключевое слово), ';
						$anyUnloadRule = true;
					}
					if ($bulkType === 404 && $bulkValue === 1) {
						$handleChangesOutput['bulk'] .= ' Выгружается на странице «404 Not Found» (любой URL), ';
						$anyUnloadRule = true;
					}
					if (strpos($bulkType, 'custom_post_type_archive_') !== false) {
					    $customPostType = str_replace('custom_post_type_archive_', '', $bulkType);
						$handleChangesOutput['bulk'] .= ' Выгружается на странице архива (списка постов) `'.$customPostType.'` custom post type'.self::anyNoPostTypeEntriesMsg($customPostType).', ';
						$anyUnloadRule = true;
					}
				}
			}

			if (isset($handleData['unload_bulk']['author']) && $handleData['unload_bulk']['author']) {
				$handleChangesOutput['bulk'] .= ' Выгружается на всех авторских страницах, ';
				$anyUnloadRule = true;
			}
            // [/wpacu_pro]

			$handleChangesOutput['bulk'] = rtrim($handleChangesOutput['bulk'], ', ');

			if (isset($handleChangesOutput['site_wide'])) {
				$handleChangesOutput['bulk'] .= ' * <em>ненужный, так как он уже выгружен для всего сайта</em>';
				$hasRedundantUnloadRules = true;
			}
		}

		if (isset($handleData['unload_on_home_page']) && $handleData['unload_on_home_page']) {
			$handleChangesOutput['on_home_page'] = '<span style="color: #cc0000;">Разгружено</span> on the <a target="_blank" href="'.Misc::getPageUrl(0).'">homepage</a>';

			if (isset($handleChangesOutput['site_wide'])) {
				$handleChangesOutput['on_home_page'] .= ' * <em>ненужный, так как он уже выгружен для всего сайта</em>';
				$hasRedundantUnloadRules = true;
			}

			$anyUnloadRule = true;
        }

		if (isset($handleData['load_exception_on_home_page']) && $handleData['load_exception_on_home_page']) {
			$handleChangesOutput['load_exception_on_home_page'] = '<span style="color: green;">Loaded (as an exception)</span> on the <a target="_blank" href="'.Misc::getPageUrl(0).'">homepage</a>';
			$anyLoadExceptionRule = true;
		}

		// On this page: post, page, custom post type
		if (isset($handleData['unload_on_this_page']['post'])) {
			$handleChangesOutput['on_this_post'] = '<span style="color: #cc0000;">Выгружается в следующих сообщениях:</span> ';

			$postsList = '';

			sort($handleData['unload_on_this_page']['post']);

			foreach ($handleData['unload_on_this_page']['post'] as $postId) {
				$postData   = get_post($postId);

                if (isset($postData->post_title, $postData->post_type)) {
	                $postTitle  = $postData->post_title;
	                $postType   = $postData->post_type;
                    $postStatus = $postData->post_status;

	                $postsList .= '<a title="Post Title: ' . esc_attr( $postTitle ) . ', Post Type: ' . esc_attr( $postType ) . '" class="wpacu-tooltip" target="_blank" href="' . esc_url( admin_url( 'post.php?post=' . $postId . '&action=edit' ) ) . '">' . $postId . '</a>';

                    if ($postStatus === 'trash') {
                        $postsList .= '&nbsp;<span style="color: #cc0000;" title="The post is in the \'Trash\'. This rule is not relevant if the post URL is not accessible." class="wpacu-tooltip dashicons dashicons-warning"></span>';
                    }

                    $postsList .= ', ';
                } else {
	                $postsList .= '<s class="wpacu-tooltip" title="N/A (post deleted)" style="color: #cc0000;">'.$postId.'</s>, ';
                }
			}

			$handleChangesOutput['on_this_post'] .= rtrim($postsList, ', ');

			if (isset($handleChangesOutput['site_wide'])) {
				$handleChangesOutput['on_this_post'] .= ' * <em>ненужный, так как он уже выгружен для всего сайта</em>';
				$hasRedundantUnloadRules = true;
            }

			$anyUnloadRule = true;
		}

		// [wpacu_pro]
		// Unload on this page: taxonomy such as 'category', 'product_cat' (specific one, not all categories)
		if (isset($handleData['unload_on_this_page']['term'])) {
			$handleChangesOutput['on_this_tax'] = '<span style="color: #cc0000;">Выгружается на следующих страницах:</span> ';

			$taxList = '';

			sort($handleData['unload_on_this_page']['term']);

			foreach ($handleData['unload_on_this_page']['term'] as $termId) {
				$taxData = term_exists((int)$termId) ? get_term($termId) : false;

				if ( ! $taxData || (isset($taxData->errors['invalid_taxonomy']) && ! empty($taxData->errors['invalid_taxonomy'])) ) {
					$taxList .= '<span style="color: darkred; font-style: italic;">Ошибка: Таксономия с ID '.$termId.' does not exist anymore (rule does not apply)</span>';
				} else {
                    $taxonomy    = $taxData->taxonomy;

					global $wp_rewrite;
					$termPermalink = $wp_rewrite->get_extra_permastruct( $taxonomy );

                    if ($termPermalink) {
	                    $termLink    = get_term_link( $taxData, $taxonomy );
	                    $termRelLink = str_replace( site_url(), '', $termLink );
	                    $taxList     .= '<a target="_blank" href="' . $termLink . '">' . $termRelLink . '</a>, ';
                    } else {
	                    $termLink    = @get_term_link( $taxData, $taxonomy );
	                    $termRelLink = str_replace( site_url(), '', $termLink );
	                    $taxList     .= '<a target="_blank" href="' . $termLink . '">' . $termRelLink . '</a> <span style="color: #cc0000;" title="The taxonomy might not exist anymore as its permalink could not be retrieved" class="wpacu-tooltip dashicons dashicons-warning"></span>, ';
                    }
				}
			}

			$handleChangesOutput['on_this_tax'] .= rtrim($taxList, ', ');

			if (isset($handleChangesOutput['site_wide'])) {
				$handleChangesOutput['on_this_tax'] .= ' * <em>ненужный, так как он уже выгружен для всего сайта</em>';
				$hasRedundantUnloadRules = true;
			}

			$anyUnloadRule = true;
		}

		if (isset($handleData['unload_on_this_page']['user'])) {
			$handleChangesOutput['on_this_tax'] = '<span style="color: #cc0000;">Выгружено</span> на следующих авторских страницах: ';

			$taxList = '';

			sort($handleData['unload_on_this_page']['user']);

			foreach ($handleData['unload_on_this_page']['user'] as $userId) {
                $user = get_user_by('id', $userId);

                if (isset($user->ID)) {
	                $authorLink    = get_author_posts_url( $userId );
	                $authorRelLink = str_replace( site_url(), '', $authorLink );

	                $taxList .= '<a target="_blank" href="' . $authorLink . '">' . $authorRelLink . '</a>, ';
                } else {
	                $taxList .= '<s style="color: #cc0000;">Н/Д (пользователь со следующим был удален: <strong>'.$userId.'</strong>)</s>, ';
                }
			}

			$handleChangesOutput['on_this_tax'] .= rtrim($taxList, ', ');

			if (isset($handleChangesOutput['site_wide'])) {
				$handleChangesOutput['on_this_tax'] .= ' * <em>ненужный, так как он уже выгружен для всего сайта</em>';
				$hasRedundantUnloadRules = true;
			}

			$anyUnloadRule = true;
		}

		// Unload via RegEx
		if (isset($handleData['unload_regex']) && $handleData['unload_regex']) {
			$handleChangesOutput['unloaded_via_regex'] = '<span style="color: #cc0000;">Выгружается, если</span> URI запроса (из URL) соответствует этому регулярному выражению (es): <code style="color: #cc0000;">'.nl2br($handleData['unload_regex']).'</code>';

			if (isset($handleChangesOutput['site_wide'])) {
				$handleChangesOutput['unloaded_via_regex'] .= ' * <em>unnecessary, as it\'s already unloaded site-wide</em>';
				$hasRedundantUnloadRules = true;
			}

			$anyUnloadRule = true;
		}
		// [/wpacu_pro]

		// Maybe it has other unload rules on top of the site-wide one (which covers everything)
		if ($hasRedundantUnloadRules) {
			$uniqueDelimiter = md5($handleData['handle'] . $handleData['asset_type']);
			$clearRedundantUnloadRulesConfirmMsg = sprintf(esc_js(__('This will clear all redundant (useless) unload rules for the `%s` CSS handle as there\'s already a site-wide rule applied.', 'wp-asset-clean-up')), $handleData['handle']) . '\n\n' . esc_js(__('Click `OK` to confirm the action', 'wp-asset-clean-up')).'!';
			$wpacuNonceField = wp_nonce_field('wpacu_clear_all_redundant_rules', 'wpacu_clear_all_redundant_rules_nonce');
			$clearRedundantUnloadRulesArea = <<<HTML
<form method="post" action="" style="display: inline-block;">
<input type="hidden" name="wpacu_action" value="clear_all_redundant_unload_rules" />
<input type="hidden" name="wpacu_handle" value="{$handleData['handle']}" />
<input type="hidden" name="wpacu_asset_type" value="{$handleData['asset_type']}" />
{$wpacuNonceField}
<script type="text/javascript">
var wpacuClearRedundantUnloadRulesConfirmMsg_{$uniqueDelimiter} = "{$clearRedundantUnloadRulesConfirmMsg}";
</script>
<button onclick="return confirm(wpacuClearRedundantUnloadRulesConfirmMsg_{$uniqueDelimiter});" type="submit" class="button button-secondary"><span class="dashicons dashicons-trash" style="vertical-align: text-bottom;"></span> Clear all redundant unload rules</button>
</form>
HTML;
			$handleChangesOutput['has_redundant_unload_rules'] = $clearRedundantUnloadRulesArea;
		}

		if (isset($handleData['ignore_child']) && $handleData['ignore_child']) {
            $handleChangesOutput['ignore_child'] = 'Если выгружено по какому-либо правилу, игнорируйте зависимости и оставьте загруженными его "потомков"';
		}

		// Load exceptions? Per page, via RegEx, if user is logged-in
		if (isset($handleData['load_exception_on_this_page']['post'])) {
			$handleChangesOutput['load_exception_on_this_post'] = '<span style="color: green;">Загружено (в виде исключения)</span> в следующих постах: ';

			$postsList = '';

			sort($handleData['load_exception_on_this_page']['post']);

			foreach ($handleData['load_exception_on_this_page']['post'] as $postId) {
				$postData   = get_post($postId);

                if (isset($postData->post_title, $postData->post_type)) {
				    $postTitle  = $postData->post_title;
				    $postType   = $postData->post_type;
				    $postsList .= '<a title="Post Title: '.esc_attr($postTitle).', Post Type: '.esc_attr($postType).'" class="wpacu-tooltip" target="_blank" href="'.esc_url(admin_url('post.php?post='.$postId.'&action=edit')).'">'.$postId.'</a>, ';
                } else {
	                $postsList .= '<s class="wpacu-tooltip" title="Н/Д (сообщение удалено)" style="color: #cc0000;">'.$postId.'</s>, ';
                }
			}

			$handleChangesOutput['load_exception_on_this_post'] .= rtrim($postsList, ', ');
			$anyLoadExceptionRule = true;
		}

		// e.g. Unloaded site-wide, but loaded on all 'product' (WooCommerce) pages
		if (isset($handleData['load_exception_post_type'])) {
			$handleChangesOutput['load_exception_post_type'] = '<span style="color: green;">Загружается (как исключение)</span> на всех страницах следующих типов записей: ';

			$postTypesList = '';

			sort($handleData['load_exception_post_type']);

			foreach ($handleData['load_exception_post_type'] as $postType) {
				$postTypesList .= '<strong>'.$postType.'</strong>'.self::anyNoPostTypeEntriesMsg($postType).', ';
			}

			$handleChangesOutput['load_exception_post_type'] .= rtrim($postTypesList, ', ');
			$anyLoadExceptionRule = true;
		}

		// [wpacu_pro]
        // Load exception on all pages of [post] type when specific taxonomies are set
		if (isset($handleData['load_exception_post_type_via_tax'])) {
			$handleChangesOutput['load_exception_post_type_via_tax'] = '';

			foreach ($handleData['load_exception_post_type_via_tax'] as $postType => $termIds) {
				$taxTermsToList = $taxLabelsToNames = array();

				$handleChangesOutput['load_exception_post_type_via_tax'] .=
                    '<span style="color: green;">Загружается (в виде исключения)</span> на всех страницах <strong>'
                    . $postType .
                    '</strong> post type'.self::anyNoPostTypeEntriesMsg($postType).' в которых установлены эти таксономии: ';

				foreach ($termIds as $termId) {
				    if ( ! term_exists((int)$termId) ) {
                        $appendAfter = ' <span style="color: #cc0000;" title="The taxonomy might not be available anymore as it was not detected from the specified ID: '.$termId.'" class="wpacu-tooltip dashicons dashicons-warning"></span>';
					    $handleChangesOutput['load_exception_post_type_via_tax'] .= '<strong><s>' . $termId . '</s></strong>'.$appendAfter.' | ';
					    continue;
				    }

					$term = get_term( $termId );
					$taxonomy = get_taxonomy($term->taxonomy);
					$taxLabelsToNames[$taxonomy->label] = $term->taxonomy;
					$taxTermsToList[$taxonomy->label][] = $term->name. ' ('.$term->count.')';
				}

				if ( ! empty($taxTermsToList) ) {
					foreach ( array_keys( $taxTermsToList ) as $taxonomyLabel ) {
						usort( $taxTermsToList[ $taxonomyLabel ], static function( $a, $b ) {
							return strcasecmp( $a, $b );
						} );
					}

					foreach ( $taxTermsToList as $categoryTitle => $termsAssoc ) {
						$handleChangesOutput['load_exception_post_type_via_tax'] .= '<strong>' . $categoryTitle . '</strong> (' . $taxLabelsToNames[ $categoryTitle ] . '): ' . implode( ', ', $termsAssoc ) . ' | ';
					}

					$handleChangesOutput['load_exception_post_type_via_tax'] = rtrim( $handleChangesOutput['load_exception_post_type_via_tax'], ' | ' );
					$handleChangesOutput['load_exception_post_type_via_tax'] .= '<br />';

					$anyLoadExceptionRule = true;
				}
		    }
        }

        // Load exceptions? Per taxonomy page (e.g. /category/clothes/)
		if (isset($handleData['load_exception_on_this_page']['term'])) {
			$handleChangesOutput['load_exception_on_this_taxonomy'] = '<span style="color: green;">Загружено (как исключение)</span> на следующих страницах таксономии: ';

			$postsList = '';

			sort($handleData['load_exception_on_this_page']['term']);

			foreach ($handleData['load_exception_on_this_page']['term'] as $termId) {
				$termData = get_term_by('term_taxonomy_id', $termId);

				if (! $termData) {
					$postsList .= '<span style="color: darkred; font-style: italic;">Error: Taxonomy with ID '.$termId.' больше не существует (правило не применяется)</span>';
				} else {
					$postsList .= '<a title="" target="_blank" href="' . esc_url( admin_url( 'term.php?taxonomy=' . $termData->taxonomy . '&tag_ID=' . $termId ) ) . '">' . $termId . '</a> (' . $termData->name . ' / taxonomy: ' . $termData->taxonomy . '), ';
				}
			}

			$handleChangesOutput['load_exception_on_this_taxonomy'] .= rtrim($postsList, ', ');
			$anyLoadExceptionRule = true;
		}

		// Load exceptions? Per user archive page (e.g. /author/john/)
		if (isset($handleData['load_exception_on_this_page']['user'])) {
			$handleChangesOutput['load_exception_on_this_user'] = '<span style="color: green;">Загружено (в виде исключения)</span> на следующих страницах пользовательского архива: ';

			$usersList = '';

			sort($handleData['load_exception_on_this_page']['user']);

			foreach ($handleData['load_exception_on_this_page']['user'] as $userId) {
				$userData = get_user_by('id', $userId);

				if (! $userData) {
					$usersList .= '<span style="color: darkred; font-style: italic;">Ошибка: пользователь с ID '.$userId.' больше не существует (правило не применяется)</span>';
				} else {
					$usersList .= '<a title="" target="_blank" href="' . esc_url ( admin_url( 'user-edit.php?user_id=' . $userData->ID ) ) . '">' . $userData->ID . '</a> (' . $userData->data->user_nicename . '), ';
				}
			}

			$handleChangesOutput['load_exception_on_this_user'] .= rtrim($usersList, ', ');
			$anyLoadExceptionRule = true;
		}

		// Load exceptions? Search page
		if (isset($handleData['load_exception_on_this_page']['search'])) {
			$handleChangesOutput['load_exception_on_search_any_term'] = '<span style="color: green;">Загружено (в виде исключения)</span> in a `Search` page (any term)';
			$anyLoadExceptionRule = true;
		}

		// Load exceptions? 404 page
		if (isset($handleData['load_exception_on_this_page']['404'])) {
			$handleChangesOutput['load_exception_on_404_page'] = '<span style="color: green;">Загружено (в виде исключения)</span> in a `404 (Not Found)` page';
			$anyLoadExceptionRule = true;
		}

		// Load exceptions? Date archive page
		if (isset($handleData['load_exception_on_this_page']['date'])) {
			$handleChangesOutput['load_exception_on_date_archive_page'] = '<span style="color: green;">Загружено (в виде исключения)</span> in a `Date` archive page';
			$anyLoadExceptionRule = true;
		}

		// Load exceptions? Custom post type archive page
		$loadExceptionsPageStr = isset($handleData['load_exception_on_this_page']) && is_array($handleData['load_exception_on_this_page']) ? implode('', array_keys($handleData['load_exception_on_this_page'])) : '';
		if (strpos($loadExceptionsPageStr, 'custom_post_type_archive_') !== false) {
		    foreach (array_keys($handleData['load_exception_on_this_page']) as $loadExceptionForDataType) {
		        if (strpos($loadExceptionForDataType, 'custom_post_type_archive_') !== false) {
		            $customPostType = str_replace('custom_post_type_archive_', '', $loadExceptionForDataType);
			        $handleChangesOutput['load_exception_on_'.$loadExceptionForDataType] =
                        '<span style="color: green;">Загружено (в виде исключения)</span> на странице архива (пользовательский тип записи: <em>'.$customPostType.'</em>)'.
                        self::anyNoPostTypeEntriesMsg($customPostType);
		        }
		    }

			$anyLoadExceptionRule = true;
		}

		if (isset($handleData['load_regex']) && $handleData['load_regex']) {
		    if ($anyLoadExceptionRule) {
		        $textToShow = ' <strong>или</strong> если URI запроса (из URL) соответствует этому регулярному выражению';
            } else {
			    $textToShow = '<span style="color: green;">Загружается (как исключение)</span>, если URI запроса (из URL) соответствует этому RegEx(es)';
            }

			$handleChangesOutput['load_exception_regex'] = $textToShow.': <code style="color: green;">'.nl2br($handleData['load_regex']).'</code>';
			$anyLoadExceptionRule = true;
		}
		// [/wpacu_pro]

		if (isset($handleData['load_it_logged_in']) && $handleData['load_it_logged_in']) {
			if ($anyLoadExceptionRule) {
				$textToShow = ' <strong>или</strong> если пользователь вошел в систему';
			} else {
				$textToShow = '<span style="color: green;">Загружается (как исключение)</span>, если пользователь вошел в систему';
			}

			$handleChangesOutput['load_it_logged_in'] = $textToShow;
			$anyLoadExceptionRule = true;
		}

		// Since more than one load exception rule is set, merge them on the same row to save space and avoid duplicated words
		if (isset($handleChangesOutput['load_exception_on_this_post'], $handleChangesOutput['load_exception_regex'])) {
			$handleChangesOutput['load_exception_all'] = $handleChangesOutput['load_exception_on_this_post'] . $handleChangesOutput['load_exception_regex'];
			unset($handleChangesOutput['load_exception_on_this_post'], $handleChangesOutput['load_exception_regex']);
        }

		if (! $anyUnloadRule && $anyLoadExceptionRule) {
		    $handleType = ($handleData['asset_type'] === 'styles') ? 'CSS' : 'JS';
		    $clearLoadExceptionsConfirmMsg = sprintf( esc_attr(__('This will clear all load exceptions for the `%s` %s handle', 'wp-asset-clean-up')), $handleData['handle'], $handleType).'.' . '\n\n' . esc_js(__('Click `OK` to confirm the action', 'wp-asset-clean-up')).'!';
		    $wpacuNonceField = wp_nonce_field('wpacu_clear_load_exceptions', 'wpacu_clear_load_exceptions_nonce');

		    $uniqueDelimiter = md5($handleData['handle'].$handleData['asset_type']);
		    $clearLoadExceptionsArea = <<<HTML
<form method="post" action="" style="display: inline-block;">
<input type="hidden" name="wpacu_action" value="clear_load_exceptions" />
<input type="hidden" name="wpacu_handle" value="{$handleData['handle']}" />
<input type="hidden" name="wpacu_asset_type" value="{$handleData['asset_type']}" />
{$wpacuNonceField}
<script type="text/javascript">
var wpacuClearLoadExceptionsConfirmMsg_{$uniqueDelimiter} = '{$clearLoadExceptionsConfirmMsg}';
</script>
<button onclick="return confirm(wpacuClearLoadExceptionsConfirmMsg_{$uniqueDelimiter});" type="submit" class="button button-secondary clear-load-exceptions"><span class="dashicons dashicons-trash" style="vertical-align: text-bottom;"></span> Очистить исключения загрузки для этого дескриптора</button>
</form>
HTML;
			$handleChangesOutput['load_exception_notice'] = '<div><em><small><strong>Примечание.</strong> Хотя добавлено правило исключения загрузки, оно не имеет значения, так как нет правил, которые работали бы вместе с ним (например, выгружается для всего сайта, для всех сообщений). Это исключение можно убрать, так как файл все равно загружается на всех страницах.</small></em>&nbsp;'.
                ' '.$clearLoadExceptionsArea.'</div><div style="clear:both;"></div>';
		}

		return $handleChangesOutput;
	}

	/**
	 * @param $postType
	 *
	 * @return string
	 */
	public static function anyNoPostTypeEntriesMsg($postType)
    {
	    $appendAfter = '';
	    $postTypeStatus = Misc::isValidPostType($postType);

	    if ( ! $postTypeStatus['has_records'] ) {
		    $appendAfter = ' <span style="color: #cc0000;" title="В базе нет сообщений, имеющих следующий тип сообщения:' . $postType . '" class="wpacu-tooltip dashicons dashicons-warning"></span>';
	    }

        return $appendAfter;
    }
}
