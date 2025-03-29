<?php
/* ------------------------------------------------------------
  Module "Attribute Kombination Manager" made by Karl

  inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

  modified eCommerce Shopsoftware
  http://www.modified-shop.org

  Released under the GNU General Public License
-------------------------------------------------------------- */

/*
 * --------------------------------------------------------------------------
 * @file      web0null_attribute_price_updater.js.php
 * @date      18.10.17
 *
 *
 * LICENSE:   Released under the GNU General Public License
 * --------------------------------------------------------------------------
 */
//BOF - web0null_attribute_price_updater
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true' && MODULE_PRODUCTS_COMBINATIONS_PRICEUPDATER_ON == 'true') {
  if (basename($PHP_SELF) == FILENAME_PRODUCT_INFO) {
?>
    <script type="text/javascript">
      function CombiPriceUpdater() {
        function calculate(This) {
          var viewAdditional = <?php echo MODULE_PRODUCTS_COMBINATIONS_ADDITIONAL; ?>,
            updateOrgPrice = <?php echo MODULE_PRODUCTS_COMBINATIONS_UPDATE_PRICE; ?>,
            summe = 0,
            attrvpevalue = 0,
            symbolLeft = '',
            symbolRight = '',
            data = This.data('attrdata'),
            el = $('div[id^="combination' + data.pid + '"] select').length ? ' option:selected' : ' input:checked';
          $.each($('div[id^="combination' + data.pid + '"]' + el), function() {
            if (!$(this).parents('div[id^="combination' + data.pid + '"] [id^="pmatrix_v"]').attr('style')) {
              data = $(this).data('attrdata');
              if (data.aprice != 0) {
                if (data.prefix == '-') {
                  summe -= data.aprice;
                } else if (data.prefix == '+') {
                  summe += data.aprice;
                } else if (data.prefix == '=') {
                  summe += data.aprice - data.gprice;
                }
              }
              if (data.attrvpevalue != 0) {
                attrvpevalue = data.attrvpevalue;
              }
            }
          });
          var metaPrice = (Math.round((summe + data.gprice) * 100) / 100).toFixed(2).toString();
          var newPrice = metaPrice.replace(/[.]/, ',');
          var oldPrice = (Math.round((summe + data.oprice) * 100) / 100).toFixed(2).toString().replace(/[.]/, ',');
          var newVpePrice = (Math.round((summe + data.gprice) / (data.vpevalue + attrvpevalue) * 100) / 100).toFixed(2).toString().replace(/[.]/, ',');
          if (data.cleft) {
            symbolLeft = data.cleft + '&nbsp;';
          }
          if (data.cright) {
            symbolRight = '&nbsp;' + data.cright;
          }
          if (viewAdditional) {
            $('div[id^="combination' + data.pid + '"] .combiPriceUpdater span.cuPrice').html('&nbsp;' + symbolLeft + newPrice + symbolRight);
            if (data.vpevalue != 0) {
              $('div[id^="combination' + data.pid + '"] .combiPriceUpdater span.cuVpePrice').html(symbolLeft + newVpePrice + symbolRight + data.protext + data.vpetext);
            } else {
              $('div[id^="combination' + data.pid + '"] .combiPriceUpdater span.cuVpePrice').html('');
            }
          }
          if (updateOrgPrice) {
            $('.pd_price .standard_price').html(symbolLeft + newPrice + symbolRight);
            $('.pd_price .new_price').html(data.onlytext + symbolLeft + newPrice + symbolRight);
            $('.pd_price .old_price').html(data.insteadtext + symbolLeft + oldPrice + symbolRight);
            if (data.vpevalue != 0) {
              $('.pd_summarybox .pd_vpe').html(symbolLeft + newVpePrice + symbolRight + data.protext + data.vpetext);
              $('.pd_price .vpe').html(symbolLeft + newVpePrice + symbolRight + data.protext + data.vpetext);
            }
            $('.pd_price meta[itemprop="price"]').attr("content", metaPrice);
          }
        }

        function calculateAll() {
          $.each($('div[id^="combination"] input[type=radio]:checked, div[id^="combination"] input[type=checkbox], div[id^="combination"] option'), function() {
            if (typeof $(this).data('attrdata') !== 'undefined') {
              calculate($(this));
            }
          });
        }
        calculateAll();
      };
    </script>
<?php
  }
}
