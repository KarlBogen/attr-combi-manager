<?php
namespace KarlK\HookPointManager\Classes\DefaultHookPoints;

/*

	This class provides data for template and shopfile restore

 */

class KKDefaultRestore
{

    public function getRestoreData($modifiedVersion)
    {
		$ResData = array();
		$ResData[] = $this->getXtcRestockData();

		switch ($modifiedVersion) {
			case '2.0.1.0':
			case '2.0.2.0':
			case '2.0.2.1':
			case '2.0.2.2':
			case '2.0.3.0':
			case '2.0.4.0':
			case '2.0.4.1':
			case '2.0.4.2':
				$ResData[] = $this->getMainClassData();
				break;
		}

		$ResData[] = $this->getSumoselectData300();
		$ResData[] = $this->getSumoselectData300nova();
		$ResData[] = $this->getSumoselectData($modifiedVersion);
		$ResData[] = $this->getGeneralBottomData();
		$ResData[] = $this->getDefaultData();
		$TplResData = $this->getProductInfoData();
		$TplResData1 = $this->getProductInfoData300();
		$TplRestoreData = array_merge($ResData, $TplResData, $TplResData1);

        return $TplRestoreData;

    }

	protected function getSumoselectData($modifiedVersion) {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/extra/sumoselect.js.php',
						'SEARCHPATTERN' => $this->getSearchpatternPHP(),
						'REPLACESTRING' => (((strpos($modifiedVersion, '2.0.7.') !== false) || (strpos($modifiedVersion, '3.0') !== false)) ? '	$(\'select:not([name=country])\').SumoSelect();' : '	$(\'select\').SumoSelect();')."\n",
				);
        return $data;

	}

	protected function getSumoselectData300() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/extra/sumoselect.js.php',
						'SEARCHPATTERN' => $this->getSearchpatternPHP300(),
						'REPLACESTRING' => '	$(\'select:not([name=filter_sort]):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([id^=sel_]):not([id=ec_term])\').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"});'."\n",
				);
        return $data;

	}

	protected function getSumoselectData300nova() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/extra/sumoselect.js.php',
						'SEARCHPATTERN' => $this->getSearchpatternPHP300nova(),
						'REPLACESTRING' => '	$(\'select:not([name=filter_sort]):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([name=language]):not([id^=sel_]):not([id=ec_term])\').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"});'."\n",
				);
        return $data;

	}

	protected function getGeneralBottomData() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/general_bottom.js.php',
						'SEARCHPATTERN' => $this->getSearchpatternPHP(),
						'REPLACESTRING' => '	',
				);
        return $data;

	}

	protected function getDefaultData() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/extra/default.js.php',
						'SEARCHPATTERN' => $this->getSearchpatternPHP(),
						'REPLACESTRING' => '',
				);
        return $data;

	}

	protected function getProductInfoData() {

		$data =	array();
		$tpls = array('product_info_tabs_v1.html', 'product_info_tabs_v1_3_spaltig.html', 'product_info_v1.html', 'product_info_x_accordion_v1.html');
		foreach($tpls as $tpl) {
			$data[] =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/module/product_info/' . $tpl,
								'SEARCHPATTERN' => $this->getSearchpatternSmarty(),
								'REPLACESTRING' => '{if isset($MODULE_product_options) && $MODULE_product_options != \'\'}',
						);
		}
        return $data;

	}

	protected function getProductInfoData300() {

		$data =	array();
		$tpls = array('product_info_v1_tabs.html', 'product_info_v2_accordion.html', 'product_info_v3_plain.html');
		foreach($tpls as $tpl) {
			$data[] =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/module/product_info/' . $tpl,
								'SEARCHPATTERN' => $this->getSearchpatternSmarty(),
								'REPLACESTRING' => '{if isset($MODULE_product_options) && $MODULE_product_options != \'\'}{$MODULE_product_options}{/if}',
						);
		}
        return $data;

	}

	protected function getXtcRestockData() {

		$data =	array(	'TPLFILE' => DIR_FS_INC . 'xtc_restock_order.inc.php',
						'SEARCHPATTERN' => $this->getSearchpatternPHP(),
						'REPLACESTRING' => '        }'."\n",
				);
        return $data;

	}

	protected function getMainClassData() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . DIR_WS_CLASSES . 'main.php',
						'SEARCHPATTERN' => $this->getSearchpatternPHP(),
						'REPLACESTRING' => $this->getMainClassString(),
				);
        return $data;

	}

	protected function getMainClassString() {

		$code .= '//new module support' . "\n";
		$code .= '    $attributes = $this->mainModules->getAttributesSelect($attributes,$paramsArr,$paramsArrOrigin);' . "\n\n";
		$code .= '    return xtc_db_fetch_array($attributes);' . "\n";
        return $code;

	}

	protected function getSearchpatternPHP() {

		$searchpattern = '!/\* BOF Module "Attribute Kombination Manager.*?Attribute Kombination Manager" made by Karl \*/\n!s';
        return $searchpattern;

	}

	protected function getSearchpatternPHP300() {

		$searchpattern = '!/\* BOF Module "Attribute Kombination Manager.*?Attribute Kombination Manager" made by Karl responsive \*/\n!s';
        return $searchpattern;

	}

	protected function getSearchpatternPHP300nova() {

		$searchpattern = '!/\* BOF Module "Attribute Kombination Manager.*?Attribute Kombination Manager" made by Karl nova \*/\n!s';
        return $searchpattern;

	}

	protected function getSearchpatternSmarty() {

		$searchpattern = '!{\* BOF Module "Attribute Kombination Manager.*?Attribute Kombination Manager" made by Karl \*}!s';
        return $searchpattern;

	}

}