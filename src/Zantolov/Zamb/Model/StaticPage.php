<?php

namespace Zantolov\Zamb\Model;

use LaravelBook\Ardent\Ardent;

/**
 * Class StaticPage
 *
 * @property int $id
 * @property string $title
 * @property string  $body
 * @property boolean $active
 * @property int $author_id
 * @property string $slug
 * @property string $menu_caption
 */
class StaticPage extends Ardent
{
    use BaseModelTrait;

    public static $rules = array(
        'title'        => 'required|between:3,255',
        'body'         => 'required|min:3',
        'active'       => 'required',
        'slug'         => 'alpha_dash|unique',
        'menu_caption' => 'alpha_dash',
    );

    protected $table = 'static_pages';
    protected $fillable = array('body', 'title', 'active', 'slug', 'menu-caption');

    public $autoHydrateEntityFromInput = true; // hydrates on new entries' validation
    public $forceEntityHydrationFromInput = true; // hydrates whenever validation is called

}
