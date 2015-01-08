<?php

namespace Zantolov\Zamb\Repository;

use StaticPage;

class StaticPageRepository implements RepositoryInterface
{

    public function all()
    {
        return StaticPage::all();
    }

    public function find($id)
    {
        return StaticPage::find($id);
    }

    public function findOrFail($id)
    {
        return StaticPage::findOrFail($id);
    }

    public function destroy($id)
    {
        return StaticPage::destroy($id);
    }

    public function create($input)
    {
        return StaticPage::create($input);
    }

    public function getNew()
    {
        return new StaticPage;
    }
}
