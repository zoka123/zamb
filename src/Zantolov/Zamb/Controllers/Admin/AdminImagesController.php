<?php

namespace Zantolov\Zamb\Controllers\Admin;

use Datatables;
use DB;
use Input;
use Redirect;
use Image;
use Zantolov\Zamb\Repositories\ImageRepository;

class AdminImagesController extends \Zantolov\Zamb\Controllers\AdminCRUDController
{

    /**
     * CRUD controller specifics
     */
    protected function afterConstruct()
    {
        parent::afterConstruct();
        $this->repository = new ImageRepository();
        $this->templateRoot = 'zamb::Admin.Images';
        $this->baseRoute = 'Admin.Images';
    }


    /**
     * Show a list of all the users formatted for Datatables.
     * @return Datatables JSON
     */
    public function getData()
    {
        $items = DB::table('images')->select(array('images.id', 'images.id as filename', 'images.title', 'images.created_at'));

        return Datatables::of($items)->add_column('actions', $this->getActions(array(self::EDIT_ACTION, self::DELETE_ACTION)))->edit_column('filename',
                '<img src="{{{ \Helpers\ImageHelper::getImageUrlById($id, \'thumbnail\') }}}" />')//->remove_column('id')
            ->make();
    }


    /**
     * Store a newly created user in storage.
     * @return Response
     */
    public function postStore()
    {
        $model = $this->repository->getNew();

        $file = Input::file('file');
        if (empty($file)) {
            /** @var \Image $model */
            $model->errors()->add('file', 'File not chosen');

            return Redirect::back()->withErrors($model->errors())->withInput();
        } else {
            $model = $this->repository->getNewModelByUploadedFile($file);
        }

        if ($model->updateUniques()) {
            $this->repository->attachImageFileToModel($model, $file);
            $this->processRelatedEntities($model);

            return \Illuminate\Http\Response::create($this->getSuccessJSResponse());
        } else {
            dd($model->errors());

            return Redirect::back()->withErrors($model->errors())->withInput();
        }
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

        $file = Input::file('file');
        if (!empty($file)) {
            $im = new \Services\ImageManager();
            $im->deleteFiles($model);

            $imageFile = $this->repository->moveUploadedFile($file);
            $this->repository->attachImageFileToModel($model, $imageFile);
        }

        if ($model->updateUniques()) {
            $this->processRelatedEntities($model);

            return \Illuminate\Http\Response::create($this->getSuccessJSResponse());
        } else {
            return Redirect::back()->withErrors($model->errors())->withInput();
        }
    }


    public function getPopup()
    {
        $images = Image::all();

        return $this->render('zamb::Admin.Images.popup', compact('images'));
    }

}