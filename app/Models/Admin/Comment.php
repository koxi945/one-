<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 文章评论模型
 *
 * @author jiang <mylampblog@163.com>
 */
class Comment extends Base
{
    /**
     * 文章数据表名
     *
     * @var string
     */
    protected $table = 'comment';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'object_type', 'object_id', 'nickname', 'content', 'reply_ids', 'time');

    /**
     * 取得评论信息
     *
     * @return array
     */
    public function allComment()
    {
        $currentQuery = $this->orderBy('id', 'desc')->paginate(self::PAGE_NUMS);
        return $currentQuery;
    }

    /**
     * 删除文章评论
     * @param  array $ids 评论的id
     * @return boolean
     */
    public function deleteComment(array $ids)
    {
        return $this->destroy($ids);
    }

}
