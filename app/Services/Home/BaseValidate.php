<?php

/**
 * 表单验证基类
 *
 * @author jiang
 */

namespace App\Services\Home;

class BaseValidate
{
    /**
     * 表单验证的信息
     *
     * @access protected
     */
    protected $msg;
    
    /**
     * 取回表单验证不通过的时候所提示的信息
     *
     * @access public
     */
    public function getMsg()
    {
        return $this->msg;
    }
    
}
