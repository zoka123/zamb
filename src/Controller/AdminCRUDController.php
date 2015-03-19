<?php

namespace Zantolov\Zamb\Controller;

use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
Use \Response;
Use \Redirect;
Use \Lang;
Use \Url;
Use \Input;

abstract class AdminCRUDController extends AdminController implements AdminCRUDInterface
{

    // Action codes
    const CREATE_ACTION = 'action.create';
    const DELETE_ACTION = 'action.delete';
    const EDIT_ACTION = 'action.edit';

    protected $model = null;

    /**
     * Repository that CRUD Controller will use for Model operations
     * @var \Repository\RepositoryInterface
     */
    protected $repository = null;


    /**
     * Base template path that is root for other templates (index, create_update etc)
     * @var string
     */
    protected $templateRoot = null;


    /**
     * Base route path that is root for route URL generation
     * @var string
     */
    protected $baseRoute = null;


    /**
     * Array where key is method name and value is array with additional params
     * @var array
     */
    protected $params = array();


    public function __construct()
    {
        $this->beforeConstruct();
        parent::__construct();

        $this->setParam('title', 'Administration');
        $this->setParam('menu', new \Zamb\Menu\AdminMenu());

        //After construct events
        $this->afterConstruct();
    }


    /**
     * Define CRUD Controller specifics such as base paths and routes and repository classes
     */
    protected function beforeConstruct()
    {
        // For inheritance
    }


    protected function afterConstruct()
    {
        // For inheritance
    }

    /**
     * If we want to override params that method will forward to template, we save it here with method name.
     * Each method first try to load its params
     * @param $methodName
     * @return array
     */
    protected function getParamsForMethod($methodName)
    {
        if (!empty($this->params[$methodName])) {
            return $this->params[$methodName];
        } else {
            return array();
        }
    }


    /**
     * Set params for method that method will forward to template
     * @param $methodName
     * @param $params
     */
    protected function setParamsForMethod($methodName, $params)
    {
        $this->params[$methodName] = $params;
    }


    /**
     * Display a listing of model rows
     * @return Response
     */
    public function getIndex()
    {
        $params = $this->getParamsForMethod('getIndex');

        return $this->render($this->templateRoot . '.index', $params);
    }


    /**
     * Show the form for creating a new model
     * @return Response
     */
    public function getCreate()
    {
        $model = $this->repository->getNew();
        $params = $this->getParamsForMethod('getCreate');
        $params += compact('model');

        return $this->render($this->templateRoot . '.create_update', $params);
    }


    /**
     * Store a newly created model in storage.
     * @return Response
     */
    public function postStore()
    {
        $model = $this->repository->getNew();
        if ($model->updateUniques()) {
            $this->processRelatedEntities($model);

            return \Illuminate\Http\Response::create($this->getSuccessJSResponse());
        } else {
            return Redirect::back()->withErrors($model->errors())->withInput();
        }
    }


    /**
     * Display the specified model
     *
     * @param  int $id
     * @return Response
     */
    public function getShow($id)
    {
        $model = $this->repository->findOrFail($id);
        $params = $this->getParamsForMethod('getShow');
        $params += compact('model');

        return $this->render($this->templateRoot . '.show', $params);
    }


    /**
     * Show the form for editing the specified model.
     *
     * @param  int $id
     * @return Response
     */
    public function getEdit($id)
    {
        $model = $this->repository->findOrFail($id);
        $params = $this->getParamsForMethod('getEdit');
        $params += compact('model');;

        return $this->render($this->templateRoot . '.create_update', $params);
    }


    /**
     * Update the specified model in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function postUpdate($id)
    {
        $model = $this->repository->findOrFail($id);
        if ($model->updateUniques()) {
            $this->processRelatedEntities($model);

            return \Illuminate\Http\Response::create($this->getSuccessJSResponse());
        } else {
            return Redirect::back()->withErrors($model->errors())->withInput();
        }
    }


    /**
     * Renders delete confirmation form
     * @param $id
     * @return \Illuminate\View\View
     */
    public function getDelete($id)
    {
        $model = $this->repository->findOrFail($id);
        $params = $this->getParamsForMethod('getDelete');
        $params += compact('model');

        return $this->render($this->templateRoot . '.delete', $params);
    }


    /**
     * Remove the specified model instance from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function postDestroy($id)
    {
        try {
            $this->repository->destroy($id);
        } catch (QueryException $e) {
            return Redirect::back()->with('error', 'Object can\'t be deleted since it is used elsewhere');
        }

        $params = $this->getParamsForMethod('postDestroy');

        return \Illuminate\Http\Response::create($this->getSuccessJSResponse());
    }


    /**
     * Get action buttons method renders action buttos
     * @param $actions
     * @return string
     */
    protected function getActions($actions)
    {
        $return = '';
        foreach ($actions as $action) {
            switch ($action) {
                case self::CREATE_ACTION:
                    $return .= '<a href="' . URL::route($this->baseRoute . '.Create') . '" class="btn-sm btn btn-primary"><i class="fa fa-plus"></i></a>';
                    break;
                case self::EDIT_ACTION:
                    $return .= '<button data-toggle="iframe-modal"  data-iframe-src="' . URL::route($this->baseRoute . '.Edit') . '/{{{ $id }}}" class="btn-sm btn btn-primary"><i class="fa fa-edit"></i></button>';
                    break;
                case self::DELETE_ACTION:
                    $return .= '<button data-toggle="iframe-modal"  data-iframe-src="' . URL::route($this->baseRoute . '.Delete') . '/{{{ $id }}}" class="btn-sm btn btn-primary"><i class="fa fa-trash"></i></button>';
                    break;
            }
        }

        return $return;
    }


    /**
     * Iterate over all related entities and update
     * @param $model
     */
    protected function processRelatedEntities($model)
    {
        if (!is_array($model->relatedIds)) {
            return;
        }

        $relatedEntities = array_keys($model->relatedIds);
        if (!empty($relatedEntities)) {
            foreach ($relatedEntities as $property) {
                $values = Input::get($property);
                $model->relatedIds[$property] = $values;
            }
        }

        $model->saveRelated($model->relatedIds);
    }


    /**
     * Return JS snippet that will close modal and update table
     * @return string
     */
    protected function getSuccessJSResponse()
    {
        return '<script>parent.app.CRUDUpdated("' . Lang::get('notification.crud.success') . '");</script>';
    }


    /**
     * Return JS snippet that will close modal and update table
     * @return string
     */
    protected function getErrorJSResponse()
    {
        return '<script>parent.app.CRUDUpdated("' . Lang::get('notification.crud.error') . '");</script>';
    }


    /**
     * @param $roles
     */
    public function checkForRoles($roles, $type = 'ANY')
    {
        if (!is_array($roles)) {
            $roles = array($roles);
        }

        foreach ($roles as $role) {
            if ('ANY' == $type && \Entrust::hasRole($role)) {
                return;
            }

            if ('ALL' == $type && !\Entrust::hasRole($role)) {
                throw new AccessDeniedHttpException;
            }
        }

        throw new AccessDeniedHttpException;
    }

}
