<?php namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;
use App\Services\Formhash;

/**
 * 父控制类类
 *
 * @author jiang <mylampblog@163.com>
 */
abstract class Controller extends BaseController
{
    /**
     * 检测表单篡改
     * 
     * @return true|exception
     */
    protected function checkFormHash()
    {
        return (new Formhash())->checkFormHash();
    }

}
