<?php

namespace DirectoryLister\Controller;

use Col\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct()
    {
        $this->request = $this->request();
    }

    /**
     * post请求返回参数
     * @return mixed
     */
    public function body()
    {
        return $this->request['body'];
    }

    /**
     * get请求返回参数
     * @return mixed
     */
    public function query()
    {
        return $this->request['query'];
    }

    public function is_post()
    {
        return ($this->request->method === 'POST') ? true : false;
    }

    public function is_get()
    {
        return ($this->request->method === 'GET') ? true : false;
    }
}