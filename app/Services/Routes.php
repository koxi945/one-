<?php

namespace App\Services;

use Route;

/**
 * 系统路由
 * 
 * 注：大部分的路由及控制器所执行的动作来说，
 * 
 * 你需要返回完整的 Illuminate\Http\Response 实例或是一个视图
 *
 * @author jiang <mylampblog@163.com>
 */
class Routes
{
    private $adminDomain;

    private $wwwDomain;

    private $noPreDomain;

    private $soDomain;

    /**
     * 初始化，取得配置
     *
     * @access public
     */
    public function __construct()
    {
        $this->adminDomain = config('sys.sys_admin_domain');
        $this->wwwDomain = config('sys.sys_blog_domain');
        $this->noPreDomain = config('sys.sys_blog_nopre_domain');
        $this->soDomain = config('sys.sys_blog_search_domain');
    }

    /**
     * 后台的通用路由
     * 
     * 覆盖通用的路由一定要带上别名，且別名的值为module.class.action
     * 
     * 即我们使用别名传入了当前请求所属的module,controller和action
     *
     * <code>
     *     Route::get('index-index.html', ['as' => 'module.class.action', 'uses' => 'Admin\IndexController@index']);
     * </code>
     *
     * @access public
     */
    public function admin()
    {
        Route::group(['domain' => $this->adminDomain], function()
        {
            $this->adminSigin();
            $this->adminCommon();
        });
        return $this;
    }

    /**
     * 后台登陆相关
     * 
     * @access private
     */
    private function adminSigin()
    {
        Route::group(['middleware' => ['csrf']], function()
        {
            Route::get('/', 'Admin\Foundation\LoginController@index');
            Route::controller('login', 'Admin\Foundation\LoginController', ['getOut' => 'foundation.login.out']);
        });
    }

    /**
     * 后台通用路由
     * 
     * @access private
     */
    private function adminCommon()
    {
        Route::group(['middleware' => ['auth', 'acl', 'alog']], function()
        {
            Route::any('{module}-{class}-{action}.html', ['as' => 'common', function($module, $class, $action)
            {
                $touchClass = 'App\\Http\\Controllers\\Admin\\'.ucfirst(strtolower($module)).'\\'.ucfirst(strtolower($class)).'Controller';
                if(class_exists($touchClass))
                {
                    $classObject = new $touchClass();
                    if(method_exists($classObject, $action)) return call_user_func(array($classObject, $action));
                }
                return abort(404);
            }])->where(['module' => '[0-9a-z]+', 'class' => '[0-9a-z]+', 'action' => '[0-9a-z]+']);
        });
    }

    /**
     * 博客查询页面
     * 
     * @access public
     */
    public function search()
    {
        Route::group(['domain' => $this->soDomain], function()
        {
            Route::get('/search.html', ['as' => 'blog.search.index', 'uses' => 'Home\SearchController@index']);
        });
        return $this;
    }

    /**
     * 博客通用路由
     * 
     * 这里必须要返回一个Illuminate\Http\Response 实例而非一个视图
     * 
     * 原因是因为csrf中需要响应的必须为一个response
     *
     * @access public
     */
    public function www()
    {
        $this->wwwHome();
        $homeDoaminArray = ['home' => $this->wwwDomain, 'home_empty_prefix' => $this->noPreDomain];
        foreach($homeDoaminArray as $key => $value)
        {
            Route::group(['domain' => $value, 'middleware' => ['csrf']], function() use ($key)
            {
                $this->wwwCommon($key);
            });
        }
        return $this;
    }

    /**
     * 博客首页
     * 
     * @access private
     */
    private function wwwHome()
    {
        Route::group(['domain' => $this->wwwDomain], function()
        {
            Route::get('/', ['as' => 'blog.index.index', 'uses' => 'Home\IndexController@index']);
        });
    }

    /**
     * 博客通用路由
     * 
     * @access private
     */
    private function wwwCommon($key)
    {
        Route::any('{class}/{action}.html', ['as' => $key, function($class, $action)
        {
            return $this->wwwTouch($class, $action);
        }])->where(['class' => '[0-9a-z]+', 'action' => '[0-9a-z]+']);
    }

    /**
     * 检测路由是不是正常的
     * 
     * @access private
     */
    private function wwwTouch($class, $action)
    {
        $touchClass = 'App\\Http\\Controllers\\Home\\'.ucfirst(strtolower($class)).'Controller';
        if( ! class_exists($touchClass)) {
            return abort(404);
        }
        $classObject = new $touchClass();
        if( ! method_exists($classObject, $action)) {
            return abort(404);
        }
        $result = $this->wwwWithCacheControl(call_user_func(array($classObject, $action)));
        return $result;
    }

    /**
     * 加上header cache control
     *
     * @access private
     */
    private function wwwWithCacheControl($result)
    {
        if( ! $result instanceof \Illuminate\Http\Response)
        {
            $cacheSecond = config('home.cache_control');
            $time = date('D, d M Y H:i:s', time() + $cacheSecond) . ' GMT';
            return response($result)->header('Cache-Control', 'max-age='.$cacheSecond)->header('Expires', $time);
        }
        return $result;
    }

}
