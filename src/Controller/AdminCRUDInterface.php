<?php

namespace Zantolov\Zamb\Controller;

interface AdminCRUDInterface
{

    public function getIndex();

    public function getCreate();

    public function postStore();

    public function getShow($id);

    public function getEdit($id);

    public function postUpdate($id);

    public function postDestroy($id);

    public function getData();

} 