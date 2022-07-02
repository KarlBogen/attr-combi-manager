<img alt="logo" style="margin: 20px 0;" width="193" height="193" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_001.png"/>

**Handbuch für**

# Attribut Kombinationen Verwaltung

**Version 1.0.7**

**Ein Systemmodul für die *mod*ified eCommerce Shopsoftware**



Erstellt von KarlK

Stand: Mai 2022

<br />
<a href="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/handbuch.pdf">Das Handbuch im PDF-Format kann hier heruntergeladen werden.</a>
<br /><br />

<h2 id="user-content-inhaltsverzeichnis" style="padding-top: 60px; margin-top: -60px;">Inhaltsverzeichnis</h2>

[1\. Einleitung](#user-content-1-einleitung)

[2\. Installation / Update / Deinstallation](#user-content-2-installation--update--deinstallation)

[3\. Artikelmerkmale und Attribute](#user-content-3-artikelmerkmale-und-attribute)

[4\. Kombinationen](#user-content-4-kombinationen)

[4.1 Neue Kombinationen anlegen](#user-content-41-neue-kombinationen-anlegen)

[4.2 Einzelne Kombinationen anlegen](#user-content-42-einzelne-kombinationen-anlegen)

[4.3 Alle Kombinationen anlegen](#user-content-43-alle-kombinationen-anlegen)

[4.4 Kombinationsdaten erfassen](#user-content-44-kombinationsdaten-erfassen)

[4.4.1 Daten eingeben](#user-content-441-daten-eingeben)

[4.4.2 Bilder verknüpfen](#user-content-442-bilder-verknüpfen)

[4.5 Kombinationen editieren](#user-content-45-kombinationen-editieren)

[4.6 Kombinationen löschen](#user-content-46-kombinationen-löschen)

[4.7 Neue Attribute zu Kombinationen hinzufügen](#user-content-47-neue-attribute-zu-kombinationen-hinzufügen)

[5\. Optionen des Systemmoduls ↔ Auswirkung im Shop](#user-content-5-optionen-des-systemmoduls--auswirkung-im-shop)

[Anhang Templateänderungen](#user-content-anhang-templateaenderungen)

[Anhang 1: TPL_MODIFIED_RESPONSIVE](#user-content-anhang-1-tpl-modified-responsive)

[Anhang 2: TPL_MODIFIED](#user-content-anhang-2-tpl-modified)

[Anhang 3: XTC5](#user-content-anhang-3-xtc-5)

[Anhang 4: BOOTSTRAP4](#user-content-anhang-4-bootstrap-4)

[Anhang Hilfe / Fehlersuche](#user-content-anhang-hilfe--fehlersuche)

<br /><br />

<h2 id="user-content-1-einleitung" style="padding-top: 60px; margin-top: -60px;">1. Einleitung</h2>

### 1.1 Kurzbeschreibung

Mit der **mod**ified eCommerce Shopsoftware kann man einzelnen Artikeln bestimmte Attribute zuweisen.<br />
Allerdings ist es nicht möglich diese Attribute zu verknüpfen und so Kombinationen bzw. Variationen zu bilden.

Hier greift die **Attribut Kombinationen Verwaltung**, mit ihr ist es möglich Attributkombinationen zu erstellen.

Den einzelnen Kombinationen kann _Bestand, Artikelnummer, EAN_ und _Bild_ zugewiesen werden.

Es kann zum Beispiel ein T-Shirt, Größe S, Farbe rot, Form Rundhals `nicht ausgewählt` werden, weil sich `kein Stück im Lager` befindet.

So ist es auch machbar, dass zum Beispiel `2 Stück` T-Shirts, Größe S, Farbe rot, Form Rundhals `nicht bestellt` werden können, weil sich `nur 1 Stück im Lager` befindet.

> Hinweis: Für dieses Modul sind geringe Anpassungen im Template nötig. Diese **Anpassungen können manuell oder per Knopfdruck** gemacht werden.

<br /><br />

### 1.2 Version der Shopsoftware

Die **Attribut Kombinationen Verwaltung** benötigt *mod*ified eCommerce Shopsoftware **Version 2.0.1.0 oder höher**.

Getestet wurde das Modul mit den stable Versionen "2.0.1.0", "2.0.2.0", "2.0.2.1", "2.0.2.2", "2.0.3.0", "2.0.4.0", "2.0.4.1", "2.0.4.2", "2.0.5.0", "2.0.5.1", "2.0.6.0", "2.0.7.0", "2.0.7.1".

Diese Anleitung, Bilder und Beschreibungen beziehen sich auf die Version 2.0.5.1.

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />


<h2 id="user-content-2-installation--update--deinstallation" style="padding-top: 60px; margin-top: -60px;">2. Installation / Update / Deinstallation</h2>

### 2.1 Voraussetzungen

*   PHP 7.0 oder höher
*   MMLC - Modified Module Loader Client installiert

Hinweise zur Installation sind bei [https://module-loader.de](https://module-loader.de/) zu finden.

### 2.2 Installation

Beachte: Erstellen Sie vor der Installation dieses Moduls ein Backup der Datenbank.

1.  Melden Sie sich im MMLC an und suchen Sie im Reiter „Alle“ nach dem Modul **Attribut Kombinationen Verwaltung** (zu finden unter Sonstige Module).

2.  Klicken Sie auf „Download & Install“.
    _Sie sollten sich jetzt wieder aus dem MMLC ausloggen._

3.  Melden Sie sich im Adminbereich an.

4.  Gehen Sie im Menü zu **Module > System Module**.

5.  Wählen Sie dort das Modul **Attribut Kombinationen Verwaltung** aus und klicken auf **Installieren**.

6.  Klicken Sie auf **Bearbeiten** und konfigurieren Sie das Modul den Bedürfnissen entsprechend.

7. **Anpassung Templatedateien**<br />
*Die Anpassung der Dateien kann entweder per Knopfdruck oder manuell erfolgen.*<br /><br />
`Automatisiert:` Klicken Sie auf den grünen Button **Templatedateien anpassen**.<br /><br />
`Manuell:` Lesen Sie dazu bitte den Abschnitt weiter unten.

> <span class="small">Hinweis:<br />
Mit dem Systemmodul werden **Klassenerweiterungen Module** für „categories, main, order und shopping_card“ mitinstalliert und aktiviert.<br />
Desweiteren werden einzelne Shopdateien automatisch an das Modul angepasst!</span>

### 2.3 Update

**Wichtig: Nach einem Shop- oder Module-Update - Update-Button drücken!**

1.  Melden Sie sich im Adminbereich an.

2.  Gehen Sie im Menü zu **Module > System Module**.

3.  Wählen Sie dort das Modul **Attribut Kombinationen Verwaltung** aus.

4.  Falls ihr Template noch Änderungen der Vorgängerversion enthält klicken auf **Template und Shopdatei - Anpassungen entfernen**.

5.  Anschließend nacheinander klicken auf **Update** und **Templatedateien anpassen**.

### 2.4 Deinstallation

1.  Melden Sie sich im Adminbereich an.

2.  Gehen Sie im Menü zu **Module > System Module**.

3.  Wählen Sie dort das Modul **Attribut Kombinationen Verwaltung** aus und klicken auf **Deinstallieren**.

4.  Melden Sie sich im MMLC an und suchen Sie im Reiter „Installiert“ nach dem Modul **Attribut Kombinationen Verwaltung**.

5.  Klicken Sie auf „Deinstallieren“.

Bei der Deinstallation werden die neu angelegten Tabellen und Spalten in der Datenbank entfernt.<br />
Anpassungen am momentan aktiven Shoptemplate werden entfernt.

### 2.5  Anpassung Templatedateien

Abhängig vom genutzten Template sind Änderungen in den Dateien durchzuführen:

*   [Anhang 1: tpl_modified_responsive](#user-content-anhang-1-tpl-modified-responsive)
*   [Anhang 2: tpl_modified](#user-content-anhang-2-tpl-modified)
*	[Anhang 3: XTC5](#user-content-anhang-3-xtc-5)
*   [Anhang 4: bootstrap4](#user-content-anhang-4-bootstrap-4)

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />

<h2 id="user-content-3-artikelmerkmale-und-attribute" style="padding-top: 60px; margin-top: -60px;">3. Artikelmerkmale und Attribute</h2>

### 3.1 Artikelmerkmale

Wie der Name vermuten lässt, baut die Attribut Kombinationen Verwaltung auf die Attribute des Shops auf.

Aus diesem Grund müssen Artikelmerkmale und Optionswerte erstellt werden, rufen Sie dazu **Katalog > Artikelmerkmale** auf.

<img alt="screenshot" style="margin: 20px 0;" width="522" height="159" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_002.png"/>

Legen Sie hier eine Sortierung fest (**fehlende Sortierung kann zu Fehlern in der Kombinationen Verwaltung führen**).

Diese Reihenfolge ist später entscheidend für die Erstellung der Kombinationen.

### 3.2 Attribute

Bevor Kombinationen erstellt werden können müssen den Artikeln Attribute zugeordnet werden.

Das können Sie entweder über die Menüpunkte **Katalog > Attribut Verwaltung,
Katalog > Kategorien/Artikel** oder direkt beim Artikel.

<img alt="screenshot" style="margin: 20px 0;" width="586" height="187" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_003.png"/>

Wählen Sie Attribute und vergeben eine Reihenfolge (**achten Sie auf die Vergabe der Reihenfolge**).

<img alt="screenshot" style="margin: 20px 0;" width="605" height="246" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_004.png"/>

Hinweis: Alle Eingabefelder können genutzt werden, die Spalte „Lager“ wird von der Kombinationen Verwaltung deaktiviert.

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />

<h2 id="user-content-4-kombinationen" style="padding-top: 60px; margin-top: -60px;">4. Kombinationen</h2>

<h3 id="user-content-41-neue-kombinationen-anlegen" style="padding-top: 60px; margin-top: -60px;">4.1 Neue Kombinationen anlegen</h3>

Kombinationen können auf mehreren Wegen erstellt werden.

> Voraussetzung ist immer, dass **dem Artikel *mindestens zwei Attribute* zugeordnet** wurden.

**Katalog > Artikelmerkmale** – Artikel auswählen

<img alt="screenshot" style="margin: 20px 0;" width="605" height="170" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_005.png"/>

**Katalog > Artikelmerkmale** – ausgewählten Artikel **> Bearbeiten**

<img alt="screenshot" style="margin: 20px 0;" width="605" height="212" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_006.png"/>

Menüpunkt **Katalog > Attribut Kombinationen**

<img alt="screenshot" style="margin: 20px 0;" width="453" height="139" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_007.png"/>

<h3 id="user-content-42-einzelne-kombinationen-anlegen" style="padding-top: 60px; margin-top: -60px;">4.2 Einzelne Kombinationen anlegen</h3>

<img alt="screenshot" style="margin: 20px 0;" width="508" height="174" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_008.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="508" height="323" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_009.png"/>

1.  Kombinationen im Dropdown wählen und hinzufügen

2.  Aktualisieren

Nach dem Aktualisieren ändert sich die Anzeige und es geht weiter bei 4.4.

<h3 id="user-content-43-alle-kombinationen-anlegen" style="padding-top: 60px; margin-top: -60px;">4.3 Alle Kombinationen anlegen</h3>

<img alt="screenshot" style="margin: 20px 0;" width="516" height="168" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_010.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="521" height="609" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_011.png"/>

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />

<h3 id="user-content-44-kombinationsdaten-erfassen" style="padding-top: 60px; margin-top: -60px;">4.4 Kombinationsdaten erfassen</h3>

<img alt="screenshot" style="margin: 20px 0;" width="608" height="571" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_012.png"/>

Die Ansicht der Attribut Kombinationen Verwaltung gliedert sich in 3 Bereiche

*   Datenausgabe / Dateneingabe
*   Eingabehilfen
*   Bilder (alle Artikelbilder stehen hier zur Verfügung)

Hinweis: Die Eingabefelder für Artikelnummer und EAN werden nur angezeigt, wenn im Systemmodul die entsprechende Einstellung gemacht wurde.

<h4 id="user-content-441-daten-eingeben" style="padding-top: 60px; margin-top: -60px;">4.4.1 Daten eingeben</h4>

Mit Unterstützung der Eingabehilfen können Datenfelder sehr schnell befüllt werden. Dazu links das Kontrollkästchen der betreffenden Kombination markieren, Vorgabewert eintragen und mit Klick das Feld vorbelegen.

<h4 id="user-content-442-bilder-verknüpfen" style="padding-top: 60px; margin-top: -60px;">4.4.2 Bilder verknüpfen</h4>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="170" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_013.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="162" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_014.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="142" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_015.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="157" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_016.png"/>

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />

<h3 id="user-content-45-kombinationen-editieren" style="padding-top: 60px; margin-top: -60px;">4.5 Kombinationen editieren</h3>

Die Verwaltung kann wieder auf mehreren Wegen aufgerufen werden, hinzugekommen sind die kleinen Icons in der Kategorieübersicht.

<img alt="screenshot" style="margin: 20px 0;" width="605" height="182" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_017.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="598" height="129" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_018.png"/>

<h3 id="user-content-46-kombinationen-löschen" style="padding-top: 60px; margin-top: -60px;">4.6 Kombinationen löschen</h3>

<img alt="screenshot" style="margin: 20px 0;" class="left" width="226" height="288" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_019.png"/>

1.  alle Kombinationen löschen

2.  Speichern oder Aktualisieren.

Einzelne Kombinationen werden mittels der Eingabehilfe gelöscht.

> Hinweis: Gespeichert kann nur werden, wenn mindestens eine Kombination aktiv ist.

<h3 id="user-content-47-neue-attribute-zu-kombinationen-hinzufügen" style="padding-top: 60px; margin-top: -60px;">4.7 Neue Attribute zu Kombinationen hinzufügen</h3>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="207" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_020.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="642" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_021.png"/>

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />

<h2 id="user-content-5-optionen-des-systemmoduls--auswirkung-im-shop" style="padding-top: 60px; margin-top: -60px;">5. Optionen des Systemmoduls ↔ Auswirkung im Shop</h2>

Hier am Beispiel des Templates „tpl_modified_responsive“

<img alt="screenshot" style="margin: 20px 0;" width="605" height="266" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_022.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="263" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_023.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="240" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_024.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="349" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_025.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="244" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_026.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="139" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_027.png"/>

<img alt="screenshot" style="margin: 20px 0;" width="605" height="255" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_028.png"/>

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />

<h2 id="user-content-anhang-templateaenderungen" style="padding-top: 60px; margin-top: -60px;">Anhang Templateänderungen</h2>

<h3 id="user-content-anhang-1-tpl-modified-responsive" style="padding-top: 60px; margin-top: -60px;">Anhang 1: TPL_MODIFIED_RESPONSIVE</h3>

**# /javascript/extra/sumoselect.js.php**

*Finde:*

```javascript
$('select:not([name=country])').SumoSelect();
```

*Ersetze mit:*

```javascript
    /* BOF Module "Attribute Kombination Manager" made by Karl */
    /* Original    $('select:not([name=country])').SumoSelect(); */
    $('select').not('[name=country], .combi_id').SumoSelect();
    /* EOF Module "Attribute Kombination Manager" made by Karl */
```

**# /javascript/general_bottom.js.php**

*Finde:*

```php
$script_min = DIR_TMPL_JS.'tpl_plugins.min.js';
```

*Füge davor ein:*

```php
/* BOF Module "Attribute Kombination Manager" made by Karl */
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true'){
  $script_array[] = DIR_TMPL_JS .'dependent-dropdown.min.js';
  if ($_SESSION["language_code"]=='de') $script_array[] = DIR_TMPL_JS .'depdrop_locale_de.js';
}
/* EOF Module "Attribute Kombination Manager" made by Karl */
```

**# /javascript/extra/default.js.php**

*Finde:*

```javascript
<script>
```

*Füge dahinter ein:*

```javascript
  /* BOF Module "Attribute Kombination Manager" made by Karl */
  <?php if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true'): ?>
  $(document).ready(function(){
    if (typeof jqueryReady !== 'undefined' && $.isFunction(jqueryReady)) {jqueryReady();}
    /* alle Dropdowns müssen ausgewählt sein */
    $("#cart_quantity").submit(function(event) {
      var failed = false;
      $(".combi_id option:selected").each(function(){
        if (!$(this).val()){
          failed = true;
        }
      });
      if (failed == true){
        if ($('.combi_stock').length && $('.combi_stock').text() == '0'){
          alert("<?php echo COMBI_TEXT_CANT_BUY ?>");
        } else {
          alert("<?php echo COMBI_TEXT_SEL_ALL_OPTIONS ?>");
        }
        event.preventDefault();
      }
    });
  });
  <?php endif; ?>
  /* EOF Module "Attribute Kombination Manager" made by Karl */
```

**# /module/product_info/product_info_tabs_v1.html**<br />
**# /module/product_info/product_info_v1.html**<br />
**# /module/product_info/product_info_x_accordion_v1.html**

*Finde:*

```smarty
          {if isset($MODULE_product_options) && $MODULE_product_options != ''}
```

*Ersetze mit:*

```smarty
          {* BOF Module "Attribute Kombination Manager" made by Karl *}
          {if isset($MODULE_product_combi) && $MODULE_product_combi != ''}
              {$MODULE_product_combi}
          {/if}
          {if isset($MODULE_product_options) && $MODULE_product_options != '' && $MODULE_product_combi == ''}
          {*if isset($MODULE_product_options) && $MODULE_product_options != ''*}
          {* EOF Module "Attribute Kombination Manager" made by Karl *}
```

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />

<h3 id="user-content-anhang-2-tpl-modified" style="padding-top: 60px; margin-top: -60px;">Anhang 2: TPL_MODIFIED</h3>

**# /javascript/general_bottom.js.php**

*Finde:*

```php
$script_min = DIR_TMPL_JS.'tpl_plugins.min.js';
```

*Füge davor ein:*

```php
/* BOF Module "Attribute Kombination Manager" made by Karl */
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true'){
  $script_array[] = DIR_TMPL_JS .'dependent-dropdown.min.js';
  if ($_SESSION["language_code"]=='de') $script_array[] = DIR_TMPL_JS .'depdrop_locale_de.js';
}
/* EOF Module "Attribute Kombination Manager" made by Karl */
```

**# /javascript/extra/default.js.php**

*Finde:*

```javascript
<script>
```

*Füge dahinter ein:*

```javascript
  /* BOF Module "Attribute Kombination Manager" made by Karl */
  <?php if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true'): ?>
  $(document).ready(function(){
    if (typeof jqueryReady !== 'undefined' && $.isFunction(jqueryReady)) {jqueryReady();}
    /* alle Dropdowns müssen ausgewählt sein */
    $("#cart_quantity").submit(function(event) {
      var failed = false;
      $(".combi_id option:selected").each(function(){
        if (!$(this).val()){
          failed = true;
        }
      });
      if (failed == true){
        if ($('.combi_stock').length && $('.combi_stock').text() == '0'){
          alert("<?php echo COMBI_TEXT_CANT_BUY ?>");
        } else {
          alert("<?php echo COMBI_TEXT_SEL_ALL_OPTIONS ?>");
        }
        event.preventDefault();
      }
    });
  });
  <?php endif; ?>
  /* EOF Module "Attribute Kombination Manager" made by Karl */
```

**# /module/product_info/product_info_tabs_v1.html**<br />
**# /module/product_info/product_info_v1.html**<br />
**# /module/product_info/product_info_x_accordion_v1.html**

*Finde:*

```smarty
          {if isset($MODULE_product_options) && $MODULE_product_options != ''}
```

*Ersetze mit:*

```smarty
          {* BOF Module "Attribute Kombination Manager" made by Karl *}
          {if isset($MODULE_product_combi) && $MODULE_product_combi != ''}
              {$MODULE_product_combi}
          {/if}
          {if isset($MODULE_product_options) && $MODULE_product_options != '' && $MODULE_product_combi == ''}
          {*if isset($MODULE_product_options) && $MODULE_product_options != ''*}
          {* EOF Module "Attribute Kombination Manager" made by Karl *}
```

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />

<h3 id="user-content-anhang-3-xtc-5" style="padding-top: 60px; margin-top: -60px;">Anhang 3: XTC5</h3>

**# /javascript/general_bottom.js.php**

*Finde:*

```php
$script_min = DIR_TMPL_JS.'tpl_plugins.min.js';
```

*Füge davor ein:*

```php
/* BOF Module "Attribute Kombination Manager" made by Karl */
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true'){
  $script_array[] = DIR_TMPL_JS .'dependent-dropdown.min.js';
  if ($_SESSION["language_code"]=='de') $script_array[] = DIR_TMPL_JS .'depdrop_locale_de.js';
}
/* EOF Module "Attribute Kombination Manager" made by Karl */
```

**# /javascript/extra/default.js.php**

*Finde:*

```javascript
<script type="text/javascript">
```

*Füge dahinter ein:*

```javascript
  /* BOF Module "Attribute Kombination Manager" made by Karl */
  <?php if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true'): ?>
  $(document).ready(function(){
    if (typeof jqueryReady !== 'undefined' && $.isFunction(jqueryReady)) {jqueryReady();}
    /* alle Dropdowns müssen ausgewählt sein */
    $("#cart_quantity").submit(function(event) {
      var failed = false;
      $(".combi_id option:selected").each(function(){
        if (!$(this).val()){
          failed = true;
        }
      });
      if (failed == true){
        if ($('.combi_stock').length && $('.combi_stock').text() == '0'){
          alert("<?php echo COMBI_TEXT_CANT_BUY ?>");
        } else {
          alert("<?php echo COMBI_TEXT_SEL_ALL_OPTIONS ?>");
        }
        event.preventDefault();
      }
    });
  });
  <?php endif; ?>
  /* EOF Module "Attribute Kombination Manager" made by Karl */
```

**# /module/product_info/product_info_tabs_v1.html**<br />
**# /module/product_info/product_info_v1.html**<br />
**# /module/product_info/product_info_x_accordion_v1.html**

*Finde:*

```smarty
          {if $MODULE_product_options != ''}
```

*Ersetze mit:*

```smarty
          {* BOF Module "Attribute Kombination Manager" made by Karl *}
          {if isset($MODULE_product_combi) && $MODULE_product_combi != ''}
              {$MODULE_product_combi}
          {/if}
          {if isset($MODULE_product_options) && $MODULE_product_options != '' && $MODULE_product_combi == ''}
          {*if isset($MODULE_product_options) && $MODULE_product_options != ''*}
          {* EOF Module "Attribute Kombination Manager" made by Karl *}
```

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />

<h3 id="user-content-anhang-4-bootstrap-4" style="padding-top: 60px; margin-top: -60px;">Anhang 4: BOOTSTRAP4</h3>

**# /javascript/general_bottom.js.php**

*Finde:*

```php
$script_min = DIR_TMPL_JS.'tpl_plugins.min.js';
```

*Füge davor ein:*

```php
/* BOF Module "Attribute Kombination Manager" made by Karl */
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true'){
  $script_array[] = DIR_TMPL_JS .'dependent-dropdown.min.js';
  if ($_SESSION["language_code"]=='de') $script_array[] = DIR_TMPL_JS .'depdrop_locale_de.js';
}
/* EOF Module "Attribute Kombination Manager" made by Karl */
```

**# /javascript/extra/default.js.php**

*Finde:*

```javascript
<script>
```

*Füge dahinter ein:*

```javascript
  /* BOF Module "Attribute Kombination Manager" made by Karl */
  <?php if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true'): ?>
  $(document).ready(function(){
    if (typeof jqueryReady !== 'undefined' && $.isFunction(jqueryReady)) {jqueryReady();}
    /* alle Dropdowns müssen ausgewählt sein */
    $("#cart_quantity").submit(function(event) {
      var failed = false;
      $(".combi_id option:selected").each(function(){
        if (!$(this).val()){
          failed = true;
        }
      });
      if (failed == true){
        if ($('.combi_stock').length && $('.combi_stock').text() == '0'){
          alert("<?php echo COMBI_TEXT_CANT_BUY ?>");
        } else {
          alert("<?php echo COMBI_TEXT_SEL_ALL_OPTIONS ?>");
        }
        event.preventDefault();
      }
    });
  });
  <?php endif; ?>
  /* EOF Module "Attribute Kombination Manager" made by Karl */
```

**# /module/product_info/product_info_tabs_v1.html**<br />
**# /module/product_info/product_info_tabs_v1_3_spaltig.html**<br />
**# /module/product_info/product_info_v1.html**<br />
**# /module/product_info/product_info_x_accordion_v1.html**

*Finde:*

```smarty
          {if isset($MODULE_product_options) && $MODULE_product_options != ''}
```

*Ersetze mit:*

```smarty
          {* BOF Module "Attribute Kombination Manager" made by Karl *}
          {if isset($MODULE_product_combi) && $MODULE_product_combi != ''}
            <div class="card bg-custom mb-2 p-2">
              {$MODULE_product_combi}
            </div>
          {/if}
          {if isset($MODULE_product_options) && $MODULE_product_options != '' && $MODULE_product_combi == ''}
          {*if isset($MODULE_product_options) && $MODULE_product_options != ''*}
          {* EOF Module "Attribute Kombination Manager" made by Karl *}
```

**Achtung:**
Bei eingeschaltetem Easyzoom muss im Systemmodul der Wert für "Wird ein Bootstrap-Template mit eingeschaltetem Bilder-Zoomeffekt genutzt?" auf "Ja" gestellt werden!

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />

<h2 id="user-content-anhang-hilfe--fehlersuche" style="padding-top: 60px; margin-top: -60px;">Anhang Hilfe / Fehlersuche</h2>

Sollten seltsame Kombinationen (z.B. gelb /L / blau) erzeugt werden, die Detailansicht im Shop falsche Attribute (z.B. Farbe / Größe / Farbe) anzeigen, prüfen Sie bitte zuerst, ob Sie für Artikelmerkmale eine **Sortierreihenfolge** vergeben haben.

Sollte etwas nicht so funktionieren wie gewohnt, dann sollten Sie zuerst diese Dinge prüfen.

1\. **Module > System Module** aufrufen, dort das Modul **Attribut Kombinationen Verwaltung** auswählen und prüfen, ob der Status aktiv (grünes Häkchen) ist.

2\. grünen Button **Update** klicken – hier werden einige Variablen geprüft.

3\. **Module > Klassenerweiterungen Module** aufrufen und Sortierreihenfolge und Status folgender Module prüfen:

*  Tab categories – **combiRemoveProduct**
*  Tab main – **combiDataToAttr**
*  Tab order - **combiModelToProduct**
*  Tab shopping_card – **combiDataToProduct**

Sollte ein anderes Modul dieselbe Sortierreihenfolge haben, dann auf **Bearbeiten** klicken und die Zahl ändern.

4\. Entwicklertools des Browsers aufrufen (meistens Taste F12) und prüfen, ob die Konsole einen Fehler anzeigt.

<img alt="screenshot" style="margin: 20px 0;" width="606" height="93" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_029.png"/>

Das könnte so oder so ähnlich aussehen.
Geprüft werden sollten mindestens die Ansichten Artikel bearbeiten, Attribute bearbeiten, Kombinationen bearbeiten, Kategorieübersicht.

5\. In der Ansicht **Artikel bearbeiten** muss der Lagerbestand der Kombinationsbestand stehen.

<img alt="screenshot" style="margin: 20px 0;" width="605" height="96" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_030.png"/>

Klickt man auf **Kombinationen editieren** sollte der zusammengezählte Bestand der einzelnen Kombinationen diesen Wert ergeben.

<img alt="screenshot" style="margin: 20px 0;" width="605" height="174" src="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/images/Image_031.png"/>

Der Artikelbestand wird automatisch aktualisiert, wenn bei den Kombinationen Änderungen gespeichert werden.

6\. Prüfen, ob diese Dateien

*   admin/includes/modules/categories_view.php
*   admin/includes/modules/new_product.php
*   inc/xtc_restock_order.inc.php
*   includes/classes/main.php (nur wenn Shopversion < 2.0.5.0)

Änderungen enthalten.<br />
Änderungen können mit einer dieser Zeilen
*   /\* BOF Module "Attribute Kombination Manager" made by Karl \*/
*   /\* \*\*\* robinthehood/hook-point-manager START \*\*\*

beginnen.

7\. Bei Problemen im Shopfrontend - prüfen, ob die Konsole einen Fehler anzeigt (siehe Nummer 4.) oder Templateänderungen fehlerhaft durchgeführt wurden (Anhang 1-4).

<br /><br /><br />

### Sollten Sie mit einem Problem nicht weiter kommen, finden sich bestimmt Helfer im Modified-Forum

### [Thema: MODUL: Attribute Kombinationen Manager für Shopversion 2.x](https://www.modified-shop.org/forum/index.php?topic=37318.0)

<br />

[↑ zurück zum Inhaltsverzeichnis](#user-content-inhaltsverzeichnis)

<br />
