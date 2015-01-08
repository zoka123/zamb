<?php

namespace Zantolov\Zamb\Repositories;

use Tag;

class TagRepository implements RepositoryInterface
{

    public function all()
    {
        return Tag::all();
    }

    public function find($id)
    {
        return Tag::find($id);
    }

    public function findOrFail($id)
    {
        return Tag::findOrFail($id);
    }

    public function destroy($id)
    {
        return Tag::destroy($id);
    }

    public function create($input)
    {
        return Tag::create($input);
    }

    public function getNew()
    {
        return new Tag;
    }
}
