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
    public function workflowInfos()
    {
        return $this->workflowModel->getAllWorkflowByPage();
    }

    /**
     * 增加新的工作流
     *
     * @param object $data
     * @access public
     * @return boolean true|false
     */
    public function addGroup(\App\Services\Admin\Workflow\Param\WorkflowSave $data)
    {
        if( ! $this->groupValidate->add($data)) return $this->setErrorMsg($this->groupValidate->getErrorMessage());
        //检查当前用户的权限是否能增加这个用户组
        if( ! $this->acl->checkGroupLevelPermission($data->level, Acl::GROUP_LEVEL_TYPE_LEVEL)) return $this->setErrorMsg(Lang::get('common.account_level_deny'));
        if($this->groupModel->addGroup($data->toArray()) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    

}