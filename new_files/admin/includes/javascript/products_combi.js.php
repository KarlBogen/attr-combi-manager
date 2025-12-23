<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

// prüfen, ob Systemmodul installiert und Status true ist
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {

?>
  <script type="text/javascript">
    <?php if (defined('CONFIRM_SAVE_ENTRY') && CONFIRM_SAVE_ENTRY == 'true') { ?>

      function confirmCombi(message, title, form) {
        title = title || 'Information';
        $.confirm({
          keyboardEnabled: true,
          title: title,
          content: (message ? message : ' '),
          confirmButton: js_button_yes,
          cancelButton: js_button_no,
          columnClass: 'jconfirm-width',
          animation: 'none',
          confirm: function() {
            if (form == 'save' || form == 'back' || form == 'del') {
              if (!checkStatus()) return;
              $("#variations").submit();
            }
            if (form == 'save_red') {
              if (!checkStatus()) return;
              $('input[name="action"]').val('save_redirect');
              $("#variations").submit();
            }
            if (form == 'del_row') {
              makeCombi2delField();
              $('.case:checkbox:checked').closest("tr").remove();
              check();
            }
          },
          cancel: function() {
            if (form == 'back') {
              if ($('input[name="combi_value_id[]"]').length) {
                $('input[name="action"]').val('only_redirect');
                $("#variations").submit();
              } else {
                $('input[name="action"]').val('del_redirect');
                $("#variations").submit();
              }
            }
            if (form == 'del') {
              $('.del_combi').prop("checked", false);
            }
            if (form == 'save_red') {
              $('input[name="action"]').val('only_redirect');
              $("#variations").submit();
            }
            if (form == 'del_row') {
              $('.case').prop("checked", false);
              $('.check_all').prop("checked", false);
            }
          }
        });
        return false;
      }
    <?php } else { ?>

      function confirmCombi(message, title, form) {
        if (form == 'save' || form == 'del') {
          if (!checkStatus()) return;
          $("#variations").submit();
        }
        if (form == 'back') {
          if ($('input[name="combi_value_id[]"]').length) {
            $('input[name="action"]').val('only_redirect');
            $("#variations").submit();
          } else {
            $('input[name="action"]').val('del_redirect');
            $("#variations").submit();
          }
        }
        if (form == 'save_red') {
          if (!checkStatus()) return;
          $('input[name="action"]').val('save_redirect');
          $("#variations").submit();
        }
        if (form == 'del_row') {
          makeCombi2delField();
          $('.case:checkbox:checked').closest("tr").remove();
          check();
        }
        return false;
      }
    <?php } ?>

    // Zu löschende Kombinationen in Hiddenfeld übertragen
    function makeCombi2delField() {
      var values = new Array();
      var combi2del_old = $('input[name="combi2del"]').val();
      if (combi2del_old != '') {
        values.push(combi2del_old.split(','));
      }
      $('.case:checkbox:checked').each(function() {
        values.push($(this).closest('tr').find('input[name="combi_value_id[]"]').val());
      });
      var combi2del_new = values.join(",");
      $('input[name="combi2del"]').val(combi2del_new);
    }
    // Status Checkboxen prüfen
    function checkStatus() {
      if ($('.status:checkbox:checked').length < 1) {
        alert('<?php echo COMBI_NO_COMBI_ACTIVE; ?>');
        return false;
      }
      // setzt den Status von nicht markierten Kombinationen auf 0
      $('.status:checkbox:not(:checked)').each(function() {
        $(this).hide();
        $(this).val("0");
        $(this).prop("checked", true);
      });
      return true;
    }
    // Nummerierung
    function check() {
      obj = $('#variations table tr').find('span.snum');
      $.each(obj, function(key, value) {
        $(this).html(key + 1);
      });
    }
    // Zeile ausgewählt ?
    function casecheck() {
      if ($('.case:checkbox:checked').length < 1) {
        alert('<?php echo COMBI_NO_ROW_SELECTED; ?>');
        return false;
      }
      return true;
    }
    // Bild ausgewählt ?
    function imgcheck() {
      if (!$('.image_select').hasClass('selected')) {
        alert('<?php echo COMBI_NO_IMG_SELECTED; ?>');
        return false;
      }
      return true;
    }
    $(document).ready(function() {
      // Headerlinks ausschalten
      if ($('#variations').length) {
        $('#fixed-header').css({
          "pointer-events": "none",
          "cursor": "default"
        });
      }
      // Kombinationsliste ohne Speichern verlassen
      $("#variations .back").on('click', function(event) {
        if ($('input[name="combi_id"]').length) {
          // Kombinationsliste löschen
          if ($('input.del_combi').is(':checked')) {
            return confirmCombi("<?php echo COMBI_CONFIRM_DELETE_ALL; ?>", "", "del");
          }
          $('input[name="action"]').val('save_redirect');
          return confirmCombi("<?php echo COMBI_TEXT_SAVE_BEFORE_LEAVE; ?>", "", "back");
        }
      });
      // Prüfung vor dem Senden "Speichern"
      $("#variations .save_red").on('click', function(event) {
        // Kombinationsliste löschen
        if ($('input.del_combi').is(':checked')) {
          return confirmCombi("<?php echo COMBI_CONFIRM_DELETE_ALL; ?>", "", "del");
        }
        return confirmCombi("<?php echo SAVE_ENTRY; ?>", "", "save_red");
      });
      // Prüfung vor dem Senden "Aktualisieren"
      $("#variations .save").on('click', function(event) {
        // Kombinationsliste löschen
        if ($('input.del_combi').is(':checked')) {
          return confirmCombi("<?php echo COMBI_CONFIRM_DELETE_ALL; ?>", "", "del");
        }
        return confirmCombi("<?php echo SAVE_ENTRY; ?>", "", "save");
      });
      // Bilder von Liste löschen
      $(".image_delete").on('click', function() {
        if (!casecheck()) return;
        $('input.case:checkbox:checked').each(function() {
          var output = '<input type="hidden" name="image[]" value=""/>';
          $(this).closest("tr").find('td.image').empty().append(output);
        });
        $('.case').prop("checked", false);
        $('.check_all').prop("checked", false);
      });
      // Bilder laden
      $("#img_load").on('click', function(event) {
        if (!casecheck()) return;
        if (!imgcheck()) return;
        $("img.loading").show();
        var tok = $('#upload input[type=hidden]');
        var field = $('input[name="attribute_id[]"]');
        var img_to_load = $('.image_select.selected img').attr('title');
        var combi_id = $('input[name="combi_id"]').val();
        var attribute_id = $('.case:checkbox:checked').closest("tr").find(field).val();
        var form_data = new FormData();
        form_data.append(tok.attr("name"), tok.val());
        form_data.append('func', 'load');
        form_data.append('img_to_load', img_to_load);
        form_data.append('combi_id', combi_id);
        form_data.append('attribute_id', attribute_id);

        $.ajax({
          url: 'products_combi.php',
          dataType: 'json',
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: 'post',
          success: function(data) {
            $('.case:checkbox:checked').each(function(index) {
              var output = '<input type="hidden" name="image[]" value="' + data.file + '"/>';
              output += '<a href="#" id="image' + data.unique + '-' + index + '" rel="subcontent' + data.unique + '-' + index + '"><?php echo PROD_COMBI_IMG_PREVIEW; ?><\/a>';
              output += '<div id="subcontent' + data.unique + '-' + index + '" style="position:absolute; visibility: hidden; border: 1px solid #000000; background-color: white; padding: 2px;">';
              output += '<img src="../images/product_images/info_images/' + data.file + '?' + data.unique + '" alt="image" style="padding:10px;border:0;max-width:120px;max-height:120px;"><\/div>';
              $(this).closest("tr").find('.image').empty().append(output);
              var init_dat = 'image' + data.unique + '-' + index;
              dropdowncontent.init(init_dat, "left-top", 250);
            });
            $("#status_message").append('<span class="messageStackSuccess">' + data.message + '<\/span>');
            setTimeout(function() {
              $("#status_message").empty();
            }, 3000);
            $('.case').prop("checked", false);
            $('.check_all').prop("checked", false);
            $("img.loading").hide();
          },
          error: function() {
            $("#status_message").append('<span class="messageStackError"><?php echo COMBI_IMAGE_LINK_ERROR; ?><\/span>');
            setTimeout(function() {
              $("#status_message").empty();
            }, 3000);
            $("img.loading").hide();
          }
        });
        event.preventDefault();
      });
      // Eingabehilfe
      $(".update_field_model").on('click', function() {
        if (!casecheck()) return;
        var selfield = $('select[name="sel_field"] option:checked').val();
        var newval = $('input[name="new_val_model"]').val().trim();
        var updatefield = 'input[name="model[]"]';
        $('.case:checkbox:checked').closest("tr").find(updatefield).val(newval);
        $('.case').prop("checked", false);
        $('.check_all').prop("checked", false);
      });
      $(".update_field_ean").on('click', function() {
        if (!casecheck()) return;
        var selfield = $('select[name="sel_field"] option:checked').val();
        var newval = $('input[name="new_val_ean"]').val().trim();
        var updatefield = 'input[name="ean[]"]';
        $('.case:checkbox:checked').closest("tr").find(updatefield).val(newval);
        $('.case').prop("checked", false);
        $('.check_all').prop("checked", false);
      });
      $(".update_fields").on('click', function() {
        if (!casecheck()) return;
        var selfield = $('select[name="sel_field"] option:checked').val();
        var newval = $('input[name="new_val"]').val().trim();
        var updatefield = 'input[name="stock[]"]';
        $('.case:checkbox:checked').closest("tr").find(updatefield).val(newval);
        $('.case').prop("checked", false);
        $('.check_all').prop("checked", false);
      });
      // Löscht Kombinationen
      $(".delete").on('click', function() {
        if (!casecheck()) return;
        return confirmCombi("<?php echo COMBI_CONFIRM_DELETE_ROW; ?>", "", "del_row");
      });
      // Bild wählen
      $(".image_select").on('click', function() {
        $(".image_select").removeClass('selected');
        $(this).addClass('selected');
      });
      // Fügt Kombinationen hinzu
      var i = 2;
      $(".addmore").on('click', function() {
        var attributeName = "",
          valueID = "",
          double = false;
        $('div#options').find('select').each(function(index) {
          var ele = $(this).find('option:selected');
          attributeName += (index != 0 ? ' / ' + ele.text() : ele.text());
          valueID += (index != 0 ? '_' + ele.val() : ele.val());
        });
        var field = $('input[name="attribute_id[]"]');
        // Kombination schon vorhanden ?
        $(field).each(function() {
          if ($(this).val() == valueID) {
            double = true;
            alert('<?php echo COMBI_EXISTS_TOGETEHER; ?>');
          }
        });
        if (double) return;
        count = $('#variations table tr').length;
        if ($(".image").length < 1) {
          var data = '<tr class="dataTableRow"><td class="dataTableContent txta-c" style="width:5%;"><input type="checkbox" class="case"/><\/td><td class="dataTableContent txta-c" style="width:5%;"><span id="snum' + i + '" class="snum">' + count + '<\/span><\/td>';
          data += '<td class="dataTableContent txta-c" style="width:5%;"><input class="status" type="checkbox" value="1" name="status[]" checked="checked"\/><\/td>';
          data += '<td class="dataTableContent"><strong>' + attributeName + '<\/strong><input type="hidden" name="attribute_name[]" value="' + attributeName + '"\/><input type="hidden" name="attribute_id[]" value="' + valueID + '"\/><\/td>';
        } else {
          var data = '<tr class="dataTableRow">';
          data += '<td class="dataTableContent txta-c"><input type="checkbox" class="case"/><\/td>';
          data += '<td class="dataTableContent txta-c"><\/td>';
          data += '<td class="dataTableContent txta-c"><input type="hidden" name="combi_value_id[]" value=""\/><span id="snum' + i + '" class="snum">' + count + '<\/span><\/td>';
          data += '<td class="dataTableContent txta-c"><input class="status" type="checkbox" value="1" name="status[]" checked="checked"\/><\/td>';
          data += '<td class="dataTableContent"><strong>' + attributeName + '<\/strong><input type="hidden" name="attribute_name[]" value="' + attributeName + '"\/><input type="hidden" name="attribute_id[]" value="' + valueID + '"\/><\/td>';
          <?php if (defined('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN') && MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN == 'true') { ?>
            data += '<td class="dataTableContent txta-c"><input type="text" class="w100" name="model[]" size="15" value=""\/><\/td>';
            data += '<td class="dataTableContent txta-c"><input type="text" class="w100" name="ean[]" size="13" value=""\/><\/td>';
          <?php } ?>
          data += '<td class="dataTableContent txta-c"><input type="text" name="stock[]" size="8" value="0"\/><\/td>';
          data += '<td class="dataTableContent txta-c image"><input type="hidden" name="image[]" value=""\/><\/td>';
        }
        data += '<\/tr>';
        $('#variations table').append(data);
        i++;
      });
      // Select all
      $(".check_all").change(function() {
        $('input.case').each(function() {
          if ($('input.check_all').is(':checked')) {
            $(this).prop("checked", true);
          } else {
            $(this).prop("checked", false);
          }
        });
      });
      // Sortierung
      $("#variations .moveup").on("click", function() {
        var elem = $(this).closest(".dataTableRow");
        elem.prev(".dataTableRow").before(elem);
      });
      $("#variations .movedown").on("click", function() {
        var elem = $(this).closest(".dataTableRow");
        elem.next(".dataTableRow").after(elem);
      });
    });
  </script>
<?php
}
