<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

// prüfen, ob Systemmodul installiert und Status true ist
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {

  // Werte kommen aus admin/includes/extra/modules/new_attributes_include_th
  // $combi[0] == combi_id, $combi[1] == Optionen, , $combi[2] == Optionswerte
  if (isset($combi[2]) && $combi[2]) {
    $combis = explode(',', $combi[2]);
    // fügt einen unsichtbaren td mit class als Identifizierer in der Attributverwaltung ein
    // diese class wird von Javascript benutzt um Kombioptionen auszublenden
    if (in_array($current_value_id, $combis)) {
      $output .= '<td class="is_combi_val" style="display:none;"></td>' . PHP_EOL;
    } else {
      $output .= '<td class="no_combi_val" style="display:none;"></td>' . PHP_EOL;
    }
  }
}
