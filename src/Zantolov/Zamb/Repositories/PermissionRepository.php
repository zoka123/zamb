<?php

namespace Zantolov\Zamb\Repositories;

use Permission;

class PermissionRepository implements RepositoryInterface
{

    public function all()
    {
        return Permission::all();
    }

    public function find($id)
    {
        return Permission::find($id);
    }

    public function findOrFail($id)
    {
        return Permission::findOrFail($id);
    }

    public function destroy($id)
    {
        return Permission::destroy($id);
    }

    public function create($input)
    {
        return Permission::create($input);
    }

    public function getNew()
    {
        return new Permission;
    }
}
