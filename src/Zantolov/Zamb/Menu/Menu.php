<?php

namespace Zantolov\Zamb\Menu;

class Menu
{

    protected $menu = array();
    protected $params = array();

    public function getMenu()
    {
        return $this->menu;
    }

    public function addParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    public function addMenuItem(MenuItem $item)
    {
        $this->menu[] = $item;
    }

    public function compose($view)
    {
        $view->with('menu', $this->getMenu());

        // Dynamic menu params injection
        if (is_array($this->params) && !empty($this->params)) {
            foreach ($this->params as $key => $param) {
                $view->with($key, $param);
            }

        }
    }


}