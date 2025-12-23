<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {

  // Listenpunkt unter 'Katalog'
  $add_contents[BOX_HEADING_PRODUCTS][] = array(
    'admin_access_name' => 'products_combi',   //Eintrag fuer Adminrechte
    'filename' => 'products_combi.php',  //Dateiname der neuen Admindatei
    'boxname' => BOX_PRODUCTS_COMBI,       //Anzeigename im Menue
    'parameters' => '',                   //zusaetzliche Parameter z.B. 'set=export'
    'ssl' => ''                           //SSL oder NONSSL, kein Eintrag = NONSSL
  );
}
