<?php

namespace App\Http\Controllers\Admin\Foundation;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\Group as GroupModel;
use Request, Lang;
use App\Services\Admin\Group\Process as GroupActionProcess;
use App\Libraries\Js;
use App\Services\Admin\Acl\Acl;

/**
 * 用户组管理
 *
 * @author jiang <mylampblog@163.com>
 */
class GroupController extends Controller
{
    /**
     * 显示用户组列表首页
     *
     * @access public
     */
    public function index()
    {
        $groupModel = new GroupModel();
        $grouplist = $groupModel->getAllGroupByPage();
        $page = $grouplist->appends(Request::all())->render();
        return view('admin.group.index', compact('grouplist', 'page'));
    }
    
    /**
     * 增加用户组
     *
     * @access public
     */
    public function add()
    {
        if(Request::method() == 'POST') return $this->saveDatasToDatabase();
        $formUrl = R('common', 'foundation.group.add');
        return view('admin.group.add', compact('formUrl'));
    }
    
    /**
     * 增加用户组入库处理
     *
     * @access private
     */
    private function saveDatasToDatabase()
    {
        $data = (array) Request::input('data');
        $manager = new GroupActionProcess();
        if($manager->addGroup($data) !== false) return Js::locate(R('common', 'foundation.group.index'), 'parent');
        return Js::error($manager->getErrorMessage());
    }

    /**
     * 删除用户组
     *
     * @access public
     */
    public function delete()
    {
        if( ! $id = Request::input('id')) return responseJson(Lang::get('common.action_error'));
        if( ! is_array($id)) $id = array($id);
        $manager = new GroupActionProcess();
        if($manager->detele($id)) return responseJson(Lang::get('common.action_success'), true);
        return responseJson($manager->getErrorMessage());
    }
    
    /**
     * 编辑用户组
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST') return $this->updateDatasToDatabase();
        $id = Request::input('id');
        if( ! $id or ! is_numeric($id)) return Js::error(Lang::get('common.illegal_operation'));
        $groupInfo = (new GroupModel())->getOneGroupById($id);
        if(empty($groupInfo)) return Js::error(Lang::get('group.group_not_found'));
        if( ! (new Acl())->checkGroupLevelPermission($id, Acl::GROUP_LEVEL_TYPE_GROUP)) return Js::error(Lang::get('common.account_level_deny'), true);
        $formUrl = R('common', 'foundation.group.edit');
        return view('admin.group.add', compact('groupInfo', 'formUrl', 'id'));
    }
    
    /**
     * 编辑用户组入库处理
     *
     * @access private
     */
    private function updateDatasToDatabase()
    {
        $data = Request::input('data');
        if( ! $data or ! is_array($data)) return Js::error(Lang::get('common.illegal_operation'));
        $manager = new GroupActionProcess();
        if($manager->editGroup($data)) return Js::locate(R('common', 'foundation.group.index'), 'parent');
        return Js::error($manager->getErrorMessage());
    }

}