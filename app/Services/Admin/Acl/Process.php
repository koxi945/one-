<?php namespace App\Services\Admin\Acl;

use Lang;
use App\Services\Admin\Acl\Validate\Acl as AclValidate;
use App\Services\Admin\Acl\Acl as AclManager;
use App\Models\Admin\Permission as PermissionModel;

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
    private $permissionModel;

    /**
     * 用户组表单验证对象
     * 
     * @var object
     */
    private $aclValidate;

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
        if( ! $this->permissionModel) $this->permissionModel = new PermissionModel();
        if( ! $this->aclValidate) $this->aclValidate = new AclValidate();
        if( ! $this->acl) $this->acl = new AclManager();
    }

    /**
     * 增加新的用户组
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addAcl($data)
    {
        if( ! $this->aclValidate->add($data))
        {
            $this->errorMsg = $this->aclValidate->getMsg();
            return false;
        }
        //检测是否已经存在
        if($this->permissionModel->checkIfIsExists('', $data['class'], $data['action']))
        {
            $this->errorMsg = Lang::get('acl.acl_exists');
            return false;
        }
        //标志当前属于第几级菜单
        $info = $this->permissionModel->getOnePermissionById(intval($data['pid']));
        $data['level'] = $info['level'] + 1;
        //开始保存到数据库
        if($this->permissionModel->addPermission($data) !== false) return true;
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
        if($this->permissionModel->deletePermission($ids) !== false) return true;
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
    public function editAcl($data)
    {
        $id = intval($data['id']); unset($data['id']);
        if( ! $id or ! is_numeric($id))
        {
            $this->errorMsg = Lang::get('common.illegal_operation');
            return false;
        }
        if( ! $this->aclValidate->edit($data))
        {
            $this->errorMsg = $this->aclValidate->getMsg();
            return false;
        }
        //检测是否已经存在
        if($this->permissionModel->checkIfIsExists('', $data['class'], $data['action'], false, $id))
        {
            $this->errorMsg = Lang::get('acl.acl_exists');
            return false;
        }
        //标志当前属于第几级菜单
        $info = $this->permissionModel->getOnePermissionById(intval($data['pid']));
        $data['level'] = $info['level'] + 1;

        if($this->permissionModel->editPermission($data, intval($id)) !== false) return true;
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