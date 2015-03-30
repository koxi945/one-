<?php

namespace App\Widget\Admin;

use Config;

/**
 * 上传小组件
 *
 * @author jiang <mylampblog@163.com>
 */
class Upload
{
    /**
     * 上传的配置
     * 
     * @var array
     */
    private $config = [
        'id' => '', //必传,表单id
        'callback' => '', //必传,回调函数
        'alowexts' => '', //允许图片格式
        'nums' => '', //最多可以上传多少个文件
        'thumbSetting' => '', //缩略图配置
        'waterSetting' => '', //0或1 水印
        'uploadPath' => '', //上传的路径
    ];

    /**
     * 上传的配置
     *
     * <code>
     *     配置的示例：
     *     array(
     *         'id' => '', //必传,表单id
     *         'callback' => '', //必传,回调函数
     *         'alowexts' => '', //允许图片格式
     *         'nums' => '', //最多可以上传多少个文件
     *         'thumbSetting' => '', //缩略图配置
     *         'waterSetting' => '', //0或1 水印
     *         'uploadPath' => '', //上传的路径
     *     )
     * </code>
     *
     * @param array $config 上传的配置
     */
    public function setConfig(array $config)
    {
        foreach($config as $key => $value)
        {
            if(isset($this->config[$key])) $this->config[$key] = $value;
        }
        return $this;
    }

    /**
     * 输出上传图片按钮，调用上传窗口
     */
    public function uploadButton()
    {
        $config = $this->config;
        $config['thumbExt'] = ',';
        if(isset($config['thumbSetting'][1])) $config['thumbExt'] = $config['thumbSetting'][0].','.$config['thumbSetting'][1];
        if( ! isset($config['alowexts'])) $config['alowexts'] = 'jpg|jpeg|gif|bmp|png';
        //$swfupload = new SwfUpload("$nums,$alowexts,1,$thumbExt,$waterSetting");
        $config['authkey'] = '11'; //$swfupload->uploadKey();
        if( ! isset($config['uploadPath'])) $config['uploadPath'] = Config::get('sys.sys_upload_path');
        $config['uploadUrl'] = route('common', ['class' => 'upload', 'action' => 'index']);
        return view('admin.widget.uploadbutton',
            compact('config')
        );
    }

}