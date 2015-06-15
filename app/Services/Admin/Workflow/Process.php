<?php namespace App\Services\Admin\Workflow;

use Lang;
use App\Models\Admin\Workflow as WorkflowModel;
use App\Services\Admin\Workflow\Validate\Workflow as WorkflowValidate;
use App\Services\Admin\BaseProcess;

/**
 * 工作流
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 工作流模型
     * 
     * @var object
     */
    private $workflowModel;

    /**
     * 工作流表单验证对象
     * 
     * @var object
     */
    private $workflowValidate;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->workflowModel) $this->workflowModel = new WorkflowModel();
        if( ! $this->workflowValidate) $this->workflowValidate = new WorkflowValidate();
    }

    /**
     * 工作流列表
     *
     * @access public
     */
    public function workflowInfos($where = [])
    {
        if(empty($where)) return $this->workflowModel->getAllWorkflowByPage();
        if(isset($where['ids'])) return $this->workflowModel->getWorkflowInIds($where['ids']);
        return [];
    }

    /**
     * 取得单条工作流信息
     *
     * @param array $where 条件
     * @return array
     */
    public function workflowInfo($where)
    {
        return $this->workflowModel->getWorkflowInfo($where);
    }

    /**
     * 增加新的工作流
     *
     * @param object $data
     * @access public
     * @return boolean true|false
     */
    public function addWorkflow(\App\Services\Admin\Workflow\Param\WorkflowSave $data)
    {
        if( ! $this->workflowValidate->add($data)) return $this->setErrorMsg($this->workflowValidate->getErrorMessage());
        if($this->workflowModel->addWorkflow($data->toArray()) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 编辑工作流
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editWorkflow(\App\Services\Admin\Workflow\Param\WorkflowSave $data)
    {
        if( ! isset($data->id)) return $this->setErrorMsg(Lang::get('common.action_error'));
        $id = $data->id; unset($data->id);
        if( ! $id) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        if( ! $this->workflowValidate->edit($data)) return $this->setErrorMsg($this->groupValidate->getErrorMessage());
        if($this->workflowModel->editWorkflow($data->toArray(), $id) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 删除工作流
     *
     * @param array $where 条件
     * @return true|false
     * @access public
     */
    public function deleteWorkflow($where)
    {
        if(isset($where['ids'])) $ids = array_map('intval', $where['ids']);
        if(isset($ids)) return $this->workflowModel->deleteWorkflow($ids);
        return false;
    }

    

}