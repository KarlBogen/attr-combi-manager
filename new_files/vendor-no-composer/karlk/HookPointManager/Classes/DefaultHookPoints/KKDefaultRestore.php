<?php
namespace KarlK\HookPointManager\Classes\DefaultHookPoints;

/*

	This class provides data for template and shopfile restore

 */

class KKDefaultRestore
{

    public function getRestoreData()
    {
		$ResData = array();
		$ResData[] = $this->getXtcRestockData();
		$ResData[] = $this->getMainClassData();
		$ResData[] = $this->getSumoselectData();
		$ResData[] = $this->getGeneralBottomData();
		$ResData[] = $this->getDefaultData();
		$TplResData = $this->getProductInfoData();
		$TplRestoreData = array_merge($ResData, $TplResData);

        return $TplRestoreData;

    }

	protected function getSumoselectData() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/extra/sumoselect.js.php',
						'SEARCHPATTERN' => $this->getSearchpatternPHP(),
						'REPLACESTRING' => '$(\'select\').SumoSelect();'."\n",
				);
        return $data;

	}

	protected function getGeneralBottomData() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/general_bottom.js.php',
						'SEARCHPATTERN' => $this->getSearchpatternPHP(),
						'REPLACESTRING' => '',
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

	protected function getSearchpatternSmarty() {

		$searchpattern = '!{\* BOF Module "Attribute Kombination Manager.*?Attribute Kombination Manager" made by Karl \*}!s';
        return $searchpattern;

	}

}