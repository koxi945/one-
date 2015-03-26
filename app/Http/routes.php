<?php

//注：但是以大部分的路由及控制器所执行的动作来说，你需要返回完整的 Illuminate\Http\Response 实例或是一个视图

//系统后台路由
Route::group(['domain' => 'admin.opcache.net'], function() {
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
	function homeRouteCommon($type)
	{
		Route::get('/', 'Home\IndexController@index');
		Route::any('{class}/{action}.html', ['as' => $type, function($class, $action) {
			$class = 'App\\Http\\Controllers\\Home\\'.ucfirst(strtolower($class)).'Controller';
			if(class_exists($class)) {
				$classObject = new $class();
				//这里必须要返回一个Illuminate\Http\Response 实例而非一个视图，原因是因为csrf中需要影响的必须为一个response
				if(method_exists($classObject, $action))
				{
					$return = call_user_func(array($classObject, $action));
					if( ! $return instanceof Illuminate\Http\Response) return (new Illuminate\Http\Response())->setContent();
					return $return;
				}
			}
			return abort(404);
		}])->where(['class' => '[0-9a-z]+', 'action' => '[0-9a-z]+']);
	}
}

$homeDoaminArray = ['home_empty_prefix' => 'opcache.net', 'home' => 'www.opcache.net', 'test' => 'test.opcache.net'];
foreach($homeDoaminArray as $key => $value)
{
	Route::group(['domain' => $value, 'middleware' => ['csrf']], function() use ($key) {
		homeRouteCommon($key);
	});
}

