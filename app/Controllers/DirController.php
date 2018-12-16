<?php

namespace App\Controllers;

use Col\Lib\Config;
use Col\Request;

/**
 * Class DirController
 * @package DirectoryLister\Controller
 * @version 0.0.3
 */
class DirController extends BaseController
{
    private $file_type = [];

    private $storage = 'local';

    private $ignore = [];

    private $date_format = 'Y-m-d H:i:s';

    private $root = '/';

    private $path = '/';

    public function __construct()
    {
        if ( !function_exists('scandir')) {
            $str = '<h3>关键函数被禁用</h3>';
            $str .= '打开php.ini, 查找<strong>disable_functions</strong>  ';
            $str .= '(<a href="https://blog.flxxyz.com/technology/2018/find-php-ini.html" target="_blank">不知道查找php.ini看这</a>), ';
            $str .= '存在 <strong>scandir</strong>, 则将其去掉, 并重启php服务';
            exit($str);
        }

        $this->file_type = Config::get('filetype');
        $this->storage = Config::get('other', 'storage');
        $this->ignore = Config::get('other', 'ignore_list');
        $this->date_format = Config::get('other', 'date_format');
        $this->root = Config::get('other', 'root_path');
        $this->path = Config::get('other', 'data_path');

        if ( !is_dir($this->path)) {
            $str = '<h3>设置的目录不存在</h3>';
            $str .= '请在 <code>站点目录/config/config.php</code> 中, 找到 <strong>data_path</strong> 选项修改为可以显示并存在的目录<br>';
            exit($str);
        }

        $this->ignore[] = '.';  // 永远忽略当前目录
    }

    public function index(Request $request)
    {
        $path = $request->get('path', null);
        $ajax = $request->get('ajax', null);
        $down = $request->get('down', null);
        $name = $request->get('name', null);
        if (is_null($path) || $path == '') {
            $this->ignore[] = '..';  // 首页忽略上级目录
        }

        $result = [];
        switch ($this->storage) {
            case 'local':
                $storage = '本地';
                $result = $this->local($path, $down, $name);
                break;
            case 'aliyun_oss':
                $storage = '阿里云OSS';
                $result = $this->oss($path);
                break;
        }

        $data = [
            'root'    => $this->root . $path,
            'storage' => $storage,
            'data'    => $result,
        ];

        if ( !is_null($ajax)) {
            if (in_array($ajax, ['json'])) {
                return $this->ajax('success', $data, $ajax);
            }

            return $this->ajax('not found method [xml]', [], 'json', 400);
        } else {
            v('index', $data);
        }
    }

    /**
     * 本地文件
     * @param $curr_path
     * @param $down
     * @param $name
     * @return array|void
     */
    public function local($curr_path, $down, $name)
    {
        $path = $this->path . '/' . $curr_path;

        if ($down === '1') {
            return $this->download($path, $name);
        }

        $result = scandir($path);
        $dirList = [];
        $fileList = [];

        foreach ($result as $value) {
            if (!in_array($value, $this->ignore)) {
                $filename = $path . '/' . $value;
                $a = explode('/', $curr_path);

                if (is_dir($filename)) {
                    if ($value === '..') {
                        array_pop($a);

                        //二级目录返回一级目录
                        if (count($a) <= 1) {
                            $url = '/';
                        } else {
                            $url = '?path=' . join('/', $a);
                        }
                    } else {
                        $url = '?path=' . join('/', $a) . '/' . urlencode($value);
                    }

                    $dirList[] = [
                        'type' => 'dir',
                        'name' => $value,
                        'size' => null,
                        'time' => null,
                        'url' => $url,
                    ];
                } else {
                    $fileList[] = [
                        'type' => 'file',
                        'name' => $value,
                        'size' => filesize($filename),
                        'time' => filectime($filename),
                        'url' => '?path=' . join('/', $a) . '&name=' . urlencode($value) . '&down=1',
                    ];
                }
            }
        }

        return $this->handleFileList(array_merge($dirList, $fileList));
    }

    /**
     * 阿里云OSS文件
     * @param $curr_path
     * @return array
     * @throws \OSS\Core\OssException
     */
    public function oss($curr_path)
    {
        $result = oss()->getList($curr_path);

        return $this->handleFileList($result);
    }

    /**
     * 统一处理文件列表
     * @param $result
     * @return array
     */
    public function handleFileList($result)
    {
        $temp = [];

        foreach ($result as $file) {
            if (!in_array($file['name'], $this->ignore)) {
                $icon = 'fa-folder';
                $ext = '';
                $is_dir = false;

                if ($file['type'] === 'dir') {
                    $is_dir = true;
                } else {
                    $file['size'] = file_unit_conver($file['size']);
                    $icon = $this->file_type['blank'];

                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    if (array_key_exists($ext, $this->file_type)) {
                        $icon = $this->file_type[$ext];
                    }
                }

                $temp[] = [
                    'is_dir' => $is_dir,
                    'size'   => $file['size'] ?? '',
                    'time'   => $is_dir ? '' : date($this->date_format, $file['time']),  // 按定义格式输出时间
                    'name'   => $is_dir ? str_replace('/', '', $file['name']) : $file['name'],
                    'icon'   => $icon,
                    'ext'    => $ext,
                    'url'    => $file['url'],
                ];
            }
        }

        return $temp;
    }

    /**
     * 本地文件下载
     * @param $path
     * @param $name
     */
    public function download($path, $name)
    {
        $filename = $path . '/' . $name;
        if (is_file($filename)) {
            $pathinfo = pathinfo($filename);
            $basename = $pathinfo['basename'];

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
            header("Content-Length: " . filesize($filename));
            ob_clean();
            flush();
            readfile($filename);
            exit(0);
        }

        exit('小可爱，没有这个文件哦');
    }

    /**
     * 返回排序后列表
     * @param array $result
     * @return array
     */
    public function sort($result = [])
    {
        $dirList = [];
        $fileList = [];
        foreach ($result as $item) {
            if ($item['is_dir']) {
                $dirList[] = $item;
            } else {
                $fileList[] = $item;
            }
        }

        return array_merge($dirList, $fileList);
    }
}