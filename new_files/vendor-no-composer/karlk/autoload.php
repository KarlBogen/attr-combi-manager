<?php
require_once DIR_FS_DOCUMENT_ROOT . '/vendor/composer/ClassLoader.php';

$loader = new \Composer\Autoload\ClassLoader();
$loader->setPsr4('KarlK\\', DIR_FS_DOCUMENT_ROOT . '/vendor-no-composer/karlk');
$loader->register();
