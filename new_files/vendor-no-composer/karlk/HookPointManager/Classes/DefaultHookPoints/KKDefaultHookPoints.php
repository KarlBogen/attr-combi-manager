<?php
namespace KarlK\HookPointManager\Classes\DefaultHookPoints;

use KarlK\HookPointManager\Classes\KKHookPointManager;

/*
    *** Default Hook Points for Modified 2.0.5.1 ***
    You can add new hook points by making a pull request in https://github.com/RobinTheHood/hook-point-manager

    index   | description                                           | example value
    --------------------------------------------------------------------------------------------------
    name    | unique name of the hook point                         | hpm-default-create-account-prepare-data
    module  | module name of hook poit creator                      | robinthehood/hook-point-manager
    file    | file path in which the hook point is to be installed  | /create_account.php
    hash    | md5-Hash of original unmodified file                  | 2b5ce65ba6177ed24c805609b28572a7
    line    | line after which the hook point is to be installed    | 289
    include | auto_include directory for the hook point files       | /includes/extra/hpm/create_account/prepare_data/
 */

class KKDefaultHookPoints
{
    public function registerAll()
    {

        $hookPointManager = new KKHookPointManager();

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => 'b957a828b863628ca8c4670b9e3e400c',
            'line' => 714,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['3.1.3', '3.1.4', '3.1.5']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '250b8d593baced8fb40a213d922f0b57',
            'line' => 718,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['3.1.0', '3.1.1', '3.1.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => 'fe1591f0a316513a2790ee578f1fd4b6',
            'line' => 718,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['3.0.0', '3.0.1', '3.0.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '95df9da9d04d4d59bac9712d7ed0c920',
            'line' => 660,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.7.0', '2.0.7.1', '2.0.7.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '3e93faae7d5d1af9ab367bc822f9fbe9',
            'line' => 661,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.6.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '68617ac9e3f07e2cffbb68adfd9b4d9f',
            'line' => 665,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.5.1']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '191fcb1e635a9b4ace30e598519f4f32',
            'line' => 665,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.5.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '7c650d5b66f0aea25d24f11cea6d1a35',
            'line' => 652,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.3.0', '2.0.4.0', '2.0.4.1', '2.0.4.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '8ce0fe15badbb3839417e2f19f4cc6b3',
            'line' => 646,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.2.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => 'c97a271942255c4c7a61bf0b0cdc9661',
            'line' => 638,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.2.1']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '56739996fc8651d4b92b0c9f8c71ad31',
            'line' => 638,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.1.0', '2.0.2.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => 'f67a6809c34e13744ef7070202e6298d',
            'line' => 632,
            'include' => 'includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.0.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => 'b957a828b863628ca8c4670b9e3e400c',
            'line' => 1018,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['3.1.3', '3.1.4', '3.1.5']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '250b8d593baced8fb40a213d922f0b57',
            'line' => 1022,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['3.1.0', '3.1.1', '3.1.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => 'fe1591f0a316513a2790ee578f1fd4b6',
            'line' => 1022,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['3.0.0', '3.0.1', '3.0.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '95df9da9d04d4d59bac9712d7ed0c920',
            'line' => 961,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.7.0', '2.0.7.1', '2.0.7.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '3e93faae7d5d1af9ab367bc822f9fbe9',
            'line' => 1001,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.6.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '68617ac9e3f07e2cffbb68adfd9b4d9f',
            'line' => 1008,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.5.1']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '191fcb1e635a9b4ace30e598519f4f32',
            'line' => 1008,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.5.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '7c650d5b66f0aea25d24f11cea6d1a35',
            'line' => 1005,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.3.0', '2.0.4.0', '2.0.4.1', '2.0.4.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '8ce0fe15badbb3839417e2f19f4cc6b3',
            'line' => 999,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.2.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => 'c97a271942255c4c7a61bf0b0cdc9661',
            'line' => 991,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.2.1']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => '56739996fc8651d4b92b0c9f8c71ad31',
            'line' => 991,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.1.0', '2.0.2.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/categories_view.php',
            'hash' => 'f67a6809c34e13744ef7070202e6298d',
            'line' => 974,
            'include' => 'includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.0.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-new-product-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/new_product.php',
            'hash' => '8860e648d0485f6f0fab18f830add1be',
            'line' => 279,
            'include' => 'includes/extra/hpm/new_product/buttons/'
        ], ['3.0.0', '3.0.1', '3.0.2', '3.1.0', '3.1.1', '3.1.2', '3.1.3', '3.1.4', '3.1.5']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-new-product-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/new_product.php',
            'hash' => 'c0464372ec54c35c060b0d5784551007',
            'line' => 271,
            'include' => 'includes/extra/hpm/new_product/buttons/'
        ], ['2.0.7.0', '2.0.7.1', '2.0.7.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-new-product-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/new_product.php',
            'hash' => '007e9af6ec2cfa8c384d914d4edcae22',
            'line' => 254,
            'include' => 'includes/extra/hpm/new_product/buttons/'
        ], ['2.0.6.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-new-product-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/new_product.php',
            'hash' => 'f5bce50f35a1c99224b32cc64fbbfa3f',
            'line' => 242,
            'include' => 'includes/extra/hpm/new_product/buttons/'
        ], ['2.0.5.0', '2.0.5.1']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-new-product-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/new_product.php',
            'hash' => '15f9aa43275bb79818082066abbc1685',
            'line' => 242,
            'include' => 'includes/extra/hpm/new_product/buttons/'
        ], ['2.0.1.0', '2.0.2.0', '2.0.2.1', '2.0.2.2', '2.0.3.0', '2.0.4.0', '2.0.4.1', '2.0.4.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-new-product-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => 'includes/modules/new_product.php',
            'hash' => '60474957aa78f0c54260cf807aba2651',
            'line' => 241,
            'include' => 'includes/extra/hpm/new_product/buttons/'
        ], ['2.0.0.0']);

    }
}