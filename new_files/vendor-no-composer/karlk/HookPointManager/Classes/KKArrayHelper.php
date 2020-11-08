<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License

	The original class is part of https://github.com/RobinTheHood/hook-point-manager.
	This class is adapted to the needs of this module.
-------------------------------------------------------------- */

namespace KarlK\HookPointManager\Classes;

class KKArrayHelper
{
    public static function insertAfter(array $array, $afterIndex, $newIndex, $newValue)
    {
        if (array_key_exists($afterIndex, $array)) {
            $newArray = [];
            foreach ($array as $index => $value) {
                $newArray[$index] = $value;
                if ($index === $afterIndex) {
                    $newArray[$newIndex] = $newValue;
                }
            }
            return $newArray;
        }
        return false;
    }
}