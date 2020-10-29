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

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

class combiRemoveProduct {  //Important same name as filename

    //--- BEGIN DEFAULT CLASS METHODS ---//
    function __construct()
    {
        $this->code = 'combiRemoveProduct'; //Important same name as class name
        $this->title = 'combiRemoveProduct';
        $this->description = 'combiRemoveProduct';
        $this->name = 'MODULE_CATEGORIES_'.strtoupper($this->code);
        $this->enabled = defined($this->name.'_STATUS') && constant($this->name.'_STATUS') == 'true' ? true : false;
        $this->sort_order = defined($this->name.'_SORT_ORDER') ? constant($this->name.'_SORT_ORDER') : '';

        $this->translate();
    }

    function translate() {
        if (isset($_SESSION['language_code']) && $_SESSION['language_code'] == 'de') {
            $this->description = '<strong>Dieses Modul geh&ouml;rt zum Systemmodul "Attribut Kombinationen Verwaltung"</strong><br />Es wird automatisch konfiguriert mit dem Systemmodul.<br />Aufgabe: Wird eine Kategorie gel&ouml;scht, werden enthaltene Artikel aus der Attribut Kombinationen Verwaltung entfernt.';
		} else {
            $this->description = '<strong>This module is part of the systemmodule "Attribute Combinations Manger"</strong><br />It is automatically configured with the system module.<br />Function: When a categorie is deleted, the articles also removed from Attribute Combinations Manger.';
        }
    }

    function check() {
        if (!isset($this->_check)) {
          $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = '".$this->name."_STATUS'");
          $this->_check = xtc_db_num_rows($check_query);
        }
        return $this->_check;
    }

    function keys() {
        define($this->name.'_SORT_ORDER_TITLE', TEXT_DEFAULT_SORT_ORDER_TITLE);
        define($this->name.'_SORT_ORDER_DESC', TEXT_DEFAULT_SORT_ORDER_DESC);

        return array(
            $this->name.'_SORT_ORDER'
        );
    }

    function install() {
    }

    function remove() {
    }


    //--- BEGIN CUSTOM  CLASS METHODS ---//

	function remove_product($product_id) {
		if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {
			// Kombinationsliste und Bilder löschen, wenn Produkt gelöscht wird
			require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/autoload.php';
			$combi_id = ProductCombiAdmin::hasProductCombi((int)$product_id);
			ProductCombiAdmin::deleteCombinationsList($combi_id);
		}
	}
}
?>