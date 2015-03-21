<?php

return [

    //登录处理用哪个处理器来处理
    'login_process' => 'default',
    //不需要验证权限的功能，*号代表全部,module不能为*号
	'access_public' => [
		['module' => '', 'class' => 'upload', 'function' => '*'],
		['module' => '', 'class' => 'account', 'function' => '*'],
		['module' => '', 'class' => 'index', 'function' => ['index', 'error']],
		['module' => '', 'class' => 'baidumap', 'function' => ['map', 'show']],
	]
];