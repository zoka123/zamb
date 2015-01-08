<?php

namespace Zantolov\Zamb\Models;

class Tag extends BaseModel
{
    protected $table = 'tags';
    public static $rules = array(
        'name' => 'required|between:2,128|unique'
    );

    protected $fillable = array('name');

    public $autoHydrateEntityFromInput = true;    // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

    public function taggable()
    {
        return $this->morphTo();
    }

    public function products()
    {
        return $this->morphedByMany('Product', 'taggable');
    }
}
