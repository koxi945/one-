<?php namespace App\Http\Controllers\Admin\Foundation;

use App\Models\Admin\Group;
use App\Models\Admin\User;
use Request, Lang, Session;
use App\Services\Admin\SC;
use App\Services\Admin\User\Process as UserActionProcess;
use App\Libraries\Js;
use App\Services\Admin\Acl\Acl;
use App\Http\Controllers\Admin\Controller;
use App\Services\Admin\User\Param\UserSave;
use App\Services\Admin\User\Param\UserModifyPassword;
use App\Services\Admin\Login\Process as LoginProcess;

/**
 * 用户相关
 *
 * @author jiang <mylampblog@163.com>
 */
class UserController extends Controller
{
    /**
     * group model
     * 
     * @var object
     */
    private $groupModel;

    /**
     * user model
     * 
     * @var object
     */
    private $userModel;

    /**
     * user process
     * 
     * @var object
     */
    private $userProcess;

    /**
     * user save
     * 
     * @var object
     */
    private $userSave;

    /**
     * 初始化一些常用的类
     */
    public function __construct()
    {
        $this->userModel = new User();
        $this->groupModel = new Group();
        $this->userProcess = new UserActionProcess();
        $this->userSave = new UserSave();
    }

    /**
     * 用户管理列表
     *
     * @access public
     */
    public function index()
    {
        Session::flashInput(['http_referer' => Request::fullUrl()]);
        $groupId = Request::input('gid');
        $userList = $this->userModel->getAllUser(['group_id' => $groupId]);
        $page = $userList->setPath('')->appends(Request::all())->render();
        $groupList = $this->groupModel->getAllGroup();
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
        if(Request::method() == 'POST') {
            return $this->saveUserInfoToDatabase();
        }

        $groupId = SC::getLoginSession()->group_id;
        $groupInfo = $this->groupModel->getOneGroupById($groupId);

        $isSuperSystemManager = (new Acl())->isSuperSystemManager();
        if($isSuperSystemManager) $groupInfo['level'] = 0;

        $groupList = $this->groupModel->getGroupLevelLessThenCurrentUser($groupInfo['level']);
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
        $this->userSave->setAttributes($data);
        if($this->userProcess->addUser($this->userSave)) {
            $this->setActionLog();
            return Js::locate(R('common', 'foundation.user.index'), 'parent');
        }
        return Js::error($this->userProcess->getErrorMessage());
    }
    
    /**
     * 删除用户
     *
     * @access public
     */
    public function delete()
    {
        $id = (array) Request::input('id');

        foreach($id as $key => $value) {
            if( ! ($id[$key] = url_param_decode($value)) ) {
                return responseJson(Lang::get('common.action_error'));
            }
        }

        $id = array_map('intval', $id);

        $userInfos = $this->userModel->getUserInIds($id);

        if($this->userProcess->detele($id)) {
            $this->setActionLog(['userInfos' => $userInfos]);
            return responseJson(Lang::get('common.action_success'), true);
        }

        return responseJson(
            $this->userProcess->getErrorMessage()
        );
    }
    
    /**
     * 编辑用户的资料
     *
     * @access public
     */
    public function edit()
    {
        if(Request::method() == 'POST') {
            return $this->updateUserInfoToDatabase();
        }

        Session::flashInput(['http_referer' => Session::getOldInput('http_referer')]);

        $id = Request::input('id');
        $userId = url_param_decode($id);

        if( ! $userId or ! is_numeric($userId)) {
            return Js::error(Lang::get('common.illegal_operation'), true);
        }

        $userInfo = $this->userModel->getOneUserById($userId);
        if(empty($userInfo)) {
            return Js::error(Lang::get('user.user_not_found'), true);
        }

        if( ! (new Acl())->checkGroupLevelPermission($userId, Acl::GROUP_LEVEL_TYPE_USER)) {
            return Js::error(Lang::get('common.account_level_deny'), true);
        }

        //根据当前用户的权限获取用户组列表
        $groupInfo = $this->groupModel->getOneGroupById(SC::getLoginSession()->group_id);
        $isSuperSystemManager = (new Acl())->isSuperSystemManager();

        if($isSuperSystemManager) $groupInfo['level'] = 0;

        $groupList = $this->groupModel->getGroupLevelLessThenCurrentUser($groupInfo['level']);
        $formUrl = R('common', 'foundation.user.edit');

        return view('admin.user.add',
            compact('userInfo', 'formUrl', 'id', 'groupList')
        );
    }
    
    /**
     * 更新用户信息到数据库
     *
     * @access private
     */
    private function updateUserInfoToDatabase()
    {
        $httpReferer = Session::getOldInput('http_referer');
        $data = Request::input('data');

        if( ! $data or ! is_array($data)) {
            return Js::error(Lang::get('common.info_incomplete'));
        }

        $this->userSave->setAttributes($data);

        if($this->userProcess->editUser($this->userSave)) {
            $this->setActionLog();
            $backUrl = ( ! empty($httpReferer)) ? $httpReferer : R('common', 'foundation.user.index'); 
            return Js::locate($backUrl, 'parent');
        }
        
        return Js::error($this->userProcess->getErrorMessage());
    }

    /**
     * 修改自己的密码
     */
    public function mpassword()
    {
        $params = new UserModifyPassword();

        $params->setOldPassword(Request::input('old_password'))
               ->setNewPassword(Request::input('new_password'))
               ->setNewPasswordRepeat(Request::input('new_password_repeat'));
               
        if($this->userProcess->modifyPassword($params)) {
            (new LoginProcess())->getProcess()->logout();
            return responseJson(Lang::get('common.action_success'), true);
        }
        return responseJson($this->userProcess->getErrorMessage());
    }
    
}