<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

use KarlK\ProductCombiManager\Classes\ProductCombi;

require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/karlk/autoload.php';

	$combi_id = ProductCombi::hasProductCombi($product->pID);

	// Änderung Preisupdater
	$prod_data = array(	'pid'			=> (int)$product->data['products_id'],
                        'gprice'    	=> isset($products_price) ? $products_price : 0,
        				'tax_id'		=> isset($product->data['products_tax_class_id']) ? $product->data['products_tax_class_id'] : 0,
                        'products_vpe'	=> $json_vpetext = isset($product->data['products_vpe']) ? (xtc_get_vpe_name($product->data['products_vpe']) ? htmlentities(xtc_get_vpe_name($product->data['products_vpe'])) : COMBI_TEXT_PRODUCTS_VPE) : '',
                        'vpe_status'    => isset($product->data['products_vpe_status']) ? $product->data['products_vpe_status'] : 0,
                        'vpe_value'		=> isset($product->data['products_vpe_value']) ? $product->data['products_vpe_value'] : ''
						);

	if($combi_id) {
		$output = ProductCombi::getCombinationsListfromTable($combi_id, $prod_data);
		$info_smarty->assign('MODULE_product_combi', $output);
	}

?>
