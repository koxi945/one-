<?php

/**
 * 系统上传相关处理
 *
 * @author jiang
 */

namespace Kj\Admin\Controller;

use View, Scstore, Input, Redirect, Config, Auth, Lang, Response, Request, Hash, URL, Validator;
use Kj\Admin\Controller\AdminController;
use Kj\Admin\Libraries\SwfUpload;

class UploadController extends AdminController
{
    /**
     * 上传处理对象
     *
     * @var object
     */
    private $swfupload;
    
    /**
     * 上传文件的访问地址
     *
     * @var string
     */
    private $upload_url;

    /**
     * construct
     *
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->upload_url = Config::get('admin.upload_url_host');
    }
    
    /**
     * swfupload上传附件，从phpcms移值过来的
     *
     * @access public
     */
    public function swfupload()
    {
        //检测参数的正确性
        $args = Input::get('args');
        $authkey = Input::get('authkey');
        //最大的上传允许
        $upload_maxsize = Config::get('admin.upload_maxsize');
        $file_size_limit = sizecount($upload_maxsize * 1024);
        $this->swfupload = new SwfUpload($args);
        $this->swfupload->setUploadMaxSize($upload_maxsize);

        //检测密钥
        if($this->swfupload->uploadKey() != $authkey) return Response::make('upload authkey deny', 401);

        //初始化上传参数
        extract($this->swfupload->getswfinit());
        
        //是否显示未处理的图片
        $att_not_used = Scstore::getAttJson();
        $tab_status = $div_status = '';
        if(empty($att_not_used) or ! isset($att_not_used)) $tab_status = ' class="on"';
        if( ! empty($att_not_used)) $div_status = ' hidden';
        
        //获取临时未处理文件列表
        $att = $this->_attNotUsed();
        
        return View::make('admin/upload/swfupload')->with(
                compact('tab_status', 'att_not_used', 'div_status',
                    'args', 'file_upload_limit', 'file_size_limit',
                    'file_types', 'watermark_enable', 'upload_maxsize',
                    'att'
                )
            );
    }
    
    /**
     * swfupload上传附件处理
     *
     * @access private
     */
    public function swfuploaddo()
    {
        $data = Input::all();
        //上传处理类
        $this->swfupload = new SwfUpload();
        //最大的上传允许
        $upload_maxsize = Config::get('admin.upload_maxsize');
        $this->swfupload->setUploadMaxSize($upload_maxsize);

        //检测密钥
        if( ! $this->swfupload->checkSwfAuthKey($data['swf_auth_key'], $data['SWFUPLOADSESSID']))
        {
            return Response::make('swf_auth_key deny', 401);
        }

        //开始上传
        $aids = $this->swfupload->upload();

        //上传失败
        if( ! isset($aids[0]))
        {
            $res = '0,'.$this->swfupload->error();
            return Response::make($res, 200);
        }
        
        //返回上传成功的文件信息
        $info = $this->swfupload->getCurrentUploadFileInfo();

        //如果是图片的话
        if($info['isimage'])
        {
            $res = $aids[0].','.$this->upload_url.$info['filepath'].','.$info['isimage'].','.$info['filename'];
        }
        else
        {
            $fileext = $this->_fileExt($info['fileext']);
            $res = $aids[0].','.$this->upload_url.$info['filepath'].','.$fileext.','.$info['filename'];
        }
        return Response::make($res, 200);
    }
    
    /**
     * 未处理的文件列表
     *
     * @access private
     */
    private function _fileExt($fileext)
    {
        if($fileext == 'zip' || $fileext == 'rar') $fileext = 'rar';
        elseif($fileext == 'doc' || $fileext == 'docx') $fileext = 'doc';
        elseif($fileext == 'xls' || $fileext == 'xlsx') $fileext = 'xls';
        elseif($fileext == 'ppt' || $fileext == 'pptx') $fileext = 'ppt';
        elseif ($fileext == 'flv' || $fileext == 'swf' || $fileext == 'rm' || $fileext == 'rmvb') $fileext = 'flv';
        else $fileext = 'do';
        return $fileext;
    }
    
    /**
     * 未处理的文件列表
     *
     * @access private
     */
    private function _attNotUsed()
    {
        $att = array();
        $att_json = Scstore::getAttJson();
        if( ! $att_json) return $att;

        if($att_json) $att_cookie_arr = explode('||', $att_json);
        foreach ($att_cookie_arr as $_att_c) $att[] = json_decode($_att_c,true);

        if( ! is_array($att) or empty($att)) return $att;
        
        foreach ($att as $n=>$v)
        {
            $ext = fileext($v['src']);
            if(in_array($ext, array('jpg','gif','png','bmp','jpeg')))
            {
                $att[$n]['fileimg'] = $v['src'];
                $att[$n]['width'] = '80';
                $att[$n]['filename'] = urldecode($v['filename']);
            }
            else
            {
                $att[$n]['fileimg'] = file_icon($v['src']);
                $att[$n]['width'] = '64';
                $att[$n]['filename'] = urldecode($v['filename']);
            }
        }

        return $att;
    }
    
    /**
     * 设置swfupload上传的未处理的json格式cookie
     *
     * @access public
     */
    public function swfuploadjson()
    {
        $arr['aid'] = intval(Input::get('aid'));
        $arr['src'] = safe_replace(trim(Input::get('src')));
        $arr['filename'] = urlencode(safe_replace(Input::get('filename')));
        $json_str = json_encode($arr);
        $att_arr_exist = Scstore::getAttJson();
        $att_arr_exist_tmp = explode('||', $att_arr_exist);
        if(is_array($att_arr_exist_tmp) && in_array($json_str, $att_arr_exist_tmp))
        {
            return Response::make(1, 200);
        }
        else
        {
            $json_str = $att_arr_exist ? $att_arr_exist.'||'.$json_str : $json_str;
            return Response::make(2, 200)->withCookie(Scstore::setAttJson($json_str, 60));
        }
    }
    
    /**
     * 删除设置swfupload上传的未处理的json格式cookie
     *
     * @access public
     */
    public function swfuploadjsondel()
    {
        $arr['aid'] = intval(Input::get('aid'));
        $arr['src'] = trim(Input::get('src'));
        $arr['filename'] = urlencode(Input::get('filename'));
        $json_str = json_encode($arr);
        $att_arr_exist = Scstore::getAttJson();
        $att_arr_exist = str_replace(array($json_str,'||||'), array('','||'), $att_arr_exist);
        $att_arr_exist = preg_replace('/^\|\|||\|\|$/i', '', $att_arr_exist);
        return Response::make(2, 200)->withCookie(Scstore::setAttJson($att_arr_exist, 60));
    }
    
    /**
     * 目录浏览
     *
     * @access public
     */
    public function albumdir()
    {
        $args = Input::get('args');
        $this->swfupload = new SwfUpload($args);
        if($args) extract($this->swfupload->getswfinit($args));
        
        $dir_native = Input::get('dir');
        $dir = isset($dir_native) && !empty($dir_native) ? str_replace(array('..\\', '../', './', '.\\','..'), '', trim($dir_native)) : '';
        $filepath = Config::get('admin.upload_path').'/'.$dir;
        $list = glob($filepath.'/'.'*');
        if(!empty($list)) rsort($list);
        $local = str_replace(array(DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR), array(DIRECTORY_SEPARATOR), $filepath);
        $url = ($dir == '.' || $dir=='') ? $this->upload_url : $this->upload_url.'/'.str_replace('.', '', $dir).'/';
        $show_header = true;
        return View::make('admin/upload/albumdir')->with(compact('local', 'dir', 'list', 'dir_native', 'url'));
    }

}