<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 工作流表模型
 *
 * @author jiang
 */
class Workflow extends Base
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'workflow';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('name', 'description', 'addtime');
    
    /**
     * 取得所有的工作流
     *
     * @return array
     */
    public function getAllWorkflowByPage()
    {
        $currentQuery = $this->orderBy('id', 'desc')->paginate(self::PAGE_NUMS);
        return $currentQuery;
    }

    
}
