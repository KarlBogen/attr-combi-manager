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

// Wenn eine Produktkombi existiert und der Bestand überschritten wird, dann den Artikel kennzeichnen nicht das Attribut
// Normalerweise werden die Attribute gekennzeichnet!

	// prüfen, ob Systemmodul installiert und Status true ist
	if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {

		if (STOCK_CHECK != 'true' && !isset($hascombi)) {
			require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/karlk/autoload.php';
			$hascombi = ProductCombi::hasProductCombi(intval($products[$i]['id']));
		}

		// Artikel markieren, falls Anzahl im Warenkorb den Bestand überschreitet
		if ($hascombi) {
			$module_content[$i]['ATTRIBUTES'][$subindex]['VALUE_NAME'] = $attributes['products_options_values_name'];
			if ($combi_out_of_stock < 1) $_SESSION['any_out_of_stock'] = 0;
		}
	}
?>