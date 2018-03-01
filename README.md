# DirectoryLister

READMD| [English document](https://github.com/flxxyz/directory-lister/blob/master/README_en.md) (寻找大佬翻译)

----

### 介绍
PHP实现目录列表，思路来自DirectoryLister，不像DirectoryLister的简单结构，采用的类似laravel的目录结构，开放public目录，隔绝程序文件的访问，使用composer来管理使用的类库，便于后期开发功能。

本项目适用于有一定的php知识储备的开发人员使用，小白用户使用请先了解一下[composer](http://docs.phpcomposer.com/00-intro.html)使用


### 特点
- 支持指定目录
- 支持中文
- 支持自定义隐藏名单
- 支持自定义主题
- 支持自定义图标
- 界面简洁，目录结构清晰
- 等等...

## 要求
请使用PHP版本大于等于7.0的版本。详细访问[PHP.net](https://secure.php.net/)

### 起步
1. 到[Releases](https://github.com/flxxyz/directory-lister/releases)页面选择合适的版本，下载，解压

2. 进入根目录，执行
   ```bash
   composer update
   ```

3. 设置`config/config.php`中的`data_path`选项为存在并可以显示的目录

4. 在**apache**或**nginx**的站点配置文件中，将 `public` 设置为根目录，关闭404错误页配置，禁止`js,css,php,jpg,png,gif`等文件的重写
   
   **nginx的栗子**
   ```
   server
   {
       listen 80;
       server_name 你的域名;
       index index.php index.html index.htm;
       root /站点目录/public;
       
       location / {
           try_files $uri $uri/ /index.php$is_args$query_string;
       }
   }
   ```
   apache请自行对照nginx编写

5. 可以启动站点访问了

### FQA
- Q: 一直提示我PHP低于7.0怎么办呀？在线等，急

  flxxyz: 请到[PHP.net](https://secure.php.net/downloads.php)下载安装，网上也有诸如宝塔(bt.cn)这类方便快捷的面板，请自行判断安装。

- Q: 不是说可以自定义目录的吗？在哪里设置？

  flxxyz: 打开`config/config.php`，修改`data_path`选项为可以显示并存在的目录

- Q: 那个，请问隐藏文件和文件夹的名单在哪里呀，谢谢！

  flxxyz: 打开`config/config.php`，修改`ignore_list`选项，依次添加需要忽略的文件或文件名

- Q: 我想添加文件的图标怎么添加？

  flxxyz: 打开`config/filetype.php`，按照格式对应添加
  
- Q: 我想自己做主题怎么做？

  flxxyz: 打开`config/config.php`，修改`theme`选项设置主题名，同时在`app/view/`目录下创建同名的文件夹，格式参照`default`下的结构

### 感谢
[PHP.net](https://secure.php.net), [DirectoryLister](https://github.com/DirectoryLister/DirectoryLister), [bulma.io](https://bulma.io/)

### License
采用[MIT](./LICENSE)许可证
