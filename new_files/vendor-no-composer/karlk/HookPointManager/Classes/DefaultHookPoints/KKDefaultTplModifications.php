<?php
namespace KarlK\HookPointManager\Classes\DefaultHookPoints;

/*

	This class provides data for template modifications

 */

class KKDefaultTplModifications
{

    public function getModifyData($modifiedVersion)
    {
		$ModData = $TplModifyData = array();

		switch ($modifiedVersion) {

			case '2.0.0.0':
				break;

			case '2.0.1.0':
			case '2.0.2.0':
			case '2.0.2.1':
			case '2.0.2.2':
			case '2.0.3.0':
			case '2.0.4.0':
			case '2.0.4.1':
			case '2.0.4.2':
				$ModData[] = $this->getGeneralBottomData24();
				$ModData[] = $this->getGeneralBottomData();
				$TplModData = $this->getProductInfoData();
				$TplModifyData = array_merge($ModData, $TplModData);
				break;

			case '2.0.5.0':
			case '2.0.5.1':
			case '2.0.6.0':
				$ModData[] = $this->getSumoselectData();
				$ModData[] = $this->getExtraDefaultData();
				$ModData[] = $this->getGeneralBottomData();
				$TplModData = $this->getProductInfoData();
				$TplModifyData = array_merge($ModData, $TplModData);
				break;

			case '3.0.0':
			case '3.0.1':
			case '3.0.2':
				$ModData[] = $this->getSumoselectData300();
				$ModData[] = $this->getSumoselectData300nova();
				$TplModData300 = $this->getProductInfoData300();

			case '2.0.7.0':
			case '2.0.7.1':
			case '2.0.7.2':
			case '3.0.0':
			case '3.0.1':
			case '3.0.2':
			default:
				$ModData[] = $this->getSumoselectData2070();
				$ModData[] = $this->getExtraDefaultData();
				$ModData[] = $this->getGeneralBottomData();
				$TplModData1 = $this->getProductInfoData2070();
				$TplModData = $this->getProductInfoData();
        if(is_array($TplModData300)) {
					$TplModifyData = array_merge($ModData, $TplModData1, $TplModData, $TplModData300);
				} else {
					$TplModifyData = array_merge($ModData, $TplModData1, $TplModData);
				}
				break;

		}

        return $TplModifyData;

    }

	protected function getSumoselectData() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/extra/sumoselect.js.php',
						'SEARCHSTRING' => '$(\'select\').SumoSelect();',
						'KEYPLUS' => 0,
						'REPLACESTRING' => $this->getSumoselectString(),
				);
        return $data;

	}

	protected function getSumoselectString() {

		$code = '    /* BOF Module "Attribute Kombination Manager" made by Karl */' . "\n";
		$code .= '    /* Original    $(\'select\').SumoSelect(); */' . "\n";
		$code .= '    $(\'select\').not(\'.combi_id\').SumoSelect();' . "\n";
		$code .= '    /* EOF Module "Attribute Kombination Manager" made by Karl */';
        return $code;

	}

	protected function getSumoselectData2070() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/extra/sumoselect.js.php',
						'SEARCHSTRING' => '$(\'select:not([name=country])\').SumoSelect();',
						'KEYPLUS' => 0,
						'REPLACESTRING' => $this->getSumoselectString2070(),
				);
        return $data;

	}

	protected function getSumoselectString2070() {

		$code = '    /* BOF Module "Attribute Kombination Manager" made by Karl */' . "\n";
		$code .= '    /* Original    $(\'select:not([name=country])\').SumoSelect(); */' . "\n";
		$code .= '    $(\'select\').not(\'[name=country], .combi_id\').SumoSelect();' . "\n";
		$code .= '    /* EOF Module "Attribute Kombination Manager" made by Karl */';
        return $code;

	}

	protected function getSumoselectData300() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/extra/sumoselect.js.php',
						'SEARCHSTRING' => '$(\'select:not([name=filter_sort]):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([id^=sel_]):not([id=ec_term])\').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"});',
						'KEYPLUS' => 0,
						'REPLACESTRING' => $this->getSumoselectString300(),
				);
        return $data;

	}

	protected function getSumoselectString300() {

		$code = '    /* BOF Module "Attribute Kombination Manager made by Karl */' . "\n";
		$code .= '    /* Original    $(\'select:not([name=filter_sort]):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([id^=sel_]):not([id=ec_term])\').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"}); */' . "\n";
		$code .= '    $(\'select:not([name=filter_sort]):not(.combi_id):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([id^=sel_]):not([id=ec_term])\').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"});' . "\n";
		$code .= '    /* EOF Module "Attribute Kombination Manager" made by Karl responsive */';
        return $code;

	}

	protected function getSumoselectData300nova() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/extra/sumoselect.js.php',
						'SEARCHSTRING' => '$(\'select:not([name=filter_sort]):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([name=language]):not([id^=sel_]):not([id=ec_term])\').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"});',
						'KEYPLUS' => 0,
						'REPLACESTRING' => $this->getSumoselectString300nova(),
				);
        return $data;

	}

	protected function getSumoselectString300nova() {

		$code = '    /* BOF Module "Attribute Kombination Manager made by Karl */' . "\n";
		$code .= '    /* Original    $(\'select:not([name=filter_sort]):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([name=language]):not([id^=sel_]):not([id=ec_term])\').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"}); */' . "\n";
		$code .= '    $(\'select:not([name=filter_sort]):not(.combi_id):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([name=language]):not([id^=sel_]):not([id=ec_term])\').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"});' . "\n";
		$code .= '    /* EOF Module "Attribute Kombination Manager" made by Karl nova */';
        return $code;

	}

	protected function getExtraDefaultData() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/extra/default.js.php',
						'SEARCHSTRING' => array('<script>', '<script type="text/javascript">'),
						'KEYPLUS' => 0,
						'REPLACESTRING' => $this->getExtraDefaultString(),
				);
        return $data;

	}

	protected function getExtraDefaultString() {

		$code = CURRENT_TEMPLATE != 'xtc5' ? '<script>' . "\n" : '<script type="text/javascript">' . "\n";
		$code .= '  /* BOF Module "Attribute Kombination Manager" made by Karl */' . "\n";
		$code .= $this->getDefaultJSString();
        return $code;

	}

	protected function getDefaultJSString() {

		$code = '  <?php if (defined(\'MODULE_PRODUCTS_COMBINATIONS_STATUS\') && MODULE_PRODUCTS_COMBINATIONS_STATUS == \'true\'): ?>' . "\n";
		$code .= '  $(document).ready(function(){' . "\n";
		$code .= '    if (typeof jqueryReady !== \'undefined\' && $.isFunction(jqueryReady)) {jqueryReady();}' . "\n";
		$code .= '    /* alle Dropdowns müssen ausgewählt sein */' . "\n";
		$code .= '    $("#cart_quantity").submit(function(event) {' . "\n";
		$code .= '      var failed = false;' . "\n";
		$code .= '      $(".combi_id option:selected").each(function(){' . "\n";
		$code .= '        if (!$(this).val()){' . "\n";
		$code .= '          failed = true;' . "\n";
		$code .= '        }' . "\n";
		$code .= '      });' . "\n";
		$code .= '      if (failed == true){' . "\n";
		$code .= '        if ($(\'.combi_stock\').length && $(\'.combi_stock\').text() == \'0\'){' . "\n";
		$code .= '          alert("<?php echo COMBI_TEXT_CANT_BUY ?>");' . "\n";
		$code .= '        } else {' . "\n";
		$code .= '          alert("<?php echo COMBI_TEXT_SEL_ALL_OPTIONS ?>");' . "\n";
		$code .= '        }' . "\n";
		$code .= '        event.preventDefault();' . "\n";
		$code .= '      }' . "\n";
		$code .= '    });' . "\n";
		$code .= '  });' . "\n";
		$code .= '  <?php endif; ?>' . "\n";
		$code .= '  /* EOF Module "Attribute Kombination Manager" made by Karl */';
        return $code;

	}

	protected function getGeneralBottomData() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/general_bottom.js.php',
						'SEARCHSTRING' => '$script_min = DIR_TMPL_JS.\'tpl_plugins.min.js\';',
						'KEYPLUS' => 0,
						'REPLACESTRING' => $this->getGeneralBottomString(),
				);
        return $data;

	}

	protected function getGeneralBottomString() {

		$code = '/* BOF Module "Attribute Kombination Manager" made by Karl */' . "\n";
		$code .= 'if (defined(\'MODULE_PRODUCTS_COMBINATIONS_STATUS\') && MODULE_PRODUCTS_COMBINATIONS_STATUS == \'true\'){' . "\n";
		$code .= '  $script_array[] = DIR_TMPL_JS .\'dependent-dropdown.min.js\';' . "\n";
		$code .= '  if ($_SESSION["language_code"]==\'de\') $script_array[] = DIR_TMPL_JS .\'depdrop_locale_de.js\';' . "\n";
		$code .= '}' . "\n";
		$code .= '/* EOF Module "Attribute Kombination Manager" made by Karl */' . "\n";

		$code .= '$script_min = DIR_TMPL_JS.\'tpl_plugins.min.js\';';
        return $code;

	}

	protected function getGeneralBottomData24() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/javascript/general_bottom.js.php',
						'SEARCHSTRING' => '<script type="text/javascript">',
						'KEYPLUS' => 0,
						'REPLACESTRING' => $this->getGeneralBottomString24(),
				);
        return $data;

	}

	protected function getGeneralBottomString24() {

		// in der Zeile BOF Module "Attribute Kombination Manager made... fehlen die Anführungszeichen hinter Manager absichtlich
		// durch diese Änderung ist eine zweite Anpassung in der selben Datei möglich
		$code = '<script type="text/javascript">' . "\n";
		$code .= '  /* BOF Module "Attribute Kombination Manager made by Karl */' . "\n";
		$code .= $this->getDefaultJSString();
        return $code;

	}

	protected function getProductInfoData() {

		$data =	array();
		$tpls = array('product_info_tabs_v1.html', 'product_info_tabs_v1_3_spaltig.html', 'product_info_v1.html', 'product_info_x_accordion_v1.html');
		foreach($tpls as $tpl) {
			$data[] =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/module/product_info/' . $tpl,
								'SEARCHSTRING' => array('{if isset($MODULE_product_options) && $MODULE_product_options != \'\'}', '{if $MODULE_product_options != \'\'}'),
								'KEYPLUS' => 0,
								'REPLACESTRING' => $this->getProductInfoString(),
						);
		}
        return $data;

	}

	protected function getProductInfoString() {

		$code = '          {* BOF Module "Attribute Kombination Manager" made by Karl *}' . "\n";
		$code .= '          {if isset($MODULE_product_combi) && $MODULE_product_combi != \'\'}' . "\n";
		$code .= '            <div class="card bg-custom mb-2 p-2">' . "\n";
		$code .= '              {$MODULE_product_combi}' . "\n";
		$code .= '            </div>' . "\n";
		$code .= '          {/if}' . "\n";
		$code .= '          {if isset($MODULE_product_options) && $MODULE_product_options != \'\' && empty($MODULE_product_combi)}' . "\n";
		$code .= '          {*if isset($MODULE_product_options) && $MODULE_product_options != \'\'*}' . "\n";
		$code .= '          {* EOF Module "Attribute Kombination Manager" made by Karl *}';
        return $code;

	}

	protected function getProductInfoData2070() {

		$data =	array();
		$tpls = array('product_info_tabs_v1.html', 'product_info_v1.html', 'product_info_x_accordion_v1.html');
		foreach($tpls as $tpl) {
			$data[] =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/module/product_info/' . $tpl,
								'SEARCHSTRING' => array('{if $MODULE_product_options_template != \'multi_options_1.html\' && $MODULE_product_options_template|strpos:"dropdown" === false}', '{if $MODULE_product_options_template != \'multi_options_1.html\' && strpos($MODULE_product_options_template, \'dropdown\' === false}'),
								'KEYPLUS' => -1,
								'REPLACESTRING' => $this->getProductInfoString2070(),
						);
		}
        return $data;

	}

	protected function getProductInfoString2070() {

		$code = '      {* BOF Module "Attribute Kombination Manager made by Karl *}' . "\n";
		$code .= '      {if isset($MODULE_product_options) && $MODULE_product_options != \'\' && empty($MODULE_product_combi)}' . "\n";
		$code .= '      {*if isset($MODULE_product_options) && $MODULE_product_options != \'\'*}' . "\n";
		$code .= '      {* EOF Module "Attribute Kombination Manager" made by Karl *}';
        return $code;

	}

	protected function getProductInfoData300() {

		$data =	array();
		$tpls = array('product_info_v1_tabs.html', 'product_info_v2_accordion.html', 'product_info_v3_plain.html');
		foreach($tpls as $tpl) {
			$data[] =	array(	'TPLFILE' => DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/module/product_info/' . $tpl,
								'SEARCHSTRING' => '{if isset($MODULE_product_options) && $MODULE_product_options != \'\'}{$MODULE_product_options}{/if}',
								'KEYPLUS' => 0,
								'REPLACESTRING' => $this->getProductInfoString300(),
						);
		}
        return $data;

	}

	protected function getProductInfoString300() {

		$code = '          {* BOF Module "Attribute Kombination Manager" made by Karl *}' . "\n";
		$code .= '          {if isset($MODULE_product_combi) && $MODULE_product_combi != \'\'}' . "\n";
		$code .= '            <div class="card bg-custom mb-2 p-2">' . "\n";
		$code .= '              {$MODULE_product_combi}' . "\n";
		$code .= '            </div>' . "\n";
		$code .= '          {/if}' . "\n";
		$code .= '          {if isset($MODULE_product_options) && $MODULE_product_options != \'\' && empty($MODULE_product_combi)}{$MODULE_product_options}{/if}' . "\n";
		$code .= '          {*if isset($MODULE_product_options) && $MODULE_product_options != \'\'}{$MODULE_product_options}{/if*}' . "\n";
		$code .= '          {* EOF Module "Attribute Kombination Manager" made by Karl *}';
        return $code;

	}

}