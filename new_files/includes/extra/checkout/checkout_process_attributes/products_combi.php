<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

// Kombibestand nach dem Checkout ändern

	// prüfen, ob Systemmodul installiert und Status true ist
	if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {

		// nach dem Checkout Bestand ändern
        if ($update_attr_stock === true) {
        	if(sizeof($order->products[$i]['attributes']) >= 2 && !isset($order->products[$i]['checked_out'])) {

				$tmpquery = "SELECT combi_id FROM ".TABLE_PRODUCTS_OPTIONS_COMBI." WHERE products_id = " . xtc_get_prid($order->products[$i]['id']) . " LIMIT 1";
				$tmpresult = xtc_db_query($tmpquery);
				$tmpdata = xtc_db_fetch_array($tmpresult);
				if(xtc_db_num_rows($tmpresult) > 0) {

					// Order-ID zerlegen damit wir die attribute_id erhalten
					$tmpAttrid = '';
					$plh = '_';
					$tmpId = $order->products[$i]['id'];
					$tmpList = preg_split('/[{}]/', $tmpId, -1, PREG_SPLIT_NO_EMPTY);
					$tmpPid = $tmpList[0];
					for($a=2; $a < sizeof($tmpList);$a+=2){
						if ($a+1 == sizeof($tmpList)) $plh = '';
						$tmpAttrid .= $tmpList[$a].$plh;
					}

					$query = "SELECT combi_value_id, stock
								FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2."
								WHERE combi_id = " . $tmpdata['combi_id'] . "
								AND
								 	attribute_id = '".$tmpAttrid."'
								LIMIT 1";

					$result = xtc_db_query($query);
					if(xtc_db_num_rows($result) > 0) {
						$tmpdata =xtc_db_fetch_array($result);

						$new_stock["stock"] = $tmpdata["stock"] - $order->products[$i]['qty'];

						// update stock
						xtc_db_perform(TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2, $new_stock, 'update', 'combi_value_id='.$tmpdata["combi_value_id"]);
						$order->products[$i]['checked_out'] = true;
					}
				}
        	}
		}
	}
?>