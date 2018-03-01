<?php

namespace DirectoryLister\Controller;

/**
 * Class DirController
 * @package DirectoryLister\Controller
 * @version 0.0.1
 */
class DirController extends Controller
{
    public function __construct()
    {
        if (!function_exists('scandir')) {
            $str = '<h3>关键函数被禁用</h3>';
            $str .= '打开php.ini, 查找<strong>disable_functions</strong>  ';
            $str .= '(<a href="https://blog.flxxyz.com/technology/2018/find-php-ini.html" target="_blank">不知道查找php.ini看这</a>), ';
            $str .= '存在 <strong>scandir</strong>, 则将其去掉, 并重启php服务';
            exit($str);
        }

        $this->start_time = microtime(true);
        $this->config = config('config');
        $this->file_type = config('filetype');
        $this->ignore = $this->config['ignore_list'];
        $this->date_format = $this->config['date_format'];
        $this->root = $this->config['root_path'];
        $this->path = $this->config['data_path'];

        if (!is_dir($this->path)) {
            $str = '<h3>设置的目录不存在</h3>';
            $str .= '请在 <code>站点目录/config/config.php</code> 中, 找到 <strong>data_path</strong> 选项修改为可以显示并存在的目录<br>';
            exit($str);
        }

        $this->ignore[] = '.';  // 永远忽略当前目录

        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
    }

    public function index()
    {
        $path = $this->path;
        $this->ignore[] = '..';  // 首页忽略上级目录
        $root_dir = scandir($path);
        $result = $this->dir($path, $root_dir);

        v('index', [
            'root' => $this->root,
            'data' => $result,
            'time' => $this->run_time(),
        ]);
    }

    public function sub()
    {
        $args = func_get_args();
        $child = array_pop($args);
        $path = "{$this->path}/{$child}";

        // 文件存在直接下载
        if (is_file($path)) {
            $name = pathinfo($path);
            $basename = $name['basename'];

            set_time_limit(0);
            ini_set('memory_limit', '768M');
            header('Content-Description: File Transfer');
            header("Content-type: application/octet-stream");
            $ua = $_SERVER["HTTP_USER_AGENT"];
            $encoded_filename = rawurlencode($basename);
            if (preg_match("/MSIE/", $ua)) {
                header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
            } else if (preg_match("/Firefox/", $ua)) {
                header("Content-Disposition: attachment; filename*=\"utf8''" . $basename . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $basename . '"');
            }

            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header("Content-Length: " . filesize($path));
            ob_clean();
            flush();
            readfile($path);
            exit(0);
        }

        // 目录不存在，返回404
        if (!is_dir($path)) {
            return v('404', [], 404);
        }

        $root_dir = scandir($path);
        $result = $this->dir($path, $root_dir);

        v('index', [
            'root' => $this->root . $child . DS,
            'data' => $result,
            'time' => $this->run_time(),
        ]);
    }

    /**
     * 获取目录文件
     * @param $dir
     * @param $data
     * @return array
     */
    private function dir($dir, $data)
    {
        $result = [];
        foreach ($data as $value) {
            if (!in_array($value, $this->ignore)) {
                $path = "{$dir}/{$value}";
                $time = filectime($path);
                $size = '-';
                $ext = 'fa-folder';
                $is_dir = false;

                if (is_dir($path)) {
                    $is_dir = true;  // 确定是目录
                } else if (is_file($path)) {
                    $ext = $this->file_type['blank'];
                    $size = hex_conver(filesize($path));  // 取文件大小
                    //$md5_file = md5_file($path);
                    //$sha1_file = sha1_file($path);

                    // 判定扩展名输出相应图标
                    $extension = pathinfo($path, PATHINFO_EXTENSION);
                    if (array_key_exists($extension, $this->file_type)) {
                        $ext = $this->file_type[$extension];
                    }
                    unset($extension);
                }

                $result[] = [
                    'is_dir' => $is_dir,
                    'size'   => $size,
                    'time'   => date($this->date_format, $time),  // 按定义格式输出时间
                    'name'   => $value,
                    'ext'    => $ext,
                ];
            }
        }
        unset($root_dir, $value, $dir, $is_dir, $path, $time, $size);  // 清理占用

        return $result;
    }

    /**
     * 获取代码运行时长
     * @return string
     */
    private function run_time()
    {
        return round((microtime(true) - $this->start_time) * 1000, 2) . 'ms';
    }
}