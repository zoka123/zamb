<?php

namespace Zantolov\Zamb\Controller;

Use StaticPage;

class StaticPagesController extends BaseController
{

    public function show($slug = '404')
    {
        $page = StaticPage::where('active', '=', 1)->where('slug', '=', $slug)->first();

        if (empty($page)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Static page not found');
        }

        $this->setParam('page', $page);
        return $this->render('zamb::Site.StaticPages.default');
    }

}