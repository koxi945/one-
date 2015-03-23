<?php namespace App\Models\Home;

use Illuminate\Database\Eloquent\Model;

/**
 * 文章表模型
 *
 * @author jiang
 */
class SearchDict extends Model
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
    protected $table = 'search_dict';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('key', 'value');

    /**
     * 保存字典
     *
     * @param array $data 要保存的数据
     * @return boolean
     */
    public function getDict()
    {
        $result = $this->select(\DB::raw("concat(`key`, ' ') as `key`, value"))->get()->toArray();
        $return = [];
        foreach($result as $value)
        {
            $return[$value['key']] = $value['value'];
        }
        return $return;
    }

}
