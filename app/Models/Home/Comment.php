<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;

/**
 * 评论表模型
 *
 * @author jiang
 */
class Comment extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'comment';

    /**
     * 代表文章的标识
     */
    CONST OBJECT_TYPE = 1;

    /**
     * 根据文章的ID取得评论的内容
     * 
     * @return array
     */
    public function getContentByObjectId($objectId, $objectType = self::OBJECT_TYPE)
    {
        return $this->where('object_type', $objectType)->where('object_id', $objectId)->get()->toArray();
    }

}
