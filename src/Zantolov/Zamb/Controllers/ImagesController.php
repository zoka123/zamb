<?php

namespace Zantolov\Zamb\Controllers;

use Config;
use InterventionImage;
use Image;
use Exception;

class ImagesController extends \Controller
{

    public function output($variation = 'original', $id, $filename)
    {
        $img = null;

        $filePath = Config::get('zamb.images.path.root') . DIRECTORY_SEPARATOR . $variation . DIRECTORY_SEPARATOR . $filename;
        if (file_exists($filePath)) {
            $img = InterventionImage::make($filePath);
        } else {
            $image = Image::where(array('id' => $id, 'filename' => $filename))->firstOrFail();
            if (Config::get('zamb.images.autocreate')) {
                $img = $this->createVariation($image, $variation);
            }
        }

        if (!is_null($img)) {
            return $img->response('jpg', 70);
        }

        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
    }


    protected function createVariation($image, $variation)
    {
        $im = new \Services\ImageManager();
        if (!$im->variationExists($variation)) {
            throw new Exception('Variation ' . $variation . ' doesn\'t exists');
        }

        $file = $im->create($image, $variation);
        return $file;

    }

}