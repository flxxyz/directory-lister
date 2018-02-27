<?php

namespace DirectoryLister\Controller;

class DirController extends Controller
{
    public function __construct()
    {
        $this->config = config('config');
        $this->ignore = $this->config['ignore_list'];
        $this->date_format = $this->config['date_format'];
        $this->root = $this->config['root_path'];
        $this->path = $this->config['data_path'];
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
    }

    public function index()
    {
        $path = $this->path;
        $this->ignore[] = '..';
        $root_dir = scandir($path);
        $result = $this->dir($path, $root_dir);

        v('index', [
            'root' => $this->root,
            'data' => $result,
        ]);
    }

    public function sub()
    {
        $args = func_get_args();
        var_dump($args);
        exit(0);
        $child = array_pop($args);
        $name = array_pop($args);
        $path = "{$this->path}/{$child}";

        if (is_file($path)) {
            header("Content-type: application/octet-stream");
            $ua = $_SERVER["HTTP_USER_AGENT"];
            $encoded_filename = rawurlencode($name);
            if (preg_match("/MSIE/", $ua)) {
                header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
            } else if (preg_match("/Firefox/", $ua)) {
                header("Content-Disposition: attachment; filename*=\"utf8''" . $name . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $good_name . '"');
            }

            header("Content-Length: ". filesize($path));
            readfile($path);
            exit(0);
        }

        if (!is_dir($path)) {
            return v('404', [], 404);
        }

        $root_dir = scandir($path);
        $result = $this->dir($path, $root_dir);
        v('index', [
            'root' => $this->root . $child . DS,
            'data' => $result,
        ]);
    }

    private function dir($dir, $data)
    {
        $result = [];
        foreach ($data as $value) {
            if (!in_array($value, $this->ignore)) {
                $path = "{$dir}/{$value}";
                $time = filemtime($path);
                $size = '-';
                $is_dir = false;

                if (is_dir($path)) {
                    $is_dir = true;
                } else if (is_file($path)) {
                    $size = filesize($path);
                }

                $result[] = [
                    'is_dir' => $is_dir,
                    'size'   => $size,
                    'time'   => date($this->date_format, $time),
                    'name'   => $value,
                ];
            }
        }
        unset($root_dir, $value, $dir);

        return $result;
    }
}