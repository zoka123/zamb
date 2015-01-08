<?php

namespace Zantolov\Zamb;

use Route;
use Entrust;
use Redirect;

class Zamb
{

    /**
     * Register default Zamb app routes
     */
    public static function registerAppRoutes()
    {
        // Image output route
        Route::get('image/{variation}/{id}-{filename}', array(
            'as'   => 'image.output',
            'uses' => 'Zantolov\Zamb\Controllers\ImagesController@output'
        ));

        // Static page output default route
        Route::get('{slug}', 'Zantolov\Zamb\Controllers\StaticPagesController@show')->where(array('slug' => '[a-z1-9-]*'));
    }

    /**
     * Register default Admin routes
     */
    public static function registerAdminRoutes()
    {
        Route::model('user', 'User');
        Route::model('permission', 'Permission');
        Route::model('role', 'Role');

        /*
        |--------------------------------------------------------------------------
        | User management routes
        |--------------------------------------------------------------------------
        */
        Route::controller('users', 'Zantolov\Zamb\Controllers\Admin\AdminUsersController', array(
            'getIndex'    => 'Admin.Users.Index',
            'getCreate'   => 'Admin.Users.Create',
            'postStore'   => 'Admin.Users.Store',
            'getShow'     => 'Admin.Users.Show',
            'getEdit'     => 'Admin.Users.Edit',
            'postUpdate'  => 'Admin.Users.Update',
            'getDelete'   => 'Admin.Users.Delete',
            'postDestroy' => 'Admin.Users.Destroy',
            'getData'     => 'Admin.Users.Data',
        ));

        /*
        |--------------------------------------------------------------------------
        | Role management routes
        |--------------------------------------------------------------------------
        */
        Route::controller('roles', 'Zantolov\Zamb\Controllers\Admin\AdminRolesController', array(
            'getIndex'    => 'Admin.Roles.Index',
            'getCreate'   => 'Admin.Roles.Create',
            'postStore'   => 'Admin.Roles.Store',
            'getShow'     => 'Admin.Roles.Show',
            'getEdit'     => 'Admin.Roles.Edit',
            'postUpdate'  => 'Admin.Roles.Update',
            'getDelete'   => 'Admin.Roles.Delete',
            'postDestroy' => 'Admin.Roles.Destroy',
            'getData'     => 'Admin.Roles.Data',
        ));

        /*
        |--------------------------------------------------------------------------
        | Permissions management routes
        |--------------------------------------------------------------------------
        */
        Route::controller('permissions', 'Zantolov\Zamb\Controllers\Admin\AdminPermissionsController', array(
            'getIndex'    => 'Admin.Permissions.Index',
            'getCreate'   => 'Admin.Permissions.Create',
            'postStore'   => 'Admin.Permissions.Store',
            'getShow'     => 'Admin.Permissions.Show',
            'getEdit'     => 'Admin.Permissions.Edit',
            'postUpdate'  => 'Admin.Permissions.Update',
            'getDelete'   => 'Admin.Permissions.Delete',
            'postDestroy' => 'Admin.Permissions.Destroy',
            'getData'     => 'Admin.Permissions.Data',
        ));

        /*
        |--------------------------------------------------------------------------
        | Static Page management routes
        |--------------------------------------------------------------------------
        */
        Route::controller('static-pages', 'Zantolov\Zamb\Controllers\Admin\AdminStaticPagesController', array(
            'getIndex'    => 'Admin.StaticPages.Index',
            'getCreate'   => 'Admin.StaticPages.Create',
            'postStore'   => 'Admin.StaticPages.Store',
            'getShow'     => 'Admin.StaticPages.Show',
            'getEdit'     => 'Admin.StaticPages.Edit',
            'postUpdate'  => 'Admin.StaticPages.Update',
            'getDelete'   => 'Admin.StaticPages.Delete',
            'postDestroy' => 'Admin.StaticPages.Destroy',
            'getData'     => 'Admin.StaticPages.Data',
        ));

        /*
        |--------------------------------------------------------------------------
        | Tags management routes
        |--------------------------------------------------------------------------
        */
        Route::controller('tags', 'Zantolov\Zamb\Controllers\Admin\AdminTagsController', array(
            'getIndex'    => 'Admin.Tags.Index',
            'getCreate'   => 'Admin.Tags.Create',
            'postStore'   => 'Admin.Tags.Store',
            'getShow'     => 'Admin.Tags.Show',
            'getEdit'     => 'Admin.Tags.Edit',
            'postUpdate'  => 'Admin.Tags.Update',
            'getDelete'   => 'Admin.Tags.Delete',
            'postDestroy' => 'Admin.Tags.Destroy',
            'getData'     => 'Admin.Tags.Data',
        ));


        /*
        |--------------------------------------------------------------------------
        | Image routes
        |--------------------------------------------------------------------------
        */
        Route::controller('images', 'Zantolov\Zamb\Controllers\Admin\AdminImagesController', array(
            'getIndex'    => 'Admin.Images.Index',
            'getCreate'   => 'Admin.Images.Create',
            'postStore'   => 'Admin.Images.Store',
            'getShow'     => 'Admin.Images.Show',
            'getEdit'     => 'Admin.Images.Edit',
            'postUpdate'  => 'Admin.Images.Update',
            'getDelete'   => 'Admin.Images.Delete',
            'postDestroy' => 'Admin.Images.Destroy',
            'getData'     => 'Admin.Images.Data',
            'getPopup'    => 'Admin.Images.Popup',
        ));


        // Check for role on all admin routes
        #Entrust::routeNeedsRole('admin*', array('admin'));
        // Check for permissions on admin actions
        #Entrust::routeNeedsPermission('admin/users*', 'manage_users');
        #Entrust::routeNeedsPermission('admin/roles*', 'manage_roles');

    }


    /**
     * Register all API routes
     */
    public static function registerApiRoutes()
    {
        self::registerUserApiRoutes();
    }

    /**
     * Register User Api Routes that are used in authorization and registration
     */
    public static function registerUserApiRoutes()
    {
        Route::controller('api/user', 'Zantolov\Zamb\Controllers\API\UserApiController', array(
            'postLogin'             => 'Api.Login',
            'postRegister'          => 'Api.Register',
            'postForgottenPassword' => 'Api.ForgottenPassword',
            'getCheckUsername'      => 'Api.CheckUsername',
            'getCheckEmail'         => 'Api.CheckEmail',
        ));
    }

    /**
     * Register Zamb specific filters
     */
    public static function registerZambFilters()
    {
        Route::filter('admin_role', function () {
            if (!Entrust::hasRole('admin')) {
                \App::abort(401, 'Not allowed');
            }
        });
    }

    /**
     * Setup acces rules, i.e. routes and filters bindings
     */
    public static function registerAccessRules()
    {
        Route::when('admin/*', 'auth|admin_role');
        Route::when('api/secure/*', 'auth');
    }

}