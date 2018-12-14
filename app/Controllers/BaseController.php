<?php

namespace App\Controllers;


use Col\Controller;

class BaseController extends Controller
{
    public function ajax($message = '', $data = [], $ajax = 'json', $code = 200)
    {
        $result = array_merge([
            'message'    => $message,
            'state'      => $code,
            'query_time' => run_time(),
        ], $data);

        return $this->$ajax($result);
    }
}