<?php namespace App\Models\Admin;

use App\Models\Admin\Base;

/**
 * 工作流步骤表模型
 *
 * @author jiang
 */
class WorkflowStep extends Base
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'workflow_step';

    /**
     * 可以被集体附值的表的字段
     *
     * @var string
     */
    protected $fillable = array('workflow_id', 'name', 'description', 'step_level', 'addtime');
    
    /**
     * 取得所有的工作流步骤
     *
     * @return array
     */
    public function getAllWorkflowStepByPage()
    {
        $currentQuery = $this->orderBy('step_level', 'asc')->paginate(self::PAGE_NUMS);
        return $currentQuery;
    }

    /**
     * 增加工作流步骤
     * 
     * @param array $data 所需要插入的信息
     */
    public function addWorkflowStep(array $data)
    {
        return $this->create($data);
    }

    /**
     * 取得单条工作流步骤信息
     *
     * @param array $where 条件
     * @return array
     */
    public function getWorkflowStepInfo($where)
    {
        if(isset($where['id'])) $search = $this->where('id', '=', intval($where['id']));
        if(isset($search)) return $search->first();
    }

    /**
     * 修改工作流步骤
     * 
     * @param array $data 所需要插入的信息
     */
    public function editWorkflowStep(array $data, $id)
    {
        return $this->where('id', '=', intval($id))->update($data);
    }

    /**
     * 删除工作流步骤
     * 
     * @param array $id 工作流的ID
     */
    public function deleteWorkflowStep(array $ids)
    {
        return $this->destroy($ids);
    }

    /**
     * 取得指定ID组的工作流步骤信息
     * 
     * @param intval $ids 工作流的ID
     * @return array
     */
    public function getWorkflowStepInIds($ids)
    {
        if( ! is_array($ids)) return false;
        return $this->whereIn('id', $ids)->get()->toArray();
    }

    
}
