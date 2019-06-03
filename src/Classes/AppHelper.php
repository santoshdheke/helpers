<?php
namespace SsGroup\Helper\Classes;

use Illuminate\Http\Response;

class AppHelper
{

    // define variable
    private $module;
    private $viewPath;
    private $title;
    private $baseRoute;
    private $folderPath;

    /**
     * set module value
     *
     * @param $value
     */
    public function setModule($value)
    {
        $this->module = $value;
    }

    public function test()
    {
        return 'its work';
    }

    /**
     * get module
     *
     * @return mixed
     */
    public function getModule($value = null)
    {
        $module = $this->module;
        if (isset($value)) {
            $module .= '.' . $value;
        }
        return $module;
    }

    /**
     * set folderPath value
     *
     * @param $value
     */
    public function setFolderPath($value)
    {
        $this->folderPath = $value;
    }

    /**
     * get folderPath
     *
     * @return mixed
     */
    public function getFolderPath($value = null)
    {
        $folderPath = $this->folderPath;
        if (isset($value)) {
            $folderPath .= '/' . $value;
        }
        return $folderPath;
    }

    /**
     * set baseRoute value
     *
     * @param $value
     */
    public function setBaseRoute($value)
    {
        $this->baseRoute = $value;
    }

    /**
     * get baseRoute
     *
     * @return mixed
     */
    public function getBaseRoute($value = null)
    {
        $baseRoute = $this->baseRoute;
        if (isset($value)) {
            $baseRoute .= '.' . $value;
        }
        return $baseRoute;
    }

    /**
     * set view Path value
     *
     * @param $value
     */
    public function setViewPath($value)
    {
        $this->viewPath = $value;
    }

    /**
     * get view path
     *
     * @return mixed
     */
    public function getViewPath($value = null)
    {
        $viewPath = $this->viewPath;
        if (isset($value)) {
            $viewPath .= '.' . $value;
        }
        return $viewPath;
    }

    /**
     * set title value
     *
     * @param $value
     */
    public function setTitle($value)
    {
        $this->title = $value;
    }

    /**
     * get singular title
     *
     * @return mixed
     */
    public function getTitle($value = null)
    {
        $title = $this->title;
        if (isset($value)) {
            $title .= ' ' . $value;
        }
        return ucwords($title);
    }

    /**
     * get plular title
     *
     * @return mixed
     */
    public function getTitles($value = null)
    {
        $title = $this->title;
        if (isset($value)) {
            $title .= ' ' . $value;
        }
        return ucwords(str_plural($title));
    }

    public function fileUpload($image)
    {
        $fileName = uniqid(rand(0000, 9999)) . '.' . $image->getClientOriginalExtension();
        $image->move($this->folderPath, $fileName);
        return $fileName;
    }

    public function deleteImage($image)
    {
        if (file_exists($this->folderPath . $image) && $image != null) {
            unlink($this->folderPath . $image);
        }
    }

    public function setSession($lang = null)
    {
        if ($lang) {
            session()->put('locale', $lang);
        } else if (!session()->get('locale')) {
            session()->put('locale', 'en');
        }
        return session()->get('locale');
    }

    public function message(bool $error, string $message, int $status)
    {
        $response['error'] = $error;
        $response['message'] = $message;
        $response['status_code'] = $status;

        return $response;
    }

    public function useOtherErrorMessage()
    {
        return $this->message(true, $this->title . 'use on child.', Response::HTTP_FORBIDDEN);
    }

    public function createMessage()
    {
        return $this->message(false, $this->title . ' Create Successful', Response::HTTP_CREATED);
    }

    public function updateMessage()
    {
        return $this->message(false, $this->title . ' Update Successful', Response::HTTP_RESET_CONTENT);
    }

    public function deleteMessage()
    {
        return $this->message(false, $this->title . ' Delete Successful', Response::HTTP_OK);
    }

    public function returnBack($result)
    {
        if ($result['error']) {
            $error_message = $result['message'];
            $status = $result['status_code'];
            return view('error', compact('error_message', 'status'));
        } else {
            return redirect()->back()->with('success', $result['message']);
        }
    }

    public function returnRoute($route,$result)
    {
        if ($result['error']) {
            return view('error', $result);
        } else {
            return redirect()->route($route)->with('success', $result['message']);
        }
    }


}