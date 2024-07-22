<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

// Aufgabe der Datei:
// Wird ein Kombiartikel in den Warenkorb verschoben, dann wird Artikelnummer, EAN und Artikelbild durch Kombidaten (falls vorhanden) ersetzt

class combiDataToProduct {  //Important same name as filename

  var $code;
  var $title;
  var $description;
  var $name;
  var $sort_order;
  var $enabled;
  var $translate;
  var $_check;


    //--- BEGIN DEFAULT CLASS METHODS ---//
    function __construct()
    {
        $this->code = 'combiDataToProduct'; //Important same name as class name
        $this->title = 'combiDataToProduct';
        $this->description = 'combiDataToProduct';
        $this->name = 'MODULE_SHOPPING_CART_'.strtoupper($this->code);
        $this->enabled = defined($this->name.'_STATUS') && constant($this->name.'_STATUS') == 'true' ? true : false;
        $this->sort_order = defined($this->name.'_SORT_ORDER') ? constant($this->name.'_SORT_ORDER') : '';

        $this->translate();
    }

    function translate() {
        if (isset($_SESSION['language_code']) && $_SESSION['language_code'] == 'de') {
            $this->description = '<strong>Dieses Modul geh&ouml;rt zum Systemmodul "Attribut Kombinationen Verwaltung"</strong><br />Es wird automatisch konfiguriert mit dem Systemmodul.<br />Aufgabe: Hat eine Kombination eine eigene Artikelnummer, EAN oder ein Bild, dann werden diese Nummern dem bestellten Produkt zugeordnet.';
		} else {
            $this->description = '<strong>This module is part of the systemmodule "Attribute Combinations Manger"</strong><br />It is automatically configured with the system module.<br />Function: If a combination has its own article number, EAN or an image, these numbers are assigned to the ordered product.';
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

    function get_products($products_data, $product, $contents)
    {
		if ((defined('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN') && MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN == 'true')
			|| (defined('MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE') && MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE == 'true')) {

			$tmpquery = "SELECT combi_id FROM ".TABLE_PRODUCTS_OPTIONS_COMBI." WHERE products_id = " . xtc_get_prid($products_data['id']) . " LIMIT 1";
			$tmpresult = xtc_db_query($tmpquery);
			$tmpdata = xtc_db_fetch_array($tmpresult);
			if(xtc_db_num_rows($tmpresult) > 0) {

				// Order-ID zerlegen damit wir die attribute_id erhalten (Beispiel "6_2_5")
				$tmpAttrid = '';
				$plh = '_';
				$tmpId = $products_data['id'];
				$tmpList = preg_split('/[{}]/', $tmpId, -1, PREG_SPLIT_NO_EMPTY);
				$tmpPid = $tmpList[0];
				for($a=2; $a < sizeof($tmpList);$a+=2){
					if ($a+1 == sizeof($tmpList)) $plh = '';
					$tmpAttrid .= $tmpList[$a].$plh;
				}

				$query = "SELECT model, ean, image
							FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2."
							WHERE combi_id = " . $tmpdata['combi_id'] . "
							AND
							 	attribute_id = '".$tmpAttrid."'
							LIMIT 1";
				$result = xtc_db_query($query);
				if(xtc_db_num_rows($result) > 0) {
					$tmpdata =xtc_db_fetch_array($result);

					// Artikelnummer und EAN ersetzen
                    if (defined('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN') && MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN == 'true') {
						if ($tmpdata['model'] != '') $products_data['model'] = $tmpdata['model'];
						if ($tmpdata['ean'] != '') $products_data['ean'] = $tmpdata['ean'];
					}
					// Artikelbild ersetzen
					if (defined('MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE') && MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE == 'true') {
						if ($tmpdata['image'] != '') $products_data['image'] = $tmpdata['image'];
					}
				}
			}
	    }

		return $products_data;
    }
}
?>