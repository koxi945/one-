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
     * permission model
     * 
     * @var object
     */
    private $permissionModel;

    /**
     * access model
     * 
     * @var object
     */
    private $accessModel;

    /**
     * user model
     * 
     * @var object
     */
    private $userModel;

    /**
     * group model
     * 
     * @var object
     */
    private $groupModel;

    /**
     * acl process
     * 
     * @var object
     */
    private $aclProcess;

    /**
     * acl save
     * 
     * @var object
     */
    private $aclSave, $aclSet;

    /**
     * 初始化一些常用的类
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
        $list = $this->permissionModel->getAllAccessPermission();
        $list = Tree::genTree($list);
        return view('admin.acl.index', compact('list', 'pid'));
    }

    /**
     * 增加权限功能
     *
     * @access public
     */
    public function add()
    {
        if(Request::method() == 'POST')
            return $this->savePermissionToDatabase();

        $list = $this->permissionModel->getAllAccessPermission();
        $select = Tree::dropDownSelect(Tree::genTree($list));

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

        if($this->aclProcess->addAcl($this->aclSave) !== false)
            return Js::locate(R('common', 'foundation.acl.index'), 'parent');

        return Js::error($this->aclProcess->getErrorMessage());
    }
    
    /**
     * 删除权限功能
     *
     * @access public
     */
    public function delete()
    {
        $id = (array) Request::input('id');

        foreach($id as $key => $value)
        {
            if( ! ($id[$key] = url_param_decode($value)) )
                return responseJson(Lang::get('common.action_error'));
        }

        $id = array_map('intval', $id);

        if($this->aclProcess->detele($id) !== false)
            return responseJson(Lang::get('common.action_success'), true);

        return responseJson($this->aclProcess->getErrorMessage());
    }
    
    /**
     * 编辑权限功能
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST')
            return $this->updatePermissionToDatabase();

        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);

        $id = Request::input('id');
        $permissionId = url_param_decode($id);

        if( ! $permissionId or ! is_numeric($permissionId))
            return Js::error(Lang::get('common.illegal_operation'), true);

        $list = (array) Tree::genTree($this->permissionModel->getAllAccessPermission());
        $permissionInfo = $this->permissionModel->getOnePermissionById(intval($permissionId));

        if(empty($permissionInfo))
            return Js::error(Lang::get('common.acl_not_found'), true);

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
        $data = Request::input('data');

        if( ! $data)
            return Js::error(Lang::get('common.info_incomplete'));

        $this->aclSave->setAttributes($data);

        if($this->aclProcess->editAcl($this->aclSave) !== false)
        {
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

        if( ! $sort or ! is_array($sort))
            return Js::error(Lang::get('common.choose_checked'));

        foreach($sort as $key => $value)
        {
            $update = $this->permissionModel->sortPermission($key, $value);
            if($update === false) $err = true;
        }

        if(isset($err))
            return Js::error(Lang::get('common.action_error'));

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
        if(Request::method() == 'POST')
            return $this->saveUserPermissionToDatabase();

        $id = url_param_decode(Request::input('id'));
        if( ! $id or ! is_numeric($id))
            return Js::error(Lang::get('common.illegal_operation'), true);

        $info = $this->userModel->getOneUserById(intval($id));
        if(empty($info))
            return Js::error(Lang::get('common.illegal_operation'), true);

        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_USER))
            return Js::error(Lang::get('common.account_level_deny'), true);

        //取回用户所拥有的权限列表
        $list = SC::getUserPermissionSession();

        //当前用户的权限
        $userAcl = $this->accessModel->getUserAccessPermission(intval($id));
        $hasPermissions = array();
        foreach($userAcl as $key => $value)
        {
            $hasPermissions[] = $value['permission_id'];
        }

        //为ztree做数据准备
        $zTree = []; $all = [];
        foreach($list as $key => $value)
        {
            $arr = ['id' => $value['id'], 'pId' => $value['pid'], 'name' => $value['name'], 'open' => true];
            if(in_array($value['id'], $hasPermissions)) $arr['checked'] = true;
            $zTree[] = $arr;
            $all[] = $value['id'];
        }

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
        $permissions = (array) Request::input('permission');
        $id = Request::input('id');
        $all = Request::input('all');

        if( ! $id or ! is_numeric($id) or ! $all)
            return responseJson(Lang::get('common.illegal_operation'));

        $this->aclSet->setPermission($permissions)->setAll($all)->setId($id);

        $result = $this->aclProcess->setUserAcl($this->aclSet);

        if( ! $result)
            return responseJson($this->aclProcess->getErrorMessage());

        $this->setActionLog();
        return responseJson(Lang::get('common.action_success'));
        
    }
    
    /**
     * 对用户组进行权限设置
     * 
     * @access public
     */
    public function group()
    {
        if(Request::method() == 'POST')
            return $this->saveGroupPermissionToDatabase();

        $id = url_param_decode(Request::input('id'));
        if( ! $id or ! is_numeric($id))
            return Js::error(Lang::get('common.illegal_operation'), true);

        $info = $this->groupModel->getOneGroupById(intval($id));
        if(empty($info))
            return Js::error(Lang::get('common.illegal_operation'), true);

        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_GROUP))
            return Js::error(Lang::get('common.account_level_deny'), true);
        
        //取回用户组所拥有的权限列表
        $list = (array) SC::getUserPermissionSession();

        //当前所要编辑的用户组的权限，用于标识是否已经勾选
        $groupAcl = $this->accessModel->getGroupAccessPermission(intval($id));
        $hasPermissions = array();
        foreach($groupAcl as $key => $value)
        {
            $hasPermissions[] = $value['permission_id'];
        }

        //为ztree做数据准备
        $zTree = []; $all = [];
        foreach($list as $key => $value)
        {
            $arr = ['id' => $value['id'], 'pId' => $value['pid'], 'name' => $value['name'], 'open' => true];
            if(in_array($value['id'], $hasPermissions)) $arr['checked'] = true;
            $zTree[] = $arr;
            $all[] = $value['id'];
        }

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
        $permissions = (array) Request::input('permission');
        $id = Request::input('id');
        $all = Request::input('all');

        if( ! $id or ! is_numeric($id) or ! $all)
            return responseJson(Lang::get('common.illegal_operation'));

        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_GROUP))
            return responseJson(Lang::get('common.account_level_deny'));

        $this->aclSet->setPermission($permissions)->setAll($all)->setId($id);
        
        $result = $this->aclProcess->setGroupAcl($this->aclSet);
        if( ! $result)
            return responseJson($this->aclProcess->getErrorMessage());

        $this->setActionLog();
        return responseJson(Lang::get('common.action_success'));
    }

}