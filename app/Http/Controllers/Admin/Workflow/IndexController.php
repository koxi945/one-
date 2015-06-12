<?php namespace App\Http\Controllers\Admin\Workflow;

use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\Workflow\Process;
use Request;

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
    	$manger = new Process();
    	$list = $manger->workflowInfos();
    	$page = $list->appends(Request::all())->render();
        return view('admin.workflow.index', compact('list', 'page'));
    }

}