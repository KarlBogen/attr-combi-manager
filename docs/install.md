<h1 id="user-content-attribut-kombinationen-verwaltung" style="padding-top: 60px; margin-top: -60px;">Attribut Kombinationen Verwaltung</h1>

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
`Automatisiert:` Klicken Sie auf den grünen Button **Templatedateien anpassen**.<br /><br />
`Manuell:` Lesen Sie dazu bitte den Abschnitt weiter unten.

> <span class="small">Hinweis:<br />
Mit dem Systemmodul werden **Klassenerweiterungen Module** für „categories, main, order und shopping_card“ mitinstalliert und aktiviert.<br />
Desweiteren werden einzelne Shopdateien automatisch an das Modul angepasst!</span>


### Update

**Wichtig: Nach einem Shop- oder Module-Update - Update-Button drücken!**

1.  Melden Sie sich im Adminbereich an.

2.  Gehen Sie im Menü zu **Module > System Module**.

3.  Wählen Sie dort das Modul **Attribut Kombinationen Verwaltung** aus.

4.  Falls ihr Template noch Änderungen der Vorgängerversion enthält klicken auf **Template und Shopdatei - Anpassungen entfernen**.

5.  Anschließend nacheinander klicken auf **Update** und **Templatedateien anpassen**.


### Deinstallation

1.  Melden Sie sich im Adminbereich an.

2.  Gehen Sie im Menü zu **Module > System Module**.

3.  Wählen Sie dort das Modul **Attribut Kombinationen Verwaltung** aus und klicken auf **Deinstallieren**.

4.  Melden Sie sich im MMLC an und suchen Sie im Reiter „Installiert“ nach dem Modul **Attribut Kombinationen Verwaltung**.

5.  Klicken Sie auf „Deinstallieren“.

Bei der Deinstallation werden die neu angelegten Tabellen und Spalten in der Datenbank entfernt.<br />
Anpassungen am momentan aktiven Shoptemplate werden entfernt.

<br />
<a href="#user-content-attribut-kombinationen-verwaltung">↑ zurück nach oben</a>
<br />

### Anpassung Templatedateien

Abhängig vom genutzten Template sind Änderungen in den Dateien durchzuführen:

*   [Anhang 1: tpl_modified_responsive](#user-content-anhang-1-tpl_modified_responsive)
*   [Anhang 2: tpl_modified](#user-content-anhang-2-tpl_modified)
*   [Anhang 3: xtc5](#user-content-anhang-3-xtc5)
*   [Anhang 4: bootstrap4](#user-content-anhang-4-bootstrap4)
*   [Anhang 5: tpl_modified_nova](#user-content-anhang-5-tpl-modified-nova)
*   [Anhang 6: bootstrap5](#user-content-anhang-6-bootstrap5)

<br />
<a href="#user-content-attribut-kombinationen-verwaltung">↑ zurück nach oben</a>
<br />

<h2 id="user-content-anhang-templateänderungen" style="padding-top: 60px; margin-top: -60px;">Anhang Templateänderungen</h2>

<h3 id="user-content-anhang-1-tpl_modified_responsive" style="padding-top: 60px; margin-top: -60px;">Anhang 1: TPL_MODIFIED_RESPONSIVE</h3>

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

**Ab Shopversion 3.0.0 zusätzlich**

*Finde:*

```javascript
    $('select:not([name=filter_sort]):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([id^=sel_]):not([id=ec_term])').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"});
```

*Ersetze mit:*

```javascript
    /* BOF Module "Attribute Kombination Manager made by Karl */
    /* Original    $('select:not([name=filter_sort]):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([id^=sel_]):not([id=ec_term])').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"}); */
    $('select:not([name=filter_sort]):not(.combi_id):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([id^=sel_]):not([id=ec_term])').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"});
    /* EOF Module "Attribute Kombination Manager" made by Karl responsive */
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
<a href="#user-content-attribut-kombinationen-verwaltung">↑ zurück nach oben</a>
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
<a href="#user-content-attribut-kombinationen-verwaltung">↑ zurück nach oben</a>
<br />

<h3 id="user-content-anhang-3-xtc5" style="padding-top: 60px; margin-top: -60px;">Anhang 3: XTC5</h3>

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
          {*if $MODULE_product_options != ''*}
          {* EOF Module "Attribute Kombination Manager" made by Karl *}
```

<br />
<a href="#user-content-attribut-kombinationen-verwaltung">↑ zurück nach oben</a>
<br />

<h3 id="user-content-anhang-4-bootstrap4" style="padding-top: 60px; margin-top: -60px;">Anhang 4: BOOTSTRAP4</h3>

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
<a href="#user-content-attribut-kombinationen-verwaltung">↑ zurück nach oben</a>
<br />

<h3 id="user-content-anhang-5-tpl-modified-nova" style="padding-top: 60px; margin-top: -60px;">Anhang 5: TPL_MODIFIED_NOVA</h3>

**# /javascript/extra/sumoselect.js.php**

*Finde:*

```javascript
    $('select:not([name=filter_sort]):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([name=language]):not([id^=sel_]):not([id=ec_term])').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"});
```

*Ersetze mit:*

```javascript
    /* BOF Module "Attribute Kombination Manager made by Karl */
    /* Original    $('select:not([name=filter_sort]):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([name=language]):not([id^=sel_]):not([id=ec_term])').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"}); */
    $('select:not([name=filter_sort]):not(.combi_id):not([name=filter_set]):not([name=currency]):not([name=categories_id]):not([name=gender]):not([name=language]):not([id^=sel_]):not([id=ec_term])').SumoSelect({search: true, searchText: "<?php echo TEXT_SUMOSELECT_SEARCH; ?>", noMatch: "<?php echo TEXT_SUMOSELECT_NO_RESULT; ?>"});
    /* EOF Module "Attribute Kombination Manager" made by Karl nova */
```

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

**# /module/product_info/product_info_v1_tabs.html**<br />
**# /module/product_info/product_info_v2_accordion.html**
**# /module/product_info/product_info_v3_plain.html**<br />

*Finde:*

```smarty
          {if isset($MODULE_product_options) && $MODULE_product_options != ''}{$MODULE_product_options}{/if}
```

*Ersetze mit:*

```smarty
          {* BOF Module "Attribute Kombination Manager" made by Karl *}
          {if isset($MODULE_product_combi) && $MODULE_product_combi != ''}
            <div class="card bg-custom mb-2 p-2">
              {$MODULE_product_combi}
            </div>
          {/if}
          {if isset($MODULE_product_options) && $MODULE_product_options != '' && empty($MODULE_product_combi)}{$MODULE_product_options}{/if}
          {*if isset($MODULE_product_options) && $MODULE_product_options != ''}{$MODULE_product_options}{/if*}
          {* EOF Module "Attribute Kombination Manager" made by Karl *}
```

<br />
<a href="#user-content-attribut-kombinationen-verwaltung">↑ zurück nach oben</a>
<br />

<h3 id="user-content-anhang-6-bootstrap5" style="padding-top: 60px; margin-top: -60px;">Anhang 6: BOOTSTRAP5 und BOOTSTRAP5a</h3>

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

**# /module/product_info/product_info_v1_tabs.html**<br />
**# /module/product_info/product_info_v2_accordion.html**
**# /module/product_info/product_info_v3_plain.html**<br />

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

<br />
<a href="#user-content-attribut-kombinationen-verwaltung">↑ zurück nach oben</a>
<br />
