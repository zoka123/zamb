<?php

namespace Zantolov\Zamb\Controllers;

class AdminController extends BaseController
{

    protected $model = null;
    protected $templateRoot = null;


    /**
     * Initializer.
     *
     * @return \AdminController
     */
    public function __construct()
    {
        parent::__construct();
        $this->setParam('title', 'Administration');

        $this->afterConstruct();
    }



    protected function afterConstruct()
    {

    }



}