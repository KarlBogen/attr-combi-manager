<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License
-------------------------------------------------------------- */

use KarlK\ProductCombiManager\Classes\ProductCombiAdmin;

require('includes/application_top.php');

// prüfen, ob Systemmodul installiert und Status true ist
if (defined('MODULE_PRODUCTS_COMBINATIONS_STATUS') && MODULE_PRODUCTS_COMBINATIONS_STATUS == 'true') {

require_once DIR_FS_DOCUMENT_ROOT . 'vendor-no-composer/karlk/autoload.php';

$ProductCombiAdmin = new ProductCombiAdmin();
// Ajax call für Image-Upload und Bildverknüpfung
if(isset($_POST['func'])){
	$ProductCombiAdmin->CombiAjaxCall($_POST);
}

$newTable = false;
$backlink = '';
$backfile = '';
$backhidden = '';

// Backlinks zusammenstellen
if (isset ($_REQUEST['page'])){
	$page = $_REQUEST['page'];
	$backlink .= 'page='.$page.'&';
	$backhidden .= xtc_draw_hidden_field('page',$page);
}

if (isset ($_REQUEST['cPath'])){
	$chpath = $_REQUEST['cPath'];
	$backlink .= 'cPath='.$chpath.'&';
	$backhidden .= xtc_draw_hidden_field('cPath', $chpath);
}

if (isset ($_REQUEST['pID'])){
	$_POST['current_product_id']=$_REQUEST['pID'];
	if (!isset ($_POST['action'])) $_POST['action'] ="edit";
	$backlink .= 'pID='.$_POST['current_product_id'].'&';
	$backhidden .= xtc_draw_hidden_field('pID', $_REQUEST['pID']);
}
if (isset($_POST['current_product_id'])) $backhidden .= xtc_draw_hidden_field('current_product_id',$_POST['current_product_id']);

if ($backlink <> '') {
	if (isset($_REQUEST['oldaction']) && $_REQUEST['oldaction'] == 'new_product') {
        $backlink .= 'action=new_product&current_product_id='.$_POST['current_product_id'].'&';
		$backhidden .= xtc_draw_hidden_field('oldaction', $_REQUEST['oldaction']);
		$backfile = FILENAME_CATEGORIES;
	} else {
		$backfile = FILENAME_CATEGORIES;
	}
}else{
	$backfile = FILENAME_PRODUCTS_COMBI;
}

// Zurück-Button wird gedrückt
if(isset($_POST['action'])){
	switch($_POST['action']) {
		// Speichern beim Verlassen - Kombiliste vorher noch nie gespeichert
		case 'save_redirect':
		    $ProductCombiAdmin->saveCombinationsList();
    		xtc_redirect(xtc_href_link($backfile, $backlink),'NONSSL');
			break;
		// Nicht speichern beim Verlassen - Kombiliste vorher noch nie gespeichert
		case 'del_redirect':
            $ProductCombiAdmin->deleteCombinationsTable($_POST["combi_id"]);
    		xtc_redirect(xtc_href_link($backfile, $backlink),'NONSSL');
			break;
		// Nicht Speichern beim Verlassen - Kombiliste editieren
		case 'only_redirect':
      if (empty($_POST["combi_value_id"])) $ProductCombiAdmin->deleteCombinationsTable($_POST["combi_id"]);
    		xtc_redirect(xtc_href_link($backfile, $backlink),'NONSSL');
			break;
		// Speichern beim Verlassen - Kombiliste editieren
		case 'save_list':
		    $ProductCombiAdmin->saveCombinationsList();
			break;
	}
}

// Ausgabe
require (DIR_WS_INCLUDES.'head.php');
require('includes/javascript/products_combi.js.php');
?>
	<script type="text/javascript" src="includes/javascript/dropdowncontent.js"></script>
	<style>
		.image_select {
		    background-color: #e7e7e7;
    		border: none;
    		padding: 15px 15px;
    		text-align: center;
    		text-decoration: none;
    		display: inline-block;
		}
		.image_select.selected {
			background-color: #008CBA;
		}
		.image_select img{
			max-width:150px;
			height:auto;
		}
	</style>
</head>
<body>
	<?php
		require(DIR_WS_INCLUDES . 'header.php');
	?>
	<table class="tableBody">
    	<tr>
			<?php //left_navigation
			if (USE_ADMIN_TOP_MENU == 'false') {
				echo '			<td class="columnLeft2">'.PHP_EOL;
				require_once(DIR_WS_INCLUDES . 'column_left.php');
        		echo '			</td>'.PHP_EOL;
      		}
      		?>
      		<td class="boxCenter">
				<table class="tableCenter">
					<tr>
						<td class="boxCenter">
							<div class="pageHeadingImage"><?php echo xtc_image(DIR_WS_ICONS.'kombi.png'); ?></div>
							<div class="pageHeading pdg2"><?php echo PROD_COMBI_HEADER_TITLE; if (isset($_POST['current_product_id'])) echo $ProductCombiAdmin->getCombiProductName ($_POST['current_product_id'], $_SESSION['languages_id'])?></div>
<?php //hier gehts Los ?>
							<table class="tableCenter">
								<tr>
									<td>
										<?php if(!isset($_POST['action'])){ // Standard Funktion
											echo xtc_draw_form('SELECT_PRODUCT', FILENAME_PRODUCTS_COMBI);
											echo xtc_draw_hidden_field('action','edit');
											echo xtc_draw_hidden_field(xtc_session_name(), xtc_session_id());

											// hole alle Produkte
    										$result = $ProductCombiAdmin->getCombiProductsWithAttributes();
											$matches = xtc_db_num_rows($result);

											if ($matches) {
												$SelectValues = array();
												while ($line = xtc_db_fetch_array($result)) {
													// getCombiDiffAttributes => Anzahl der Attribute zählen (bei mehr als 1 Attribut wird Produkt in Auswahl übernommen)
													//$current_product_id = $line['products_id'];
													if ($ProductCombiAdmin->getCombiDiffAttributes($line['products_id']) <> 0) {
														$diff_attribute = 1;
														$SelectValues[]=array('id'=>$line['products_id'],'text'=>$line['products_name'] .' [' .$line['products_model'] . ']' .' [PID: ' .$line['products_id'] . ']');
													}
												}
												if ($diff_attribute == 1 ){
													echo xtc_draw_pull_down_menu('current_product_id', $SelectValues);
													echo '<br>';
													echo xtc_button(BUTTON_EDIT);
												} else {
													echo PROD_COMBI_NO_PRODUCTS_ERR;
												}
											} else {
												echo PROD_COMBI_NO_PRODUCTS_ERR;
											}
										?>
										</form>
										<?php } // ENDIF Standard Funktion

										if(isset($_POST['action'])) {
											switch($_POST['action']) {
												case 'create':
												case 'save':
													if($_POST['action'] == "create"){
														// Kombinationenliste wird berechnet und combi_id in Datenbank eingetragen
            											$single = false;
            											if (isset($_POST['btn_single'])) $single = true;
														$createTable = $ProductCombiAdmin->createCombinationsList($_POST['current_product_id'], $single);
														$newTable = true;
													} else {
														if (isset($_POST['del_list'])){
															// löscht die Liste
															$ProductCombiAdmin->deleteCombinationsList($_POST['combi_id']);
														} else {
															// speichert die erste Auswahlliste und holt alle Daten aus der Value-Tabelle
															$ProductCombiAdmin->saveCombinationsList();
														}
  													}

												case 'edit':
													// checken, ob combi_id existiert
													$combi_id = $ProductCombiAdmin->hasProductCombi($_POST['current_product_id']);
													if(!$combi_id){ ?>
														<br />
														<div style="float:left" class="main"><?php echo PROD_COMBI_NOT_SELECTED_MSG; ?></div>
													<?php
													} else {
														// gespeicherte Liste aus Datenbank holen
														if (!$newTable && $combi_id) {
															$createTable = $ProductCombiAdmin->getCombinationsListfromTable($combi_id);
														}
														echo xtc_draw_form('SAVE_COMBI', FILENAME_PRODUCTS_COMBI, '', 'post', 'id="variations"');
														echo xtc_draw_hidden_field('action','save');
														echo xtc_draw_hidden_field('combi_id', $createTable[2]);
														echo xtc_draw_hidden_field('combi2del');
														echo $backhidden;
														echo '<a class="save_red button" href="'.xtc_href_link($backfile, $backlink).'">'.PROD_COMBI_SAVE_BTN.'</a>';
														echo '&nbsp;&nbsp;<input type="submit" class="save button but_green" value="'.BUTTON_UPDATE.'" />';
														echo '&nbsp;&nbsp;<a class="button back" href="'.xtc_href_link($backfile, $backlink).'">'.BUTTON_BACK.'</a><br />';
														echo $createTable[0];
														echo '<br /><input class="del_combi" type="checkbox" name="del_list" value="delete"/> '.PROD_COMBI_DELETE_BTN.'<br /><br />';
														echo '<a class="save_red button" href="'.xtc_href_link($backfile, $backlink).'">'.PROD_COMBI_SAVE_BTN.'</a>';
														echo '&nbsp;&nbsp;<input type="submit" class="save button but_green" value="'.BUTTON_UPDATE.'" />';
														echo '&nbsp;&nbsp;<a class="button back" href="'.xtc_href_link($backfile, $backlink).'">'.BUTTON_BACK.'</a>';
														echo '</form>';

														// ---------------------- Eingabehilfen und Upload ----------------------
														// Kombination löschen und hinzufügen
														?>
														<br /><br /><br />
														<div class="dataTableHeadingContent" align="left"><?php echo PROD_COMBI_HELPER;?><br /></div>
														<table class="tableConfig">
															<tr>
																<td class="dataTableConfig col-left"><input type="button" class="delete button" value="<?php echo PROD_COMBI_DEL_BUTTON;?>" /></td>
															</tr>
															<tr>
																<td class="dataTableConfig col-left"><?php echo $createTable[1]; ?></td>
															</tr>
														</table>
														<?php
														// Hilfe zum Felder befüllen
														// wird nur angezeigt, wenn Liste bereits gespeichert wurde
														if(!$newTable && $combi_id){
														?>
                                                            <table class="tableConfig">
															<?php if (defined('MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN') && MODULE_PRODUCTS_COMBINATIONS_OWN_MODEL_AND_EAN == 'true') { ?>
															<tr>
															<td class="dataTableConfig col-left">
																<?php echo sprintf(PROD_COMBI_PRESELECT, PROD_COMBI_TH_MODEL);?>
															</td>
                                                            <td class="dataTableConfig col-middle">
																<input type="text" name="new_val_model" value=""/>
																<input type="button" class="update_field_model button" value="<?php echo PROD_COMBI_TH_MODEL . '&nbsp;' . PROD_COMBI_PRESELECT_BTN;?>" />
															</td>
															</tr>
															<tr>
															<td class="dataTableConfig col-left">
																<?php echo sprintf(PROD_COMBI_PRESELECT, PROD_COMBI_TH_EAN);?>
															</td>
                                                            <td class="dataTableConfig col-middle">
																<input type="text" name="new_val_ean" value=""/>
																<input type="button" class="update_field_ean button" value="<?php echo PROD_COMBI_TH_EAN . '&nbsp;' . PROD_COMBI_PRESELECT_BTN;?>" />
															</td>
															</tr>
															<?php } ?>
															<tr>
															<td class="dataTableConfig col-left">
																<?php echo sprintf(PROD_COMBI_PRESELECT, PROD_COMBI_TH_STOCK);?>
															</td>
                                                            <td class="dataTableConfig col-middle">
																<input type="text" name="new_val" value="10"/>
																<input type="button" class="update_fields button" value="<?php echo PROD_COMBI_TH_STOCK . '&nbsp;' . PROD_COMBI_PRESELECT_BTN;?>" />
															</td>
															</tr>
															</table>
                                                            <br />

															<?php
															echo xtc_draw_form('upload', FILENAME_PRODUCTS_COMBI, '', 'post', 'id="upload" enctype="multipart/form-data"');
															?>
															<div class="dataTableHeadingContent" align="left"><?php echo PROD_COMBI_UPLOAD_IMG; ?></div>
															<table border="0" width="100%" cellspacing="0" cellpadding="2" border="0">
																<tr>
																	<td><input type="button" class="image_delete button" value="<?php echo PROD_COMBI_DELETE_IMG; ?>" /></td>
																</tr>
																<tr>
																	<td><input id="img_load" type="button" class="image_load button flt-l" value="<?php echo PROD_COMBI_LOAD_IMG; ?>" />&nbsp;&nbsp;<span id="status_message" style="line-height:30px;font-size:15px;width:59%"><img class="loading" src="images/loading.gif" style="display:none;"></span></td>
																</tr>
																<tr>
																	<td>
																		<?php
																		// Produktbilder verlinken
                    													$products_images = $ProductCombiAdmin->getCombiProductsImages($_POST['current_product_id']);
																		foreach ($products_images as $img) {
																			if ($img == '' || !is_file(DIR_FS_CATALOG_THUMBNAIL_IMAGES.$img)) $img = 'noimage.gif';
                            												echo '<button class="image_select flt-l mrg5" type="button">' . xtc_image(DIR_WS_CATALOG_THUMBNAIL_IMAGES.$img, $img) . '</button>';
																		}
																		?>
																	</td>
																</tr>
															</table>
															</form>
													<?php
														}
													}

													// wenn noch keine Liste existiert
													if(!$combi_id AND $_POST['current_product_id']<>''){
														?>
														<br /><br />
														<div class="dataTableHeadingContent" style="width:60%"><?php echo PROD_COMBI_SEL_ATTRIB_MSG; ?></div>
														<br />
														<?php
														echo xtc_draw_form('DEL_COMBI', FILENAME_PRODUCTS_COMBI );
														echo xtc_draw_hidden_field('action','create');
														echo xtc_draw_hidden_field('current_product_id', $_POST['current_product_id']);

														$tmpresult = $ProductCombiAdmin->getCombiProductsOptions($_POST['current_product_id']);

														if(xtc_db_num_rows($tmpresult) < 1) {
															die (PROD_COMBI_MSQL_ERR);
														} else {
															$SelectValues = array();
															while($tmpdata = xtc_db_fetch_array($tmpresult)){
																$SelectValues[]=$tmpdata['products_options_id'];
    														}
															echo xtc_draw_hidden_field('prod_options', implode(',',$SelectValues));
														}
														?>
														<br />
														<div align="left">
														<?php
															echo $backhidden;
															echo xtc_button(PROD_COMBI_CREATE_BTN);
															echo xtc_button(PROD_COMBI_CREATE_SINGLE_BTN, 'submit', 'name="btn_single"');
															echo xtc_button_link(BUTTON_BACK, xtc_href_link($backfile, $backlink), 'id="back"');;
														?>
														</div>
														</form>
										<?php
														}
													break;
											}
										}
										?>
									</td>
								</tr>
							</table>
						<?php //hier hört es auf?>
						</td>
					</tr>
				</table>
      		</td>
		</tr>
	</table>
<!-- footer //-->
    <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php');

} else {
	// redirect falls Systemmodulstatus != true
	xtc_redirect(xtc_href_link(FILENAME_START));
}
