<?php

namespace Zantolov\Zamb\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{

    protected $config = array(
        "title" => null,
        "menu" => null,
        "active_menu_item" => null,
        "meta_description" => null,
        "meta_keywords" => null,
        "author" => null,
    );

    /**
     * Initializer.
     *
     * @access   public
     * @return \BaseController
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    /**
     * Setup the layout used by the controller.
     * @param $view
     * @param array $params
     * @return \Illuminate\View\View
     */
    protected function render($view, $params = array())
    {
        return View::make(
            $view,
            $this->config + $params
        );
    }


    public function setParam($key, $value)
    {
        $this->config[$key] = $value;
    }

    public function getParam($key)
    {
        return $this->config[$key];
    }

}