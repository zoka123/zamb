<?php

namespace Zantolov\Zamb\Controller\Admin;

use Zantolov\Zamb\Controller\AdminCRUDController;
use Datatables;
use DB;
use Input;
use Redirect;
use User;
use Zantolov\Zamb\Repository\UserRepository;

class AdminUsersController extends AdminCRUDController
{

    /**
     * Set CRUD Controller specifics
     */
    protected function afterConstruct()
    {
        parent::afterConstruct();
        $this->repository = new UserRepository();
        $this->templateRoot = 'zamb::Admin.Users';
        $this->baseRoute = 'Admin.Users';
    }

    /**
     * Override with custom params for this method
     * @return Response
     */
    public function getCreate()
    {
        $params = array('roles' => DB::table('roles')->lists('name', 'id'));
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
        $params = array('roles' => DB::table('roles')->lists('name', 'id'));
        $this->setParamsForMethod('getEdit', $params);

        return parent::getEdit($id);
    }


    /**
     * Show a list of all the users formatted for Datatables.
     * @return Datatables JSON
     */
    public function getData()
    {

        $users = DB::table('users')->leftjoin('assigned_roles', 'assigned_roles.user_id', '=', 'users.id')->leftjoin('roles', 'roles.id', '=',
            'assigned_roles.role_id')->select(DB::raw('users.id, users.username, users.email, GROUP_CONCAT(DISTINCT roles.name) as rolename, users.confirmed, users.created_at as created_at'))->groupBy('users.username');

        $actions = $this->getActions(array(self::EDIT_ACTION, self::DELETE_ACTION));

        return Datatables::of($users)// ->edit_column('created_at','{{{ Carbon::now()->diffForHumans(Carbon::createFromFormat(\'Y-m-d H\', $test)) }}}')
        ->edit_column('confirmed', '{{ DataTableHelper::prepareBooleanColumn($confirmed) }}')->add_column('actions', $actions)->remove_column('id')->make();
    }


    /**
     * Update the specified model in storage.
     * Override because of logic with modifying passwords
     * @param  int $id
     * @return Response
     */
    public function postUpdate($id)
    {
        /** @var User $model */
        $model = $this->repository->findOrFail($id);

        $model->autoHydrateEntityFromInput = false;
        $model->forceEntityHydrationFromInput = false;

        $model->fill(Input::except(array('password')));

        $password = Input::get('password');
        if (empty($password)) {
            $model->password_confirmation = $model->password;
        } else {
            $model->password = Input::get('password');
        }

        if ($model->updateUniques(User::$updateRules)) {
            $this->processRelatedEntities($model);

            return \Illuminate\Http\Response::create($this->getSuccessJSResponse());
        } else {
            return Redirect::back()->withErrors($model->errors())->withInput();
        }
    }

}
