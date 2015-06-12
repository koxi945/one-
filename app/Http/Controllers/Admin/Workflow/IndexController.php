<?php namespace App\Http\Controllers\Admin\Workflow;

use App\Http\Controllers\Admin\Controller;

/**
 * 工作流
 *
 * @author jiang <mylampblog@163.com>
 */
class IndexController extends Controller
{
    /**
     * 工作流管理
     */
    public function index()
    {
        return view('admin.workflow.index');
    }

}