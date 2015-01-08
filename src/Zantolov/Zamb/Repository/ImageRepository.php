<?php

namespace Zantolov\Zamb\Repository;

use Image;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageRepository implements RepositoryInterface
{

    public function all()
    {
        return Image::all();
    }

    public function find($id)
    {
        return Image::find($id);
    }

    public function findOrFail($id)
    {
        return Image::findOrFail($id);
    }

    public function destroy($id)
    {
        return Image::destroy($id);
    }

    public function create($input)
    {
        return Image::create($input);
    }

    public function getNew()
    {
        return new Image;
    }

    /**
     * Move uploaded file to temp dir
     *
     * @param UploadedFile $image
     * @return File
     */
    public function moveUploadedFile(UploadedFile $image)
    {
        return $image->move(
            $this->getImageTempDirectory($image),
            $this->getImageTempFilename($image)
        );
    }

    public function getImageTempDirectory(File $image)
    {
        return \Config::get('zamb.images.temp.path');
    }

    public function getImageDirectory(File $image)
    {
        return \Config::get('zamb.images.path');
    }


    /**
     * Returns filename for image based on model ID and original filename
     *
     * @param File $image
     * @param $id
     * @return string
     */
    public function getImageFilename(File $image, $id)
    {
        $filename = 'image';
        $filename .= '_' . $id;

        if (method_exists($image, 'getClientOriginalExtension')) {
            $filename .= '.' . $image->getClientOriginalExtension();
        } else {
            $filename .= '.' . $image->getExtension();
        }

        return $filename;
    }


    /**
     * Returns temp filename for image file
     *
     * @param File $image
     * @return string
     */
    public function getImageTempFilename(File $image)
    {
        $filename = 'image';
        $filename .= '_' . uniqid();

        if (method_exists($image, 'getClientOriginalExtension')) {
            $filename .= '.' . $image->getClientOriginalExtension();
        }

        return $filename;
    }


    /**
     * Move file to original directory and attach it to image model and save
     *
     * @param Image $image
     * @param File $imageFile
     * @throws \Exception
     */
    public function attachImageFileToModel(Image $image, File $imageFile)
    {
        $imageFile = $imageFile->move(
            $this->getImageDirectory($imageFile),
            $this->getImageFilename($imageFile, $image->id)
        );
        $image->filename = $imageFile->getFilename();
        if (!$image->save()) {
            throw new \Exception($image->errors()->toJson());
        }
    }


    /**
     * Create new model and attach temp file
     *
     * @param UploadedFile $uploadedImage
     * @return Image
     */
    public function getNewModelByUploadedFile(UploadedFile $uploadedImage)
    {
        $tempFilename = $this->getImageTempFilename($uploadedImage);

        $image = $this->getNew();
        $image->title = $uploadedImage->getClientOriginalName();
        $image->filename = $tempFilename;

        return $image;
    }


    public function createImageByUploadedFile(UploadedFile $uploadedImage)
    {

        $tempFilename = $this->getImageTempFilename($uploadedImage);
        $imageFile = $uploadedImage->move(
            $this->getImageTempDirectory($uploadedImage),
            $tempFilename
        );

        // Create image model
        $image = $this->getNewModelByUploadedFile($uploadedImage);
        try {
            if (!$image->save()) {
                throw new \Exception($image->errors()->toJson());
            }
        } catch (\Exception $e) {
            $image->delete();
            unlink($imageFile->getPath());

            return null;
        }

        // Move it from temp and update model
        try {
            $this->attachImageFileToModel($image, $imageFile);

        } catch (\Exception $e) {
            $image->delete();
            unlink($imageFile->getPath());

            return null;
        }

        return $image;
    }

}
