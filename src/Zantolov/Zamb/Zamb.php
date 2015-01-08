<?php

namespace Zantolov\Zamb;

use Route;
use Entrust;
use Redirect;

class Zamb
{

    public static function registerPublicRoutes()
    {
        // Image output route
        Route::get('image/{variation}/{id}-{filename}', array(
            'as'   => 'image.output',
            'uses' => 'Zantolov\Zamb\Controller\ImagesController@output'
        ));

        // Static page output default route
        Route::get('{slug}', 'Zantolov\Zamb\Controller\StaticPagesController@show')->where(array('slug' => '[a-z1-9-]*'));

    }

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
        Route::controller('users', 'Zantolov\Zamb\Controller\Admin\AdminUsersController', array(
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
        Route::controller('roles', 'Zantolov\Zamb\Controller\Admin\AdminRolesController', array(
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
        Route::controller('permissions', 'Zantolov\Zamb\Controller\Admin\AdminPermissionsController', array(
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
        Route::controller('static-pages', 'Zantolov\Zamb\Controller\Admin\AdminStaticPagesController', array(
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
        Route::controller('tags', 'Zantolov\Zamb\Controller\Admin\AdminTagsController', array(
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
        Route::controller('images', 'Zantolov\Zamb\Controller\Admin\AdminImagesController', array(
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
        Entrust::routeNeedsRole('admin*', array('admin'), function () {
            Redirect::guest(route('Public.Login'));
        });

        // Check for permissions on admin actions
        #Entrust::routeNeedsPermission('admin/users*', 'manage_users');
        #Entrust::routeNeedsPermission('admin/roles*', 'manage_roles');

    }

    public static function registerUserApiRoutes()
    {
        Route::controller('api/user', 'Zantolov\Zamb\Controller\API\UserApiController', array(
            'postLogin'             => 'Api.Login',
            'postRegister'          => 'Api.Register',
            'postForgottenPassword' => 'Api.ForgottenPassword',
            'getCheckUsername'      => 'Api.CheckUsername',
            'getCheckEmail'         => 'Api.CheckEmail',
        ));
    }

}