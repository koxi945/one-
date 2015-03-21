<?php namespace App\Services\Admin\Group;

use Lang;
use App\Models\Admin\Group as GroupModel;
use App\Services\Admin\Group\Validate\Group as GroupValidate;
use App\Services\Admin\Acl\Acl;

/**
 * 登录处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process
{
    /**
     * 用户组模型
     * 
     * @var object
     */
    private $groupModel;

    /**
     * 用户组表单验证对象
     * 
     * @var object
     */
    private $groupValidate;

    /**
     * 权限处理对象
     *
     * @var object
     */
    private $acl;

    /**
     * 错误的信息
     * 
     * @var string
     */
    private $errorMsg;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->groupModel) $this->groupModel = new GroupModel();
        if( ! $this->groupValidate) $this->groupValidate = new GroupValidate();
        if( ! $this->acl) $this->acl = new Acl();
    }

    /**
     * 增加新的用户组
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addGroup($data)
    {
        if( ! $this->groupValidate->add($data))
        {
            $this->errorMsg = $this->groupValidate->getMsg();
            return false;
        }
        //检查当前用户的权限是否能增加这个用户
        if( ! $this->acl->checkGroupLevelPermission($data['level'], Acl::GROUP_LEVEL_TYPE_LEVEL))
        {
            $this->errorMsg = Lang::get('common.account_level_deny');
            return false;
        }
        //开始保存到数据库
        if($this->groupModel->addGroup($data) !== false) return true;
        $this->errorMsg = Lang::get('common.action_error');
        return false;
    }

    /**
     * 删除用户组
     * 
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function detele($ids)
    {
        if( ! is_array($ids)) return false;
        foreach($ids as $key => $value)
        {
            if( ! $this->acl->checkGroupLevelPermission($value, Acl::GROUP_LEVEL_TYPE_GROUP))
            {
                $this->errorMsg = Lang::get('common.account_level_deny');
                return false;
            }
        }
        if($this->groupModel->deleteGroup($ids) !== false) return true;
        $this->errorMsg = Lang::get('common.action_error');
        return false;
    }

    /**
     * 编辑用户组
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editGroup($data)
    {
        if( ! isset($data['id']))
        {
            $this->errorMsg = Lang::get('common.action_error');
            return false;
        }

        $id = intval($data['id']); unset($data['id']);

        if( ! $this->groupValidate->edit($data))
        {
            $this->errorMsg = $this->groupValidate->getMsg();
            return false;
        }
        //检查当前用户的权限是否能增加这个用户
        if( ! $this->acl->checkGroupLevelPermission($data['level'], Acl::GROUP_LEVEL_TYPE_LEVEL))
        {
            $this->errorMsg = Lang::get('common.account_level_deny');
            return false;
        }
        if($this->groupModel->editGroup($data, $id) !== false) return true;
        $this->errorMsg = Lang::get('common.action_error');
        return false;
    }

    /**
     * 取得错误的信息
     *
     * @access public
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMsg;
    }

}