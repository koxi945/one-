<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 推荐位表和文章的关系模型
 *
 * @author jiang
 */
class PositionRelation extends Base
{
    /**
     * 推荐位数据表名
     *
     * @var string
     */
    protected $table = 'article_position_relation';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'article_id', 'position_id', 'sort', 'time');
    
    /**
     * 批量删除
     */
    public function deletePositionRelation(array $articleIds)
    {
        return $this->whereIn('article_id', $articleIds)->delete();
    }

}
