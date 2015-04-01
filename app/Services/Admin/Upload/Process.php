<?php namespace App\Services\Admin\Upload;

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
     * 文件上传表单的名字
     * 
     * @var string
     */
    private $fileFormName = 'file';

    /**
     * 上传的文件对象
     * 
     * @var object
     */
    private $file;

    /**
     * 上传需要的参数
     * 
     * @var array
     */
    private $params;

    /**
     * 所要保存的文件名
     * 
     * @var string
     */
    private $saveFileName;

    /**
     * 设置上传需要的参数
     */
    public function setParam($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * 文件上传的对象
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * 生成上传附件验证，防止表单修改
     */
    public function uploadKey()
    {
        $uploadToken = md5($this->uploadToken.$_SERVER['HTTP_USER_AGENT']);
        $authkey = md5(serialize($this->params).$uploadToken);
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
     * 开始处理上传
     *
     * @return false|string
     */
    public function upload()
    {
        //是否上传出错
        if ( ! $this->file->isValid() or $this->file->getError() != UPLOAD_ERR_OK) return false;
        //保存的路径
        $savePath = $this->setSavePath();
        //保存的文件名
        $saveFileName = $this->getSaveFileName().'.'.$this->file->getClientOriginalExtension();
        //保存
        $this->file->move($savePath, $saveFileName);
        //文件是否存在
        $realFile = $savePath.$saveFileName;
        if( ! file_exists($realFile)) return false;

        //返回文件
        $configSavePath = \Config::get('sys.sys_upload_path');
        $returnFileUrl['realFileUrl'] = str_replace('/', '', str_replace($configSavePath, '', $realFile));

        //是否要裁剪
        if(isset($this->params['thumbSetting']['width'], $this->params['thumbSetting']['height']))
        {
            $thumbRealFile = $this->cutImage($realFile, $savePath);
            $returnFileUrl['thumbRealFileUrl'] = str_replace('/', '', str_replace($configSavePath, '', $thumbRealFile));
        }
        
        return $returnFileUrl;
    }

    /**
     * 开始处理裁剪
     *
     * @param  string $realFile 所要处理的图片的位置
     * @param  string $savePath 所要保存的位置
     * @return string           处理后的图片
     */
    private function cutImage($realFile, $savePath)
    {
        if( ! isImage($this->file->getClientOriginalExtension())) throw new \Exception("Image thumb must be images.");
        $imagine = new \Imagine\Gd\Imagine();
        $size = new \Imagine\Image\Box($this->params['thumbSetting']['width'], $this->params['thumbSetting']['height']);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        $saveName = $savePath.$this->getSaveFileName().'_thumb.'.$this->file->getClientOriginalExtension();
        $imagine->open($realFile)
                ->thumbnail($size, $mode)
                ->save($saveName);
        return $saveName;
    }

    /**
     * 设置保存的路径
     *
     * @access private
     */
    private function setSavePath()
    {
        $savePath = base64url_decode($this->params['uploadPath']);
        if( ! is_dir($savePath))
        {
            //如果保存路径不存在，那么建立它
            dir_create($savePath);
        }
        return $savePath;
    }

    /**
     * 所要保存的文件名
     * 
     * @return string
     */
    private function getSaveFileName()
    {
        if( ! $this->saveFileName) $this->saveFileName = md5(uniqid('pre', TRUE).mt_rand(1000000,9999999));
        return $this->saveFileName;
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