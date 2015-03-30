<?php namespace App\Services\Admin\Upload;

use Lang;

/**
 * 上传处理
 *
 * @author jiang <mylampblog@163.com>
 */
class Process
{
    /**
     * 错误的信息
     * 
     * @var string
     */
    private $errorMsg;

    /**
     * 用于上传的加密密钥
     * 
     * @var string
     */
    private $uploadToken = 'jiang';

    /**
     * 上传需要的参数
     * 
     * @var array
     */
    private $params;

    /**
     * 设置上传需要的参数
     */
    public function setParam($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * 生成上传附件验证，防止表单修改
     */
    public function uploadKey()
    {
        $uploadToken = md5($this->uploadToken.$_SERVER['HTTP_USER_AGENT']);
        $authkey = md5(implode(',', $this->params).$uploadToken);
        return $authkey;
    }

    /**
     * 检测token是否匹配
     * 
     * @return boolean
     */
    public function checkUploadToken($uploadToken)
    {
        if($this->uploadKey() != $uploadToken) return false;
        return true;
    }

    /**
     * 取得错误的信息
     *
     * @access public
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMsg;
    }

}