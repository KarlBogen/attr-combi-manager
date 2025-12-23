<?php
/* ------------------------------------------------------------
	Module "Attribute Kombination Manager" made by Karl

	inspired by Products Matrix Module (c) Timo Doerr <timo.doerr@work-less.de>

	modified eCommerce Shopsoftware
	http://www.modified-shop.org

	Released under the GNU General Public License

	The original class is part of https://github.com/RobinTheHood/hook-point-manager.
	This class is modified to the needs of this module.
-------------------------------------------------------------- */

namespace KarlK\HookPointManager\Classes;

class KKHookPointManager
{

  protected $message = [];

  public function __construct()
  {
    $hookPointRepository = new KKHookPointRepository();
    $hookPointRepository->createTableKKHookPointIfNotExists();
  }

  public function registerHookPoint($hookPoint, $versions)
  {
    $hookPointRepository = new KKHookPointRepository();

    foreach ($versions as $version) {
      $hookPoint['version'] = $version;

      if ($hookPointRepository->getHookPointByNameAndVersion($hookPoint['name'], $hookPoint['version'])) {
        $hookPointRepository->updateHookPoint($hookPoint);
      } else {
        $hookPointRepository->addHookPoint($hookPoint);
      }
    }
  }

  public function unregisterHookPoint() {}

  public function registerDefault()
  {
    (new DefaultHookPoints\KKDefaultHookPoints)->registerAll();
  }

  public function update()
  {
    $modifiedVersion = KKShopInfo::getModifiedVersion();
    $hookPointRepository = new KKHookPointRepository();
    $hookPoints = $hookPointRepository->getAllHookPointsByVersion($modifiedVersion);

    $this->updateHookPoints($hookPoints);
  }

  public function updateHookPoints($hookPoints)
  {
    $groupedHookPoints = $this->groupHookPointsByFile($hookPoints);

    foreach ($groupedHookPoints as $fileHookPoints) {
      $relativeFilePath = '/' . DIR_ADMIN . $fileHookPoints[0]['file'];
      $hash = $fileHookPoints[0]['hash'];
      $this->createBackupFile($relativeFilePath, $hash);
      $this->insertHookPointsToFile($relativeFilePath, $fileHookPoints);
    }
  }

  public function groupHookPointsByFile($hookPoints)
  {
    $groupedHookPoints = [];
    foreach ($hookPoints as $hookPoint) {
      $relativeFilePath = $hookPoint['file'];
      $groupedHookPoints[$relativeFilePath][] = $hookPoint;
    }
    return $groupedHookPoints;
  }

  //TODO: only copy when file-hash is equal
  public function createBackupFile($relativeFilePath, $hash)
  {
    $modifiedVersion = KKShopInfo::getModifiedVersion();
    $filePath = KKShopInfo::getShopRoot() . $relativeFilePath;
    $orgFilePath = str_replace('.php', '-' . $modifiedVersion . '-hpmorg.php', $filePath);

    if (!file_exists($filePath)) {
      // throw new \RuntimeException("Can not create original file $orgFilePath because $filePath not exsits.");
      $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_ORGFILE_CANNOTCREATE, $orgFilePath, $filePath));
      return;
    }

    if (file_exists($orgFilePath)) {
      return;
    }

    if (md5(file_get_contents($filePath)) != $hash) {
      // throw new \RuntimeException("Can not create original file $orgFilePath out of $filePath because file hash dose not match.");
      $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_ORGFILE_NOTCREATED, $orgFilePath, $filePath));
      return;
    }

    copy($filePath, $orgFilePath);

    if (file_exists($orgFilePath)) {
      $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_ORGFILE_CREATED, $orgFilePath, $filePath), 'success');
    }
  }

  public function insertHookPointsToFile($relativeFilePath, $fileHookPoints)
  {
    $modifiedVersion = KKShopInfo::getModifiedVersion();
    $filePath = KKShopInfo::getShopRoot() . $relativeFilePath;
    $orgFilePath = str_replace('.php', '-' . $modifiedVersion . '-hpmorg.php', $filePath);

    if (!file_exists($orgFilePath)) {
      //throw new \RuntimeException("Can not create hook points in $filePath because $orgFilePath not exsits.");
      $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_ORGFILE_NOTEXISTS, $filePath, $orgFilePath));
      return;
    }

    // Test hashes
    $hash = md5(file_get_contents($orgFilePath));
    foreach ($fileHookPoints as $hookPoint) {
      if ($hookPoint['hash'] != $hash) {
        $hookPointName = $hookPoint['name'];
        // throw new \RuntimeException("Can install $hookPointName in $filePath because file hash dose not match.");
        $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_HASH_MATCH, $hookPointName, $filePath));
        return;
      }
    }

    $fileContent = file_get_contents($orgFilePath);
    $lines = explode("\n", $fileContent);

    foreach ($fileHookPoints as $hookPoint) {
      $name = isset($hookPoint['name']) ? $hookPoint['name'] : 'unknown-hook-point-name';
      $line = $hookPoint['line'];
      $indexName = $line . ':' . $name;
      $lines = KKArrayHelper::insertAfter($lines, $line - 1, $indexName, $this->createAutoIncludeCode($hookPoint, $orgFilePath));
    }

    $newFileContent = implode("\n", $lines);

    file_put_contents($filePath, $newFileContent);

    if (file_exists($filePath)) {
      $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_HP_INSERTED, $filePath), 'success');
    }
  }

  public function createAutoIncludeCode(array $hookPoint, string $orgFilePath)
  {
    $name = isset($hookPoint['name']) ? $hookPoint['name'] : 'unknown-hook-point-name';
    $module = isset($hookPoint['module']) ? $hookPoint['module'] : 'unknown-hook-point-module';
    $includePath = isset($hookPoint['include']) ? $hookPoint['include'] : '/includes/etra/hpm/unknown_hook_point/';

    $code = "/* *** robinthehood/hook-point-manager START ***" . "\n";
    $code .= " * This is a automatically generated file with new hook points." . "\n";
    $code .= " * You can find the original unmodified file at: $orgFilePath" . "\n";
    $code .= " *" . "\n";
    $code .= " * From Module: $module" . "\n";
    $code .= " * HookPointName: $name" . "\n";
    $code .= " */" . "\n";
    $code .= "foreach(auto_include(DIR_FS_CATALOG . '/' . DIR_ADMIN . '$includePath','php') as \$file) require (\$file);" . "\n";
    $code .= "/* robinthehood/hook-point-manager END */" . "\n";
    return $code;
  }

  public function modifyFilesBySelection($selection = 'shop')
  {
    $modifiedVersion = KKShopInfo::getModifiedVersion();
    if ($selection != 'shop') {
      $modifyDatas = (new DefaultHookPoints\KKDefaultTplModifications)->getModifyData($modifiedVersion);
    } else {
      $modifyDatas = (new DefaultHookPoints\KKDefaultShopModifications)->getModifyData($modifiedVersion);
    }

    foreach ($modifyDatas as $modifyData) {
      $res = '';
      if (file_exists($modifyData['TPLFILE'])) {
        $fileContent = file_get_contents($modifyData['TPLFILE']);
        if (strpos($fileContent, 'BOF Module "Attribute Kombination Manager"') === false) {
          $needle = $modifyData['SEARCHSTRING'];
          $lines = explode("\n", $fileContent);
          $i = 0;
          foreach ($lines as $key => $val) {
            if ((is_array($needle) && in_array(trim($val), $needle)) || (is_string($needle) && $needle == trim($val))) {
              $lines[$key + $modifyData['KEYPLUS']] = $modifyData['REPLACESTRING'];
              $i++;
              break;
            }
          }
          $newFileContent = implode("\n", $lines);
          $res = file_put_contents($modifyData['TPLFILE'], $newFileContent);
          if (isset($res) && $res > 0 && $i > 0) {
            $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_TPLFILE_MODIFIED, $modifyData['TPLFILE']), 'success');
          } else {
            $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_TPLFILE_SEARCHSTRING_NOTFOUND, $modifyData['TPLFILE']), 'warning');
          }
        } else {
          $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_TPLFILE_ISALREADY_MODIFIED, $modifyData['TPLFILE']), 'success');
        }
      } else {
        $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_TPLFILE_NOTEXISTS, $modifyData['TPLFILE']), 'error');
      }
    }
  }

  public function restoreAllFiles()
  {
    $modifiedVersion = KKShopInfo::getModifiedVersion();
    $restoreDatas = (new DefaultHookPoints\KKDefaultRestore)->getRestoreData($modifiedVersion);

    foreach ($restoreDatas as $restoreData) {
      $res = '';
      if (file_exists($restoreData['TPLFILE'])) {
        $fileContent = file_get_contents($restoreData['TPLFILE']);
        if (strpos($fileContent, 'BOF Module "Attribute Kombination Manager') !== false) {
          $newFileContent = preg_replace($restoreData['SEARCHPATTERN'], $restoreData['REPLACESTRING'], $fileContent);
          $res = file_put_contents($restoreData['TPLFILE'], $newFileContent);
        } else {
          $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_TPLFILE_NOTMODIFIED, $restoreData['TPLFILE']), 'warning');
        }
      } else {
        $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_TPLFILE_NOTEXISTS, $restoreData['TPLFILE']), 'warning');
      }
      if (isset($res) && $res > 0) {
        $this->addMessage(sprintf(COMBI_HOOKPOINT_MANAGER_TPLFILE_RESTORED, $restoreData['TPLFILE']), 'success');
      }
    }
  }

  public function addMessage($message, $type = 'error')
  {
    $this->message[] = array('text' => $message, 'type' => $type);
  }

  public function getMessage()
  {
    return $this->message;
  }
}
