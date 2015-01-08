<?php

namespace Zantolov\Zamb;

use Route;

class Zamb
{

    public function helloWorld()
    {
        dd("Hello World");
    }

    public static function staticHelloWorld()
    {
        dd("Static Hello World");
    }

    public static function registerUserApiRoutes()
    {
        Route::controller('api', 'Zantolov\Zamb\Controller\Api\UserApiController', array(
            'postLogin' => 'Api.Login',
            'postRegister' => 'Api.Register',
            'postForgottenPassword' => 'Api.ForgottenPassword',
            'getCheckUsername' => 'Api.CheckUsername',
            'getCheckEmail' => 'Api.CheckEmail',
        ));
    }

}