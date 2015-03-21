<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Permission as PermissionModel;
use App\Models\Admin\Access as AccessModel;
use App\Models\Admin\User as UserModel;
use App\Models\Admin\Group as GroupModel;
use Request;
use App\Services\Admin\Acl\Process as AclActionProcess;
use App\Libraries\Js;
use App\Services\Admin\Acl\Acl;
use Lang;
use App\Services\Admin\Tree;
use App\Services\Admin\SC;

/**
 * 登录相关
 *
 * @author jiang <mylampblog@163.com>
 */
class AclController extends Controller
{
    /**
     * 显示权限列表首页
     *
     * @access public
     */
    public function index()
    {
        $permissionModel = new PermissionModel();
        $list = $permissionModel->getAllAccessPermissionByPage();
        $page = $list->render();
        return view('admin.acl.index', compact('list', 'page'));
    }

    /**
     * 增加权限功能
     *
     * @access public
     */
    public function add()
    {
        if(Request::method() == 'POST') return $this->savePermissionToDatabase();
        $formUrl = route('common', ['class' => 'acl', 'action' => 'add']);
        $list = (new PermissionModel())->getAllAccessPermission();
        $select = Tree::dropDownSelect(Tree::genTree($list));
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
        $manager = new AclActionProcess();
        if($manager->addAcl($data) !== false) return Js::locate(route('common', ['class' => 'acl', 'action' => 'index']), 'parent');
        return Js::error($manager->getErrorMessage());
    }
    
    /**
     * 删除权限功能
     *
     * @access public
     * @todo 只能删除自己所拥有的权限？有没有必要做？
     */
    public function delete()
    {
        $id = (int) Request::input('id');
        if( ! $id) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $manager = new AclActionProcess();
        if($manager->detele($id) !== false) return responseJson(Lang::get('common.action_success'), true);;
        return Js::error($manager->getErrorMessage());
    }
    
    /**
     * 编辑权限功能
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST') return $this->updatePermissionToDatabase();
        if( ! $id = Request::input('id') or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'));
        $permissionModel = new PermissionModel();
        $list = (array) Tree::genTree($permissionModel->getAllAccessPermission());
        $permissionInfo = $permissionModel->getOnePermissionById(intval($id));
        if(empty($permissionInfo)) return Js::error(Lang::get('common.acl_not_found'), true);
        $select = Tree::dropDownSelect($list, $permissionInfo['pid']);
        $formUrl = route('common', ['class' => 'acl', 'action' => 'edit']);
        return view('admin.acl.add', compact('select', 'permissionInfo', 'formUrl', 'id'));
    }
    
    /**
     * 编辑功能权限入库处理
     *
     * @access private
     */
    private function updatePermissionToDatabase()
    {
        $data = Request::input('data');
        if( ! $data) return Js::error(Lang::get('common.info_incomplete'));
        $manager = new AclActionProcess();
        if($manager->editAcl($data) !== false) return Js::locate(route('common', ['class' => 'acl', 'action' => 'index']), 'parent');
        return Js::error($manager->getErrorMessage());
    }
    
    /**
     * 排序权限功能
     *
     * @access public
     */
    public function sort()
    {
        $sort = Request::input('sort');
        if( ! $sort or ! is_array($sort)) return Js::error(Lang::get('common.choose_checked'));
        foreach($sort as $key => $value)
        {
            if((new PermissionModel())->sortPermission($key, $value) === false) $err = true;
        }
        if(isset($err)) return Js::error(Lang::get('common.action_error'));
        return Js::locate(route('common', ['class' => 'acl', 'action' => 'index']), 'parent');
    }

    /**
     * 对用户进行权限设置
     * 
     * @access public
     */
    public function user()
    {
        if(Request::method() == 'POST') return $this->saveUserPermissionToDatabase();
        if( ! $id = Request::input('id') or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'));
        //用户信息
        $info = (new UserModel())->getOneUserById(intval($id));
        if(empty($info)) return Js::error(Lang::get('common.illegal_operation'));
        $aclManager = new Acl();
        //判断当前用户有没有权限进行这个操作
        if( ! $aclManager->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_USER)) return Js::error(Lang::get('common.account_level_deny'), true);
        //分菜单来查询
        $pid = intval(Request::input('pid'));
        //取回用户所拥有的权限列表
        $tree = Tree::genPermissionTree(SC::getUserPermissionSession());
        //当前用户的权限
        $userAcl = (new AccessModel())->getUserAccessPermission(intval($id));
        $hasPermissions = array();
        foreach($userAcl as $key => $value)
        {
            $hasPermissions[] = $value['permission_id'];
        }
        $router = 'user';
        return view('admin.acl.setpermission',
            compact('tree', 'hasPermissions', 'id', 'info', 'pid', 'router')
        );
    }

    /**
     * 用户权限入库
     * 
     * @return boolean true|false
     */
    private function saveUserPermissionToDatabase()
    {
        $permissions = Request::input('permission', array());
        $id = Request::input('id');
        $all = Request::input('all');
        if( ! $id or ! is_numeric($id) or ! $all) return Js::error(Lang::get('common.illegal_operation'));
        //判断当前用户有没有权限进行这个操作
        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_USER)) return Js::error(Lang::get('common.account_level_deny'));
        //当前列表中的所有权限信息
        $allArr = explode(',', $all);
        $allArr = array_map('intval', $allArr);
        //需要作更改的权限信息
        $permission = array_unique($permissions);
        $ret = (new AccessModel())->setPermission($permission, intval($id), $allArr, 2);
        if($ret) return Js::error(Lang::get('common.action_success'));
        return Js::error(Lang::get('common.action_error'));
    }
    
    /**
     * 对用户组进行权限设置
     * 
     * @access public
     */
    public function group()
    {
        if(Request::method() == 'POST') return $this->saveGroupPermissionToDatabase();
        if( ! $id = Request::input('id') or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'));
        //用户组信息
        $info = (new GroupModel())->getOneGroupById(intval($id));
        if(empty($info)) return Js::error(Lang::get('common.illegal_operation'));
        
        //判断当前用户有没有权限进行这个操作
        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_GROUP)) return Js::error(Lang::get('common.account_level_deny'), true);

        //分菜单来查询
        $pid = intval(Request::input('pid'));
        
        //取回用户组所拥有的权限列表
        $list = (array) SC::getUserPermissionSession();
        $tree = Tree::genPermissionTree($list);

        //当前用户组的权限
        $groupAcl = (new AccessModel())->getGroupAccessPermission(intval($id));
        $hasPermissions = array();
        foreach($groupAcl as $key => $value)
        {
            $hasPermissions[] = $value['permission_id'];
        }
        $router = 'group';
        return view('admin.acl.setpermission',
            compact('tree', 'hasPermissions', 'id', 'info', 'pid', 'router')
        );
    }

    /**
     * 用户组权限入库
     * 
     * @return boolean true|false
     */
    private function saveGroupPermissionToDatabase()
    {
        $permissions = Request::input('permission', array());
        $id = Request::input('id', false);
        $all = Request::input('all', false);
        //确保参数的正确性
        if( ! $id or ! is_numeric($id) or ! $all) return Js::error(Lang::get('common.illegal_operation'));
        
        //判断当前用户有没有权限进行这个操作
        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_GROUP)) return Js::error(Lang::get('common.account_level_deny'));

        //当前列表中的所有权限信息
        $allArr = explode(',', $all);
        $allArr = array_map('intval', $allArr);
        
        //需要作更改的权限信息
        $permission = array_unique($permissions);

        //入库
        $ret = (new AccessModel())->setPermission($permission, intval($id), $allArr, 1);
        if($ret) return Js::error(Lang::get('common.action_success'));
        return Js::error(Lang::get('common.action_error'));
    }

}