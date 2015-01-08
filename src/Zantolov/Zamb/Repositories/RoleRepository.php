<?php

namespace Zantolov\Zamb\Repositories;

use Role;

class RoleRepository implements RepositoryInterface
{

    public function all()
    {
        return Role::all();
    }

    public function find($id)
    {
        return Role::find($id);
    }

    public function findOrFail($id)
    {
        return Role::findOrFail($id);
    }

    public function destroy($id)
    {
        return Role::destroy($id);
    }

    public function create($input)
    {
        return Role::create($input);
    }

    public function getNew()
    {
        return new Role;
    }
}
