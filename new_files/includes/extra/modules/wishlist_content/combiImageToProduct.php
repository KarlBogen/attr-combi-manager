<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

// Aufgabe der Datei:
// Wird ein Kombiartikel auf den Merkzettel verschoben, dann wird das Artikelbild durch das Kombibild (falls vorhanden) ersetzt

	// prüfen, ob Artikelbild durch Kombibild ersetzt werden soll
	if (defined('MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE') && MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE == 'true') {

		$mydata = $module_data[$i];

		$pID = xtc_get_prid($mydata["PRODUCTS_ID"]);
		$tmpquery = "SELECT combi_id FROM ".TABLE_PRODUCTS_OPTIONS_COMBI." WHERE products_id = " . (int)$pID . " LIMIT 1";
		$tmpresult = xtc_db_query($tmpquery);
		$tmpdata = xtc_db_fetch_array($tmpresult);
		if(xtc_db_num_rows($tmpresult) > 0) {

			// Order-ID zerlegen damit wir die attribute_id erhalten (Beispiel "6_2_5")
			$tmpAttrid = '';
			$plh = '_';
			$tmpId = $mydata["PRODUCTS_ID"];
			$tmpList = preg_split('/[{}]/', $tmpId, null, PREG_SPLIT_NO_EMPTY);
			$tmpPid = $tmpList[0];
			for($a=2; $a < sizeof($tmpList);$a+=2){
				if ($a+1 == sizeof($tmpList)) $plh = '';
				$tmpAttrid .= $tmpList[$a].$plh;
			}

			$query = "SELECT image
						FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2."
						WHERE combi_id = " . $tmpdata['combi_id'] . "
						AND
						 	attribute_id = '".$tmpAttrid."'
						LIMIT 1";
			$result = xtc_db_query($query);
			if(xtc_db_num_rows($result) > 0) {
				$tmpdata =xtc_db_fetch_array($result);

				// Artikelbild ersetzen
				if (defined('MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE') && MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE == 'true') {
					if ($tmpdata['image'] != '') {
						$org_image = xtc_get_products_image($pID);
						$new_image = str_replace($org_image, $tmpdata['image'], $mydata["PRODUCTS_IMAGE"]);
					}
				}
			}
		}

		if ($new_image != '') $module_data[$i]["PRODUCTS_IMAGE"] = $new_image;

    }

?>