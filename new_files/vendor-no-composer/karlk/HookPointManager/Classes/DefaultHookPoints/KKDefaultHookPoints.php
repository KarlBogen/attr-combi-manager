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
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '68617ac9e3f07e2cffbb68adfd9b4d9f',
            'line' => 665,
            'include' => '/admin/includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.5.1']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '191fcb1e635a9b4ace30e598519f4f32',
            'line' => 665,
            'include' => '/admin/includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.5.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '7c650d5b66f0aea25d24f11cea6d1a35',
            'line' => 652,
            'include' => '/admin/includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.3.0', '2.0.4.0', '2.0.4.1', '2.0.4.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '8ce0fe15badbb3839417e2f19f4cc6b3',
            'line' => 646,
            'include' => '/admin/includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.2.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => 'c97a271942255c4c7a61bf0b0cdc9661',
            'line' => 638,
            'include' => '/admin/includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.2.1']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '56739996fc8651d4b92b0c9f8c71ad31',
            'line' => 638,
            'include' => '/admin/includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.1.0', '2.0.2.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-small-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => 'f67a6809c34e13744ef7070202e6298d',
            'line' => 632,
            'include' => '/admin/includes/extra/hpm/categories_view/small_buttons/'
        ], ['2.0.0.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '68617ac9e3f07e2cffbb68adfd9b4d9f',
            'line' => 1008,
            'include' => '/admin/includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.5.1']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '191fcb1e635a9b4ace30e598519f4f32',
            'line' => 1008,
            'include' => '/admin/includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.5.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '7c650d5b66f0aea25d24f11cea6d1a35',
            'line' => 1005,
            'include' => '/admin/includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.3.0', '2.0.4.0', '2.0.4.1', '2.0.4.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '8ce0fe15badbb3839417e2f19f4cc6b3',
            'line' => 999,
            'include' => '/admin/includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.2.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => 'c97a271942255c4c7a61bf0b0cdc9661',
            'line' => 991,
            'include' => '/admin/includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.2.1']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => '56739996fc8651d4b92b0c9f8c71ad31',
            'line' => 991,
            'include' => '/admin/includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.1.0', '2.0.2.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-categories-view-side-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/categories_view.php',
            'hash' => 'f67a6809c34e13744ef7070202e6298d',
            'line' => 974,
            'include' => '/admin/includes/extra/hpm/categories_view/side_buttons/'
        ], ['2.0.0.0']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-new-product-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/new_product.php',
            'hash' => 'f5bce50f35a1c99224b32cc64fbbfa3f',
            'line' => 242,
            'include' => '/admin/includes/extra/hpm/new_product/buttons/'
        ], ['2.0.5.0', '2.0.5.1']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-new-product-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/new_product.php',
            'hash' => '15f9aa43275bb79818082066abbc1685',
            'line' => 242,
            'include' => '/admin/includes/extra/hpm/new_product/buttons/'
        ], ['2.0.1.0', '2.0.2.0', '2.0.2.1', '2.0.2.2', '2.0.3.0', '2.0.4.0', '2.0.4.1', '2.0.4.2']);

        $hookPointManager->registerHookPoint([
            'name' => 'hpm-default-admin-new-product-buttons',
            'module' => 'robinthehood/hook-point-manager',
            'file' => '/admin/includes/modules/new_product.php',
            'hash' => '60474957aa78f0c54260cf807aba2651',
            'line' => 241,
            'include' => '/admin/includes/extra/hpm/new_product/buttons/'
        ], ['2.0.0.0']);

    }
}