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

	if(strpos($_SERVER['PHP_SELF'], 'products_attributes.php') !== false){
?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.no_combi_opt').closest('div').remove();
			if ( $( ".is_combi_opt" ).length ) {
				$('.is_combi_opt').closest('table').each(function(){
					$(this).find('tr').each(function(){
						$(this).find("input.ChkBox.select_all").remove();
						if ($(this).find('td').hasClass('is_combi_val')) {$(this).find("input.ChkBox").addClass("hidden");}
						$(this).find('input[name*="_stock"]').attr('disabled', false).prop('type', 'hidden').after('<?php echo PRODUCTS_COMBI_STOCK; ?>');
					});
				});
				$('head').append('<style type="text/css">#attributes input.hidden.ChkBox[type="checkbox"] + em {background:none !important;}#attributes input.hidden.ChkBox[type="checkbox"] {pointer-events: none !important;cursor: none;}</style>');
			}
		});
	</script>
<?php
	}
}
