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
	require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/autoload.php';
	// wenn bereits eine Kombination angelegt ist
		$combi_id = ProductCombiAdmin::hasProductCombi($pInfo->products_id);
	if ($combi_id)
	{
		$contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 100%; border-top: 1px solid #aaa; margin-top: 5px;">' . PRODUCTS_COMBI_HEADING . '</div>');
		$contents[] = array('align' => 'center',
							'text' =>  '<a class="button" href="'.xtc_href_link(FILENAME_PRODUCTS_COMBI, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')).'action=edit&current_product_id='.$pInfo->products_id.'&cPath='.$cPath.'&pID='.$pInfo->products_id).'">' . PRODUCTS_COMBI_EDIT . '</a>'
							);
	}
	// wenn noch keine Kombination angelegt ist, aber das Produkt mehr als 1 Attribut hat
	elseif (ProductCombiAdmin::getCombiDiffAttributes($pInfo->products_id) > 1)
	{
		$contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 100%; border-top: 1px solid #aaa; margin-top: 5px;">' . PRODUCTS_COMBI_HEADING . '</div>');
		$contents[] = array('align' => 'center',
							'text' =>  '<a class="button but_green" href="'.xtc_href_link(FILENAME_PRODUCTS_COMBI, xtc_get_all_get_params(array('cPath', 'action', 'pID', 'cID')).'action=edit&current_product_id='.$pInfo->products_id.'&cPath='.$cPath.'&pID='.$pInfo->products_id).'">' . PRODUCTS_COMBI_NEW . '</a>'
							);
	}
}