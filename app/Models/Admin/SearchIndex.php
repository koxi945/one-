<?php namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

/**
 * 文章表模型
 *
 * @author jiang
 */
class SearchIndex extends Model
{
    /**
     * 关闭自动维护updated_at、created_at字段
     * 
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * 文章数据表名
     *
     * @var string
     */
    protected $table = 'search_index';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('id', 'article_id', 'title', 'summary', 'content', 'added_date', 'edited_date');

    /**
     * 保存字典索引
     *
     * @param array $data 要保存的数据
     * @return boolean
     */
    public function saveIndex(array $check, array $data)
    {
        return $this->updateOrCreate($check, $data);
    }
    

}
