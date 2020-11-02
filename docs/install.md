<h1 id="top" style="padding-top: 60px; margin-top: -60px;">Attribut Kombinationen Verwaltung</h1>

<br />
<a href="https://raw.githubusercontent.com/KarlBogen/manuals/master/acm/handbuch.pdf">Das Handbuch im PDF-Format kann hier heruntergeladen werden.</a>
<br /><br />

## Installation / Update / Deinstallation

### Installation

Beachte: Erstellen Sie vor der Installation dieses Moduls ein Backup der Datenbank.

1.  Klicken Sie auf „Download & Install“.
    _Sie sollten sich jetzt wieder aus dem MMLC ausloggen._

2.  Melden Sie sich im Adminbereich an.

3.  Gehen Sie im Menü zu **Module > System Module**.

4.  Wählen Sie dort das Modul **Attribut Kombinationen Verwaltung** aus und klicken auf **Installieren**.

5.  Klicken Sie auf **Bearbeiten** und konfigurieren Sie das Modul den Bedürfnissen entsprechend.

6. **Anpassung Shop- und Templatedateien**<br />
*Die Anpassung der Dateien kann entweder per Knopfdruck oder manuell erfolgen.*<br /><br />
`Automatisiert:` Klicken Sie auf den grünen Button **Template und Shopdatei anpassen**.<br /><br />
`Manuell:` Lesen Sie dazu bitte den Abschnitt weiter unten.

> Hinweis: Mit dem Systemmodul werden **Klassenerweiterungen Module** für „categories, main, order und shopping_card“ mitinstalliert und aktiviert.

### Update

**Wichtig: Nach einem Module-Update - Update-Button drücken!**

1.  Melden Sie sich im Adminbereich an.

2.  Gehen Sie im Menü zu **Module > System Module**.

3.  Wählen Sie dort das Modul **Attribut Kombinationen Verwaltung** aus und klicken auf **Update**.

### Deinstallation

1.  Melden Sie sich im Adminbereich an.

2.  Gehen Sie im Menü zu **Module > System Module**.

3.  Wählen Sie dort das Modul **Attribut Kombinationen Verwaltung** aus und klicken auf **Deinstallieren**.

4.  Melden Sie sich im MMLC an und suchen Sie im Reiter „Installiert“ nach dem Modul **Attribut Kombinationen Verwaltung**.

5.  Klicken Sie auf „Deinstallieren“.

Bei der Deinstallation werden die neu angelegten Tabellen und Spalten in der Datenbank entfernt.<br />
Anpassungen am momentan aktiven Shoptemplate werden entfernt.

<br />
[↑ zurück nach oben](#top)
<br />

### Anpassung Shop- und Templatedateien

Abhängig vom genutzten Template sind Änderungen in den Dateien durchzuführen:

*   [Anhang 1: tpl_modified_responsive](#user-content-anhang-1-tpl_modified_responsive)
*   [Anhang 2: tpl_modified](#user-content-anhang-2-tpl_modified)
*   [Anhang 3: bootstrap4](#user-content-anhang-3-bootstrap4)

> Falls beim Stornieren oder Löschen einer Bestellung im Adminbereich der Lagerbestand der Kombination automatisch angepasst werden soll, dann muss die Datei /inc/xtc_restock_order.inc.php wie nachstehend beschrieben angepasst werden.

*   [Anhang 4: Kombinationsbestand automatisch anpassen](#user-content-anhang-4-kombinationsbestand-automatisch-anpassen)

<br />
[↑ zurück nach oben](#top)
<br />

<h2 id="user-content-anhang-templateänderungen" style="padding-top: 60px; margin-top: -60px;">Anhang Templateänderungen</h2>

<h3 id="user-content-anhang-1-tpl_modified_responsive" style="padding-top: 60px; margin-top: -60px;">Anhang 1: TPL_MODIFIED_RESPONSIVE</h3>

**# /javascript/extra/sumoselect.js.php**

*Finde:*

```javascript
$('select').SumoSelect();
```

*Ersetze mit:*

```javascript
    /* BOF Module "Attribute Kombination Manager" made by Karl */
    /* Original    $('select').SumoSelect(); */
    $('select').not('.combi_id').SumoSelect();
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
[↑ zurück nach oben](#top)
<br />

<h3 id="user-content-anhang-2-tpl_modified" style="padding-top: 60px; margin-top: -60px;">Anhang 2: TPL_MODIFIED</h3>

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
[↑ zurück nach oben](#top)
<br />

<h3 id="user-content-anhang-3-bootstrap4" style="padding-top: 60px; margin-top: -60px;">Anhang 3: BOOTSTRAP4</h3>

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
[↑ zurück nach oben](#top)
<br />

<h3 id="user-content-anhang-4-kombinationsbestand-automatisch-anpassen">Anhang 4: Kombinationsbestand automatisch anpassen</h3>

Falls beim Stornieren oder Löschen einer Bestellung im Adminbereich der Lagerbestand der Kombination automatisch angepasst werden soll, muss die Datei **/inc/xtc_restock_order.inc.php** wie nachstehend beschrieben angepasst werden.

**# /inc/xtc_restock_order.inc.php**

*Finde:*

```php
          $products_update = false;
        }
      }
    }
```

*Ersetzen durch:*

```php
           $products_update = false;
        }
/* BOF - Module "Attribute Kombination Manager" made by Karl */
/* Original
      }
    }
*/
/* wird die Bestellung im Adminbereich gelöscht, so wird der Kombinationsbestand wieder hochgesetzt */
        $combi_attr_id[] = $orders_attributes["orders_products_options_values_id"];
      }
    }
    if (count($combi_attr_id) >= 2) {
      /* $combi_attr_id zusammenbauen damit wir mit der attribute_id der Kombi vergleichen können */
      $tmpAttrid = '';
      $plh = '_';
      $tmpAttrid = implode($plh, $combi_attr_id);

      $combi_attr_id = array();
      $new_stock = array();

      $query = "SELECT combi_value_id, stock
            FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2."
            WHERE products_id = " . $order['products_id'] . "
            AND
              attribute_id = '".$tmpAttrid."'
            LIMIT 1";

      $result = xtc_db_query($query);
      if(xtc_db_num_rows($result) > 0) {
        $tmpdata =xtc_db_fetch_array($result);

        $new_stock["stock"] = $tmpdata["stock"] + $order['products_quantity'];

        /* update stock */
        xtc_db_perform(TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2, $new_stock, 'update', 'combi_value_id='.$tmpdata["combi_value_id"]);
      }
    }
/* EOF - Module "Attribute Kombination Manager" made by Karl */
```

<br />
[↑ zurück nach oben](#top)
<br />

