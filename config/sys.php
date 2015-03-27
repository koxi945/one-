<?php

return [

    //登录处理用哪个处理器来处理
    'login_process' => 'default',
    'sys_images_domain' => 'http://img.opcache.net',
    //上传的路径，包括ueditor的上传路径也在这里定义了，因为修改了ueditor，重新加载了这个文件。
    'sys_upload_path' => __DIR__ . '/../../upload_path',
    //不需要验证权限的功能，*号代表全部,module不能为*号
	'access_public' => [
		['module' => '', 'class' => 'upload', 'function' => '*'],
		['module' => '', 'class' => 'account', 'function' => '*'],
		['module' => '', 'class' => 'index', 'function' => ['index', 'error']],
		['module' => '', 'class' => 'baidumap', 'function' => ['map', 'show']],
	]
];