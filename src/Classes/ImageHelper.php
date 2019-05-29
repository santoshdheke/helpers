<?php
namespace SsGroup\Helper\Classes;

use Image;
use Intervention\Image\ImageManager;

class ImageHelper extends ImageManager
{
    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $upload_path;

    /**
     * @var null
     */
    private $thumbnails = null;

    /**
     * @param String
     * @param null || Array $thumbnails
     */
    public function folder($module, $thumbnails = null)
    {
        $this->module = $module;
        $this->upload_path = public_path(config('image.upload_folder').'/');
        if (!file_exists($this->upload_path . $this->module)) {
            mkdir($this->upload_path . $this->module, 0755, true);
        }
        if ($thumbnails) {
            $this->thumbnails = $thumbnails;
            foreach ($thumbnails as $key => $thumbnail) {
                if (!file_exists($this->upload_path . $this->module . '/thumbnails' . '/' . $thumbnail)) {
                    mkdir($this->upload_path . $this->module . '/thumbnails' . '/' . $thumbnail, 0755, true);
                }
            }
        }
    }

    /**
     * @param $image
     * @return string
     */
    public function saveImage($image)
    {
        $folder = $this->module;
        $ext = $image->getClientOriginalExtension();
        $real_filename = $image->getClientOriginalName();
        $image = $this->make($image);
        $filename = substr(md5($real_filename . time()), 0, 16) . '.' . $ext;
        $image->save($this->upload_path . $folder . '/' . $filename);

        if ($this->thumbnails) {
            foreach ($this->thumbnails as $key => $thumbnail) {
                Image::make($image)->resize(config('image.thumbnail.' . $thumbnail . '.w', 100), config('image.thumbnail.' . $thumbnail . '.h', 100))
                    ->save($this->upload_path . $this->module . '/thumbnails' . '/' . $thumbnail . '/' . $filename);
            }
        }
        return $filename;
    }

    /**
     * @param $filename
     */
    public function deleteImage($filename)
    {
        $folders = [''];
        if ($this->thumbnails) {
            foreach ($this->thumbnails as $key => $thumbnail) {
                array_push($folders, 'thumbnails/' . $thumbnail . '/');
            }
        } else {
            $folders = ['', 'thumbnails/'];
        }
        foreach ($folders as $folder) {
            $filePath = $this->upload_path . $this->module . "/$folder" . $filename;
            if (file_exists($filePath) && (!empty($filename))) {
                unlink($this->upload_path . $this->module . "/$folder" . $filename);
            }
        }
    }
}