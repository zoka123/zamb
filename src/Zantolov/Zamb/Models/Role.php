<?php

namespace Zantolov\Zamb\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    use BaseModelTrait;

    public static $rules = array(
        'name' => 'required|between:4,128|unique:roles'
    );

    protected $fillable = array('name');

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    public $relatedIds = array(
        'perms' => array()
    );

    /* RELATED MODELS START */
    /**********************/
    public function permsLoadIds()
    {
        $this->relatedIds['perms'] = $this->perms()->lists('permission_id');
    }

    public function permsSave($permissions)
    {
        $this->perms()->sync($permissions);
    }
    /**********************/
    /* RELATED MODELS END */


}
