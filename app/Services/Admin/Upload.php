<?php namespace App\Services\Admin;

/**
 * 上传处理类
 *
 * @author jiang <mylampblog@163.com>
 */
class Upload
{
    /**
     * 密钥
     * 
     * @var string
     */
    private $token = 'jiang';

    /**
     * 参数
     * 
     * @var string
     */
    private $args;

    /**
     * 允许上传的最大容量
     * 
     * @var string
     */
    private $upload_maxsize = 20;
    
    /**
     * 允许上传的后缀
     * 
     * @var string
     */
    private $site_allowext;
    
    /**
     * 文件上传的表单名
     * 
     * @var string
     */
    private $file_post_name = 'Filedata';
    
    /**
     * 错误标识
     * 
     * @var string
     */
    private $error;
    
    /**
     * 上传的路径
     * 
     * @var string
     */
    private $upload_path;
    
    /**
     * 上传的路径子目录
     * 
     * @var string
     */
    private $upload_dir = '';
    
    /**
     * 当前已经上传了的文件的信息
     * 
     * @var array
     */
    private $uploadedfile = array();
    
    /**
     * 图片后缀
     * 
     * @var array
     */
    private $imageexts = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

    /**
     * 初始化
     * 
     * @param array $args
     */
    public function __construct($args = '')
    {
        $this->args = $args;
        $this->site_allowext = \Yii::$app->params['site_allowext'];
        $this->upload_path = \Yii::$app->params['upload_path'];
    }

    /**
     * 设置最大的上传值
     */
    public function setUploadMaxSize($upload_maxsize)
    {
        $this->upload_maxsize = $upload_maxsize;
    }
    
    /**
     * 设置最大的上传值
     */
    public function setUploadPath($path)
    {
        $this->upload_path = $path;
    }

    /**
     * 生成上传附件验证
     */
    public function uploadKey()
    {
        $token = md5($this->token.$_SERVER['HTTP_USER_AGENT']);
        $authkey = md5($this->args.$token);
        return $authkey;
    }
    
    /**
     * 设置上传表单的名字
     */
    public function setFilePostName($name)
    {
        $this->file_post_name = $name;
    }
    
    /**
     * 返回上传表单的名字
     */
    public function getFilePostName()
    {
        return $this->file_post_name;
    }
    
    /**
     * 检测上传的时候的密钥
     */
    public function checkSwfAuthKey($swfAuthKey, $swfId)
    {
        if($swfAuthKey != md5($this->token.$swfId)) return false;
        return true;
    }
    
    /**
     * 设置上传的子目录
     */
    public function setUploadDir($upload_dir)
    {
        $this->upload_dir = $upload_dir;
    }
    
    /**
     * 生成文件名称
     *
     * @param $fileext 附件扩展名
     */
    private function getname($fileext)
    {
        return date('Ymdhis').rand(100, 999).'.'.$fileext;
    }
    
    /**
     * 取得当前已经上传成功的文件的相关信息
     */
    public function getCurrentUploadFileInfo()
    {
        return $this->uploadedfile;
    }

    /**
     * 返回上传的错误信息
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * 取得文件扩展
     *
     * @param $filename 文件名
     * @return 扩展名
     */
    public function fileext($filename)
    {
        return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
    }

    /**
    * 判断文件是否是通过 HTTP POST 上传的
    *
    * @param    string  $file   文件地址
    * @return   bool    所给出的文件是通过 HTTP POST 上传的则返回 TRUE
    */
    public function isuploadedfile($file)
    {
        return is_uploaded_file($file) || is_uploaded_file(str_replace('\\\\', '\\', $file));
    }

    /**
     * 返回经addslashes处理过的字符串或数组
     * @param $string 需要处理的字符串或数组
     * @return mixed
     */
    public function new_addslashes($string)
    {
        if(!is_array($string)) return addslashes($string);
        foreach($string as $key => $val) $string[$key] = new_addslashes($val);
        return $string;
    }
    
    /**
     * 开始上传
     */
    public function upload()
    {
        //是否已经上传文件
        if( ! isset($_FILES[$this->file_post_name]))
        {
            $this->error = UPLOAD_ERR_OK;
            return false;
        }
        //如果有错误产生
        if(isset($_FILES[$this->file_post_name]['error']))
        {
            if($_FILES[$this->file_post_name]['error'] !== UPLOAD_ERR_OK)
            {
                $this->error = $_FILES[$this->file_post_name]['error'];
                return false;
            }
        }
        //上传的路径
        $this->savepath = $this->upload_path.'/'.$this->upload_dir.date('Y/md/');
        //建立文件夹
        if( ! \yii\helpers\Common::dir_create($this->savepath) or ! is_dir($this->savepath))
        {
            $this->error = '8';
            return false;
        }
        //该变上传路径的权限
        @chmod($this->savepath, 0777);
        //检测是否可写
        if( ! is_writeable($this->savepath))
        {
            $this->error = '9';
            return false;
        }
        //开始处理上传
        $aids = array();
        
        $fileSize = $_FILES[$this->file_post_name]['size'];
        $fileExt = $this->fileext($_FILES[$this->file_post_name]['name']);
        $fileRealName = $_FILES[$this->file_post_name]['name'];
        $fileRealPath = $_FILES[$this->file_post_name]['tmp_name'];
        
        //检测后缀名
        if( ! preg_match("/^(".$this->site_allowext.")$/", $fileExt))
        {
            $this->error = '10';
            return false;
        }
        //检测文件大小
        if($this->upload_maxsize && $fileSize > $this->upload_maxsize * 1024)
        {
            $this->error = '11';
            return false;
        }
        
        //检测是不是http方式上传
        if( ! $this->isuploadedfile($_FILES[$this->file_post_name]['tmp_name']))
        {
            $this->error = '12';
            return false;
        }
        
        //一些安全过滤
        $fileName = $this->getname($fileExt);
        $saveFile = $this->savepath.$fileName;
        $preg = "/(php|phtml|php3|php4|jsp|exe|dll|asp|cer|asa|shtml|shtm|aspx|asax|cgi|fcgi|pl)(\.|$)/i";
        $saveFile = preg_replace($preg, "_\\1\\2", $saveFile);
        $fileName = preg_replace($preg, "_\\1\\2", $fileName);
        $filepath = preg_replace($this->new_addslashes("|^".$this->upload_path."|"), "", $saveFile);
        
        //如果文件已经存在，那么直接返回
        if(file_exists($saveFile)) return $aids;
        
        //移动文件
        if(@copy($_FILES[$this->file_post_name]['tmp_name'], $saveFile))
        {
            //上传的文件名
            $uploadFileName = \yii\helpers\Common::safe_replace($fileRealName);
            
            //保存已经上传的文件信息
            $this->uploadedfile = array(
                'filename'  => $uploadFileName,
                'filepath'  => $filepath,
                'filesize'  => $fileSize,
                'fileext'   => $fileExt,
                'isimage'   => in_array($fileExt, $this->imageexts) ? 1 : 0,
            );
            
            //删除临时文件
            @unlink($fileRealPath);
            $aids[] = uniqid();
        }
        return $aids;
    }
    
    /**
     * 读取swfupload配置类型
     */
    public function getswfinit()
    {
        $args = $this->args;
        //允许上传的文件后缀
        $site_allowext = $this->site_allowext;
        //传过来的参数
        $args = explode(',', $args);
        //上传的限制数量
        $arr['file_upload_limit'] = intval($args[0]) ? intval($args[0]) : '8';
        
        //允许上传的文件后缀，通过传过来的参数控制
        $args['1'] = ($args[1]!='') ? $args[1] : $site_allowext;
        
        $arr_allowext = explode('|', $args[1]);
        foreach($arr_allowext as $k=>$v)
        {
            $v = '*.'.$v;
            $array[$k] = $v;
        }
        $upload_allowext = implode(';', $array);
        $arr['file_types'] = $upload_allowext;
        $arr['file_types_post'] = $args[1];
        $arr['allowupload'] = intval($args[2]);
        $arr['thumb_width'] = intval($args[3]);
        $arr['thumb_height'] = intval($args[4]);
        $arr['watermark_enable'] = ($args[5]=='') ? 1 : intval($args[5]);
        return $arr;
    }

    /**
     * flash上传初始化，初始化swfupload上传中需要的参数
     */
    public function initupload($userid_flash = '0')
    {
        extract($this->getswfinit());
        //最大的上传允许
        $file_size_limit = $this->upload_maxsize * 1024;
        $sess_id = time();
        //上传的路径
        $upload_path = \yii\helpers\Url::toRoute('/upload/swfuploaddo');
        //简单的密钥
        $swf_auth_key = md5($this->token.$sess_id);

        //保存的路径
        $file_save_path = $this->upload_path;

        //sessionid解决flash用户登录无法验证问题
        $sessionid = \Yii::$app->session->id;

        //上传初始化所需要的js
        $init =  'var swfu = \'\';
        $(document).ready(function(){
        swfu = new SWFUpload({
            flash_url:"'.JS_PATH.'/swfupload/swfupload.swf?"+Math.random(),
            upload_url:"'.$upload_path.'",
            file_post_name : "'.$this->file_post_name.'",
            post_params:{"file_save_path" : "'.$file_save_path.'","sessionid": "'.$sessionid.'", "SWFUPLOADSESSID":"'.$sess_id.'","thumb_width":"'.$thumb_width.'","thumb_height":"'.$thumb_height.'","watermark_enable":"'.$watermark_enable.'","filetype_post":"'.$file_types_post.'","swf_auth_key":"'.$swf_auth_key.'", "userid_flash":"'.$userid_flash.'"},
            file_size_limit:"'.$file_size_limit.'",
            file_types:"'.$file_types.'",
            file_types_description:"All Files",
            file_upload_limit:"'.$file_upload_limit.'",
            custom_settings : {progressTarget : "fsUploadProgress",cancelButtonId : "btnCancel"},
     
            //这个选项会发起一个请求，如果不指定，这个请求会502
            button_image_url: "'.JS_PATH.'/swfupload/images/swfBntx.png",

            button_width: 75,
            button_height: 28,
            button_placeholder_id: "buttonPlaceHolder",
            button_text_style: "",
            button_text_top_padding: 3,
            button_text_left_padding: 12,
            button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
            button_cursor: SWFUpload.CURSOR.HAND,

            file_dialog_start_handler : fileDialogStart,
            file_queued_handler : fileQueued,
            file_queue_error_handler:fileQueueError,
            file_dialog_complete_handler:fileDialogComplete,
            upload_progress_handler:uploadProgress,
            upload_error_handler:uploadError,
            upload_success_handler:uploadSuccess,
            upload_complete_handler:uploadComplete
            });
        })';
        return $init;
    }
    
}
