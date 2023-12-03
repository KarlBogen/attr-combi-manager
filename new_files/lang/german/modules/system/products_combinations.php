<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

define('MODULE_PRODUCTS_COMBINATIONS_TEXT_TITLE', 'Attribut Kombinationen Verwaltung © by <a href="https://github.com/KarlBogen" target="_blank" style="color: #e67e22; font-weight: bold;">karlk</a>');
define('MODULE_PRODUCTS_COMBINATIONS_TEXT_DESCRIPTION', '<strong>Mit der "Attribut Kombinationen Verwaltung" stehen Funktionen zur Verf&uuml;gung, um f&uuml;r ausgew&auml;hlte Artikel Attributkombinationen zu erstellen.</strong><br /><br />');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_DELETE', 'Moduldateien l&ouml;schen');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_DELETE_DESC', '<u>Hinweis:</u><br />Es werden alle Moduldateien gel&ouml;scht, nachdem die Dateianpassungen wieder entfernt wurden!');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_MODIFYTPL', 'Templatedateien anpassen');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_MODIFYTPL_DESC', '<u>Hinweis:</u><br />Die <strong>Templatedateien des momentan aktiven Shoptemplates</strong> (Konfiguration -> Mein Shop -> Templateset) werden durchsucht und f&uuml;r das Modul angepasst.');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_MODIFYTPL_CONFIRM', 'Sollen die Dateien im Template <strong>%s</strong> wirklich durchsucht und verändert werden?');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_RESTORETPL', 'Template und Shopdatei - Anpassungen entfernen');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_RESTORETPL_DESC', '<u>Hinweis:</u><br />Mit dieser Funktion k&ouml;nnen Dateianpassungen wieder entfernt werden. Die ver&auml;nderten Dateien<br />- /admin/includes/modules/categories_view.php<br />- /admin/includes/modules/new_product.php<br />werden nicht zur&uuml;ckgesetzt!');
define('MODULE_PRODUCTS_COMBINATIONS_BUTTON_RESTORETPL_CONFIRM', 'Sollen die Dateien im Shop und im Template <strong>%s</strong> wirklich durchsucht und Anpassungen entfernt werden?');
define('MODULE_PRODUCTS_COMBINATIONS_STATUS_TITLE', 'Modul aktivieren?');
define('MODULE_PRODUCTS_COMBINATIONS_STATUS_DESC', 'Im Adminbereich k&ouml;nnen Sie Attributkombinationen anlegen.<br />Im Shop werden dann in der Produktdetailansicht voneinander abh&auml;ngige Dropdownfelder angezeigt.<br />Es k&ouml;nnen nur vorher angelegte Kombinationen ausgew&auml;hlt und in den Warenkorb gelegt werden.<br />');
define('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN_TITLE', 'Sollen die Kombinationen eigene Artikelnummer und EAN erhalten?');
define('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN_DESC', 'Hat eine Kombination eine eigene Artikelnummer oder EAN, dann werden diese Nummern dem bestellten Produkt zugeordnet!<br />');
define('MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK_TITLE', 'Bestand der Kombination pr&uuml;fen?');
define('MODULE_PRODUCTS_COMBINATIONS_CHECK_COMBI_STOCK_DESC', 'Wenn Sie diese Funktion einschalten, wird der Artikelbestand der Kombination gepr&uuml;ft.<br />Nicht verf&uuml;gbare Kombinationen werden zwar in den Dropdownfeldern (mit einem Hinweis) angezeigt<br />sind aber deaktiviert und damit nicht w&auml;hlbar.<br />');
define('MODULE_PRODUCTS_COMBINATIONS_SHOW_EMPTY_COMBI_OPTION_TITLE', 'Kombinationen ohne Bestand anzeigen?');
define('MODULE_PRODUCTS_COMBINATIONS_SHOW_EMPTY_COMBI_OPTION_DESC', 'Wenn Sie diese Funktion ausschalten, werden Kombinationen ohne Bestand in den Dropdownfeldern ausgeblendet.<br /><strong>Funktioniert nur, wenn Bestandspr&uuml;fung eingeschaltet ist!</strong><br />');
define('MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE_TITLE', 'Artikelbild nach fertiger Auswahl tauschen?');
define('MODULE_PRODUCTS_COMBINATIONS_CHANGE_IMAGE_DESC', 'Wenn Sie diese Funktion einschalten, wird nach getroffener Auswahl das Kombinationsbild zum aktiven Artikelbild.<br />');
define('MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP_TITLE', 'Wird ein Bootstrap-Template mit eingeschaltetem Bilder-Zoomeffekt genutzt?');
define('MODULE_PRODUCTS_COMBINATIONS_BOOTSTRAP_DESC', 'F&uuml;r Bootstrap mit Zoomeffekt wird das Javascript ver&auml;ndert werden.<br />');
define('MODULE_PRODUCTS_COMBINATIONS_PRICEUPDATER_ON_TITLE', '<br /><br />web0null_attribute_price_updater<br /><br />Preisupdater');
define('MODULE_PRODUCTS_COMBINATIONS_PRICEUPDATER_ON_DESC', 'Einschalten?<br />');
define('MODULE_PRODUCTS_COMBINATIONS_ADDITIONAL_TITLE', 'Zusatzbereich');
define('MODULE_PRODUCTS_COMBINATIONS_ADDITIONAL_DESC', 'Anzeige der Zusatzzeilen (In dieser Ausf&uuml;hrung...)<br />');
define('MODULE_PRODUCTS_COMBINATIONS_UPDATE_PRICE_TITLE', 'Preis neu berechnen');
define('MODULE_PRODUCTS_COMBINATIONS_UPDATE_PRICE_DESC', '&Auml;ndert auch den Originalpreis im Template. Rechtlich abkl&auml;ren!<br />');
define('MODULE_PRODUCTS_COMBINATIONS_REMOVE', '<b>Bitte beachten:</b> Alle bisher erstellten und gespeicherten Produktkombinationen werden gelöscht!');
?>