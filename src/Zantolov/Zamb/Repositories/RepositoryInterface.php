<?php

namespace Zantolov\Zamb\Repositories;

interface RepositoryInterface
{
    public function all();

    public function find($id);

    public function findOrFail($id);

    public function destroy($id);

    public function create($input);

    public function getNew();

}