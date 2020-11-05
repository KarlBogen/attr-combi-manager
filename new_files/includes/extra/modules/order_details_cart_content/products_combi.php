<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl
	Version: 0.0.1

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

use KarlK\ProductCombiManager\Classes\ProductCombi;

// Wenn eine Produktkombi existiert und der Bestand überschritten wird, dann den Artikel kennzeichnen
// Normalerweise werden die Attribute gekennzeichnet!

if (STOCK_CHECK == 'true') {

	// prüfen, ob Systemmodul installiert und Status true ist
	if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {
		// Überschreitet die Bestellmenge bereits die zulässige Anzahl Sonderangebote, dann muss der Kombibestand nicht mehr geprüft werden
		if ($mark_stock != '') {
			$combi_out_of_stock = 1;
		}
		else {
			require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/karlk/autoload.php';
			// Artikel markieren, falls Anzahl im Warenkorb den Bestand überschreitet
			$hascombi = ProductCombi::hasProductCombi(intval($products[$i]['id']));
			if ($hascombi) {
				$tmpAttrid = '';
				$plh = '_';

				$tmpId = $products[$i]['id'];
				$tmpList = preg_split('/[{}]/', $tmpId, null, PREG_SPLIT_NO_EMPTY);
				$tmpPid = $tmpList[0];
				for($a=2; $a < sizeof($tmpList);$a+=2){
					if ($a+1 == sizeof($tmpList)) $plh = '';
					$tmpAttrid .= $tmpList[$a].$plh;
				}
				$combi_out_of_stock = 0;
				$combi_stock = ProductCombi::getCombiStock($tmpPid, $tmpAttrid);
				if ((int)$combi_stock - $products[$i]['quantity'] < 0) {
					$module_content[$i]['PRODUCTS_NAME'] = $products[$i]['name'].'<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
					$_SESSION['any_out_of_stock'] = 1;
	                $combi_out_of_stock = 1;
				}

			}
		}
	}

}
?>