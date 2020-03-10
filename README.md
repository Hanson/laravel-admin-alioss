# laravel-admin-alioss

Laravel admin 框架的七牛 alioss 多图上传扩展，可拖拽，异步上传图片，支持删除

![1_7M_G0VFANP6HK48EEL2QO.png](https://i.loli.net/2020/02/09/Hys9IGfjWloc8Fm.png)

![__FP8P8`VX`LN_Y3__4K762.png](https://i.loli.net/2020/02/09/hMFqysDLK4vZaOx.png)

## 安装

`composer require hanson/laravel-admin-alioss:dev-master -vvv`

## 配置

在 `config/filesystems.php` 增加一个 disk

```php
<?php

return [
   'disks' => [
        //...
        'oss' => [
            'driver'        => 'oss',
            'access_id'     => '<Your Aliyun OSS AccessKeyId>',
            'access_key'    => '<Your Aliyun OSS AccessKeySecret>',
            'bucket'        => '<OSS bucket name>',
            'endpoint'      => '<the endpoint of OSS, E.g: oss-cn-hangzhou.aliyuncs.com | custom domain, E.g:img.abc.com>', // OSS 外网节点或自定义外部域名
            //'endpoint_internal' => '<internal endpoint [OSS内网节点] 如：oss-cn-shenzhen-internal.aliyuncs.com>', // v2.0.4 新增配置属性，如果为空，则默认使用 endpoint 配置(由于内网上传有点小问题未解决，请大家暂时不要使用内网节点上传，正在与阿里技术沟通中)
            'cdnDomain'     => '<CDN domain, cdn域名>', // 如果isCName为true, getUrl会判断cdnDomain是否设定来决定返回的url，如果cdnDomain未设置，则使用endpoint来生成url，否则使用cdn
            'ssl'           => true, // true to use 'https://' and false to use 'http://'. default is false,
            'isCName'       => true, // 是否使用自定义域名,true: 则Storage.url()会使用自定义的cdn或域名生成文件url， false: 则使用外部节点生成url
            'debug'         => true,
            ],
        //...
    ]
];
```

## 使用

```php
<?php

$form = new \Encore\Admin\Form(new Goods);

$form->aliossImages('column', '商品图')->sortable(); // 普通用法

$form->aliossImages('column', '商品图')
    ->sortable() // 让图片可以拖拽排序
    ->extraData(['disk' => 'alioss2', 'path' => 'avatar']) // 假如你有多个七牛配置，可以通过指定此处的 disk 进行上传， path 为文件路径的前缀
    ->value(['http://url.com/a.jpg', 'http://url.com/b.jpg']); // 默认显示的图片数组，必须为 url

$form->saving(function (\Encore\Admin\Form $form) {
    $paths = \Hanson\LaravelAdminAlioss\Alioss::getPaths(request('alioss_column')); // 需要 alioss_ 作为前缀的字段
});
```
