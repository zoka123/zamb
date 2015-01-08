<?php

namespace Zantolov\Zamb\Controllers\Admin;

use Zantolov\Zamb\Controllers\AdminCRUDController;
use Datatables;
use DB;
use Zantolov\Zamb\Repositories\StaticPageRepository;

class AdminStaticPagesController extends AdminCRUDController
{

    /**
     * CRUD controller specifics
     */
    protected function afterConstruct()
    {
        parent::afterConstruct();
        $this->repository = new StaticPageRepository();
        $this->templateRoot = 'zamb::Admin.StaticPages';
        $this->baseRoute = 'Admin.StaticPages';
    }

    /**
     * Show a list of all the users formatted for Datatables.
     * @return Datatables JSON
     */
    public function getData()
    {
        $items = DB::table('static_pages')->select(array('id', 'title', 'active', 'created_at'));

        return Datatables::of($items)
            // ->edit_column('created_at','{{{ Carbon::now()->diffForHumans(Carbon::createFromFormat(\'Y-m-d H\', $test)) }}}')
            ->edit_column('active', '{{ DataTableHelper::prepareBooleanColumn($active) }}')
            ->add_column('actions', $this->getActions(array(self::EDIT_ACTION, self::DELETE_ACTION)))
            ->remove_column('id')
            ->make();
    }
}
