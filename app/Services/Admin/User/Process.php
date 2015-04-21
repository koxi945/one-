<?php namespace App\Services\Admin\User;

use Lang;
use App\Models\Admin\User as UserModel;
use App\Services\Admin\User\Validate\User as UserValidate;
use App\Services\Admin\Acl\Acl;
use App\Services\Admin\BaseProcess;

/**
 * 用户处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 用户模型
     * 
     * @var object
     */
    private $userModel;

    /**
     * 用户表单验证对象
     * 
     * @var object
     */
    private $userValidate;

    /**
     * 权限处理对象
     *
     * @var object
     */
    private $acl;

    /**
     * 初始化
     *
     * @access public
     */
    public function __construct()
    {
        if( ! $this->userModel) $this->userModel = new UserModel();
        if( ! $this->userValidate) $this->userValidate = new UserValidate();
        if( ! $this->acl) $this->acl = new Acl();
    }

    /**
     * 增加新的用户
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addUser($data)
    {
        if( ! $this->userValidate->add($data)) return $this->setErrorMsg($this->userValidate->getErrorMessage());
        //检查当前用户的权限是否能增加这个用户
        if( ! $this->acl->checkGroupLevelPermission($data['group_id'], Acl::GROUP_LEVEL_TYPE_GROUP)) return $this->setErrorMsg(Lang::get('common.account_level_deny'));
        //检测当前用户名是否已经存在
        if($this->userModel->getOneUserByName($data['name'])) return $this->setErrorMsg(Lang::get('user.account_exists'));
        $data['password'] = md5($data['password']);
        //开始保存到数据库
        if($this->userModel->addUser($data) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 删除用户
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
            if( ! $this->acl->checkGroupLevelPermission($value, Acl::GROUP_LEVEL_TYPE_USER)) return $this->setErrorMsg(Lang::get('common.account_level_deny'));
            if($value == Acl::ADMIN_ID) return $this->setErrorMsg(Lang::get('common.sys_account'));
        }
        if($this->userModel->deleteUser($ids) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 编辑用户
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editUser($data)
    {
        if( ! isset($data['id'])) return $this->setErrorMsg(Lang::get('common.action_error'));
        $id = url_param_decode($data['id']);
        if( ! $id) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        $id = intval($id); unset($data['id']);
        if( ! $this->userValidate->edit($data)) return $this->setErrorMsg($this->userValidate->getErrorMessage());
        if( ! empty($data['password'])) $data['password'] = md5($data['password']);
        else unset($data['password']);
        //检查当前用户的权限是否能增加这个用户
        if( ! $this->acl->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_USER)) return $this->setErrorMsg(Lang::get('common.account_level_deny'));
        if($this->userModel->editUser($data, $id) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

}