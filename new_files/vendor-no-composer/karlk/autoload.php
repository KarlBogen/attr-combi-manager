<?php
require_once DIR_FS_DOCUMENT_ROOT . '/vendor/composer/KKClassLoader.php';

$loader = new \Composer\KKAutoload\KKClassLoader();
$loader->setPsr4('KarlK\\', DIR_FS_DOCUMENT_ROOT . '/vendor-no-composer/karlk');
$loader->register();
