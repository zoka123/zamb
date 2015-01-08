<?php

namespace Zantolov\Zamb\Controllers\Admin;

use Zantolov\Zamb\Controllers\AdminCRUDController;
use Datatables;
use DB;
use Zantolov\Zamb\Repositories\PermissionRepository;


class AdminPermissionsController extends AdminCRUDController
{

    /**
     * CRUD controller specifics
     */
    protected function afterConstruct()
    {
        parent::afterConstruct();
        $this->repository = new PermissionRepository();
        $this->templateRoot = 'zamb::Admin.Permissions';
        $this->baseRoute = 'Admin.Permissions';
    }


    /**
     * Show a list of all the users formatted for Datatables.
     * @return Datatables JSON
     */
    public function getData()
    {
        $roles = DB::table('permissions')->select(array('permissions.id', 'permissions.display_name', 'permissions.name', 'permissions.created_at'));

        return Datatables::of($roles)->add_column('actions', $this->getActions(array(self::EDIT_ACTION, self::DELETE_ACTION)))->remove_column('id')->make();
    }
}
