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

class KKHookPointRepository
{
  public function createTableKKHookPointIfNotExists()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `kk_hook_point` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `version` varchar(255) DEFAULT NULL,
            `module` varchar(255) DEFAULT NULL,
            `name` varchar(255) DEFAULT NULL,
            `include` text,
            `file` text,
            `hash` varchar(255) DEFAULT NULL,
            `line` int(11) DEFAULT NULL,
            `description` text,
            PRIMARY KEY (`id`)
          ) DEFAULT CHARSET=utf8;";
    $query = xtc_db_query($sql);
  }

  public function addHookPoint(array $hookPoint)
  {
    $version = isset($hookPoint['version']) ? $hookPoint['version'] : '';
    $module = isset($hookPoint['module']) ? $hookPoint['module'] : '';
    $name = isset($hookPoint['name']) ? $hookPoint['name'] : '';
    $include = isset($hookPoint['include']) ? $hookPoint['include'] : '';
    $file = isset($hookPoint['file']) ? $hookPoint['file'] : '';
    $hash = isset($hookPoint['hash']) ? $hookPoint['hash'] : '';
    $line = isset($hookPoint['line']) ? $hookPoint['line'] : '';
    $description = isset($hookPoint['description']) ? $hookPoint['description'] : '';


    $sql = "INSERT INTO kk_hook_point
            (`version`, `module`, `name`, `include`, `file`, `hash`, `line`, `description`)
            VALUES
            ('$version', '$module', '$name', '$include', '$file', '$hash', '$line', '$description');";

    $query = xtc_db_query($sql);
  }

  public function updateHookPoint($hookPoint)
  {
    $version = isset($hookPoint['version']) ? $hookPoint['version'] : '';
    $module = isset($hookPoint['module']) ? $hookPoint['module'] : '';
    $name = isset($hookPoint['name']) ? $hookPoint['name'] : '';
    $include = isset($hookPoint['include']) ? $hookPoint['include'] : '';
    $file = isset($hookPoint['file']) ? $hookPoint['file'] : '';
    $hash = isset($hookPoint['hash']) ? $hookPoint['hash'] : '';
    $line = isset($hookPoint['line']) ? $hookPoint['line'] : '';
    $description = isset($hookPoint['description']) ? $hookPoint['description'] : '';

    $sql = "UPDATE kk_hook_point SET
                    `version` = '$version',
                    `module` = '$module',
                    `name` = '$name',
                    `include` = '$include',
                    `file` = '$file',
                    `hash` = '$hash',
                    `line` = '$line',
                    `description` = '$description'
                WHERE `version` = '$version' AND `name` = '$name';";

    //die($sql);
    $query = xtc_db_query($sql);
  }

  public function getHookPointByNameAndVersion(string $name, string $version)
  {
    $sql = "SELECT * FROM kk_hook_point WHERE name='$name' AND version='$version';";
    $query = xtc_db_query($sql);

    $row = xtc_db_fetch_array($query);
    return $row;
  }

  public function getAllHookPointsByVersion(string $version)
  {
    $sql = "SELECT * FROM kk_hook_point WHERE version='$version';";
    $query = xtc_db_query($sql);

    $hookPoints = [];
    while ($row = xtc_db_fetch_array($query)) {
      $hookPoints[] = $row;
    }
    return $hookPoints;
  }
}
