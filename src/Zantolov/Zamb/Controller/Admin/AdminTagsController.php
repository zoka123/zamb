<?php

namespace Zantolov\Zamb\Controller\Admin;

use Zantolov\Zamb\Controller\AdminCRUDController;
use Datatables;
use DB;
use Zantolov\Zamb\Repository\TagRepository;

class AdminTagsController extends AdminCRUDController
{

    /**
     * CRUD controller specifics
     */
    protected function afterConstruct()
    {
        parent::afterConstruct();
        $this->repository = new TagRepository();
        $this->templateRoot = 'zamb::Admin.Tags';
        $this->baseRoute = 'Admin.Tags';
    }

    /**
     * Show a list of all the users formatted for Datatables.
     * @return Datatables JSON
     */
    public function getData()
    {
        $items = DB::table('tags')->select(array('id', 'name'));

        return Datatables::of($items)// ->edit_column('created_at','{{{ Carbon::now()->diffForHumans(Carbon::createFromFormat(\'Y-m-d H\', $test)) }}}')
            ->add_column('actions', $this->getActions(array(self::EDIT_ACTION, self::DELETE_ACTION)))->remove_column('id')->make();
    }
}
