<?php

//系统后台路由
Route::group(['domain' => 'admin.xx.net'], function() {
	//登录界面
	Route::get('/', 'Admin\LoginController@index');
	Route::controller('login', 'Admin\LoginController', ['getOut' => 'login.out']);

	Route::group(['middleware' => ['auth', 'acl']], function() {

		//特别要注意的
		//覆盖通用的路由的例子，一定要带上别名，且另名的值为class.action，即我们使用别名传入了当前请求所属的controller和action.
		//Route::get('index-index.html', ['as' => 'login.index', 'uses' => 'Admin\IndexController@index']);
		
		//通用的路由
		Route::any('{class}----{action}.html', ['as' => 'common', function($class, $action) {
			$class = 'App\\Http\\Controllers\\Admin\\'.ucfirst(strtolower($class)).'Controller';
			if(class_exists($class)) {
				$classObject = new $class();
				if(method_exists($classObject, $action)) return call_user_func(array($classObject, $action));
			}
			return abort(404);			
		}])->where(['class' => '[0-9a-z]+', 'action' => '[0-9a-z]+']);
	});
});

//博客首页
if( ! function_exists('homeRouteCommon'))
{
	function homeRouteCommon()
	{
		Route::get('/', 'Home\IndexController@index');
		Route::any('{class}/{action}.html', ['as' => 'home', function($class, $action) {
			$class = 'App\\Http\\Controllers\\Home\\'.ucfirst(strtolower($class)).'Controller';
			if(class_exists($class)) {
				$classObject = new $class();
				if(method_exists($classObject, $action)) return call_user_func(array($classObject, $action));
			}
			return abort(404);			
		}])->where(['class' => '[0-9a-z]+', 'action' => '[0-9a-z]+']);
	}
}

$homeDoaminArray = ['xx.net', 'www.xx.net', 'test.xx.net'];
foreach($homeDoaminArray as $value)
{
	Route::group(['domain' => $value], function() {
		homeRouteCommon();
	});
}

