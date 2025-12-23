<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

use KarlK\ProductCombiManager\Classes\ProductCombiAdmin;

// prüfen, ob Systemmodul installiert und Status true ist
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {
  require_once DIR_FS_EXTERNAL . 'productscombi/vendor-no-composer/karlk/autoload.php';
  $ProductCombiAdmin = new ProductCombiAdmin();
  $combi_id = $ProductCombiAdmin->hasProductCombi($products['products_id']);
  if ($combi_id) {
    echo '<a href="' . xtc_href_link(FILENAME_PRODUCTS_COMBI, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&current_product_id=' . $products['products_id'] . '&pID=' . $products['products_id']) . '&action=edit' . '">' . xtc_image(DIR_WS_ICONS . 'icon_edit_combi.gif', PRODUCTS_COMBI_EDIT, '', '', $icon_padding) . '</a>';
  }
}
