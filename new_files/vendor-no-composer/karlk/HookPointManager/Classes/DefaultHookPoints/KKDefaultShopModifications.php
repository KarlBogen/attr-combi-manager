<?php
namespace KarlK\HookPointManager\Classes\DefaultHookPoints;

/*

	This class provides data for shopfile modifications

 */

class KKDefaultShopModifications
{

    public function getModifyData($modifiedVersion)
    {
		$ModData = array();

		switch ($modifiedVersion) {

			case '2.0.0.0':
				break;

			case '2.0.1.0':
			case '2.0.2.0':
			case '2.0.2.1':
			case '2.0.2.2':
			case '2.0.3.0':
			case '2.0.4.0':
			case '2.0.4.1':
			case '2.0.4.2':
				// Ist im Adminbereich Konfiguration -> Lagerverwaltungs Optionen -> Warenmenge abziehen auf "Ja"
				$ModData[] = $this->getXtcRestockData();
				$ModData[] = $this->getMainClassData1();
				$ModData[] = $this->getMainClassData2();
				break;

			case '2.0.5.0':
			case '2.0.5.1':
			case '2.0.6.0':
			case '2.0.7.0':
			case '2.0.7.1':
			case '2.0.7.2':
			case '3.0.0':
			case '3.0.1':
			case '3.0.2':
			default:
				// Ist im Adminbereich Konfiguration -> Lagerverwaltungs Optionen -> Warenmenge abziehen auf "Ja"
				$ModData[] = $this->getXtcRestockData();
				break;

		}

        return $ModData;

    }

	protected function getMainClassData1() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . DIR_WS_CLASSES . 'main.php',
						'SEARCHSTRING' => 'return xtc_db_fetch_array($attributes);',
						'KEYPLUS' => 0,
						'REPLACESTRING' => $this->getMainClassString1(),
				);
        return $data;

	}

	protected function getMainClassString1() {

		$code = '    return $attributes;' . "\n";
		$code .= '    /* EOF Module "Attribute Kombination Manager" made by Karl */';
        return $code;

	}

	protected function getMainClassData2() {

		$data =	array(	'TPLFILE' => DIR_FS_CATALOG . DIR_WS_CLASSES . 'main.php',
						'SEARCHSTRING' => 'return $attributes;',
						'KEYPLUS' => -3,
						'REPLACESTRING' => $this->getMainClassString2(),
				);
        return $data;

	}

	protected function getMainClassString2() {

		$code = '    /* BOF Module "Attribute Kombination Manager" made by Karl */' . "\n";
		$code .= '    $attributes = xtc_db_fetch_array($attributes);' . "\n";
        return $code;

	}

	protected function getXtcRestockData() {

		$data =	array(	'TPLFILE' => DIR_FS_INC . 'xtc_restock_order.inc.php',
						'SEARCHSTRING' => '$products_update = false;',
						'KEYPLUS' => 2,
						'REPLACESTRING' => $this->getXtcRestockString(),
				);
        return $data;

	}

	protected function getXtcRestockString() {

		$code = '/* BOF Module "Attribute Kombination Manager" made by Karl */' . "\n";
		$code .= '/* Original' . "\n";
		$code .= '        }' . "\n";
		$code .= '*/' . "\n";
		$code .= '          /* wird die Bestellung im Adminbereich gelöscht, so wird der Kombinationsbestand wieder hochgesetzt */' . "\n";
		$code .= '          $combi_attr_id[] = $orders_attributes["orders_products_options_values_id"];' . "\n";
		$code .= '        }' . "\n";
		$code .= '      }' . "\n";
		$code .= '      if (count($combi_attr_id) >= 2) {' . "\n";
		$code .= '        /* $combi_attr_id zusammenbauen damit wir mit der attribute_id der Kombi vergleichen können */' . "\n";
		$code .= '        $tmpAttrid = \'\';' . "\n";
		$code .= '        $plh = \'_\';' . "\n";
		$code .= '        $tmpAttrid = implode($plh, $combi_attr_id);' . "\n\n";

		$code .= '        $combi_attr_id = array();' . "\n";
		$code .= '        $new_stock = array();' . "\n\n";

		$code .= '        $query = "SELECT combi_value_id, stock' . "\n";
		$code .= '            FROM ".TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2."' . "\n";
		$code .= '            WHERE products_id = " . $order[\'products_id\'] . "' . "\n";
		$code .= '            AND' . "\n";
		$code .= '              attribute_id = \'".$tmpAttrid."\'' . "\n";
		$code .= '            LIMIT 1";' . "\n\n";

		$code .= '        $result = xtc_db_query($query);' . "\n";
		$code .= '        if(xtc_db_num_rows($result) > 0) {' . "\n";
		$code .= '          $tmpdata =xtc_db_fetch_array($result);' . "\n\n";

		$code .= '          $new_stock["stock"] = $tmpdata["stock"] + $order[\'products_quantity\'];' . "\n\n";

		$code .= '          /* update stock */' . "\n";
		$code .= '          xtc_db_perform(TABLE_PRODUCTS_OPTIONS_COMBI_VALUES_2, $new_stock, \'update\', \'combi_value_id=\'.$tmpdata["combi_value_id"]);' . "\n";
		$code .= '        }' . "\n";
		$code .= '/* EOF Module "Attribute Kombination Manager" made by Karl */';

        return $code;

	}


}