<?php

return [
    /**
     * 阿里云OSS存储
     */
    'aliyun_oss' => [
        /**
         * 应用id
         */
        'accessKeyId' => '',
        /**
         * 密钥
         */
        'accessKeySecret' => '',
        /**
         * 存储空间名称
         */
        'bucket' => '',
        /**
         * 地域节点
         */
        'endpoint' => 'oss-cn-hangzhou.aliyuncs.com',
        /**
         * 请求超时
         */
        'timeout' => 3600,
        /**
         * 访问域名
         * @example xxxx.oss-cn-hangzhou.aliyuncs.com
         */
        'domain' => '',
    ],
];