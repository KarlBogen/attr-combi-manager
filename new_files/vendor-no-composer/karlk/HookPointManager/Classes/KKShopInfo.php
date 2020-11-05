<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl
	Version: 0.0.1

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License

	The original class is part of https://github.com/RobinTheHood/hook-point-manager.
	This class is adapted to the needs of this module.
-------------------------------------------------------------- */

namespace KarlK\HookPointManager\Classes;

class KKShopInfo
{
    /**
     * Returns the path of the shop root directory
     * 
     * Notice: __DIR__ and __FILE__ can not handle symlinks. Both magic constants paths are resolved.
     * That's why we have to test both cases.
     */
    public static function getShopRoot()
    {
        $fileThatMustExist = '/admin/includes/version.php';

        // Check if file is installed as copy
        // .../SHOP-ROOT/vendor-no-composer/robinthehood/HookPointManager/Classes/"
        $path = realPath(__DIR__ . '/../../../../');
        $testPath = $path . $fileThatMustExist;
        if (\file_exists($testPath)) {
            return $path;
        }

        // Check if file is installed as symlink
        // .../SHOP-ROOT/ModifiedModuleLoaderClient/Modules/robinthehood/hook-point-manager/new_files/vendor-no-composer/robinthehood/HookPointManager/Classes/"
        $path = realPath(__DIR__ . '/../../../../../../../../../');
        $testPath = $path . $fileThatMustExist;
        if (\file_exists($testPath)) {
            return $path;
        }

        throw new RuntimeException('Can not find and resolve ShopRoot');
    }

    /**
     * @return string Returns the installed modified version as string.
     */
    public static function getModifiedVersion()
    {
        $path = self::getShopRoot() . '/admin/includes/version.php';
        if (!file_exists($path)) {
            return '';
        }

        if (defined('PROJECT_MAJOR_VERSION') && defined('PROJECT_MINOR_VERSION')) {
            $version = PROJECT_MAJOR_VERSION . '.' . PROJECT_MINOR_VERSION;
        } else {
        	$fileStr = file_get_contents($path);
        	$pos = strpos($fileStr, 'MOD_');
        	$version = substr($fileStr, (int) $pos + 4, 7);
        }

        return $version;
    }
}