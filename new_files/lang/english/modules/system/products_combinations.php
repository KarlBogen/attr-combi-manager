<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */
//todo
define('MODULE_PRODUCTS_COMBINATIONS_TEXT_TITLE', 'Attribute Combinations Manger © by <a href="https://github.com/KarlBogen" target="_blank" style="color: #e67e22; font-weight: bold;">karlk</a>');
define('MODULE_PRODUCTS_COMBINATIONS_TEXT_DESCRIPTION', '<strong>With the "Attribute Combinations Manager" functions are available to create attribute combinations for certain articles.</strong><br /><br />');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_DELETE', 'Delete all module files');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_DELETE_DESC', '<u>Note:</u><br />All module files will be deleted after the file modifications are removed!');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_MODIFYTPL', 'Modify template files');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_MODIFYTPL_DESC', '<u>Note:</u><br />The <strong>template files of the currently active shop template</strong> (Configuration -> My Shop -> Template Set) be searched and modified for the module.');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_MODIFYTPL_CONFIRM', 'Do you really want to search and change the files of template <strong>%s</strong>?');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_RESTORETPL', 'Restore template and shop files');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_RESTORETPL_DESC', 'With this function, file modifications can be removed. The changed files<br />- /admin/includes/modules/categories_view.php<br />- /admin/includes/modules/new_product.php<br />are not reseted!');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_RESTORETPL_CONFIRM', 'Do you really want to search through the files of shop and template <strong>%s</strong> and remove changes?');
define('MODULE_PRODUCTS_COMBINATIONS_STATUS_TITLE', 'Activate module?');
define('MODULE_PRODUCTS_COMBINATIONS_STATUS_DESC', 'You can create attribute combinations in the admin area.<br />In the shop, interdependent dropdown fields are then displayed in the product detail view.<br />Only previously created combinations can be selected and placed in the shopping cart.<br />');
define('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN_TITLE', 'Should the combinations receive their own article number and EAN?');
define('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN_DESC', 'If a combination has its own article number or EAN, these numbers are assigned to the ordered product!<br />');
define('MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK_TITLE', 'Check stock of combination?');
define('MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK_DESC', 'If you activate this function, the article stock of the combination is checked.<br />Combinations that are not available are displayed in the dropdown fields (with a note)<br />but are deactivated and therefore not selectable.<br />');
define('MODULE_PRODUCTS_COMBINATIONS_SHOW_EMPTY_COMBI_OPTION_TITLE', 'View combinations not in stock?');
define('MODULE_PRODUCTS_COMBINATIONS_SHOW_EMPTY_COMBI_OPTION_DESC', 'If you switch this function off, combinations without stock are hidden in the drop-down fields.<br /><strong>Only works if stock check is switched on!</strong><br />');
define('MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE_TITLE', 'Change product image after selection?');
define('MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE_DESC', 'If you activate this function, the combination image becomes the active article image after the selection has been made.<br />');
define('MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP_TITLE', 'Is a bootstrap template used with activated image zoom effect?');
define('MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP_DESC', 'Javascript is changed for bootstrap with zoom effect.<br />');
define('MODULE_PRODUCTS_COMBINATIONS_PRICEUPDATER_ON_TITLE', '<br /><br />web0null_attribute_price_updater<br /><br />Priceupdater');
define('MODULE_PRODUCTS_COMBINATIONS_PRICEUPDATER_ON_DESC', 'Turn on?<br />');
define('MODULE_PRODUCTS_COMBINATIONS_ADDITIONAL_TITLE', 'Additional area');
define('MODULE_PRODUCTS_COMBINATIONS_ADDITIONAL_DESC', 'Display of additional lines (in this version...)<br />');
define('MODULE_PRODUCTS_COMBINATIONS_UPDATE_PRICE_TITLE', 'Recalculate price');
define('MODULE_PRODUCTS_COMBINATIONS_UPDATE_PRICE_DESC', 'Also changes the original price in the template. Declare legally!<br />');
define('MODULE_PRODUCTS_COMBINATIONS_REMOVE', '<b>Bitte beachten:</b> Alle bisher erstellten und gespeicherten Produktkombinationen werden gelöscht!');
?>