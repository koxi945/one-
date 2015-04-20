<?php namespace App\Http\Controllers\Admin\Foundation;

use App\Models\Admin\Group;
use App\Models\Admin\User;
use Request, Lang;
use App\Services\Admin\SC;
use App\Services\Admin\User\Process as UserActionProcess;
use App\Libraries\Js;
use App\Services\Admin\Acl\Acl;
use App\Http\Controllers\Admin\Controller;

/**
 * 用户相关
 *
 * @author jiang <mylampblog@163.com>
 */
class UserController extends Controller
{
    /**
     * 用户管理列表
     *
     * @access public
     */
    public function index()
    {
        $userModel = new User(); $groupModel = new Group();
        $groupId = Request::input('gid');
        $userList = $userModel->getAllUser($groupId);
        $page = $userList->appends(Request::all())->render();
        $groupList = $groupModel->getAllGroup();
        return view('admin.user.index',
            compact('userList', 'groupList', 'page')
        );
    }
    
    /**
     * 增加一个用户
     *
     * @access public
     */
    public function add()
    {
        if(Request::method() == 'POST') return $this->saveUserInfoToDatabase();
        $groupModel = new Group();
        $groupId = SC::getLoginSession()->group_id;
        $groupInfo = $groupModel->getOneGroupById($groupId);
        $groupList = $groupModel->getGroupLevelLessThenCurrentUser($groupInfo['level']);
        $formUrl = R('common', 'foundation.user.add');
        return view('admin.user.add',
            compact('groupList', 'formUrl')
        );
    }
    
    /**
     * 保存数据到数据库
     *
     * @access private
     */
    private function saveUserInfoToDatabase()
    {
        $data = (array) Request::input('data');
        $data['add_time'] = time();
        $manager = new UserActionProcess();
        if($manager->addUser($data)) return Js::locate(R('common', 'foundation.user.index'), 'parent');
        return Js::error($manager->getErrorMessage());
    }
    
    /**
     * 删除用户
     *
     * @access public
     */
    public function delete()
    {
        if( ! $id = Request::input('id')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $manager = new UserActionProcess();
        if($manager->detele($id)) return responseJson(Lang::get('common.action_success'), true);
        return responseJson($manager->getErrorMessage());
    }
    
    /**
     * 编辑用户的资料
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST') return $this->updateUserInfoToDatabase();
        $id = Request::input('id');
        if( ! $id or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'));
        $userModel = new User(); $groupModel = new Group();
        $userInfo = $userModel->getOneUserById($id);
        if(empty($userInfo)) return Js::error(Lang::get('user.user_not_found'), true);
        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_USER)) return Js::error(Lang::get('common.account_level_deny'), true);
        //根据当前用户的权限获取用户组列表
        $groupInfo = $groupModel->getOneGroupById(SC::getLoginSession()->group_id);
        $groupList = $groupModel->getGroupLevelLessThenCurrentUser($groupInfo['level']);
        $formUrl = R('common', 'foundation.user.edit');
        return view('admin.user.add', compact('userInfo', 'formUrl', 'id', 'groupList'));
    }
    
    /**
     * 更新用户信息到数据库
     *
     * @access private
     */
    private function updateUserInfoToDatabase()
    {
        $data = Request::input('data');
        if( ! $data or ! is_array($data)) return Js::error(Lang::get('common.info_incomplete'));
        $manager = new UserActionProcess();
        if($manager->editUser($data)) return Js::locate(R('common', 'foundation.user.index'), 'parent');
        return Js::error($manager->getErrorMessage());
    }
    
}