<?php namespace App\Http\Controllers\Admin\Blog;

use Request, Lang;
use App\Models\Admin\Comment as CommentModel;
use App\Services\Admin\Comment\Process;
use App\Libraries\Js;
use App\Http\Controllers\Admin\Controller;

/**
 * 文章评论相关
 *
 * @author jiang <mylampblog@163.com>
 */
class CommentController extends Controller
{
    /**
     * 显示评论列表
     */
    public function index()
    {
        $list = with(new CommentModel())->allComment();
        $page = $list->setPath('')->appends(Request::all())->render();
        return view('admin.comment.index', compact('list', 'page'));
    }

    /**
     * 删除文章评论
     *
     * @access public
     */
    public function delete()
    {
        if( ! $id = Request::input('id')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $id = array_map('intval', $id);
        $manager = new Process();
        if($manager->delete($id)) return responseJson(Lang::get('common.action_success'), true);
        return responseJson($manager->getErrorMessage());
    }

}