<?php namespace App\Services\Admin\User\Validate;

use Validator, Lang;
use App\Services\Admin\BaseValidate;

/**
 * 用户列表表单验证
 *
 * @author jiang <mylampblog@163.com>
 */
class User extends BaseValidate
{
    /**
     * 增加用户的时候的表单验证
     *
     * @access public
     */
    public function add($data)
    {
        // 创建验证规则
        $rules = array(
            'name'      => 'required',
            'realname'  => 'required',
            'password'  => 'required',
            'group_id'  => 'required|numeric|min:1',
            'mobile'    => 'required'
        );
        
        // 自定义验证消息
        $messages = array(
            'name.required'      => Lang::get('user.account_name_empty'),
            'password.required'  => Lang::get('user.password_empty'),
            'realname.required'  => Lang::get('user.realname_empty'),
            'group_id.required'  => Lang::get('user.group_empty'),
            'group_id.numeric'   => Lang::get('user.group_empty'),
            'group_id.min'       => Lang::get('user.group_empty'),
            'mobile.required'    => Lang::get('user.mobile_empty')
        );
        
        //开始验证
        $validator = Validator::make($data, $rules, $messages);
        if($validator->fails())
        {
            $this->msg = $validator->messages()->first();
            return false;
        }
        return true;
    }
    
    /**
     * 编辑用户的时候的表单验证
     *
     * @access public
     */
    public function edit($data)
    {
        //创建验证规则
        $rules = array(
            'name'      => 'required',
            'realname'  => 'required',
            'group_id'  => 'required|numeric|min:1',
            'mobile'    => 'required'
        );
        
        //自定义验证消息
        $messages = array(
            'name.required'      => Lang::get('user.account_name_empty'),
            'realname.required'  => Lang::get('user.realname_empty'),
            'group_id.required'  => Lang::get('user.group_empty'),
            'group_id.numeric'   => Lang::get('user.group_empty'),
            'group_id.min'       => Lang::get('user.group_empty'),
            'mobile.required'    => Lang::get('user.mobile_empty')
        );
        
        //如果传入的密码，那么检测它
        if( ! empty($data['password']))
        {
            $rules['password'] = 'required';
            $messages['password.required'] = Lang::get('user.password_empty');
        }
        
        //开始验证
        $validator = Validator::make($data, $rules, $messages);
        if($validator->fails())
        {
            $this->msg = $validator->messages()->first();
            return false;
        }
        return true;
    }
    
    /**
     * 修该用户密码的时候的表单验证
     *
     * @access public
     */
    public function password($data)
    {
        // 创建验证规则
        $rules = array(
            'password'  => 'required|confirmed',
            'password_old' => 'required',
        );
        
        // 自定义验证消息
        $messages = array(
            'password_old.required'  => Lang::get('user.password_empty'),
            'password.required'  => Lang::get('user.password_empty'),
            'password.confirmed' => Lang::get('user.password_inconformity')
        );
        
        //开始验证
        $validator = Validator::make($data, $rules, $messages);
        if($validator->fails())
        {
            $message = $validator->messages();
            $this->msg = $message->all();
            return false;
        }
        return true;
    }
    
}
