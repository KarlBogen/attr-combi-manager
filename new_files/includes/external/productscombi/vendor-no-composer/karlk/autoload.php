<?php
require_once DIR_FS_EXTERNAL . 'productscombi/vendor/composer/KKClassLoader.php';

$loader = new \Composer\KKAutoload\KKClassLoader();
$loader->setPsr4('KarlK\\', DIR_FS_EXTERNAL . 'productscombi/vendor-no-composer/karlk');
$loader->register();
