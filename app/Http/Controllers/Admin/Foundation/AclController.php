<?php

namespace App\Http\Controllers\Admin\Foundation;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\Permission as PermissionModel;
use App\Models\Admin\Access as AccessModel;
use App\Models\Admin\User as UserModel;
use App\Models\Admin\Group as GroupModel;
use Request, Lang, Session;
use App\Services\Admin\Acl\Process as AclActionProcess;
use App\Libraries\Js;
use App\Services\Admin\Acl\Acl;
use App\Services\Admin\Tree;
use App\Services\Admin\SC;
use App\Services\Admin\Acl\Param\AclSave;
use App\Services\Admin\Acl\Param\AclSet;

/**
 * 权限菜单相关
 *
 * @author jiang <mylampblog@163.com>
 */
class AclController extends Controller
{
    /**
     * permission 表模型
     * 
     * @var object
     */
    private $permissionModel;

    /**
     * access 表模型
     * 
     * @var object
     */
    private $accessModel;

    /**
     * user 表模型
     * 
     * @var object
     */
    private $userModel;

    /**
     * group 表模型
     * 
     * @var object
     */
    private $groupModel;

    /**
     * acl 处理器
     * 
     * @var object
     */
    private $aclProcess;

    /**
     * acl 保存时用到的参数封装类
     * 
     * @var object
     */
    private $aclSave;

    /**
     * acl 保存用户权限时用到的参数封装类
     * 
     * @var object
     */
    private $aclSet;

    /**
     * 初始化一些常用的类
     *
     * @access public
     */
    public function __construct()
    {
        $this->permissionModel = new PermissionModel();
        $this->accessModel = new AccessModel();
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->aclProcess = new AclActionProcess();
        $this->aclSave = new AclSave();
        $this->aclSet = new AclSet();
    }

    /**
     * 显示权限列表首页
     *
     * @access public
     */
    public function index()
    {
        Session::flashInput(['http_referer' => Request::fullUrl()]);
        $pid = (int) Request::input('pid', 'all');
        $list = Tree::genTree($this->permissionModel->getAllAccessPermission());
        return view('admin.acl.index', compact('list', 'pid'));
    }

    /**
     * 增加权限功能
     *
     * @access public
     */
    public function add()
    {
        if (Request::method() == 'POST') {
            return $this->savePermissionToDatabase();
        }

        $select = Tree::dropDownSelect(Tree::genTree($this->permissionModel->getAllAccessPermission()));
        $formUrl = R('common', 'foundation.acl.add');
        return view('admin.acl.add', compact('select', 'formUrl'));
    }

    /**
     * 增加功能权限入库处理
     *
     * @access private
     */
    private function savePermissionToDatabase()
    {
        $data = (array) Request::input('data');
        $data['add_time'] = time();

        $this->aclSave->setAttributes($data);

        if($this->aclProcess->addAcl($this->aclSave) !== false) {
            return Js::locate(R('common', 'foundation.acl.index'), 'parent');
        }

        return Js::error($this->aclProcess->getErrorMessage());
    }
    
    /**
     * 删除权限功能
     *
     * @access public
     */
    public function delete()
    {
        $permissionId = (array) Request::input('id');

        if($this->aclProcess->detele($permissionId) !== false) {
            return responseJson(Lang::get('common.action_success'), true);
        }

        return responseJson($this->aclProcess->getErrorMessage());
    }
    
    /**
     * 编辑权限功能
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST') {
            return $this->updatePermissionToDatabase();
        }

        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);

        $id = Request::input('id');
        $permissionId = url_param_decode($id);

        if( ! $permissionId or ! is_numeric($permissionId)) {
            return Js::error(Lang::get('common.illegal_operation'), true);
        }

        $list = (array) Tree::genTree($this->permissionModel->getAllAccessPermission());
        $permissionInfo = $this->permissionModel->getOnePermissionById(intval($permissionId));

        if(empty($permissionInfo)) {
            return Js::error(Lang::get('common.acl_not_found'), true);
        }

        $select = Tree::dropDownSelect($list, $permissionInfo['pid']);
        $formUrl = R('common', 'foundation.acl.edit');

        return view('admin.acl.add',
            compact('select', 'permissionInfo', 'formUrl', 'id')
        );
    }
    
    /**
     * 编辑功能权限入库处理
     *
     * @access private
     */
    private function updatePermissionToDatabase()
    {
        $httpReferer = Session::getOldInput('http_referer');

        $this->aclSave->setAttributes(Request::input('data'));

        if($this->aclProcess->editAcl($this->aclSave) !== false) {
            $backUrl = ( ! empty($httpReferer)) ? $httpReferer : R('common', 'foundation.acl.index'); 
            return Js::locate($backUrl, 'parent');
        }

        return Js::error($this->aclProcess->getErrorMessage());
    }
    
    /**
     * 排序权限功能
     *
     * @access public
     */
    public function sort()
    {
        $sort = Request::input('sort');

        if( ! $sort or ! is_array($sort)) {
            return Js::error(Lang::get('common.choose_checked'));
        }

        foreach($sort as $key => $value) {
            $update = $this->permissionModel->sortPermission($key, $value);
            if($update === false) $err = true;
        }

        if(isset($err)) {
            return Js::error(Lang::get('common.action_error'));
        }

        return Js::locate(
            R('common', 'foundation.acl.index'),
            'parent'
        );
    }

    /**
     * 对用户进行权限设置
     * 
     * @access public
     */
    public function user()
    {
        if(Request::method() == 'POST') {
            return $this->saveUserPermissionToDatabase();
        }

        $id = url_param_decode(Request::input('id'));
        if( ! $id or ! is_numeric($id)) {
            return Js::error(Lang::get('common.illegal_operation'), true);
        }

        $info = $this->userModel->getOneUserById(intval($id));
        if(empty($info)) {
            return Js::error(Lang::get('common.illegal_operation'), true);
        }

        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_USER)) {
            return Js::error(Lang::get('common.account_level_deny'), true);
        }

        $zTree = $this->aclProcess->prepareDataForZtree($this->aclProcess->getUserAccessPermissionIds($id));
        $all = $this->aclProcess->prepareUserPermissionIds();

        $router = 'user';

        return view('admin.acl.setpermission',
            compact('zTree', 'id', 'info', 'router', 'all')
        );
    }

    /**
     * 用户权限入库
     * 
     * @return boolean true|false
     */
    private function saveUserPermissionToDatabase()
    {
        $this->checkFormHash();
        $id = Request::input('id');
        $all = Request::input('all');

        if( ! $id or ! is_numeric($id) or ! $all) {
            return responseJson(Lang::get('common.illegal_operation'));
        }

        $this->aclSet->setPermission(Request::input('permission'))->setAll($all)->setId($id);

        if( ! $this->aclProcess->setUserAcl($this->aclSet)) {
            return responseJson($this->aclProcess->getErrorMessage());
        }

        $this->setActionLog();

        return responseJson(
            Lang::get('common.action_success')
        );
        
    }
    
    /**
     * 对用户组进行权限设置
     * 
     * @access public
     */
    public function group()
    {
        if(Request::method() == 'POST') {
            return $this->saveGroupPermissionToDatabase();
        }

        $id = url_param_decode(Request::input('id'));
        if( ! $id or ! is_numeric($id)) {
            return Js::error(Lang::get('common.illegal_operation'), true);
        }

        $info = $this->groupModel->getOneGroupById(intval($id));
        if(empty($info)) {
            return Js::error(Lang::get('common.illegal_operation'), true);
        }

        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_GROUP)) {
            return Js::error(Lang::get('common.account_level_deny'), true);
        }

        $zTree = $this->aclProcess->prepareDataForZtree($this->aclProcess->getGroupAccessPermissionIds($id));
        $all = $this->aclProcess->prepareUserPermissionIds();

        $router = 'group';
        return view('admin.acl.setpermission',
            compact('zTree', 'id', 'info', 'router', 'all')
        );
    }

    /**
     * 用户组权限入库
     * 
     * @return boolean true|false
     */
    private function saveGroupPermissionToDatabase()
    {
        $this->checkFormHash();
        $id = Request::input('id');
        $all = Request::input('all');

        if( ! $id or ! is_numeric($id) or ! $all) {
            return responseJson(Lang::get('common.illegal_operation'));
        }

        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_GROUP)) {
            return responseJson(Lang::get('common.account_level_deny'));
        }

        $this->aclSet->setPermission(Request::input('permission'))->setAll($all)->setId($id);
        
        if( ! $this->aclProcess->setGroupAcl($this->aclSet)) {
            return responseJson($this->aclProcess->getErrorMessage());
        }

        $this->setActionLog();

        return responseJson(
            Lang::get('common.action_success')
        );
    }

}