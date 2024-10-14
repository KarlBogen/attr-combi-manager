<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

if (isset($_REQUEST['speed'])) {

	require_once ('includes/application_top.php');
	require_once (DIR_FS_INC.'db_functions_'.DB_MYSQL_TYPE.'.inc.php');
	require_once (DIR_FS_INC.'db_functions.inc.php');
	require_once (DIR_WS_INCLUDES.'database_tables.php');

}

function get_products_combi_data() {

	if (isset($_POST['func']) && $_POST['func']) {
		$func = xtc_db_prepare_input($_POST['func']);
		switch($func) {
			case 'getImage':
				$prod_id = xtc_db_prepare_input((int)$_POST['prod_id']);
				$attribute_id = xtc_db_prepare_input($_POST['attribute_id']);
				return getImage($prod_id, $attribute_id);
				break;
		}
	}

	if (!empty($_POST['depdrop_params'])) {
	   $out = [];
	    if (isset($_POST['depdrop_parents'])) {
	        $ids = $_POST['depdrop_parents'];
	          if($ids) $data = getData($ids);
	            /**
	             * the getProdList function will query the database based on the
	             * cat_id and sub_cat_id and return an array like below:
	             *  [
	             *      'out'=>[
	             *          ['id'=>'<prod-id-1>', 'name'=>'<prod-name1>'],
	             *          ['id'=>'<prod-id-2>', 'name'=>'<prod-name2>']
	             *       ],
	             *       'selected'=>'<prod-id-1>'
	             *  ]
	             */

	           return ['output'=> $data['out'], 'selected'=> $data['selected']];
	        }
	    return ['output'=>'', 'selected'=>''];
	}

}


function getImage($prod_id, $attribute_id){

	$tmpquery =	xtc_db_query("
		SELECT
			 options_ids
		FROM
			 ".TABLE_PRODUCTS_OPTIONS_COMBI."
		WHERE
			 products_id = ".(int)$prod_id."
		LIMIT 1");
	$tmpdata = xtc_db_fetch_array($tmpquery);
	$options_ids = str_replace(',', '_', $tmpdata["options_ids"]);

	$tmpquery =	xtc_db_query("
		SELECT
			 model, ean, stock, image
		FROM
			 ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2."
		WHERE
			 products_id = ".(int)$prod_id."
		AND
		 	attribute_id = '".$attribute_id."'
		LIMIT 1");
	$tmpdata = xtc_db_fetch_array($tmpquery);

	$model = $tmpdata["model"] != '' ? $tmpdata["model"] : '';
	$ean = $tmpdata["ean"] != '' ? $tmpdata["ean"] : '';
	$stock = $tmpdata["stock"] != '' ? $tmpdata["stock"] : '';
	$image = $tmpdata["image"] != '' ? $tmpdata["image"] : '';

			if (defined('IMAGE_TYPE_EXTENSION')
				&& IMAGE_TYPE_EXTENSION != 'default'
				&& $image != ''
				)
			{
				$name_extension = substr($image, 0, strrpos($image, '.')).'.'.IMAGE_TYPE_EXTENSION;
				if (is_file(DIR_FS_CATALOG.DIR_WS_THUMBNAIL_IMAGES.$name_extension)) {
					$image = $name_extension;
				}
			}

			$res =  array(
				"options_ids"	=>  $options_ids,
				"model"			=>  $model,
				"ean"			=>  $ean,
				"stock"			=>  $stock,
				"image"			=>  $image
			);

			// ajax response
			return $res;

}

function getData($datas){
	global $xtPrice;

	$params = $_POST['depdrop_params'];
	$prod_id = $params[0]; // get the value prod_id
	$prod_price = $params[1]; // get the value prod_price
	$tax_id = $params[2]; // get the value tax_id
	$products_vpe = $params[3]; // get the value products_vpe
	$vpe_status = $params[4]; // get the value vpe_status
	$vpe_value = $params[5]; // get the value vpe_value
	$discount = $params[6]; // get the value dicount
	$stock_check = isset($params[7]) ? $params[7] : false; // get the value stock_check
	$show_empty = isset($params[8]) ? $params[8] : false; // get the value show_empty

	$tmpquery = "SELECT options_values_ids FROM ".TABLE_PRODUCTS_OPTIONS_COMBI."	WHERE products_id = ".(int)$prod_id." LIMIT 1";
	$tmpresult = xtc_db_query($tmpquery);
	$tmpdata = xtc_db_fetch_array($tmpresult);

	$data["options_values_ids"] = $tmpdata["options_values_ids"];

	$tmpquery = xtc_db_query("SELECT status, attribute_id, attribute_name, stock FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2." WHERE products_id = ".(int)$prod_id." ORDER BY combi_sort, combi_value_id");
	while ($tmpresult = xtc_db_fetch_array($tmpquery)) {
		$tmpdatas[] = $tmpresult;
	}
	foreach($tmpdatas as $tmpdata){
		$data["status"][] = $tmpdata["status"];
		$data["attribute_name"][] = $tmpdata["attribute_name"];
		$data["attribute_id"][] = $tmpdata["attribute_id"];
		$data["stock"][] = $tmpdata["stock"];
	}

	// Optionsnamen der Produkte holen
	$tmpquery = "SELECT products_options_values_id, products_options_values_name FROM ".TABLE_PRODUCTS_OPTIONS_VALUES." WHERE products_options_values_id IN (".$data["options_values_ids"].") AND language_id = ".$_SESSION['languages_id'];
	$tmpresult = xtc_db_query($tmpquery);
	for($i=0;$tmpdata = xtc_db_fetch_array($tmpresult);$i++){
		$option_values_names[$tmpdata['products_options_values_id']] = $tmpdata['products_options_values_name'];
	}

    $new_array = array();
	$data_size = sizeof($datas);


	// Attributspreise und -prefixe holen
    $opt_vals = array();
	$tmpquery = "SELECT options_id, options_values_id, options_values_price, price_prefix, attributes_vpe_value FROM ".TABLE_PRODUCTS_ATTRIBUTES." WHERE products_id = ".(int)$prod_id;
	$tmpresult = xtc_db_query($tmpquery);

	for($i=0;$tmpdata = xtc_db_fetch_array($tmpresult);$i++){
		$opt_vals[$tmpdata['options_values_id']] = array(	'options_values_price' => $tmpdata['options_values_price'],
															'attributes_vpe_value' => $tmpdata['attributes_vpe_value'],
															'price_prefix' => $tmpdata['price_prefix']
														);
	}

	for($i=0; $i < sizeof($data["attribute_id"]);$i++){

		// Wenn Kombination den Status 0 hat, dann diese Schleife beenden
		if ($data["status"][$i] != '0') {
			$stocks = $data["stock"][$i];
			$val_names = explode(' / ', $data["attribute_name"][$i]);
			$val_ids = explode('_', $data["attribute_id"][$i]);

			$val_size = sizeof($val_ids);

			// ID-Array auf Vergleichslänge kürzen
			$search = array_slice($val_ids, -($val_size), $data_size);

			// ID-Array mit Ajax-Datenarray vergleichen
			if ($search == $datas) {

				// Optionspreisangabe zusammensetzen
				$price = 0;
				$opt_price_name = '';
				$opt_price = $opt_vals[$val_ids[$data_size]]['options_values_price'];
				$opt_prefix = $opt_vals[$val_ids[$data_size]]['price_prefix'];
				if ($opt_price != '0.00') {
					if ($_SESSION['customers_status']['customers_status_show_price'] == '0') {
						// $price = '';
					} else {
				        $CalculateCurr = ($tax_id == 0) ? true : false; //FIX several currencies on product attributes
				        $price = $xtPrice->xtcFormat(floatval($opt_price), false, $tax_id, $CalculateCurr);
					}
                    //BOF PRICE PREFIX
                    if ($_SESSION['customers_status']['customers_status_discount_attributes'] == 1 && $opt_prefix != '-') {
                        $price -= $price / 100 * $discount;
                    }

					$opt_price_name = $price != 0 ? '  '.$opt_prefix.' '.html_entity_decode($xtPrice->xtcFormat($price, true)) : '';
				}

				// Daten für Preisupdater zusammensetzen
				$JSON_ATTRDATA[$val_ids[$data_size]] = json_encode(
					[
						'pid'          => (int)$prod_id,
						'gprice'       => floatval($prod_price),
						'oprice'       => $xtPrice->xtcFormat($xtPrice->xtcAddTax($xtPrice->getPprice((int)$prod_id), $xtPrice->TAX[$tax_id]), false),
						'cleft'        => $xtPrice->currencies[$_SESSION['currency']]['symbol_left'],
						'cright'       => $xtPrice->currencies[$_SESSION['currency']]['symbol_right'],
						'prefix'       => $opt_vals[$val_ids[$data_size]]['price_prefix'],
						'aprice'       => $xtPrice->xtcFormat($price, false),
						'vpetext'      => $products_vpe,
						'vpevalue'     => (($vpe_status && (double)$vpe_value) ? (double)$vpe_value : false),
						'attrvpevalue' => (($vpe_status && (double)$opt_vals[$val_ids[$data_size]]['attributes_vpe_value']) ? (double)$opt_vals[$val_ids[$data_size]]['attributes_vpe_value'] : false),
						'onlytext'     => isset($json_onlytext) ? $json_onlytext : COMBI_TXT_ONLY,
						'protext'      => isset($json_protext) ? $json_protext : TXT_PER,
						'insteadtext'  => isset($json_insteadtext) ? $json_insteadtext : COMBI_TXT_INSTEAD,
					]
				);

				// Bestand prüfen wenn $stock_check == 1
				if ($stock_check == 1 && intval($stocks) < 1) {
					// leere Option anzeigen ?
					if ($show_empty == 1)
					$new_array[] = array('id' => $val_ids[$data_size], 'name' => $option_values_names[$val_ids[$data_size]].' '.COMBI_TEXT_NO_STOCK, 'options' => array('disabled' => 'true', 'data-attrdata' => $JSON_ATTRDATA[$val_ids[$data_size]]), 'any_stock' => 0);
				} else {
					$new_array[] = array('id' => $val_ids[$data_size], 'name' => $option_values_names[$val_ids[$data_size]].$opt_price_name, 'options' => array('data-attrdata' => $JSON_ATTRDATA[$val_ids[$data_size]]), 'any_stock' => 1);
				}
			}
		} // Ende Statusprüfung
	}

	// Selectfeld - Optionen vorbelegen, wenn Attribute in products_id vorhanden (Beispiel: "product_info.php?products_id=664{4}9{1}5")
	$combi_selected_array = array();
    $sel_combi = '';
	if (strpos($prod_id, '{') !== false) {
		$combi_sel_array = preg_split('/[{}]/', $prod_id, -1, PREG_SPLIT_NO_EMPTY);
		array_shift($combi_sel_array);
		for ($i=0, $n=count($combi_sel_array); $i<$n; $i+=2) {
			$combi_selected_array[] = $combi_sel_array[$i + 1];
		}
		if ($combi_selected_array[($data_size -1)] == $datas[($data_size -1)]) $sel_combi = $combi_selected_array[$data_size];
	}

	$out = unique_multidim_array($new_array,'name');

	// Ausgabepuffer leeren falls erforderlich
	if(ob_get_length() > 0) {
    	ob_clean();
	}

	return array('out' => $out, 'selected' => $sel_combi);

}

// Helferfunktion um doppelte Rückgabewerte zu entfernen
function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
    $val_array = array();

    foreach($array as $val) {
		// wenn name noch nicht vorhanden, dann
		// hier kann es sein, dass eine id mit und ohne Bestand vorhanden ist
        if (!in_array($val[$key], $key_array)) {
			// prüfen, ob id schon vorhanden
			if(in_array($val['id'], $val_array)){
				// ist id schon mit Bestand 0 vorhanden, dann aus dem Ergebnisarray entfernen
				if($val['any_stock'] != 0){
					$temp_array = removeElementWithValue($temp_array, "id", $val['id']);
            		$val_array[] = $val['id'];
            		$key_array[] = $val[$key];
            		$temp_array[] = $val;
				} else {
					// ansonsten nichts tun
				}
			} else {
				// ist die id noch nicht vorhanden, dann in das Ergebnisarray schreiben
	            $val_array[] = $val['id'];
	            $key_array[] = $val[$key];
	            $temp_array[] = $val;
			}
        }
        $i++;
    }
    return $temp_array;
}

// Helferfunktion - löscht ein Array anhand eines Keys (hier 'id')
function removeElementWithValue($array, $key, $value){
     foreach($array as $subKey => $subArray){
          if($subArray[$key] == $value){
              unset($array[$subKey]);
              $array = array_values($array);
          }
     }
     return $array;
}
