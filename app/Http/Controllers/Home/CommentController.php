<?php namespace App\Http\Controllers\Home;

use App\Services\Home\Comment\Process as CommentProcess;
use Request;
use App\Libraries\Js;

/**
 * 博客留言
 *
 * @author jiang <mylampblog@163.com>
 */
class CommentController extends Controller
{
    /**
     * 评论
     */
    public function add()
    {
        $data['object_id'] = (int) Request::input('objectid');
        $data['object_type'] = (int) Request::input('object_type');
        $data['nickname'] = strip_tags(Request::input('nickname'));
        $data['content'] = strip_tags(Request::input('comment'));
        $data['replyid'] = (int) Request::input('replyid');

        $commentProcess = new CommentProcess();
        if($commentProcess->addComment($data) !== false) return Js::reload('parent');
        return Js::error($commentProcess->getErrorMessage());
    }

}