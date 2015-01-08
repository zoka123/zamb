<?php

namespace Zantolov\Zamb\Models;

use LaravelBook\Ardent\Ardent;


abstract class BaseModel extends Ardent
{
    use BaseModelTrait;


    /**
     * Array with related entities ids
     * eg. 'roles' => array(1,2,3) for related roles
     * @var array
     */
    public $relatedIds = array();

}