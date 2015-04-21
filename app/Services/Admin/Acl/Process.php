<?php namespace App\Services\Admin\Acl;

use Lang;
use App\Services\Admin\Acl\Validate\Acl as AclValidate;
use App\Services\Admin\Acl\Acl as AclManager;
use App\Models\Admin\Permission as PermissionModel;
use App\Services\Admin\BaseProcess;

/**
 * 权限菜单处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process extends BaseProcess
{
    /**
     * 权限菜单模型
     * 
     * @var object
     */
    private $permissionModel;

    /**
     * 权限菜单表单验证对象
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
     * 增加新的权限菜单
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function addAcl($data)
    {
        if( ! $this->aclValidate->add($data)) return $this->setErrorMsg($this->aclValidate->getErrorMessage());
        //检测是否已经存在
        if($this->permissionModel->checkIfIsExists($data['module'], $data['class'], $data['action'])) return $this->setErrorMsg(Lang::get('acl.acl_exists'));
        
        //标志当前属于第几级菜单
        $info = $this->permissionModel->getOnePermissionById(intval($data['pid']));
        $data['level'] = $info['level'] + 1;
        //开始保存到数据库
        if($this->permissionModel->addPermission($data) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 删除权限菜单
     * 
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function detele($ids)
    {
        if( ! is_array($ids)) return false;
        if($this->permissionModel->deletePermission($ids) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

    /**
     * 编辑权限菜单
     *
     * @param string $data
     * @access public
     * @return boolean true|false
     */
    public function editAcl($data)
    {
        $id = intval(url_param_decode($data['id'])); unset($data['id']);
        if( ! $id or ! is_numeric($id)) return $this->setErrorMsg(Lang::get('common.illegal_operation'));
        if( ! $this->aclValidate->edit($data)) return $this->setErrorMsg($this->aclValidate->getErrorMessage());
        //检测是否已经存在
        if($this->permissionModel->checkIfIsExists($data['module'], $data['class'], $data['action'], false, $id)) return $this->setErrorMsg(Lang::get('acl.acl_exists'));
        //标志当前属于第几级菜单
        $info = $this->permissionModel->getOnePermissionById(intval($data['pid']));
        $data['level'] = $info['level'] + 1;
        if($this->permissionModel->editPermission($data, intval($id)) !== false) return true;
        return $this->setErrorMsg(Lang::get('common.action_error'));
    }

}