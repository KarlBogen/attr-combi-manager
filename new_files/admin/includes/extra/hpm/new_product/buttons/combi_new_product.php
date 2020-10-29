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

// Eingabefeld "Lagerbestand" wird zu Hidden-Feld mit dem Text Kombinationsbestand
// Button "Kombinationen editieren" wird eingefügt

// prüfen, ob Systemmodul installiert und Status true ist
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {

	require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/autoload.php';

	$combi_id = ProductCombiAdmin::hasProductCombi($pInfo->products_id);
	if($combi_id){
		$hidden = xtc_draw_hidden_field('products_quantity', $pInfo->products_quantity);
    	echo '&nbsp;&nbsp;<a class="button" href="'.xtc_href_link(FILENAME_PRODUCTS_COMBI, "cPath=". $cPath . $catfunc->page_parameter.'action=edit&oldaction=new_product&pID='.$pInfo->products_id).'">' . PRODUCTS_COMBI_EDIT . '</a>';
?>
		<script type="text/javascript">
			$(document).ready(function(){
				var qty_field = $('input[name="products_quantity"]');
				var qty_val = qty_field.val();
				qty_field.closest('span').empty().append('<strong>'+qty_val+'</strong> <?php echo PRODUCTS_COMBI_STOCK.$hidden ?>');
			});
		</script>
<?php
	}
	// wenn noch keine Kombination angelegt ist, aber das Produkt mehr als 1 Attribut hat
	elseif (ProductCombiAdmin::getCombiDiffAttributes($pInfo->products_id) > 1)
	{
    	echo '&nbsp;&nbsp;<a class="button but_green" href="'.xtc_href_link(FILENAME_PRODUCTS_COMBI, "cPath=". $cPath . $catfunc->page_parameter.'action=edit&oldaction=new_product&pID='.$pInfo->products_id).'">' . PRODUCTS_COMBI_NEW . '</a>';
	}
}
?>