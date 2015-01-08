<?php

namespace Zantolov\Zamb\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class ZambMenuServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->booting(function () {
            $this->setMenuComposers();
        });

    }

    protected function setMenuComposers()
    {
        if (\Config::get('zamb::menu-composers')) {
            $menuBindings = \Config::get('zamb::menu-composers');
            foreach ($menuBindings as $menuView => $class) {
                \View::composer($menuView, $class);
            }
        }

    }

}
