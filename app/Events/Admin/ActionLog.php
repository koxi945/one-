<?php namespace App\Events\Admin;

use App\Events\Event;

use Illuminate\Queue\SerializesModels;
use App\Services\Admin\SC;

/**
 * 操作日志事件
 *
 * @author jiang <mylampblog@163.com>
 */
class ActionLog extends Event
{
    /**
     * SerializesModels
     */
    use SerializesModels;

    /**
     * 所要记录的操作日志信息
     * 
     * @var string
     */
    public $message;

    /**
     * 当前登录的用户ID
     * 
     * @var int
     */
    public $userId;

    /**
     * 当前登录的用户名
     * 
     * @var string
     */
    public $userName;

    /**
     * 当前登录的真实姓名
     * 
     * @var string
     */
    public $realName;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $extendsDatas = [])
    {
        if( ! isset($extendsDatas['userInfo'])) $extendsDatas['userInfo'] = SC::getLoginSession();
        $userInfo = $extendsDatas['userInfo'];
        if(isset($userInfo->id)) $this->userId = $userInfo->id;
        if(isset($userInfo->name)) $this->userName = $userInfo->name;
        if(isset($userInfo->realname)) $this->realName = $userInfo->realname;
        $this->message = $message;
    }

}
