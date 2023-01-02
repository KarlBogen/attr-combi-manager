<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

use KarlK\ProductCombiManager\Classes\ProductCombi;

// Kombinations-Stock Check
// muss auf jeder Checkout-Seite geladen werden, damit gleichzeitige Bestellungen
// nicht zu minus Bestaenden fuehren !!!

// prüfen, ob Systemmodul installiert und Status true ist
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {

	if (STOCK_CHECK == 'true'
	    && (!isset($_SESSION['tmp_oID'])
	        || (isset($_SESSION['tmp_oID']) && !is_numeric($_SESSION['tmp_oID']))
	        )
	    )
	{
	  $products = $_SESSION['cart']->get_products();
	  for ($i = 0, $n = sizeof($products); $i < $n; $i++) {
			require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/karlk/autoload.php';
            $ProductCombi = new ProductCombi();
			// Artikel markieren, falls Anzahl im Warenkorb den Bestand überschreitet
			$hascombi = $ProductCombi->hasProductCombi(intval($products[$i]['id']));
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
				$combi_stock = $ProductCombi->getCombiStock($tmpPid, $tmpAttrid);
				if ((int)$combi_stock - $products[$i]['quantity'] < 0) {
					$_SESSION['any_out_of_stock'] = 1;
					$combi_out_of_stock = 1;
					xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));
				}
			}
		}
	}
}
?>