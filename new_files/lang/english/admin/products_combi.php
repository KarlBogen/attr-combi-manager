<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */
//
define('PROD_COMBI_HEADER_TITLE', "Attribute Combination Manger");
define('PROD_COMBI_NO_PRODUCTS_ERR', "You have currently no products to make a Combination.");
define('PROD_COMBI_NOT_SELECTED_MSG', "For this product there is no product combinations.");
//
define('PROD_COMBI_MSQL_ERR', "Error: There are currently no products features. Please create only via 'Item options'.");
define('PROD_COMBI_MAX_INPUT_VARS', "<br /><p class='colorRed'>Note: For more than %d combinations, the maximum number of %d input fields set in PHP can be reached.<br />In this case, reduce the combinations or insert this line <strong>php_value max_input_vars %d</strong> into your .htaccess file.<br /></p>");
define('PROD_COMBI_CREATE_BTN', "Apply");
define('PROD_COMBI_CREATE_SINGLE_BTN', "Create single variations");
//
define('PROD_COMBI_TH_ACTIVE', "Active");
define('PROD_COMBI_TH_COMBI', "Combination");
define('PROD_COMBI_TH_MODEL', "Model");
define('PROD_COMBI_TH_EAN', "GTIN/EAN");
define('PROD_COMBI_TH_STOCK', "Stock");
define('PROD_COMBI_TH_IMAGE', "Image");
define('PROD_COMBI_DELETE_BTN', "delete all combinations");
//
define('PROD_COMBI_SORT_INFO', "Note on sorting: Changing the sorting order only has a limited effect in the shop front end!");
define('PROD_COMBI_UP', "up");
define('PROD_COMBI_DOWN', "down");
//
define('PROD_COMBI_HELPER', "Helps");
define('PROD_COMBI_DEL_BUTTON', "- delete selected Combination");
define('PROD_COMBI_ADD_BUTTON', "+ insert Combination");
define('PROD_COMBI_PRESELECT', "Prefill the field <strong>%s</strong> (at all selected combinations) with the value ");
define('PROD_COMBI_PRESELECT_BTN', "prefill");
define('PROD_COMBI_SAVE_BTN', "Save");
define('PROD_COMBI_UPLOAD_IMG', "Link Images");
define('PROD_COMBI_UPLOAD_IMG_BTN', "Link image");
define('PROD_COMBI_SEL_ATTRIB_MSG', "You have these possibilities:");
define('PROD_COMBI_DELETE_IMG', "delete selected imagelinks");
define('PROD_COMBI_LOAD_IMG', "load images");
define('PROD_COMBI_IMG_PREVIEW', "Imagepreview");
define('COMBI_NO_IMG_SELECTED', "Please choose an product image!");
//
define('COMBI_TEXT_SAVE_BEFORE_LEAVE', 'Save combination list before exiting?');
define('COMBI_CONFIRM_DELETE_ALL', 'You really want to delete the combination list?');
define('COMBI_CONFIRM_DELETE_ROW', 'Delete row?');
define('COMBI_IMAGE_LINK_SUCCESS', 'Image linked - Imagepreview was loaded!');
define('COMBI_IMAGE_LINK_ERROR', 'There was an error, please try again!');
define('COMBI_EXISTS_TOGETEHER', 'This combination already exists!');
define('COMBI_NO_ROW_SELECTED', 'Any row is selected!');
define('COMBI_NO_COMBI_ACTIVE', 'One comination have to be active!');
