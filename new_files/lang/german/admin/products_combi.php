<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */
//
define('PROD_COMBI_HEADER_TITLE', "Attribut Kombinationen Verwaltung");
define('PROD_COMBI_NO_PRODUCTS_ERR', "Sie haben zur Zeit keine Produkte die Kombinationen erzeugen k&ouml;nnten.");
define('PROD_COMBI_NOT_SELECTED_MSG', "Zu diesem Produkt existieren noch keine Produktkombinationen.");
//
define('PROD_COMBI_MSQL_ERR', "Fehler: Derzeit gibt es keine Artikelmerkmale. Bitte erst via 'Artikelmerkmale' anlegen");
define('PROD_COMBI_MAX_INPUT_VARS', "<br /><p class='colorRed'>Hinweis: Bei mehr als %d Kombinationen kann es vorkommen, dass die in PHP eingestellte maximale Anzahl von %d Input-Feldern erreicht wird.<br />Ist das der Fall, reduzieren Sie die Kombinationen oder f&uuml;gen Sie in Ihre .htaccess die Zeile <strong>php_value max_input_vars %d</strong> ein.<br /></p>");
define('PROD_COMBI_CREATE_BTN', "Alle Kombinationen anlegen");
define('PROD_COMBI_CREATE_SINGLE_BTN', "Einzelne Kombinationen anlegen");
//
define('PROD_COMBI_TH_ACTIVE', "Aktiv");
define('PROD_COMBI_TH_COMBI', "Kombination");
define('PROD_COMBI_TH_MODEL', "Art.Nr.");
define('PROD_COMBI_TH_EAN', "GTIN/EAN");
define('PROD_COMBI_TH_STOCK', "Bestand");
define('PROD_COMBI_TH_IMAGE', "Bild");
define('PROD_COMBI_DELETE_BTN', "alle Kombinationen l&ouml;schen");
//
define('PROD_COMBI_SORT_INFO', "Hinweis zur Sortierung: Die &Auml;nderung der Sortierreihenfolge hat nur eingeschr&auml;nkt Auswirkung im Shop-Frontend!");
define('PROD_COMBI_UP', "auf");
define('PROD_COMBI_DOWN', "ab");
//
define('PROD_COMBI_HELPER', "Eingabehilfen");
define('PROD_COMBI_DEL_BUTTON', "- markierte Kombination l&ouml;schen");
define('PROD_COMBI_ADD_BUTTON', "+ Kombination hinzuf&uuml;gen");
define('PROD_COMBI_PRESELECT', "Das Feld <strong>%s</strong> bei allen markierten Kombinationen vorbelegen mit dem Wert ");
define('PROD_COMBI_PRESELECT_BTN', "vorbelegen");
define('PROD_COMBI_SAVE_BTN', "Speichern");
define('PROD_COMBI_UPLOAD_IMG', "Bilder verkn&uuml;pfen");
define('PROD_COMBI_UPLOAD_IMG_BTN', "Bild verkn&uuml;pfen");
define('PROD_COMBI_SEL_ATTRIB_MSG', "Sie haben folgende M&ouml;glichkeiten:");
define('PROD_COMBI_DELETE_IMG', "markierte Bildverkn&uuml;pfungen l&ouml;schen");
define('PROD_COMBI_LOAD_IMG', "Bilder laden");
define('PROD_COMBI_IMG_PREVIEW', "Bildvorschau");
define('COMBI_NO_IMG_SELECTED', "Sie m&uuml;ssen ein Artikelbild ausw&auml;hlen!");
//
define('COMBI_TEXT_SAVE_BEFORE_LEAVE', 'Kombinationsliste vor dem Verlassen speichern?');
define('COMBI_CONFIRM_DELETE_ALL', 'Kombinationsliste wirklich löschen?');
define('COMBI_CONFIRM_DELETE_ROW', 'Zeile wirklich löschen?');
define('COMBI_IMAGE_LINK_SUCCESS', 'Bild verlinkt - Bildvorschau wird geladen!');
define('COMBI_IMAGE_LINK_ERROR', 'Es ist ein Fehler aufgetreten, bitte versuchen Sie es erneut!');
define('COMBI_EXISTS_TOGETEHER', 'Diese Kombination ist schon vorhanden!');
define('COMBI_NO_ROW_SELECTED', 'Sie haben keine Zeile ausgewählt!');
define('COMBI_NO_COMBI_ACTIVE', 'Mindestens eine Kombination muss aktiv bleiben!');

?>
