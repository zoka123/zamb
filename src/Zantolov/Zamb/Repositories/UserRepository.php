<?php

namespace Zantolov\Zamb\Repositories;

use User;

class UserRepository implements RepositoryInterface
{

    public function all()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function findOrFail($id)
    {
        return User::findOrFail($id);
    }

    public function destroy($id)
    {
        return User::destroy($id);
    }

    public function create($input)
    {
        return User::create($input);
    }

    public function getNew()
    {
        return new User;
    }
}
