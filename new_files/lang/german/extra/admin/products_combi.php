<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

define('BOX_PRODUCTS_COMBI', 'Attribut Kombinationen');
define('PRODUCTS_COMBI_HEADING', 'Attribut Kombinationen Verwaltung');
define('PRODUCTS_COMBI_EDIT', 'Kombinationen editieren');
define('PRODUCTS_COMBI_NEW', 'Kombinationen anlegen');
define('PRODUCTS_COMBI_STOCK', 'Kombinationsbestand');

// Hookpoints
define('COMBI_HOOKPOINT_MANAGER_ORGFILE_CANNOTCREATE', 'Kann die Backupdatei <strong>%s</strong> nicht erstellen, weil die Originaldatei <strong>%s</strong> nicht existiert!');
define('COMBI_HOOKPOINT_MANAGER_ORGFILE_NOTCREATED', 'Kann die Backupdatei <strong>%s</strong> aus der Originaldatei <strong>%s</strong> nicht erstellen, der Datei-Hash stimmt nicht &uuml;berein!');
define('COMBI_HOOKPOINT_MANAGER_ORGFILE_CREATED', 'Die Backupdatei <strong>%s</strong> aus der Originaldatei <strong>%s</strong> wurde erstellen!');
define('COMBI_HOOKPOINT_MANAGER_ORGFILE_NOTEXISTS', 'Die HookPoints in der Datei <strong>%s</strong> k&ouml;nnen nicht erstellt werden, weil die Originaldatei <strong>%s</strong> fehlt!');
define('COMBI_HOOKPOINT_MANAGER_HASH_MATCH', 'Der HookPoint <strong>%s</strong> in der Datei <strong>%s</strong> kann nicht installiert werden, der Datei-Hash stimmt nicht mit der Originaldatei &uuml;berein!');
define('COMBI_HOOKPOINT_MANAGER_HP_INSERTED', 'Der HookPoint in der Datei <strong>%s</strong> wurde eingesetzt!');
// Templateänderungen
define('COMBI_HOOKPOINT_MANAGER_TPL_MODIFIER', 'Datei&auml;nderungen: ');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_NOTEXISTS', 'Die Datei <strong>%s</strong> ist nicht vorhanden!<br />Eventuell ist diese Datei nur in anderen Templates vorhanden.');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_ISALREADY_MODIFIED', 'Die Datei <strong>%s</strong> ist bereits modifiziert!');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_SEARCHSTRING_NOTFOUND', 'Suchstring in der Datei <strong>%s</strong> nicht gefunden!');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_MODIFIED', 'Die Datei <strong>%s</strong> wurde modifiziert!');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_NOTMODIFIED', 'Die Datei <strong>%s</strong> enthielt nicht die originalen Modulanpassungen!');
define('COMBI_HOOKPOINT_MANAGER_TPLFILE_RESTORED', 'Die Anpassungen in der Datei <strong>%s</strong> wurde entfernt!');
?>