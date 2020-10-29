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

// prüft, ob das Produkt eine Kombination hat und lädt dann nötige Datei

	// prüfen, ob Systemmodul installiert und Status true ist
	if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {

		require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/karlk/autoload.php';

		if (ProductCombi::hasProductCombi($product->pID)) {
			include (DIR_WS_MODULES.'product_combi.php');
		}

	}
?>