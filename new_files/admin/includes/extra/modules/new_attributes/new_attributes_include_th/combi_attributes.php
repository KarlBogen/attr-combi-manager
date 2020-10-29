<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl
	Version: 0.0.1

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

use KarlK\ProductCombiManager\Classes\ProductCombiAdmin;

// prüfen, ob Systemmodul installiert und Status true ist
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {
	// wenn eine Kombinationsliste existiert werden nur die Optionen der Kombi angezeigt
	require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/autoload.php';
	// combi_id und Optionen der Kombinationsliste holen
	// $combi[0] == combi_id, $combi[1] == Optionen, , $combi[2] == Optionswerte
	$combi = ProductCombiAdmin::getCombiIDandOptions($_POST['current_product_id']);

	if ($combi[0]) {
		$combis = explode(',', $combi[1]);
		// fügt einen unsichtbaren th mit class als Identifizierer in der Attributverwaltung ein
		// diese class wird von Javascript benutzt um Nicht-Kombioptionen auszublenden und Bestandsinput von Kombioptionen zu entfernen
		if (in_array($current_product_option_id, $combis)){
			$output .= '<th class="is_combi_opt" style="display:none;"></th>'. PHP_EOL;
		} else {
			$output .= '<th class="no_combi_opt" style="display:none;"></th>'. PHP_EOL;
		}
	}
}
?>