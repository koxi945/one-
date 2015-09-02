<?php namespace App\Services\Admin\Comment;

use Lang;
use App\Models\Admin\Comment as CommentModel;
use App\Services\Admin\BaseProcess;

/**
 * 文章评论处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 评论模型
     * 
     * @var object
     */
    private $commentModel;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->commentModel) $this->commentModel = new CommentModel();
    }

    /**
     * 删除评论
     * 
     * @param array $ids
     * @access public
     * @return boolean true|false
     */
    public function delete($ids)
    {
        if( ! is_array($ids)) return false;
        if($this->commentModel->deleteComment($ids) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

}