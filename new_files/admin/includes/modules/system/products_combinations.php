<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

use KarlK\HookPointManager\Classes\KKHookPointManager;
require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/karlk/autoload.php';

class products_combinations {

  var $code;
  var $title;
  var $description;
  var $sort_order;
  var $enabled;
  var $properties;
  var $_check;

	public function __construct() {
		$this->code = 'products_combinations';
		$this->title = MODULE_PRODUCTS_COMBINATIONS_TEXT_TITLE . ' - Version: 1.0.18';
		$this->description = '';
		$this->description .= MODULE_PRODUCTS_COMBINATIONS_TEXT_DESCRIPTION;
		if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS')) {
			$this->description .= '<a class="button btnbox but_green" style="text-align:center;" onclick="this.blur();" href="' . xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=' . $this->code . '&action=update') . '">Update</a><br /><br />';
			// Button xtc_restock und Template ändern
			$this->description .= '<a class="button btnbox but_green" style="text-align:center;" onclick="return confirmLink(\''. sprintf(MODULE_PRODUCTS_COMBINATIONS_BUTTON_MODIFYTPL_CONFIRM, CURRENT_TEMPLATE) .'\', \'\' ,this);" href="' . xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=' . $this->code . '&action=custom&func=moddifytpl') . '">'.MODULE_PRODUCTS_COMBINATIONS_BUTTON_MODIFYTPL.'</a><br />';
			$this->description .= MODULE_PRODUCTS_COMBINATIONS_BUTTON_MODIFYTPL_DESC;
			// Button xtc_restock und Template wiederherstellen
			$this->description .= '<a class="button btnbox but_red" style="text-align:center;" onclick="return confirmLink(\''. sprintf(MODULE_PRODUCTS_COMBINATIONS_BUTTON_RESTORETPL_CONFIRM, CURRENT_TEMPLATE) .'\', \'\' ,this);" href="' . xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=' . $this->code . '&action=custom&func=restoretpl') . '">'.MODULE_PRODUCTS_COMBINATIONS_BUTTON_RESTORETPL.'</a><br />';
			$this->description .= MODULE_PRODUCTS_COMBINATIONS_BUTTON_RESTORETPL_DESC;
		}
		if (!$this->isMmlcInstalled()) {
			$this->description .= '<a class="button btnbox but_red" style="text-align:center;" onclick="return confirmLink(\''. MODULE_PRODUCTS_COMBINATIONS_REMOVE .'\', \'\' ,this);" href="' . xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system&module=' . $this->code . '&action=custom&func=delfiles') . '">'.MODULE_PRODUCTS_COMBINATIONS_BUTTON_DELETE.'</a><br />';
			$this->description .= MODULE_PRODUCTS_COMBINATIONS_BUTTON_DELETE_DESC;
		}
		$this->sort_order = defined('MODULE_PRODUCTS_COMBINATIONS_SORT_ORDER') ? MODULE_PRODUCTS_COMBINATIONS_SORT_ORDER : 0;
		$this->enabled = (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') ? true : false;

		$this->properties['remove'] = array( 'text' => MODULE_PRODUCTS_COMBINATIONS_REMOVE);
 	}

	public function process($file) {
	}

	public function display() {
		return array('text' => '<br /><div align="center">' . xtc_button(BUTTON_SAVE) .
					xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=products_combinations')) . "</div>");
	}

	public function check() {
    if (!isset($this->_check)) {
      if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS')) {
        $this->_check = true;
      } else {
        $check_query = xtc_db_query("SELECT configuration_value
                                      FROM " . TABLE_CONFIGURATION . "
                                      WHERE configuration_key = 'MODULE_PRODUCTS_COMBINATIONS_STATUS'");
        $this->_check = xtc_db_num_rows($check_query);
      }
    }
    return $this->_check;
	}

	public function install() {
		defined('PROJECT_VERSION_NO') or define('PROJECT_VERSION_NO', PROJECT_MAJOR_VERSION . '.' . PROJECT_MINOR_VERSION);
		// #webald - 2020-11-24 - Prüfung Mindestversion, sonst keine Installation
		if (version_compare(PROJECT_VERSION_NO,'2.0.1') >= 0) {
			// Einträge in Konfigurationstabelle
	    	xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCTS_COMBINATIONS_STATUS', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
	    	xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
	    	xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
	    	xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCTS_COMBINATIONS_SHOW_EMPTY_COMBI_OPTION', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
	    	xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
	    	xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP5', 'false',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
	    	xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP', 'false',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
			// Preisupdater
	    	xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCTS_COMBINATIONS_PRICEUPDATER_ON', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
	    	xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCTS_COMBINATIONS_ADDITIONAL', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
	    	xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCTS_COMBINATIONS_UPDATE_PRICE', 'false',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");

			// Klassenerweiterungsmodul wird mitinstalliert - wird eine Kategorie oder ein Produkt gelöscht wird gleichzeitig die Kombination entfernt
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_CATEGORIES_COMBIREMOVEPRODUCT_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_CATEGORIES_COMBIREMOVEPRODUCT_SORT_ORDER', '11','6', '2', now())");

			// Klassenerweiterungsmodul wird mitinstalliert - hat der Artikel eine Kombination wird der Attributbestand erhöht, damit ein Checkout möglich ist
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_MAIN_COMBIDATATOATTR_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_MAIN_COMBIDATATOATTR_SORT_ORDER', '11','6', '2', now())");

			// Klassenerweiterungsmodul wird mitinstalliert - hat eine Kombination eine eigene Artikelnummer, EAN oder Bild, dann werden diese Nummern dem bestellten Produkt zugeordnet
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_COMBIMODELTOPRODUCT_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_COMBIMODELTOPRODUCT_SORT_ORDER', '11','6', '2', now())");

			// Klassenerweiterungsmodul wird mitinstalliert - hat eine Kombination eine eigene Artikelnummer, EAN oder Bild, dann werden diese Nummern dem bestellten Produkt zugeordnet
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHOPPING_CART_COMBIDATATOPRODUCT_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHOPPING_CART_COMBIDATATOPRODUCT_SORT_ORDER', '11','6', '2', now())");

			// Tabellen für Kombinations Verwaltung erzeugen
			xtc_db_query("CREATE TABLE IF NOT EXISTS ".TABLE_PRODUCTS_OPTIONS_COMBI." (
						`combi_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
						`products_id` int(11) NOT NULL,
						`options_ids` varchar(255) NOT NULL,
						`options_values_ids` varchar(255) NOT NULL,
						PRIMARY KEY (`combi_id`)
						);");

			xtc_db_query("CREATE TABLE IF NOT EXISTS ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2." (
						`combi_value_id` int(11) NOT NULL AUTO_INCREMENT,
						`combi_id` int(11) NOT NULL,
						`products_id` int(11) NOT NULL,
						`status` int(1) NOT NULL,
						`attribute_name` varchar(255) NOT NULL,
						`attribute_id` varchar(128) NOT NULL,
						`model` varchar(64) NOT NULL,
						`ean` varchar(128) NOT NULL,
						`stock` int(4) NOT NULL,
						`image` varchar(255) NOT NULL,
						`combi_sort` int(11) NOT NULL,
						PRIMARY KEY (`combi_value_id`)
						);");

			// Einträge in admin_access
			$admin_access_products_combi_exists = xtc_db_num_rows(xtc_db_query("SHOW COLUMNS FROM ".TABLE_ADMIN_ACCESS." WHERE Field='products_combi'"));
			if(!$admin_access_products_combi_exists) {
				xtc_db_query("ALTER TABLE ".TABLE_ADMIN_ACCESS." ADD `products_combi` INT(1) DEFAULT '0' NOT NULL");
			}
			xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET products_combi = '9' WHERE customers_id = 'groups' LIMIT 1");
			xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET products_combi = '1' WHERE customers_id = '1' LIMIT 1");
			if ($_SESSION['customer_id'] > 1) {
				xtc_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET products_combi = '1' WHERE customers_id = '".$_SESSION['customer_id']."' LIMIT 1") ;
			}
			if (version_compare(PROJECT_VERSION_NO,'2.0.3') <= 0)
			{
				// fehlende Spalte ergänzen
				// #GTB - 2018-03-16 - new products attributes handling
				xtc_db_query("ALTER TABLE ".TABLE_PRODUCTS_OPTIONS_VALUES." ADD products_options_values_sortorder INT(11) NOT NULL AFTER products_options_values_name;");
			}
			// Klassenerweiterungsmodule in Konfigurationstabelle?
			$this->checkClassExtensionModules();
			// Hookpoints setzen
			$this->installHookpoints();
		} else {
			trigger_error('Module "Attribute Kombination Manager" cannot be installed. Minimum version must be 2.0.1.',E_USER_ERROR);
		}
	}

	public function update() {

		// Eintrag löschen
		$options_select_exists = xtc_db_num_rows(xtc_db_query("SHOW COLUMNS FROM ".TABLE_PRODUCTS_OPTIONS_COMBI." WHERE Field='options_select'"));
		if($options_select_exists) {
			xtc_db_query("ALTER TABLE ".TABLE_PRODUCTS_OPTIONS_COMBI." DROP `options_select`");
		}
		// Eintrag hinzufügen
		$options_values_ids_exists = xtc_db_num_rows(xtc_db_query("SHOW COLUMNS FROM ".TABLE_PRODUCTS_OPTIONS_COMBI." WHERE Field='options_values_ids'"));
		if(!$options_values_ids_exists) {
			xtc_db_query("ALTER TABLE ".TABLE_PRODUCTS_OPTIONS_COMBI." ADD `options_values_ids` VARCHAR(255) NOT NULL");
		}
		xtc_db_query("CREATE TABLE IF NOT EXISTS ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2." (
					`combi_value_id` int(11) NOT NULL AUTO_INCREMENT,
					`combi_id` int(11) NOT NULL,
					`products_id` int(11) NOT NULL,
					`status` int(1) NOT NULL,
					`attribute_name` varchar(255) NOT NULL,
					`attribute_id` varchar(128) NOT NULL,
					`model` varchar(64) NOT NULL,
					`ean` varchar(128) NOT NULL,
					`stock` int(4) NOT NULL,
					`image` varchar(255) NOT NULL,
					`combi_sort` int(11) NOT NULL,
					PRIMARY KEY (`combi_value_id`)
					);");
		// Einträge ändern
		xtc_db_query("ALTER TABLE ".TABLE_PRODUCTS_OPTIONS_COMBI." MODIFY `options_ids` VARCHAR(255) NOT NULL");
		xtc_db_query("ALTER TABLE ".TABLE_PRODUCTS_OPTIONS_COMBI." MODIFY `options_values_ids` VARCHAR(255) NOT NULL");

		if (!defined('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN')) {
    		xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		}
		if (!defined('MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		}
		if (!defined('MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP5')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP5', 'false','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		}
		if (!defined('MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP', 'false','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		}
		if (!defined('MODULE_PRODUCTS_COMBINATIONS_PRICEUPDATER_ON')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PRODUCTS_COMBINATIONS_PRICEUPDATER_ON', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		}
		if (!defined('MODULE_PRODUCTS_COMBINATIONS_ADDITIONAL')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PRODUCTS_COMBINATIONS_ADDITIONAL', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		}
		if (!defined('MODULE_PRODUCTS_COMBINATIONS_UPDATE_PRICE')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PRODUCTS_COMBINATIONS_UPDATE_PRICE', 'false','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		}
		if (!defined('MODULE_CATEGORIES_COMBIREMOVEPRODUCT_STATUS') || !defined('MODULE_CATEGORIES_COMBIREMOVEPRODUCT_SORT_ORDER')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_CATEGORIES_COMBIREMOVEPRODUCT_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_CATEGORIES_COMBIREMOVEPRODUCT_SORT_ORDER', '11' ,'6', '2', now())");
		}
		if (!defined('MODULE_MAIN_COMBIDATATOATTR_STATUS') || !defined('MODULE_MAIN_COMBIDATATOATTR_SORT_ORDER')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_MAIN_COMBIDATATOATTR_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_MAIN_COMBIDATATOATTR_SORT_ORDER', '11','6', '2', now())");
		}
		if (!defined('MODULE_ORDER_COMBIMODELTOPRODUCT_STATUS') || !defined('MODULE_ORDER_COMBIMODELTOPRODUCT_SORT_ORDER')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_COMBIMODELTOPRODUCT_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_COMBIMODELTOPRODUCT_SORT_ORDER', '11','6', '2', now())");
		}
		if (!defined('MODULE_SHOPPING_CART_COMBIDATATOPRODUCT_STATUS') || !defined('MODULE_SHOPPING_CART_COMBIDATATOPRODUCT_SORT_ORDER')) {
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHOPPING_CART_COMBIDATATOPRODUCT_STATUS', 'true','6', '1','xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
			xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHOPPING_CART_COMBIDATATOPRODUCT_SORT_ORDER', '11','6', '2', now())");
		}
		// Klassenerweiterungsmodule in Konfigurationstabelle?
		$this->checkClassExtensionModules();
		// Hookpoints setzen
		$this->installHookpoints();
		// Datei löschen
		$shop_path = DIR_FS_CATALOG;
		$dirs_and_files = array();
		$dirs_and_files[] = $shop_path.'products_combi_data.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/footer/products_combi.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/modules/new_product/combi_new_product.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/modules/product_combi_functions.php';
		$dirs_and_files[] = $shop_path.'includes/modules/product_combi_functions.php';
		// Dateien löschen
		foreach ($dirs_and_files as $dir_or_file) {
			$this->rrmdir($dir_or_file);
		}
		// Tabelle konvertieren falls Daten vorhanden sind
		$tmpresult = xtc_db_query("SHOW TABLES LIKE '".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES."'");
		if (xtc_db_num_rows($tmpresult) > 0) {
			$this->convertOldValueTable();
		}
	}

	public function remove() {
		// alle Datenbankeinträge entfernen
		xtc_db_query("DELETE FROM ".TABLE_CONFIGURATION." WHERE configuration_key in ('" . implode("', '", $this->keys()) . "')");
		$query = xtc_db_query("SHOW COLUMNS FROM " . TABLE_ADMIN_ACCESS . " LIKE 'products_combi'");
		$exist = xtc_db_num_rows($query);
		if ($exist > 0) {
		  xtc_db_query("ALTER TABLE ".TABLE_ADMIN_ACCESS." DROP `products_combi`");
		}

		xtc_db_query("DROP TABLE IF EXISTS `products_options_combi`");
		xtc_db_query("DROP TABLE IF EXISTS `products_options_combi_values`");
		xtc_db_query("DROP TABLE IF EXISTS `products_options_combi_values_2`");

		// KKHookpointManager
		xtc_db_query("DROP TABLE IF EXISTS `kk_hook_point`");

		// Klassenerweiterungsmodul wird zeitgleich deinstalliert
		xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE 'MODULE_CATEGORIES_COMBIREMOVEPRODUCT_%'");

		// Klassenerweiterungsmodul wird zeitgleich deinstalliert
		xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE 'MODULE_MAIN_COMBIDATATOATTR_%'");

		// Klassenerweiterungsmodul wird zeitgleich deinstalliert
		xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE 'MODULE_ORDER_COMBIMODELTOPRODUCT%'");

		// Klassenerweiterungsmodul wird zeitgleich deinstalliert
		xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key LIKE 'MODULE_SHOPPING_CART_COMBIDATATOPRODUCT%'");
	}

	public function custom() {

		// Dateien anpassen
		if (isset($_GET['func']) && strip_tags($_GET['func']) == 'moddifytpl') {
			$this->modifyCurrentTemplate();
		}
		// Anpassungen entfernen
		if (isset($_GET['func']) && strip_tags($_GET['func']) == 'restoretpl') {
			$this->restoreAllFiles();
		}
		// alle Eintragungen und Dateien löschen - nur bei Installation ohne MMLC
		if (isset($_GET['func']) && strip_tags($_GET['func']) == 'delfiles') {
			// Systemmodule deinstallieren
			$this->remove();
			$this->restoreAllFiles();
			$this->removeAllFiles();
			xtc_redirect(xtc_href_link(FILENAME_MODULE_EXPORT, 'set=system'));
		}

	}

	public function keys() {
		if (defined('MODULE_CATEGORIES_COMBIREMOVEPRODUCT_STATUS'))
		{
			if ($this->enabled == false && MODULE_CATEGORIES_COMBIREMOVEPRODUCT_STATUS == 'true')
	    		xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = 'false' where configuration_key = 'MODULE_CATEGORIES_COMBIREMOVEPRODUCT_STATUS'");
			if ($this->enabled == true && MODULE_CATEGORIES_COMBIREMOVEPRODUCT_STATUS == 'false')
	    		xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = 'true' where configuration_key = 'MODULE_CATEGORIES_COMBIREMOVEPRODUCT_STATUS'");
		}
		if (defined('MODULE_MAIN_COMBIDATATOATTR_STATUS'))
		{
			if ($this->enabled == false && MODULE_MAIN_COMBIDATATOATTR_STATUS == 'true')
	    		xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = 'false' where configuration_key = 'MODULE_MAIN_COMBIDATATOATTR_STATUS'");
			if ($this->enabled == true && MODULE_MAIN_COMBIDATATOATTR_STATUS == 'false')
	    		xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = 'true' where configuration_key = 'MODULE_MAIN_COMBIDATATOATTR_STATUS'");
		}
		if (defined('MODULE_ORDER_COMBIMODELTOPRODUCT_STATUS'))
		{
			if ($this->enabled == false && MODULE_ORDER_COMBIMODELTOPRODUCT_STATUS == 'true')
	    		xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = 'false' where configuration_key = 'MODULE_ORDER_COMBIMODELTOPRODUCT_STATUS'");
			if ($this->enabled == true && MODULE_ORDER_COMBIMODELTOPRODUCT_STATUS == 'false')
	    		xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = 'true' where configuration_key = 'MODULE_ORDER_COMBIMODELTOPRODUCT_STATUS'");
		}
		if (defined('MODULE_SHOPPING_CART_COMBIDATATOPRODUCT_STATUS'))
		{
			if ($this->enabled == false && MODULE_SHOPPING_CART_COMBIDATATOPRODUCT_STATUS == 'true')
	    		xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = 'false' where configuration_key = 'MODULE_SHOPPING_CART_COMBIDATATOPRODUCT_STATUS'");
			if ($this->enabled == true && MODULE_SHOPPING_CART_COMBIDATATOPRODUCT_STATUS == 'false')
	    		xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = 'true' where configuration_key = 'MODULE_SHOPPING_CART_COMBIDATATOPRODUCT_STATUS'");
		}
    	$key = array();
    	$key[] = 'MODULE_PRODUCTS_COMBINATIONS_STATUS';
    	$key[] = 'MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN';
    	$key[] = 'MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK';
    	$key[] = 'MODULE_PRODUCTS_COMBINATIONS_SHOW_EMPTY_COMBI_OPTION';
    	$key[] = 'MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE';
    	$key[] = 'MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP5';
    	$key[] = 'MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP';
    	$key[] = 'MODULE_PRODUCTS_COMBINATIONS_PRICEUPDATER_ON';
    	$key[] = 'MODULE_PRODUCTS_COMBINATIONS_ADDITIONAL';
    	$key[] = 'MODULE_PRODUCTS_COMBINATIONS_UPDATE_PRICE';

    	return $key;
	}

	protected function rrmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
			reset($objects);
			rmdir($dir);
			return true;
		} elseif(is_file($dir)) {
			unlink($dir);
			return true;
		}
	}

	protected function convertOldValueTable() {
		global $messageStack;

		$tmpquery = xtc_db_query("SELECT * FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES." ORDER BY combi_value_id");
		while ($tmpdata = xtc_db_fetch_array($tmpquery)) {

			$res = array();
			$dat_exists = false;
			$del_old_data = false;

			// json_decode
			$data["combi_id"] = $tmpdata["combi_id"];
			$data["products_id"] = $tmpdata["products_id"];
			$data["status"] = json_decode($tmpdata["status"]);
			$data["attribute_name"] = json_decode($tmpdata["attribute_name"]);
			$data["attribute_id"] = json_decode($tmpdata["attribute_id"]);
			$data["model"] = json_decode($tmpdata["model"]);
			$data["ean"] = json_decode($tmpdata["ean"]);
			$data["stock"] = json_decode($tmpdata["stock"]);
			$data["image"] = json_decode($tmpdata["image"]);

			// prüfen, ob neuer Datensatz schon existiert
			$tmpresult = xtc_db_query("SELECT products_id FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2." WHERE products_id = " .(int)$data["products_id"]. " LIMIT 1");
			if (xtc_db_num_rows($tmpresult) != 0) {
				$messageStack->add_session('In der Tabelle "' . TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2 .'" existiert bereits ein Datensatz f&uuml;r Produkt-ID ' . $data["products_id"] . '!', 'error');
				$dat_exists = true;
			}

			for($i=0; $i < sizeof($data["attribute_name"]);$i++){
				if ($dat_exists == true) break;

				$saveData = array();
				$saveData["combi_id"] = $data["combi_id"];
				$saveData["products_id"] = $data["products_id"];
				$saveData["status"] = $data["status"][$i];
				$saveData["attribute_name"] = $data["attribute_name"][$i];
				$saveData["attribute_id"] = $data["attribute_id"][$i];
				$saveData["model"] = $data["model"][$i];
				$saveData["ean"] = $data["ean"][$i];
				$saveData["stock"] = $data["stock"][$i];
				$saveData["image"] = $data["image"][$i];
			    $saveData["combi_sort"] = $i;

				$result = xtc_db_perform(TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2, $saveData);
				$res[] = $result;
			}

			if (in_array(false, $res)) {
				$messageStack->add_session('Produkt-ID ' . $data["products_id"] . ' - Datensatz konnte nicht vollst&auml;ndig konvertiert werden!<br />Der entsprechende Datensatz wurde in der Tabelle "' . TABLE_PRODUCTS_OPTIONS_COMBI_VALUES .'" nicht gel&ouml;scht!', 'error');
			} else {
				$messageStack->add_session('Produkt-ID ' . $data["products_id"] . ' - Datensatz konvertiert!', 'success');
	            $del_old_data = true;
			}

			if ($del_old_data == true) $tmpresult = xtc_db_query('DELETE FROM '.TABLE_PRODUCTS_OPTIONS_COMBI_VALUES.' WHERE combi_id='.(int)$data["combi_id"]);

			if ($tmpresult == false){
				$messageStack->add_session('Der Datensatz f&uuml;r Produkt-ID ' . $data["products_id"] . ' in der Tabelle "' . TABLE_PRODUCTS_OPTIONS_COMBI_VALUES .'" konnte nicht gel&ouml;scht werden!', 'error');
			} else {
				$messageStack->add_session('Der Datensatz f&uuml;r Produkt-ID ' . $data["products_id"] . ' in der Tabelle "' . TABLE_PRODUCTS_OPTIONS_COMBI_VALUES .'" wurde gel&ouml;scht!', 'success');
	            $del_old_data = true;
			}

		}

			// prüfen, ob noch ein Datensatz existiert
			$tmpresult = xtc_db_query("SELECT products_id FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES." ORDER BY combi_value_id");
			if (xtc_db_num_rows($tmpresult) != 0) {
				$messageStack->add_session('Konvertierung der Tabelle "' . TABLE_PRODUCTS_OPTIONS_COMBI_VALUES .'" nicht vollst&auml;ndig - Datens&auml;tze m&uuml;ssen manuell bearbeitet werden!', 'error');
			} else {
				xtc_db_query("DROP TABLE `products_options_combi_values`");
				$messageStack->add_session('Konvertierung abgeschlossen - es wurde versucht die Tabelle "' . TABLE_PRODUCTS_OPTIONS_COMBI_VALUES .'" zu l&ouml;schen!<br />', 'success');
			}

	}

	// prüfen, ob ModifiedModuleLoaderClient installiert ist
    protected function isMmlcInstalled()
    {
        if (file_exists(DIR_FS_CATALOG . '/ModifiedModuleLoaderClient')) {
            return true;
        }
        return false;
    }

	protected function installHookpoints() {
		$hookPointManager = new KKHookPointManager();
		$hookPointManager->registerDefault();
		$hookPointManager->update();
		$hookPointManager->modifyFilesBySelection();
		$msgs = $hookPointManager->getMessage();
		$this->setMessage($msgs);
	}

	protected function modifyCurrentTemplate() {
		$hookPointManager = new KKHookPointManager();
		$hookPointManager->modifyFilesBySelection('tpl');
		$msgs = $hookPointManager->getMessage();
		$this->setMessage($msgs, COMBI_HOOKPOINT_MANAGER_TPL_MODIFIER);
	}

	protected function restoreAllFiles() {
		$hookPointManager = new KKHookPointManager();
		$hookPointManager->restoreAllFiles();
		$msgs = $hookPointManager->getMessage();
		$this->setMessage($msgs, COMBI_HOOKPOINT_MANAGER_TPL_MODIFIER);
	}

	protected function setMessage($msgs, $com = 'HookPointManager: ') {
		global $messageStack;

		foreach ($msgs as $msg) {
			$messageStack->add_session($com . $msg['text'], $msg['type']);
		}
	}

    protected function removeAllFiles()
    {
		// Dateien definieren die gelöscht werden
		$shop_path = DIR_FS_CATALOG;
		$dirs_and_files = array();
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'images/icons/icon_edit_combi.gif';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'images/icons/icon_edit_combi.psd';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'images/icons/kombi.ai';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'images/icons/kombi.psd';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'images/icons/kombi.png';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/filenames/products_combi.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/hpm/categories_view/side_buttons/product_combi_button.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/hpm/categories_view/small_buttons/product_combi_button.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/hpm/new_product/buttons/combi_new_product.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/javascript/products_combi.js.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/menu/40_products_combi.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/modules/new_attributes/new_attributes_include_th/combi_attributes.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/extra/modules/new_attributes/new_attributes_include_td/combi_attributes.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/javascript/dropdowncontent.js';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/javascript/products_combi.js.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'includes/modules/categories/combiRemoveProduct.php';
		$dirs_and_files[] = $shop_path.DIR_ADMIN.'products_combi.php';

		$dirs_and_files[] = $shop_path.'includes/extra/ajax/get_products_combi_data.php';
		$dirs_and_files[] = $shop_path.'includes/extra/application_bottom/product_combi_price_updater.php';
		$dirs_and_files[] = $shop_path.'includes/extra/cart_actions/add_product_prepare_post/products_combi_add.php';
		$dirs_and_files[] = $shop_path.'includes/extra/checkout/checkout_process_attributes/products_combi.php';
		$dirs_and_files[] = $shop_path.'includes/extra/checkout/checkout_requirements/products_combi.php';
		$dirs_and_files[] = $shop_path.'includes/extra/database_tables/products_combi_tables.php';
		$dirs_and_files[] = $shop_path.'includes/extra/modules/order_details_cart_attributes/products_combi.php';
		$dirs_and_files[] = $shop_path.'includes/extra/modules/order_details_cart_content/products_combi.php';
		$dirs_and_files[] = $shop_path.'includes/extra/modules/product_info_end/products_combi.php';
		$dirs_and_files[] = $shop_path.'includes/extra/modules/wishlist_content/combiImageToProduct.php';
		$dirs_and_files[] = $shop_path.'includes/modules/main/combiDataToAttr.php';
		$dirs_and_files[] = $shop_path.'includes/modules/order/combiModelToProduct.php';
		$dirs_and_files[] = $shop_path.'includes/modules/product_combi.php';
		$dirs_and_files[] = $shop_path.'includes/modules/shopping_cart/combiDataToProduct.php';

		$dirs_and_files[] = $shop_path.'lang/english/admin/products_combi.php';
		$dirs_and_files[] = $shop_path.'lang/english/extra/admin/products_combi.php';
		$dirs_and_files[] = $shop_path.'lang/english/extra/products_combi.php';
		$dirs_and_files[] = $shop_path.'lang/english/modules/system/products_combinations.php';

		$dirs_and_files[] = $shop_path.'lang/german/admin/products_combi.php';
		$dirs_and_files[] = $shop_path.'lang/german/extra/admin/products_combi.php';
		$dirs_and_files[] = $shop_path.'lang/german/extra/products_combi.php';
		$dirs_and_files[] = $shop_path.'lang/german/modules/system/products_combinations.php';

		$dirs_and_files[] = $shop_path.'templates/bootstrap4/javascript/depdrop_locale_de.js';
		$dirs_and_files[] = $shop_path.'templates/bootstrap4/javascript/dependent-dropdown.js';
		$dirs_and_files[] = $shop_path.'templates/bootstrap4/javascript/dependent-dropdown.min.js';

		$dirs_and_files[] = $shop_path.'templates/bootstrap5/javascript/depdrop_locale_de.js';
		$dirs_and_files[] = $shop_path.'templates/bootstrap5/javascript/dependent-dropdown.js';
		$dirs_and_files[] = $shop_path.'templates/bootstrap5/javascript/dependent-dropdown.min.js';

		$dirs_and_files[] = $shop_path.'templates/bootstrap5a/javascript/depdrop_locale_de.js';
		$dirs_and_files[] = $shop_path.'templates/bootstrap5a/javascript/dependent-dropdown.js';
		$dirs_and_files[] = $shop_path.'templates/bootstrap5a/javascript/dependent-dropdown.min.js';

		$dirs_and_files[] = $shop_path.'templates/tpl_modified/javascript/depdrop_locale_de.js';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/javascript/dependent-dropdown.js';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified/javascript/dependent-dropdown.min.js';

		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/javascript/depdrop_locale_de.js';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/javascript/dependent-dropdown.js';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_nova/javascript/dependent-dropdown.min.js';

		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/javascript/depdrop_locale_de.js';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/javascript/dependent-dropdown.js';
		$dirs_and_files[] = $shop_path.'templates/tpl_modified_responsive/javascript/dependent-dropdown.min.js';

		$dirs_and_files[] = $shop_path.'templates/xtc5/javascript/depdrop_locale_de.js';
		$dirs_and_files[] = $shop_path.'templates/xtc5/javascript/dependent-dropdown.js';
		$dirs_and_files[] = $shop_path.'templates/xtc5/javascript/dependent-dropdown.min.js';

		$dirs_and_files[] = $shop_path.'vendor/composer/KKClassLoader.php';

		$dirs_and_files[] = $shop_path.'vendor-no-composer/karlk';

		// Dateien löschen
		foreach ($dirs_and_files as $dir_or_file) {
			$this->rrmdir($dir_or_file);
		}

		$dirs[] = $shop_path.'vendor/composer';
		$dirs[] = $shop_path.'vendor';
		$dirs[] = $shop_path.'vendor-no-composer';

		foreach ($dirs as $dir) {
			$this->RemoveEmptyDirs($dir);
		}

		// Datei selbst löschen
        unlink($shop_path.DIR_ADMIN.'includes/modules/system/products_combinations.php');
	}

	// Leere Verzeichnisse löschen
	protected function RemoveEmptyDirs($dir)
	{
		if (is_dir($dir)) {
			foreach (scandir($dir) as $file){
				if (!in_array($file, array('.','..'))) {
					//echo $dir . ' ist nicht leer!<br>';
					return false;
				}
			}
			//echo $dir . ' ist leer!<br>';
			rmdir($dir);
			return true;
		}
	}

	// Funktion stellt sicher, dass die Klassenerweiterungsmodule in der Datenbank eingetragen sind
	protected function checkClassExtensionModules() {
		$classExtensions = array(
			array('MODULE_TYPE' => 'CATEGORIES', 'CLASS_FILE' => 'combiRemoveProduct.php'),
			array('MODULE_TYPE' => 'MAIN', 'CLASS_FILE' => 'combiDataToAttr.php'),
			array('MODULE_TYPE' => 'ORDER', 'CLASS_FILE' => 'combiModelToProduct.php'),
			array('MODULE_TYPE' => 'SHOPPING_CART', 'CLASS_FILE' => 'combiDataToProduct.php'),
		);

		foreach ($classExtensions as $classExtension) {
			$moduleType = 'MODULE_'.$classExtension['MODULE_TYPE'].'_INSTALLED';
			$classFile = $classExtension['CLASS_FILE'];
			if (defined($moduleType)) {
				$installed = [];
				if (constant($moduleType) != '') $installed = explode(';', constant($moduleType));
				if (!in_array($classFile, $installed)) {
					$installed[] =  $classFile;
					xtc_db_query("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '" . implode(';', $installed) . "', last_modified = now() where configuration_key = '" . $moduleType . "'");
				}
			} else {
				xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('" . $moduleType . "', '" . $classFile . ";', '6', '0', now())");
			}
		}
	}

}
