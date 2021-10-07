<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

namespace KarlK\ProductCombiManager\Classes;

class ProductCombiAdmin
{

	// Funktion zum Image-Upload wird per Ajax über products_combi.php aufgerufen
	// Standard ist case:'load' hier werden nur Produktbilder verlinkt
	public function CombiAjaxCall($ajax_post)
	{
		// Definitionen werden nur für Upload benötigt
		//defined('COMBI_IMAGES_DIR') or define('COMBI_IMAGES_DIR', DIR_FS_CATALOG.'images/product_images/combi_images/');
		//defined('COMBI_POPUP_IMAGES_DIR') or define('COMBI_POPUP_IMAGES_DIR', DIR_FS_CATALOG.'images/product_images/combi_popup_images/');
		//defined('COMBI_THUMBNAIL_IMAGES_DIR') or define('COMBI_THUMBNAIL_IMAGES_DIR', DIR_FS_CATALOG.'images/product_images/combi_thumbnail_images/');
		//defined('COMBI_IMAGES_FILENAME_SCHEMA') or define('COMBI_IMAGES_FILENAME_SCHEMA', 'combi_img-%s-%s');
		//defined('COMBI_IMAGES_FILENAME_SCHEMA_DEL') or define('COMBI_IMAGES_FILENAME_SCHEMA_DEL', 'combi_img-%s');

		$func = xtc_db_prepare_input($ajax_post['func']);

		switch($func) {
			case 'upload':
			// upload ohne Funktion veraltet
			require_once (DIR_WS_CLASSES.FILENAME_IMAGEMANIPULATOR);

			$upload_file=xtc_db_prepare_input($ajax_post['file_upload']);

	    	$accepted_mo_pics_image_files_extensions = array("jpg","jpeg","jpe","gif","png","bmp","tiff","tif","bmp");
	    	$accepted_mo_pics_image_files_mime_types = array("image/jpeg","image/gif","image/png","image/bmp");

			if ($upload_file = &xtc_try_upload('file_upload',COMBI_IMAGES_DIR, '777', $accepted_mo_pics_image_files_extensions, $accepted_mo_pics_image_files_mime_types)) {
				$upload_file_name=$upload_file->filename;
				$extension = end(explode('.', $upload_file_name));
				$attribute_id  = xtc_db_prepare_input($ajax_post['attribute_id']);
				$combi_id = xtc_db_prepare_input($ajax_post['combi_id']);

					$filename = sprintf(COMBI_IMAGES_FILENAME_SCHEMA, $combi_id, $attribute_id).'.'.$extension;
					rename( COMBI_IMAGES_DIR.$upload_file_name, COMBI_IMAGES_DIR.$filename);
					copy( COMBI_IMAGES_DIR.$filename, COMBI_POPUP_IMAGES_DIR.$filename);
					$imageTransform = new imageTransformation;
					$imageTransform->resize(COMBI_IMAGES_DIR.$filename,  PRODUCT_IMAGE_POPUP_WIDTH, PRODUCT_IMAGE_POPUP_HEIGHT, COMBI_POPUP_IMAGES_DIR.$filename);
					$imageTransform->resize(COMBI_IMAGES_DIR.$filename,  PRODUCT_IMAGE_INFO_WIDTH, PRODUCT_IMAGE_INFO_HEIGHT, COMBI_IMAGES_DIR.$filename);
					$imageTransform->resize(COMBI_IMAGES_DIR.$filename,  PRODUCT_IMAGE_THUMBNAIL_WIDTH, PRODUCT_IMAGE_THUMBNAIL_HEIGHT, COMBI_THUMBNAIL_IMAGES_DIR.$filename);
	                self::set_combi_images_file_rights($filename);
			}// end of: if ($upload_file = &xtc_try_upload('file_upload',COMBI_IMAGES_DIR )) {

				$messageStack = new messageStack();
				if ($messageStack->size > 0) $message = $messageStack->output();
				$messageStack->reset();
				$unique = uniqid();
				$res =  array(
					"message"		=>  $message,
					"file"			=>	$filename,
					"unique"        =>  $unique
				);

				// ajax response
				echo json_encode($res);
				unset($filename,$upload_file_name,$_SESSION['messageToStack']);
	   		break;

			case 'load':

				$message = '';
				$filename = xtc_db_prepare_input($ajax_post['img_to_load']);
				$unique = uniqid();
				$message = COMBI_IMAGE_LINK_SUCCESS;
				$res =  array(
					"message"		=>  $message,
					"file"			=>	$filename,
					"unique"        =>  $unique
				);

				// ajax response
				echo json_encode($res);
				unset($filename,$_SESSION['messageToStack']);
	   		break;
	     }
		exit();
	}

	protected static function set_combi_images_file_rights($image_name)
	{
		@ chmod(COMBI_POPUP_IMAGES_DIR.$filename, 0644);
		@ chmod(COMBI_IMAGES_DIR.$filename, 0644);
		@ chmod(COMBI_THUMBNAIL_IMAGES_DIR.$filename, 0644);
	}

	// prüft, ob bereits eine Kombinationenliste für dieses Produkt existiert
	public function hasProductCombi($prod_ID=0)
	{
		if ($prod_ID) {
			// checks if product has a combi and returns its combi_id
			$tmpquery = "SELECT combi_id FROM ".TABLE_PRODUCTS_OPTIONS_COMBI." WHERE products_id = " .$prod_ID . " LIMIT 1";
			$tmpresult = xtc_db_query($tmpquery);
			$tmpdata = xtc_db_fetch_array($tmpresult);
			if(xtc_db_num_rows($tmpresult) != 0) return $tmpdata['combi_id'];
		}
		return false;
	}

	// neue Kombinationsliste erstellen
	public function createCombinationsList($prod_ID=0, $single = false)
	{
		// mögliche Kombinationen / Variationen erzeugen
		$combis = $this->getCombiVariations($prod_ID);

		$options_ids = implode(",", $combis[3]);
		unset($combis[3]);
		$options_values_ids = implode(",", $combis[4]);
		unset($combis[4]);
		// Dropdownvarianten
		$options_select = json_encode($combis[2]);

		// neue combi_id erzeugen und options_select sowie options_ids in Datenbank speichern
		$combinationsID = $this->saveCombinationsID($prod_ID, $options_ids, $options_values_ids);

			// Variationen zerlegen
			foreach ($combis[0] as $combi){
				for($i = 0; $i < sizeof($combi);$i++)
				{
					$comb = explode('|', $combi[$i]);
					if ($i == 0){
	    				$combination1 = $comb[0];
	    				$combination2 = $comb[1];
					} else {
	    				$combination1 .= ' / '.$comb[0];
	    				$combination2 .= '_'.$comb[1];
					}
				}
				$attrib = array(
					'valueID' => $combination2,
	    			'attributeName' => $combination1
				);
				$comb_result[] = $attrib;
				unset($attrib);
			}
			// Varianten Dropdown zusammenbauen
				$options_select='';
			if (is_array($combis[2])){
				$options_select='<div id="options">'.PHP_EOL;
				foreach ($combis[2] as $combi){
					$options_select .= '	<select>'.PHP_EOL;
					for($i = 0; $i < sizeof($combi);$i++)
					{
						$comb = explode('|', $combi[$i]);
						$options_select .= '		<option value="'.$comb[1].'">'.$comb[0].'</option>'.PHP_EOL;
					}
					$options_select .= '	</select>'.PHP_EOL;
				}
				$options_select .= '	&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="addmore button" value="'.PROD_COMBI_ADD_BUTTON.'" />'.PHP_EOL;
				$options_select .= '</div>'.PHP_EOL;
			}

			// Tabelle für Ausgabe zusammenbauen
			$output = '';
			$output .= '<br />'.PHP_EOL;
			$output .= '<table width="60%" cellspacing="0" cellpadding="2" border="0">'.PHP_EOL;
			$output .= '	<tr class="dataTableHeadingRow">'.PHP_EOL;
			$output .= '		<th class="dataTableHeadingContent" style="width:5%;"><input class="check_all" type="checkbox"/></th>'.PHP_EOL;
			$output .= '		<th class="dataTableHeadingContent" style="width:5%;">#</th>'.PHP_EOL;
			$output .= '		<th class="dataTableHeadingContent" style="width:5%;">'.PROD_COMBI_TH_ACTIVE.'</th>'.PHP_EOL;
			$output .= '		<th class="dataTableHeadingContent" width="45%">'.PROD_COMBI_TH_COMBI.'</th>'.PHP_EOL;
			$output .= '	</tr>'.PHP_EOL;

			// alle Varianten ausgeben nur wenn $single nicht true ist
			if ($single != true){
				for($i=0; $i < sizeof($comb_result);$i++){
					$output .= '	<tr class="dataTableRow">'.PHP_EOL;
					$output .= '		<td class="dataTableContent txta-c" style="width:5%;"><input type="checkbox" class="case"/></td>'.PHP_EOL;
					$output .= '		<td class="dataTableContent txta-c" style="width:5%;"><span id="snum' . $i . '" class="snum">' . ($i+1). '</span></td>'.PHP_EOL;
					$output .= '		<td class="dataTableContent txta-c" style="width:5%;"><input class="status" type="checkbox" value="1" name="status[]" checked="checked"/></td>'.PHP_EOL;
					$output .= '		<td class="dataTableContent"><strong>' . $comb_result[$i]['attributeName'] . '</strong><input type="hidden" name="attribute_name[]" value="'. $comb_result[$i]['attributeName'] .'"/><input type="hidden" name="attribute_id[]" value="'. $comb_result[$i]['valueID'] .'"/></td>'.PHP_EOL;
					$output .= '	</tr>'.PHP_EOL;
				}
			}
			$output .= '</table>'.PHP_EOL;

			// array( Tabelle, Optionendropdown, combi_id )
			return array($output, $options_select, $combinationsID);
	}

	// Produktbilder holen
	public function getCombiProductsImages($pID)
	{
	    $products_images = array();
		require_once (DIR_FS_INC . 'xtc_get_products_image.inc.php');
		$products_image = xtc_get_products_image($pID);
		if (!empty($products_image)) $products_images[] = $products_image;
		if (MO_PICS != '0') {
			require_once (DIR_FS_INC . 'xtc_get_products_mo_images.inc.php');
			$mo_images = xtc_get_products_mo_images($pID);
	    	if ($mo_images != false) {
				foreach ($mo_images as $img) {
					$products_images[] = $img['image_name'];
				}
			}
		}
		return $products_images;
	}

	// Produkte mit Attributen auslesen
	public function getCombiProductsWithAttributes()
	{
		$query = "
			SELECT
	            p.products_id, p.products_model, pd.products_name
			FROM
				".TABLE_PRODUCTS." p,
				".TABLE_PRODUCTS_DESCRIPTION." pd
			WHERE
				p.products_id != '0'
			AND
				p.products_id = pd.products_id
			AND
				language_id = " . $_SESSION['languages_id'] . "
			ORDER BY
				products_name
			ASC";
		$result = xtc_db_query($query);
		return $result;
	}

	// Produktoptionen auslesen
	public function getCombiProductsOptions($PROD_ID)
	{
		$tmpquery = "
			SELECT
				products_options_name, products_options_id
			FROM
				products_options
			JOIN
				products_attributes
			ON
				products_options.products_options_id = products_attributes.options_id
			WHERE
				products_attributes.products_id = ".$PROD_ID."
			AND
				products_options.language_id = ". $_SESSION['languages_id']."
			GROUP BY
				products_options_id";
		$tmpresult = xtc_db_query($tmpquery);
		return $tmpresult;
	}

	// bestehende Liste aus Datenbank laden
	public function getCombinationsListfromTable($combi_id=0)
	{

		$tmpquery = xtc_db_query("SELECT * FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2." WHERE combi_id = ".(int)$combi_id." ORDER BY combi_sort, combi_value_id");
		while ($tmpresult = xtc_db_fetch_array($tmpquery)) {
			$tmpdata[] = $tmpresult;
		}

			// Ausgabetabelle zusammenbauen
			$output = '';
			$out_th = '';
			// Hinweis falls zuviele Inputdaten gespeichert werden sollen
			// Standardeinstellung für PHP: max_input_vars 1000
			// Warning: Unknown: Input variables exceeded 1000. To increase the limit change max_input_vars in php.ini. in Unknown on line 0
			$m_i_v = ini_get("max_input_vars");
			if (sizeof($tmpdata) > $m_i_v/10) $output .= sprintf(PROD_COMBI_MAX_INPUT_VARS, ($m_i_v/10), $m_i_v, ((int) (1000 * ceil(sizeof($tmpdata)*10/1000)))).PHP_EOL;

			$output .= '<br />'.PHP_EOL;
			$output .= '<div class="smallText">'.PROD_COMBI_SORT_INFO.'</div>'.PHP_EOL;
			$output .= '<table style="width:100%;border:0;padding:2px;">'.PHP_EOL;
			$out_th .= '	<tr class="dataTableHeadingRow">'.PHP_EOL;
			$out_th .= '		<th class="dataTableHeadingContent"><input class="check_all" type="checkbox"/></th>'.PHP_EOL;
			$out_th .= '		<th class="dataTableHeadingContent" style="width: 60px;">Sort</th>'.PHP_EOL;
			$out_th .= '		<th class="dataTableHeadingContent">#</th>'.PHP_EOL;
			$out_th .= '		<th class="dataTableHeadingContent">'.PROD_COMBI_TH_ACTIVE.'</th>'.PHP_EOL;
			$out_th .= '		<th class="dataTableHeadingContent">'.PROD_COMBI_TH_COMBI.'</th>'.PHP_EOL;
			if (defined('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN') && MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN == 'true') {
				$out_th .= '		<th class="dataTableHeadingContent">'.PROD_COMBI_TH_MODEL.'</th>'.PHP_EOL;
				$out_th .= '		<th class="dataTableHeadingContent">'.PROD_COMBI_TH_EAN.'</th>'.PHP_EOL;
			}
			$out_th .= '		<th class="dataTableHeadingContent">'.PROD_COMBI_TH_STOCK.'</th>'.PHP_EOL;
			$out_th .= '		<th class="dataTableHeadingContent image">'.PROD_COMBI_TH_IMAGE.'</th>'.PHP_EOL;
			$out_th .= '	</tr>'.PHP_EOL;
			$output .= $out_th;

				foreach($tmpdata as $i => $data){
					$checked = ' checked="checked"';
		            if ($data["status"] != '1') $checked = '';
					if (!isset($data["stock"])) $data["stock"] = 0;

					$output .= '	<tr class="dataTableRow">'.PHP_EOL;
					$output .= '	<td class="dataTableContent txta-c"><input type="checkbox" class="case"/></td>'.PHP_EOL;
					$output .= '	<td class="dataTableContent txta-c">'.PHP_EOL;
					$output .= '		<img class="moveup" title="'.PROD_COMBI_UP.'" alt="'.PROD_COMBI_UP.'" src="images/arrow_up.gif" style="cursor:pointer;" />&nbsp;'.PHP_EOL;
					$output .= '		<img class="movedown" title="'.PROD_COMBI_DOWN.'" alt="'.PROD_COMBI_DOWN.'" src="images/arrow_down.gif" style="cursor:pointer;" />'.PHP_EOL;
					$output .= '	</td>'.PHP_EOL;
					$output .= '	<td class="dataTableContent txta-c"><input type="hidden" name="combi_value_id[]" value="' . $data["combi_value_id"] . '"/><span id="snum' . $i . '" class="snum">' . ($i+1). '</span></td>'.PHP_EOL;
					$output .= '	<td class="dataTableContent txta-c"><input class="status" type="checkbox" value="1" name="status[]"' . $checked . '/></td>'.PHP_EOL;
					$output .= '	<td class="dataTableContent"><strong>' . $data["attribute_name"] . '</strong><input type="hidden" name="attribute_name[]" value="'. $data["attribute_name"] .'"/><input type="hidden" name="attribute_id[]" value="'. $data["attribute_id"] .'"/></td>'.PHP_EOL;
					if (defined('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN') && MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN == 'true') {
						$output .= '	<td class="dataTableContent txta-c"><input type="text" class="w100" name="model[]" size="15" value="' . $data["model"] . '"/></td>'.PHP_EOL;
						$output .= '	<td class="dataTableContent txta-c"><input type="text" class="w100" name="ean[]" size="13" value="' . $data["ean"] . '"/></td>'.PHP_EOL;
					}
					$output .= '	<td class="dataTableContent txta-c"><input type="text" name="stock[]" size="8" value="' . $data["stock"] . '"/></td>'.PHP_EOL;
					$output .= '	<td class="dataTableContent txta-c image"><input type="hidden" name="image[]" value="'. $data["image"] .'"/>';

					if (isset($data["image"]) && $data["image"] != ''){
						$uniq = uniqid().'-'.$i;
						$output.= '			<a href="#" id="image'. $uniq .'" rel="subcontent'. $uniq .'" style="padding-left:15px;padding-right:15px;display:block;"><img src="../images/product_images/info_images/'.$data["image"].'" alt="image" style="max-width:30px;border:0;" /></a>'.PHP_EOL;
						$output.= '			<div id="subcontent'. $uniq .'" style="position:absolute; visibility: hidden; border: 1px solid #000000; background-color: white; padding: 2px;">'.PHP_EOL;
// nur bei upload						$output.= '				<img src="../images/product_images/combi_images/'.$data["image"][$i].'" alt="image" style="padding:10px;border:0;" />'.PHP_EOL;
						$output.= '				<img src="../images/product_images/info_images/'.$data["image"].'" alt="image" style="padding:10px;border:0;max-width:120px;max-height:120px;" />'.PHP_EOL;
						$output.= '			</div>'.PHP_EOL;
						$output.= '			<script type="text/javascript">dropdowncontent.init("image'. $uniq .'", "left-top", 250)</script>'.PHP_EOL;
					}
					$output .= '		</td>'.PHP_EOL;
					$output.= '	</tr>'.PHP_EOL;
				}

			$output .= $out_th;
			$output .= '</table>'.PHP_EOL;

			// Optionen für Dropdown aus Datenbank holen
			$combis = $this->getCombiOptionsSelect((int)$tmpdata[0]["products_id"]);
			// Kombinationendropdown zusammenbauen
			$options_select='';
			if (is_array($combis)){
				$options_select='<div id="options">'.PHP_EOL;
				foreach ($combis as $combi){
					$options_select .= '	<select>'.PHP_EOL;
					for($i = 0; $i < sizeof($combi);$i++)
					{
						$comb = explode('|', $combi[$i]);
						$options_select .= '		<option value="'.$comb[1].'">'.$comb[0].'</option>'.PHP_EOL;
					}
					$options_select .= '	</select>'.PHP_EOL;
				}
					$options_select .= '	&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="addmore button" value="'.PROD_COMBI_ADD_BUTTON.'" />'.PHP_EOL;
					$options_select .= '</div>'.PHP_EOL;
				}

			// array( Tabelle, Kombinationendropdown, combi_id, combi_value_id)
			return array($output, $options_select, $combi_id);
	}

	// Optionen für Kombinationendropdown aus Attributen holen
	protected function getCombiOptionsSelect($prodID = 0)
	{

		// prüft, ob eine alte Sortierreihenfolge besteht
		$old_sort = 0;
		$tmpquery = "SELECT combi_id,options_ids FROM ".TABLE_PRODUCTS_OPTIONS_COMBI." WHERE products_id = " .(int)$prodID . " LIMIT 1";
		$tmpresult = xtc_db_query($tmpquery);
		$tmpdata = xtc_db_fetch_array($tmpresult);
		if(xtc_db_num_rows($tmpresult) != 0) $old_sort = $tmpdata['options_ids'];
		$sort = $old_sort != 0 ? "field(products_options_id, ".$old_sort.")" : "po.products_options_sortorder";

		// hole Attribute und Optionen aus der Datenbank
		$tmpquery = "
			SELECT
				pa.products_id, pa.options_id, po.products_options_name, pa.options_values_id, pov.products_options_values_name
			FROM
				".TABLE_PRODUCTS_ATTRIBUTES." pa,
				".TABLE_PRODUCTS_OPTIONS." po,
				".TABLE_PRODUCTS_OPTIONS_VALUES." pov
			WHERE
				pa.products_id = ".(int)$prodID."
			AND
				po.language_id = ".$_SESSION['languages_id']."
			AND
				pa.options_id = po.products_options_id
			AND
				pov.language_id = ".$_SESSION['languages_id']."
			AND
				pa.options_values_id = pov.products_options_values_id
			ORDER BY
				".$sort.", pa.sortorder, pov.products_options_values_sortorder
			";
		$tmpresult = xtc_db_query($tmpquery);

		// Optionsname und Options-ID verbinden damit später wieder der Zusammenhang herstellbar ist
		$a = 0;
		for($i=0;$tmpdata = xtc_db_fetch_array($tmpresult);$i++){
			$options_ids[$i] = $tmpdata['options_id'];
			$options_values_ids[$i] = $tmpdata['options_values_id'];
			if ($i == 0 || $options_ids[$i] != $options_ids[$i-1]) {
				$options_select[$a][] = htmlentities($tmpdata['products_options_values_name']).'|'.$tmpdata['options_values_id'];
				$a++;
			} else {
				$options_select[$a-1][] = htmlentities($tmpdata['products_options_values_name']).'|'.$tmpdata['options_values_id'];
			}
		}

		// Optionsnamen und Werte aktualisieren, dadurch ist ein nachträgliches hinzufügen von Werten möglich
		$saveData["options_ids"] = implode(",", array_unique($options_ids));
		$saveData["options_values_ids"] = implode(",", array_unique($options_values_ids));
		xtc_db_perform(TABLE_PRODUCTS_OPTIONS_COMBI, $saveData, 'update', 'products_id='.(int)$prodID);

		return $options_select;
	}

	// combi_id holen
	protected function getCombinationsID($prod_ID=0)
	{
		if ($prod_ID){
			$tmpquery = "
				SELECT
					combi_id
				FROM
					".TABLE_PRODUCTS_OPTIONS_COMBI."
				WHERE
					products_id = " . $prod_ID . "
				LIMIT 1
			";
			$tmpresult = xtc_db_query($tmpquery);
			$tmpdata = xtc_db_fetch_array($tmpresult);
			$CombinationsID = $tmpdata['combi_id'];
		    return $CombinationsID;
		}
	}

	// combi_id holen
	public function getCombiIDandOptions($prod_ID=0)
	{
		if ($prod_ID){
			$tmpquery = "
				SELECT
					combi_id, options_ids, options_values_ids
				FROM
					".TABLE_PRODUCTS_OPTIONS_COMBI."
				WHERE
					products_id = " . $prod_ID . "
				LIMIT 1
			";
			$tmpresult = xtc_db_query($tmpquery);
			$tmpdata = xtc_db_fetch_array($tmpresult);
			if($tmpdata){
				$CombinationsID = $tmpdata['combi_id'];
				$options_ids = $tmpdata['options_ids'];
				$options_values_ids = $tmpdata['options_values_ids'];
		    	return array($CombinationsID, $options_ids, $options_values_ids);
			}
			return array();
		}
	}

	// mögliche Kombinationen / Variationen berechnen und zusammenstellen
	protected function getCombiVariations($prodID=0)
	{

		// Klasse wird gebraucht um die Ergebnisse aus der Interationsschleife zu bekommen
		$final_combis = new \stdClass();
		$final_combis->result = array();
		$final_combis->codes  = array();
		$final_combis->pos    = 0;
		$final_combis->products_options_name = array();
		$final_combis->options_select = array();

		// hole Attribute und Optionen aus der Datenbank
		$tmpquery = "
			SELECT
				pa.products_id, pa.options_id, po.products_options_name, pa.options_values_id, pov.products_options_values_name
			FROM
				".TABLE_PRODUCTS_ATTRIBUTES." pa,
				".TABLE_PRODUCTS_OPTIONS." po,
				".TABLE_PRODUCTS_OPTIONS_VALUES." pov
			WHERE
				pa.products_id = ".$prodID."
			AND
				po.language_id = ".$_SESSION['languages_id']."
			AND
				pa.options_id = po.products_options_id
			AND
				pov.language_id = ".$_SESSION['languages_id']."
			AND
				pa.options_values_id = pov.products_options_values_id
			ORDER BY
				po.products_options_sortorder, pa.sortorder, pov.products_options_values_sortorder
			";
		$tmpresult = xtc_db_query($tmpquery);

		// Optionsname und Options-ID verbinden damit später wieder der Zusammenhang herstellbar ist
		$a = 0;
		for($i=0;$tmpdata = xtc_db_fetch_array($tmpresult);$i++){
			$variation = array();
			$options_ids[$i] = $tmpdata['options_id'];
			$options_values_ids[$i] = $tmpdata['options_values_id'];
			if ($i == 0 || $options_ids[$i] != $options_ids[$i-1]) {
				$options_select[$a][] = htmlentities($tmpdata['products_options_values_name']).'|'.$tmpdata['options_values_id'];
				$variations_array[$a][] = htmlentities($tmpdata['products_options_values_name']).'|'.$tmpdata['options_values_id'];
				$a++;
			} else {
				$options_select[$a-1][] = htmlentities($tmpdata['products_options_values_name']).'|'.$tmpdata['options_values_id'];
				$variations_array[$a-1][] = htmlentities($tmpdata['products_options_values_name']).'|'.$tmpdata['options_values_id'];
			}
			$final_combis->products_options_name[$a] = htmlentities($tmpdata['products_options_name']);
		}

		// mögliche Kombinationen / Variationen berechnen
		function getCombinations($allOptionsArray, $final_combis) { //benötigte Funktion
	    	if(count($allOptionsArray)) {
	        	for($i=0; $i < count($allOptionsArray[0]); $i++) {
	            	$tmp = $allOptionsArray;
	            	$final_combis->codes[$final_combis->pos] = $allOptionsArray[0][$i];
	            	array_shift($tmp);
	            	$final_combis->pos++;
	            	getCombinations($tmp, $final_combis);
	        	}
	    	} else {
	        	$final_combis->result[] = $final_combis->codes;
	    	}
	    	$final_combis->pos--;
		}
		$allOptionsArray = $variations_array;
		getCombinations($allOptionsArray, $final_combis);

		// array( Kombinationen, Optionsnamen, Kombinationendropdown
		return array($final_combis->result, $final_combis->products_options_name, $options_select, array_unique($options_ids), array_unique($options_values_ids));
	}

	// Produktname holen
	public function getCombiProductName ($pID=0, $LangID=0)
	{
		if ($pID){
			$tmpquery = "SELECT
					p.products_model, pd.products_name
				FROM
					".TABLE_PRODUCTS." p,
					".TABLE_PRODUCTS_DESCRIPTION." pd
				WHERE
					p.products_id = ".$pID."
				AND
					pd.products_id = ".$pID."
				AND
					language_id = " . $LangID;
			$tmpresult = xtc_db_query($tmpquery);
			$tmpdata = xtc_db_fetch_array($tmpresult);
			return ': '.$tmpdata['products_name'].' [' .$tmpdata['products_model'] . ']';
		}
		return '';
	}

	// zählt die Anzahl der Optionen des Produktes
	public function getCombiDiffAttributes ($pID=0)
	{
		if ($pID) {
			$tmpquery = "SELECT count(distinct options_id) as count FROM ".TABLE_PRODUCTS_ATTRIBUTES." where products_id =".$pID;
			$tmpresult = xtc_db_query($tmpquery);
			$tmpdata = xtc_db_fetch_array($tmpresult);
			if(xtc_db_num_rows($tmpresult) != 0) {
				if ($tmpdata['count'] > 1) return $tmpdata['count'];
			}
		}
		return 0;
	}

	// neue Kombinationenliste - erzeugt eine neue combi_id und gibt sie zurück
	// zusätzlich werden Kombinationendropdown und die Option IDs der Attribute gespeichert
	protected function saveCombinationsID($prod_ID=0, $options_ids='', $options_values_ids='')
	{
		$tmpquery = "
			INSERT INTO
				".TABLE_PRODUCTS_OPTIONS_COMBI."
				(products_id, options_ids, options_values_ids)
			VALUES
				( "
					. $prod_ID . ", '" . $options_ids . "', '" . $options_values_ids . "'
				)";
		xtc_db_query($tmpquery);

		$CombinationsID = $this->getCombinationsID($prod_ID);
	    return $CombinationsID;
	}

	// alle $_POST-Daten speichern in Datenbank
	public function saveCombinationsList()
	{
		$stock = 0;

		// Kombinationen die gelöscht werden sollen
		if (!empty($_POST["combi2del"])) {
			$combis2del = explode(',', $_POST["combi2del"]);
			foreach ($combis2del as $combi2del) {
				xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2." WHERE combi_value_id = '".(int)$combi2del."'");
			}
		}

		$combi_size = sizeof($_POST["attribute_name"]);
		for($i=0; $i < $combi_size; $i++){
			$saveData = array();
			$saveData["combi_id"] = $_POST["combi_id"];
			$saveData["products_id"] = $_POST["current_product_id"];
			if (isset($_POST["status"][$i])) $saveData["status"] = $_POST["status"][$i];
			$saveData["attribute_name"] = $_POST["attribute_name"][$i];
			$saveData["attribute_id"] = $_POST["attribute_id"][$i];
			if (isset($_POST["model"][$i])) $saveData["model"] = $_POST["model"][$i];
			if (isset($_POST["ean"][$i])) $saveData["ean"] = $_POST["ean"][$i];
			if (isset($_POST["stock"][$i])) $saveData["stock"] = $_POST["stock"][$i];
			if (isset($_POST["image"][$i])) $saveData["image"] = $_POST["image"][$i];
		    $saveData["combi_sort"] = $i;

			if (!empty($_POST["combi_value_id"][$i])) {
				xtc_db_perform(TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2, $saveData, 'update', 'combi_value_id='.$_POST["combi_value_id"][$i]);
			} else {
				xtc_db_perform(TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2, $saveData);
			}
		}

		// Speichern des Zählers als Produktanzahl
		// zusammenzählen für Produktanzahl gesamt
		$stock = 0;
		if (isset($_POST["stock"])) $stock = array_sum($_POST["stock"]);

		xtc_db_perform(TABLE_PRODUCTS, array ('products_quantity' => $stock), 'update', 'products_id='.(int)$_POST["current_product_id"]);
	}

	// Kominationsliste löschen
	public function deleteCombinationsList($combi_id=0)
	{
	// nur bei upload	$this->deleteCombinationsImages($combi_id);
		$this->deleteCombinationsTableValues($combi_id);
		$this->deleteCombinationsTable($combi_id);
	}

	// Bilder löschen - wird nur bei Upload genutzt
	protected function deleteCombinationsImages($combi_id=0)
	{
	    if ($combi_id) {
			// Bilder löschen
			$needle = sprintf(COMBI_IMAGES_FILENAME_SCHEMA_DEL, $combi_id).'*.*';
			$dirs = array(COMBI_IMAGES_DIR, COMBI_POPUP_IMAGES_DIR, COMBI_THUMBNAIL_IMAGES_DIR);
			foreach($dirs as $dir){
				array_map("unlink", glob($dir.$needle));
			}
	    }
	}

	// Datenbankeintrag löschen
	public function deleteCombinationsTable($combi_id=0)
	{
	    if ($combi_id) {
			// Datenbankeinträge löschen
			$tmpquery = 'DELETE FROM '.TABLE_PRODUCTS_OPTIONS_COMBI.' WHERE combi_id='.$combi_id;
			xtc_db_query($tmpquery);
	    }
	}

	// Datenbankeintrag löschen
	protected function deleteCombinationsTableValues($combi_id=0)
	{
	    if ($combi_id) {
			// Datenbankeinträge löschen
			$tmpquery = 'DELETE FROM '.TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2.' WHERE combi_id='.$combi_id;
			xtc_db_query($tmpquery);
	    }
	}

}
?>
