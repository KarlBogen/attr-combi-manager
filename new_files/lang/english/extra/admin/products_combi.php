<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

define('BOX_PRODUCTS_COMBI', 'Attribut Combinations');
define('PRODUCTS_COMBI_HEADING', 'Attribute Combinations Manger');
define('PRODUCTS_COMBI_EDIT', 'Edit Combinations');
define('PRODUCTS_COMBI_NEW', 'New Combinations');
define('PRODUCTS_COMBI_STOCK', 'Combinations stock');

// Hookpoints
define('COMBI_HOOKPOINT_MANAGER_ORGFILE_CANNOTCREATE', 'Can not create original file <strong>%s</strong> because <strong>%s</strong> not exsits!');
define('COMBI_HOOKPOINT_MANAGER_ORGFILE_NOTCREATED', 'Can not create original file <strong>%s</strong> out of <strong>%s</strong> because file hash dose not match!');
define('COMBI_HOOKPOINT_MANAGER_ORGFILE_CREATED', 'The original file <strong>%s</strong> out of <strong>%s</strong> was created!');
define('COMBI_HOOKPOINT_MANAGER_ORGFILE_NOTEXISTS', 'Can not create hook points in <strong>%s</strong> because <strong>%s</strong> not exsits!');
define('COMBI_HOOKPOINT_MANAGER_HASH_MATCH', 'Can not install HookPoint <strong>%s</strong> in <strong>%s</strong> because file hash dose not match with original file!');
define('COMBI_HOOKPOINT_MANAGER_HP_INSERTED', 'The hookpoint in file <strong>%s</strong> was inserted!');
// Template changes
define('COMBI_HOOKPOINT_MANAGER_TPL_MODIFIER', 'FileModifier: ');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_NOTEXISTS', 'The file <strong>%s</strong> does not exist!<br />This file may only be available in other templates.');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_ISALREADY_MODIFIED', 'The file <strong>%s</strong> is already modified!');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_SEARCHSTRING_NOTFOUND', 'Searchstring in file <strong>%s</strong> not found!');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_MODIFIED', 'The file <strong>%s</strong> has been modified!');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_NOTMODIFIED', 'The file <strong>% s </strong> did not contain the original module modifications!');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_RESTORED', 'The modifications in the file <strong>% s </strong> have been removed!');
