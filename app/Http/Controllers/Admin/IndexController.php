<?php namespace App\Http\Controllers\Admin;

use App\Services\Admin\SC;

/**
 * 登录相关
 *
 * @author jiang <mylampblog@163.com>
 */
class IndexController extends Controller
{
    /**
     * 显示首页
     */
    public function index()
    {
        return view('admin.index.index');
    }

    /**
     * 显示首页
     */
    public function cs()
    {
        return view('admin.index.cs');
    }

}