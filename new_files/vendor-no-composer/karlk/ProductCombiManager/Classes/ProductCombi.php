<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

namespace KarlK\ProductCombiManager\Classes;

class ProductCombi
{

// prüft, ob bereits eine Kombinationenliste für dieses Produkt existiert
public function hasProductCombi($prod_ID=0){
	if ($prod_ID) {
		// checks if product has a combi and returns its combi_id
		$tmpquery = "SELECT combi_id FROM ".TABLE_PRODUCTS_OPTIONS_COMBI." WHERE products_id = " .$prod_ID . " LIMIT 1";
		$tmpresult = xtc_db_query($tmpquery);
		$tmpdata = xtc_db_fetch_array($tmpresult);
		if(xtc_db_num_rows($tmpresult) != 0) return $tmpdata['combi_id'];
	}
	return false;
}

public function getCombiStock($prod_id, $attribute_id){
	if ($prod_id) {
		$tmpquery =	"
			SELECT
			 	stock
			FROM
			 	".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2."
			WHERE
			 	products_id = ".(int) $prod_id."
			AND
			 	attribute_id = '".$attribute_id."'
			LIMIT 1";

		$tmpresult = xtc_db_query($tmpquery);
		$data = xtc_db_fetch_array($tmpresult);

		$stock = $data["stock"] != '' ? $data["stock"] : '';

		return $stock;
	}
}

// bestehende Liste aus Datenbank laden
public function getCombinationsListfromTable($combi_id=0, $prod_data = array()){
	global $xtPrice;

	$tmpdata = array();

	$tax_id = $prod_data["tax_id"];
	$discount = $xtPrice->xtcCheckDiscount((int)$prod_data["pid"]);
	$prod_price = $prod_data["gprice"];
	$products_vpe = $prod_data["products_vpe"];
	$vpe_status = $prod_data["vpe_status"];
	$vpe_value = $prod_data["vpe_value"];

	// Kombinationsdaten holen
	$tmpquery =	xtc_db_query("
		SELECT
            products_id,
			options_ids,
			options_values_ids
		FROM
			 ".TABLE_PRODUCTS_OPTIONS_COMBI."
		WHERE
			 combi_id = ".(int)$combi_id."
		LIMIT 1");
	$tmpdata = xtc_db_fetch_array($tmpquery);
	$data["combi_id"] = (int)$combi_id;
	$data["products_id"] = $tmpdata["products_id"];
	$data["options_ids"] = $tmpdata["options_ids"];
	$data["options_values_ids"] = $tmpdata["options_values_ids"];

	$tmpquery = xtc_db_query("
		SELECT
			combi_value_id,
			combi_id,
			products_id,
			status,
			attribute_id,
			stock,
			image
		FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2."
		WHERE combi_id = ".(int)$combi_id."
		ORDER BY combi_sort, combi_value_id");
	while ($tmpresult = xtc_db_fetch_array($tmpquery)) {
		$tmpdatas[] = $tmpresult;
	}
	foreach($tmpdatas as $tmpdata){
		$data["status"][] = $tmpdata["status"];
		$data["attribute_id"][] = $tmpdata["attribute_id"];
		$data["stock"][] = $tmpdata["stock"];
		$data["image"][] = $tmpdata["image"];
	}

	// zusammenzählen der Produktanzahl gesamt
	$stock_sum = array_sum($data["stock"]);

	// Optionsnamen der Produkte holen
	$tmpquery = "SELECT products_options_name FROM ".TABLE_PRODUCTS_OPTIONS." WHERE products_options_id IN (".$data["options_ids"].") AND language_id = ".$_SESSION['languages_id']." ORDER BY field(products_options_id,".$data["options_ids"].")";
	$tmpresult = xtc_db_query($tmpquery);
	for($i=0;$tmpdata = xtc_db_fetch_array($tmpresult);$i++){
		$option_names[] = $tmpdata['products_options_name'];
	}

	// Optionswertenamen der Produkte holen
	$tmpquery = "SELECT products_options_values_id, products_options_values_name FROM ".TABLE_PRODUCTS_OPTIONS_VALUES." WHERE products_options_values_id IN (".$data["options_values_ids"].") AND language_id = ".$_SESSION['languages_id'];
	$tmpresult = xtc_db_query($tmpquery);
	for($i=0;$tmpdata = xtc_db_fetch_array($tmpresult);$i++){
		$option_values_names[$tmpdata['products_options_values_id']] = $tmpdata['products_options_values_name'];
	}

	// Attributspreise und -prefixe holen
    $opt_vals = array();
	$tmpquery = "SELECT options_id, options_values_id, options_values_price, price_prefix, attributes_vpe_value, weight_prefix FROM ".TABLE_PRODUCTS_ATTRIBUTES." WHERE products_id = ".$data["products_id"];
	$tmpresult = xtc_db_query($tmpquery);

	for($i=0;$tmpdata = xtc_db_fetch_array($tmpresult);$i++){

		// Optionspreisangabe zusammensetzen
		$price = 0;
		$opt_price_name = '';
		$opt_price = $tmpdata['options_values_price'];
		$opt_prefix = $tmpdata['price_prefix'];
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
			$opt_price_name = $price != 0 ? '  '.$opt_prefix.' '.$xtPrice->xtcFormat($price, true) : '';
		}

		$opt_vals[$tmpdata['options_values_id']] = array('opt_price_name' => $opt_price_name);

    // Attribut-VPE-Wert wird mit Hilfe des Gewichts-Prefix berechnet
    // das JavaScript rechnet immer Artikel-VPE-Wert + Attribut-VPE-Wert
    $attr_vpe_value = $tmpdata['attributes_vpe_value'];
    switch ($tmpdata['weight_prefix']) {
      case '-':
        $attr_vpe_value = -1 * abs($tmpdata['attributes_vpe_value']);
        break;
      case '=':
        $attr_vpe_value = $tmpdata['attributes_vpe_value'] - $vpe_value;
        break;
    }

    // Daten für Preisupdater zusammensetzen
		$JSON_ATTRDATA[$tmpdata['options_values_id']] = str_replace(
			'"', '&quot;', json_encode(
				[
					'pid'          => (int)$prod_data["pid"],
					'gprice'       => $prod_price,
					'oprice'       => $xtPrice->xtcFormat($xtPrice->xtcAddTax($xtPrice->getPprice((int)$prod_data["pid"]), $xtPrice->TAX[$tax_id]), false),
					'cleft'        => $xtPrice->currencies[$_SESSION['currency']]['symbol_left'],
					'cright'       => $xtPrice->currencies[$_SESSION['currency']]['symbol_right'],
					'prefix'       => $tmpdata['price_prefix'],
					'aprice'       => $xtPrice->xtcFormat($price, false),
					'vpetext'      => $products_vpe,
					'vpevalue'     => (($vpe_status && (double)$vpe_value) ? (double)$vpe_value : 0),
					'attrvpevalue' => (($vpe_status && (double)$attr_vpe_value) ? (double)$attr_vpe_value : 0),
					'onlytext'     => isset($json_onlytext) ? $json_onlytext : COMBI_TXT_ONLY,
					'protext'      => isset($json_protext) ? $json_protext : TXT_PER,
					'insteadtext'  => isset($json_insteadtext) ? $json_insteadtext : COMBI_TXT_INSTEAD,
				]
			)
		);

	}

	// ID und Name für 1. Select
    $new_array = array();
	for($i=0; $i < sizeof($data["attribute_id"]);$i++){
		// Wenn Kombination den Status 0 hat, dann diese Schleife beenden
		if ($data["status"][$i] != '0') {
			$val_ids = explode('_', $data["attribute_id"][$i]);
			$val_size = sizeof($val_ids);
			$stocks = $data["stock"][$i];
			$opt_price_name = $opt_vals[$val_ids[0]]['opt_price_name'] != '' ? $opt_vals[$val_ids[0]]['opt_price_name'] : '';

			// Bestand prüfen wenn MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK == 'true'
			if (MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK == 'true' && $stocks[0] < 1) {
				if (MODULE_PRODUCTS_COMBINATIONS_SHOW_EMPTY_COMBI_OPTION == 'true' || $stock_sum < 1)
				$new_array[] = array('id' => $val_ids[0], 'name' => $option_values_names[$val_ids[0]].' '.COMBI_TEXT_NO_STOCK,  'disabled' => true, 'any_stock' => 0);
			} else {
				$new_array[] = array('id' => $val_ids[0], 'name' => $option_values_names[$val_ids[0]].$opt_price_name, 'any_stock' => 1);
			}
		} // Ende Statusprüfung
	}

	$sel_dat_1 = array();
	$sel_dat_1 = $this->unique_multidim_array($new_array,'name');

	// Selectfeld 1 - Option vorbelegen, wenn Attribute in products_id vorhanden (Beispiel: "product_info.php?products_id=664{4}9{1}5")
	if (strpos($_GET['products_id'], '{') !== false) {
        $data["products_id"] = $_GET['products_id'];
		$combi_sel_array = preg_split('/[{}]/', $_GET['products_id'], -1, PREG_SPLIT_NO_EMPTY);
		array_shift($combi_sel_array);
	}

		// Ausgabe zusammenbauen
		$output = '';

		$output .= '<noscript>'.COMBI_JS_DISABLED.'</noscript>'.PHP_EOL;
		$output .= '<div id="combination'.(int)$prod_data["pid"].'">'.PHP_EOL;
		$output .= '<div class="combi-select options_row_multi form-group mb-3">'.PHP_EOL;
		$output .= '	<label class="options_name control-label form-label" for="combi_id_1">'.$option_names[0].': </label>'.PHP_EOL;
		$output .= '	<div class="options_select"><select id="combi_id_1" class="combi_id form-select form-control form-control-sm input-sm" onchange="hideImage();">'.PHP_EOL;
		$output .= '		<option value="">'.PULL_DOWN_DEFAULT.' ...</option>'.PHP_EOL;
		// 1. Selectfeld
        $init = false;
		for($i=0; $i < sizeof($sel_dat_1);$i++){
			$sel1_option_selected = '';
			$dis = '';
			if (isset($combi_sel_array[1]) && $sel_dat_1[$i]['id'] == $combi_sel_array[1]) {
				$sel1_option_selected = ' selected="selected"';
				$init = true;
			}
			if (isset($sel_dat_1[$i]['disabled']) && $sel_dat_1[$i]['disabled'] == true) $dis = ' disabled="disabled"';
				$output .= '		<option id="o_'.$i.'" data-attrdata="'.$JSON_ATTRDATA[$sel_dat_1[$i]['id']].'" value="'.$sel_dat_1[$i]['id'].'"'.$dis.$sel1_option_selected.'>'.$sel_dat_1[$i]['name'].'</option>'.PHP_EOL;
		}
		$output .= '	</select></div>'.PHP_EOL;
		$output .= '</div>'.PHP_EOL;
		// alle weiteren Selectfelder
		for($i=1; $i < $val_size;$i++){
			$output .= '<div class="combi-select options_row_multi form-group mb-3">'.PHP_EOL;
			$output .= '	<label class="options_name control-label form-label" for="combi_id_'.($i+1).'">'.$option_names[$i].': </label>'.PHP_EOL;
			$output .= '	<div class="options_select"><select id="combi_id_'.($i+1).'" class="combi_id form-select form-control form-control-sm input-sm"';
			// beim letzten Selectfeld onchange einfügen
			if ($i == ($val_size-1)) {
				$output .= ' onchange="hideImage();getCombiImage();"';
			} else {
				$output .= ' onchange="hideImage();"';
			}
			$output .= '>'.PHP_EOL;
			$output .= '		<option value="">'.PULL_DOWN_DEFAULT.' ...</option>'.PHP_EOL;
			$output .= '	</select></div>'.PHP_EOL;
			$output .= '</div>'.PHP_EOL;
		}
		// Ausgabe Preisupdater
		if ($_SESSION['customers_status']['customers_status_show_price'] != '0' && MODULE_PRODUCTS_COMBINATIONS_PRICEUPDATER_ON == 'true' && MODULE_PRODUCTS_COMBINATIONS_ADDITIONAL == 'true') {
			$output .= '	<div class="combiPriceUpdater">'.PHP_EOL;
			$output .= '		<span><strong>'.COMBI_TEXT_ATTRIBUTE_PRICE_UPDATER_A.'</strong><br />'.COMBI_TEXT_ATTRIBUTE_PRICE_UPDATER_B.'</span>'.PHP_EOL;
			$output .= '		<span class="cuPrice"></span><br />'.PHP_EOL;
			$output .= '		<span class="cuVpePrice">'.COMBI_CHOOSE_ATTR.'</span>'.PHP_EOL;
			$output .= '	</div>'.PHP_EOL;
		}
		$output .= '</div>'.PHP_EOL;

		if (MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK == 'true') {
			$output .= '<div id="combi_stock">'.PHP_EOL;
			$output .= '	<strong>'.COMBI_TEXT_STOCK.'</strong><span class="combi_stock">'. ($stock_sum < 1 ? '0' : COMBI_CHOOSE_ATTR) .'</span>'.PHP_EOL;
			$output .= '</div>'.PHP_EOL;
		}
		$output .= '<div id="combi_dat">'.PHP_EOL;
		$output .= '</div>'.PHP_EOL;

		$output .= '<input id="prod_id" type="hidden" name="prod_id" value="'.$data["products_id"].'" />'.PHP_EOL;
		$output .= '<input id="prod_price" type="hidden" value="'.$prod_price.'" />'.PHP_EOL;
		$output .= '<input id="combi_id" type="hidden" name="combi_id" value="" />'.PHP_EOL;
		$output .= '<input id="options_ids" type="hidden" name="options_ids" value="" />'.PHP_EOL;
		$output .= '<input id="tax_id" type="hidden" value="'.$tax_id.'" />'.PHP_EOL;
		$output .= '<input id="products_vpe" type="hidden" value="'.$products_vpe.'" />'.PHP_EOL;
		$output .= '<input id="vpe_status" type="hidden" value="'.$vpe_status.'" />'.PHP_EOL;
		$output .= '<input id="vpe_value" type="hidden" value="'.$vpe_value.'" />'.PHP_EOL;
		$output .= '<input id="discount" type="hidden" value="'.$discount.'" />'.PHP_EOL;
		$output .= '<input id="combi_err" name="combi_err" type="hidden" value="1" />'.PHP_EOL;

		if (MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK == 'true') $output .= '<input id="stock_check" type="hidden" name="stock_check" value="1" />'.PHP_EOL;
		if (MODULE_PRODUCTS_COMBINATIONS_SHOW_EMPTY_COMBI_OPTION == 'true') $output .= '<input id="show_empty" type="hidden" name="show_empty" value="1" />'.PHP_EOL;

		$output .= '<script type="text/javascript">'.PHP_EOL;
		$output .= '	function jqueryReady() {'.PHP_EOL;
		$output .= '		$("#combi_err").remove();'.PHP_EOL;
		for($i=1; $i < $val_size;$i++){
			$output .= '		$("#combi_id_'.($i+1).'").depdrop({'.PHP_EOL;
			$output .= '			url: "'.DIR_WS_BASE.'ajax.php",'.PHP_EOL;
			$output .= '			ext: {ext: "get_products_combi_data", type: "json", speed: 1, '.(($i == ($val_size-1) && isset($init))? 'last: 1' : 'last: 0').'},'.PHP_EOL;
			if ($_SESSION["language_code"]=='de') $output .= '			language: "de",'.PHP_EOL;
			if ($i == ($val_size-1) && isset($init)) {
				$output .= '			initialize: true,'.PHP_EOL;
			}
 			$output .= '			depends: [';

			for($a=0; $a < $i;$a++){
				if ($a > 0)$output .= ', ';
				$output .= '"combi_id_'.($a+1).'"';
			}

			$output .= '],'.PHP_EOL;

			$params = '';
			if (MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK == 'true') $params .= ', "stock_check"';
			if (MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK == 'true' && MODULE_PRODUCTS_COMBINATIONS_SHOW_EMPTY_COMBI_OPTION == 'true') $params .= ', "show_empty"';
			$output .= '			params: ["prod_id", "prod_price", "tax_id", "products_vpe", "vpe_status", "vpe_value", "discount"'.$params.']'.PHP_EOL;

			$output .= '		});'.PHP_EOL;

			if ($i == ($val_size-1)){
				$output .= '		$("#combi_id_'.($i+1).'").on("depdrop:afterChange", function(value) {'.PHP_EOL;
				$output .= '			if($("#combi_id_'.($i+1).'").val() > 0) {$("#combi_id_'.($i+1).'").trigger("onchange");}'.PHP_EOL;
				$output .= '		});'.PHP_EOL;
			}

		}
		$output .= '	}'.PHP_EOL;

		$output .= 'function hideImage(){'.PHP_EOL;
		$output .= '	$("#combi_dat").slideUp(1000).empty();'.PHP_EOL;
		$output .= '	$(".combi_stock").empty().append("'.COMBI_CHOOSE_ATTR.'");'.PHP_EOL;
		$output .= '	$(".combiPriceUpdater .cuPrice").empty();'.PHP_EOL;
		$output .= '	$(".combiPriceUpdater .cuVpePrice").empty().append("'.COMBI_CHOOSE_ATTR.'");'.PHP_EOL;
		$output .= '}'.PHP_EOL;

		// Kombinationsbild und Bestand holen
		$output .= 'function getCombiImage(){'.PHP_EOL;
		$output .= '	var coclass = $(".combi-select");'.PHP_EOL;
		$output .= '	var prod_id = $("#prod_id").val();'.PHP_EOL;
		$output .= '	var attribute_id = "";'.PHP_EOL;
		$output .= '	for (i = 1; i <= coclass.length; i++) {'.PHP_EOL;
		$output .= '		var c_val = $("#combi_id_"+i).find("option:selected").val();'.PHP_EOL;
		$output .= '		if (i>1) attribute_id += "_";'.PHP_EOL;
		$output .= '		attribute_id += c_val;'.PHP_EOL;
		$output .= '	}'.PHP_EOL;
		$output .= '    var form_data = new FormData();'.PHP_EOL;
		$output .= '    form_data.append("ext", "get_products_combi_data");'.PHP_EOL;
		$output .= '    form_data.append("func", "getImage");'.PHP_EOL;
		$output .= '    form_data.append("prod_id", prod_id);'.PHP_EOL;
		$output .= '    form_data.append("attribute_id", attribute_id);'.PHP_EOL;

		$output .= '    $.ajax({'.PHP_EOL;
		$output .= '                url: "'.DIR_WS_BASE.'ajax.php",'.PHP_EOL;
		$output .= '                dataType: "json",'.PHP_EOL;
		$output .= '                cache: false,'.PHP_EOL;
		$output .= '                contentType: false,'.PHP_EOL;
		$output .= '                processData: false,'.PHP_EOL;
		$output .= '                data: form_data,'.PHP_EOL;
		$output .= '                type: "post",'.PHP_EOL;
		$output .= '                success: function(data){'.PHP_EOL;
		$output .= '					$("#combi_id").val(attribute_id);'.PHP_EOL;
		$output .= '					$("#options_ids").val(data.options_ids);'.PHP_EOL;
		$output .= '					var content = "";'.PHP_EOL;
		if (MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK == 'true')
		$output .= '					if (data.stock) $(".combi_stock").empty().append(data.stock);'.PHP_EOL;
		if (MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP == 'true' && MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE == 'true') {
			$output .= '					$("#product_details a[href*=\""+data.image+"\"]").trigger("click");'.PHP_EOL;
// Änderung für den Royalslider
//			$output .= '					$("#product-slider .rsNavItem img").each(function(index) {'.PHP_EOL;
//			$output .= '						var src = $(this).attr("src");'.PHP_EOL;
//			$output .= '						if (src.indexOf(data.image) > -1){'.PHP_EOL;
//			$output .= '							$("#product-slider").royalSlider("goTo", index);'.PHP_EOL;
//			$output .= '						}'.PHP_EOL;
//			$output .= '					});'.PHP_EOL;
		} elseif (MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP5 == 'true' && MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE == 'true') {
			$output .= '					if (data.image && $(".pd_more_images img[src*=\""+data.image+"\"]").length == 1) {'.PHP_EOL;
			$output .= '						$(".pd_more_images img[src*=\""+data.image+"\"]").parents(".swap").trigger("click");'.PHP_EOL;
			$output .= '					}'.PHP_EOL;
		} else {
			if (MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE == 'true') {
				$output .= '					if (data.image && $(".pd_image_small_container img[src*=\""+data.image+"\"]").length == 1) {'.PHP_EOL;
				$output .= '						$(".pd_image_small_container img[src*=\""+data.image+"\"]").parents(".splide__slide").trigger("click");'.PHP_EOL;
				$output .= '					} else {'.PHP_EOL;
				$output .= '						var newhref = "'.DIR_WS_BASE.'images/product_images/popup_images/";'.PHP_EOL;
				$output .= '						var newsrc = "'.DIR_WS_BASE.'images/product_images/info_images/";'.PHP_EOL;
				$output .= '						$("#product_details .pd_big_image a").attr("href", newhref+data.image);'.PHP_EOL;
				$output .= '						$("#product_details .pd_big_image img").attr("src", newsrc+data.image);'.PHP_EOL;
				$output .= '					}'.PHP_EOL;
			} else {
				$output .= '					if (data.image) content += "<div class=\"combi_img\"><img src=\"'.DIR_WS_BASE.'images/product_images/thumbnail_images/"+data.image+"\" alt=\"image\" style=\"padding:10px;border:0;\"\/><\/div>";'.PHP_EOL;
			}
		}
		$output .= '					$("#combi_dat").append(content).slideDown(1000);'.PHP_EOL;
		$output .= '                },'.PHP_EOL;
		$output .= '     });'.PHP_EOL;
		$output .= '	CombiPriceUpdater();'.PHP_EOL;
		$output .= '}'.PHP_EOL;

		$output .= '</script>'.PHP_EOL;

		return $output;
}

// Helferfunktion um doppelte Rückgabewerte zu entfernen
protected function unique_multidim_array($array, $key) {
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
					$temp_array = $this->removeElementWithValue($temp_array, "id", $val['id']);
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
    }
    return $temp_array;
}

// Helferfunktion - löscht ein Array anhand eines Keys (hier 'id')
protected function removeElementWithValue($array, $key, $value){
     foreach($array as $subKey => $subArray){
          if($subArray[$key] == $value){
              unset($array[$subKey]);
              $array = array_values($array);
          }
     }
    return $array;
}

}
