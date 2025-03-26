<?php
/* ------------------------------------------------------------
  Module "Attribute Kombination Manager" made by Karl

  inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

  modified eCommerce Shopsoftware
  http://www.modified-shop.org

  Released under the GNU General Public License
-------------------------------------------------------------- */

// AttributeID wird durch die CombiID ersetzt

// prüfen, ob Systemmodul installiert und Status true ist
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {
  // wenn Javascript deaktiviert ist wird der Warenkorb nicht befüllt
  if (isset($_POST['combi_err'])) xtc_redirect(xtc_href_link($goto, xtc_get_all_get_params($parameters), 'NONSSL'));
  if (isset($_POST['combi_id']) && $_POST['combi_id']) {

    $k = explode('_', $_POST['options_ids']);
    $v = explode('_', $_POST['combi_id']);
    $_POST['id'] = array_combine($k, $v);

    unset($_POST['options_ids'], $_POST['combi_id']); // brauchen wir nicht mehr

  }
}
