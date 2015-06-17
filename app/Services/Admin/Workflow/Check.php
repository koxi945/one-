<?php namespace App\Services\Admin\Workflow;

use App\Models\Admin\Workflow as WorkflowModel;
use App\Services\Admin\BaseProcess;
use App\Services\Admin\SC;

/**
 * 工作流权限检测
 *
 * @author jiang <mylampblog@163.com>
 */
class Check extends BaseProcess
{
    /**
     * 默认的审核状态
     *
     * @var int
     */
    CONST DEFAULT_STATUS = 0;

    /**
     * 默认的审核状态的替换状态,即如果为0的话代表的是第一步审核
     *
     * @var int
     */
    CONST DEFAULT_STATUS_REPLACE = 1;

    /**
     * 如果走到了最后的一步，那么设置为这个值
     *
     * @var int
     */
    CONST DEFAULT_STATUS_FINAL_PASS = 99;

    /**
     * 工作流模型
     * 
     * @var object
     */
    private $workflowModel;

    /**
     * 指定用户和调用代码的用户审核权限缓存
     * 
     * @var array
     */
    private $userWorkflow;

    /**
     * finalLevel
     * 
     * @var array
     */
    private $finalLevel;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->workflowModel) $this->workflowModel = new WorkflowModel();
    }

    /**
     * 检测是否有审核的权限
     *
     * @param string $code 调用代码，即检测哪个工作流的
     * @param array $status 当前审核状态
     * @access public
     */
    public function checkAcl($code, $status = [])
    {
        if( ! is_array($status)) return false;
        $userInfo = SC::getLoginSession();
        //为了避免多次查询的情况，先把它缓存起来，但要注意的系不要重新实例化，widget()方法是不会重新实例化的
        if( ! isset($this->userWorkflow[$code])) $this->userWorkflow[$code] = $this->workflowModel->getCurrentUserWorkflow($userInfo->id, $code);
        $isCheck = false;
        foreach($status as $s)
        {
            if($s == self::DEFAULT_STATUS) $s = self::DEFAULT_STATUS_REPLACE;
            if(in_array($s, $this->userWorkflow[$code]))
            {
                $isCheck = true;
                break;
            }
        }
        return $isCheck;
    }

    /**
     * 返回下一步审核的状态值
     *
     * <code>
     *     $result = ['is_final' => false, 'status' => 2];
     * </code
     *
     * $result['is_final']代表的是，是不是走到了最后一步了。
     * $result['status'] 审核后所要设置的值
     * 
     * @return int|true
     */
    public function getComfirmStatus($code, $currentStatus)
    {
        if($this->isFinal($code, $currentStatus)) return ['is_final' => true, 'status' => self::DEFAULT_STATUS_FINAL_PASS];
        if($currentStatus == self::DEFAULT_STATUS) $currentStatus = self::DEFAULT_STATUS_REPLACE;
        return ['is_final' => false, 'status' => ++$currentStatus];
    }

    /**
     * 是不是最后一步审核
     * 
     * @return boolean
     */
    private function isFinal($code, $currentStatus)
    {
        if( ! isset($this->finalLevel)) $this->finalLevel = $this->workflowModel->worflowFinalLevel($code);
        return $this->finalLevel == $currentStatus;
    }

}