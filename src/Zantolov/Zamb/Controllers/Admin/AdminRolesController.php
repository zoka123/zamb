<?php

namespace Zantolov\Zamb\Controllers\Admin;

use Zantolov\Zamb\Controllers\AdminCRUDController;
use Datatables;
use DB;
use Zantolov\Zamb\Repositories\RoleRepository;

class AdminRolesController extends AdminCRUDController
{

    /**
     * CRUD controller specifics
     */
    protected function afterConstruct()
    {
        parent::afterConstruct();
        $this->repository = new RoleRepository();
        $this->templateRoot = 'zamb::Admin.Roles';
        $this->baseRoute = 'Admin.Roles';
    }


    /**
     * Override with custom params for this method
     * @return Response
     */
    public function getCreate()
    {
        $params = array('permissions' => DB::table('permissions')->lists('display_name', 'id'));
        $this->setParamsForMethod('getCreate', $params);

        return parent::getCreate();
    }


    /**
     * Override with custom params for this method
     * @param int $id
     * @return Response
     */
    public function getEdit($id)
    {
        $params = array('permissions' => DB::table('permissions')->lists('display_name', 'id'));
        $this->setParamsForMethod('getEdit', $params);

        return parent::getEdit($id);
    }

    /**
     * Show a list of all the users formatted for Datatables.
     * @return Datatables JSON
     */
    public function getData()
    {
        $roles = DB::table('roles')->select(array('roles.id', 'roles.name', 'roles.created_at'));

        return Datatables::of($roles)// ->edit_column('created_at','{{{ Carbon::now()->diffForHumans(Carbon::createFromFormat(\'Y-m-d H\', $test)) }}}')

            ->add_column('actions', $this->getActions(array(self::EDIT_ACTION, self::DELETE_ACTION)))->remove_column('id')->make();
    }
}
