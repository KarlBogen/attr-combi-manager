<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

use KarlK\ProductCombiManager\Classes\ProductCombi;

// Aufgabe der Datei:
// Hat der Artikel eine Kombination wird der Attributbestand erhöht, damit ein Checkout möglich ist

class combiDataToAttr {  //Important same name as filename

    //--- BEGIN DEFAULT CLASS METHODS ---//
    function __construct()
    {
        $this->code = 'combiDataToAttr'; //Important same name as class name
        $this->title = 'combiDataToAttr';
        $this->description = 'combiDataToAttr';
        $this->name = 'MODULE_MAIN_'.strtoupper($this->code);
        $this->enabled = defined($this->name.'_STATUS') && constant($this->name.'_STATUS') == 'true' ? true : false;
        $this->sort_order = defined($this->name.'_SORT_ORDER') ? constant($this->name.'_SORT_ORDER') : '';

        $this->translate();
    }

    function translate() {
        if (isset($_SESSION['language_code']) && $_SESSION['language_code'] == 'de') {
            $this->description = '<strong>Dieses Modul geh&ouml;rt zum Systemmodul "Attribut Kombinationen Verwaltung"</strong><br />Es wird automatisch konfiguriert mit dem Systemmodul.<br />Aufgabe: Hat der Artikel eine Kombination wird der Attributbestand erh&ouml;ht, damit ein Checkout m&ouml;glich ist.';
		} else {
            $this->description = '<strong>This module is part of the systemmodule "Attribute Combinations Manger"</strong><br />It is automatically configured with the system module.<br />Function: If the article has a combination, the attribute stock is increased so that a checkout is possible.';
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

    function getAttributesSelect($attributes,$paramsArr,$paramsArrOrigin)
    {
		// prüfen, ob Systemmodul installiert und Status true ist
		if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {

			if (STOCK_CHECK == 'true' && ATTRIBUTE_STOCK_CHECK == 'true') {
				require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/karlk/autoload.php';
				$hascombi = ProductCombi::hasProductCombi((int)$attributes["products_id"]);
				// Artikel markieren, falls Anzahl im Warenkorb den Bestand überschreitet
				if ($hascombi != false) {
					$attributes["attributes_stock"] = MAX_PRODUCTS_QTY;
				}
			}
		}

		return $attributes;
    }
}
?>